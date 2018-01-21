# -*- coding: utf-8 -*-
import os, json
import pandas as pd
import requests
import matplotlib.pyplot as plt
import numpy as np
#import pyperclip
import MySQLdb as mysql

"""Parse all WP DB data, determine if domain is already registered in 
domains.json and if necessary, registers new domains manually with raw_input
and adds 'priority' to WP DB.
"""
    
def userInput(user_domain):
    choice = int(raw_input('Domain {} is not registered yet.\n-1 to copy domain to clipboard or specify type:\n'
                           '0 [Commercial], 1 [Private], 2 [Edu], 3 [Junk]\n> '.format(user_domain)))
    
    if choice == 0:
        return 'commercial'
    elif choice == 1:
        return 'private' 
    elif choice == 2:
        return 'edu'
    elif choice == 3:
        return 'junk'
    elif choice == -1:
#        pyperclip.copy('http://www.' + user_domain)
        return None
    else:
        print "\nWrong input! Choose from (-1, 0, 1, 2, 3)."
        return None


def parseDB():
    conn = mysql.connect(host='172.18.0.2',
                     user='root',
                     passwd='admin',
                     db='wordpress')
    
    cur = conn.cursor()
    sql_parse = """SELECT ID, user_email
                    FROM 
                    wp_users 
                    WHERE ID NOT IN (
                    SELECT DISTINCT user_id 
                    FROM wp_usermeta 
                    WHERE meta_key = 'priority'
                    )
                    """
    cur.execute(sql_parse)
    indexs = []
    new_domains = []
    
    print cur.fetchall()
    
    for index, mail in cur.fetchall():
        try:
            new_domains.append(mail.split("@")[1].lower())
            indexs.append(index)
        except:
            new_domains.append('NA')
            indexs.append(index)
    
    sql_inject = """INSERT INTO wp_usermeta (user_id, meta_key) 
                    SELECT DISTINCT users.ID, 'priority'
                    FROM wp_users users
                    WHERE users.ID IN %s"""
                    
    cur.execute(sql_inject, (tuple(indexs), ))
    
    for user_id, domain in zip(indexs, new_domains):
        try:
            sql_update = "UPDATE wp_usermeta SET meta_key = %s WHERE user_id = %s AND meta_value = 'priority'"
            if domain in old_domains['commercial']:
                domain_type = "commercial"
            elif domain in old_domains['private']:
                domain_type = "private"
            elif domain in old_domains['edu']:
                domain_type = "edu"
            elif domain in old_domains['junk']:
                domain_type = "junk"
            else:
                domain_type = None
                while domain_type == None:                
                    try:
                        domain_type = userInput(domain)
                    except ValueError, e:
                        print "\nWrong input! Choose from (-1, 0, 1, 2, 3)."
                        domain_type = userInput(domain)
                if domain not in old_domains[domain_type]:
                    old_domains[domain_type].append(domain)
        except:
            cur.close()
            conn.commit()
            conn.close()
            raise
            
        cur.execute(sql_update, (domain_type, user_id,))
        
    cur.close()
    conn.commit()
    conn.close()
                
    with open(json_domain_path, 'wb') as jd:
        json.dump(old_domains, jd)
        
    print "All up-to-date!"
        

def plotStats():
    conn = mysql.connect(host='127.0.0.1',
                     user='root',
                     passwd='admin',
                     db='wordpress')
    
    cur = conn.cursor()
    
    sql_class = """ 
                SELECT meta_value, count(meta_value) as all_users
                 FROM wp_usermeta 
                 WHERE meta_key='priority'
                 GROUP BY meta_value
                """
    
    classific = pd.read_sql_query(sql=sql_class, con=conn)
    
    sql_keys = """ 
                SELECT meta_value, count(meta_value) as no_key
                 FROM wp_usermeta                 
                 WHERE meta_key='priority' 
                 AND user_id NOT IN (SELECT DISTINCT user_id FROM wp_usermeta WHERE meta_key = 'tyk_access_token')
                 GROUP BY meta_value
                """
    
    keys_users = pd.read_sql_query(sql=sql_keys, con=conn)
    
    keys_users['perc'] = keys_users['no_key']/classific['all_users']
    
    plt.figure(figsize=(20,16))
    
    ax1 = plt.subplot(221, aspect='equal')
    ax1.set_title('Customer segmentation', fontsize=16, fontweight='bold')
    sbplt1 = classific.plot.pie(y = 'all_users', ax=ax1, autopct='%1.1f%%', 
     startangle=90, shadow=False, labels=classific['meta_value'], legend=False, fontsize=14)
    sbplt1.set_ylabel('')
    
#    ax2 = plt.subplot(222)
#    ax2.set_title('Count how many API keys are active per account [commercial]', fontsize=16, fontweight='bold')
#    gb_sub = gb_type.loc[gb_type['type'] == 'commercial']
#    sbplt2 = gb_sub.set_index('key_count')['count'].plot.bar(ax=ax2, rot=0, fontsize=14)
#    sbplt2.set_xlabel('Amount of API keys', fontsize=14, fontweight='bold')
#    sbplt2.set_ylabel('Amount of account binned on API key amount', fontsize=14, fontweight='bold')
#    sbplt2.annotate('Total commercial accounts: {}'.format(gb['count'].loc[gb['type'] == 'commercial'].sum()),
#                    xy=(2,1), xytext=(1,700), textcoords='data', fontsize=14)
    

if __name__ == "__main__": 
    cwd = os.path.dirname(os.path.realpath(__file__))
    json_domain_path = os.path.join(cwd, 'data', 'domains.json')
    
    with open(json_domain_path, 'r') as json_out:
        old_domains = json.load(json_out)
    parseDB()
