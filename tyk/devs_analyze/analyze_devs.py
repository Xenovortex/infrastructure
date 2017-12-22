# -*- coding: utf-8 -*-
import os, json
import pandas as pd
import requests
import matplotlib.pyplot as plt
import numpy as np
import pyperclip
import MySQLdb as mysql

"""Parse all WP DB data, determine if domain is already registered in 
domains.json and if necessary, user registers new domains manually with raw_input
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
        pyperclip.copy('http://www.' + user_domain)
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
        cur.execute(sql_update, (domain_type, user_id,))
        
    cur.close()
    conn.commit()
    conn.close()
                
    with open(json_domain_path, 'wb') as jd:
        json.dump(old_domains, jd)
        
    print "All up-to-date!"
        
    
    
# Legacy: Get info from Tyk Dashboard API
#def parsing():
#    base_url = r"https://admin.cloud.tyk.io/api/portal/developers?p=-1"
#    auth = r"fb537f41eef94b4c615a1b6414ae0920"
#    
#    response = requests.get(base_url, headers={"authorization": auth})
#    data = json.loads(response.text)['Data']   
#    
#    print "JSON downloaded."
#    print "Start parsing..."
#    
#    users = {} # key is the 'id' field
#    
#    """Parse users and add new domains if necessary, then write JSON´s to disk.""" 
#    for entry in data:
#        user_id = entry['_id']
#        user_name = entry['fields'].get('Name', 'NA')
#        user_keys = entry['api_keys'].keys()
#        user_email = entry['email']
#        user_date = entry['date_created']
#        
#        users[user_id] = dict()
#        users[user_id]['name'] = user_name
#        users[user_id]['keys'] = user_keys
#        users[user_id]['email'] = user_email
#        users[user_id]['subscription_date'] = user_date
#        
#        try:
#            user_domain = user_email.split("@")[1].lower()
#        except:
#            user_domain = 'NA'
#        
#        if user_domain in old_domains['commercial']:
#            users[user_id]['type'] = "commercial"
#        elif user_domain in old_domains['private']:
#            users[user_id]['type'] = "private"
#        elif user_domain in old_domains['edu']:
#            users[user_id]['type'] = "edu"
#        elif user_domain in old_domains['junk']:
#            users[user_id]['type'] = "junk"
#        else:
#            domain_type = None
#            while domain_type == None:                
#                try:
#                    domain_type = userInput(user_domain)
#                except ValueError, e:
#                    print "\nWrong input! Choose from (-1, 0, 1, 2, 3)."
#                    domain_type = userInput(user_domain)
#            users[user_id]['type'] = domain_type
#            if user_domain not in domains[domain_type]:
#                domains[domain_type].append(user_domain)
#                print "Domain {} was added to {}.".format(user_domain, domain_type)
#            else:
#                print "Domain {} already existed in {}".format(user_domain, domain_type)
#        users[user_id]['domain'] = user_domain
#            
#    with open(json_domain_path, 'wb') as jd:
#        json.dump(old_domains, jd)
#    with open(json_users_path, 'wb') as ju:
#        json.dump(users, ju)
#    
#    print "Little DB´s are updated @ {}.".format(os.path.join(cwd, 'data'))

def plotStats(users):
    df_users = pd.DataFrame.from_dict(users, orient='index')
    df_users['key_count'] = df_users['keys'].str.len()
    gb = df_users.groupby(['type'])["type"].count().reset_index(name="count")
    gb_type = df_users.groupby(['type', 'key_count'])["type"].count().reset_index(name="count")
    
    
    plt.figure(figsize=(20,16))
    
    ax1 = plt.subplot(221, aspect='equal')
    ax1.set_title('Customer segmentation', fontsize=16, fontweight='bold')
    sbplt1 = gb.plot.pie(y = 'count', ax=ax1, autopct='%1.1f%%', 
     startangle=90, shadow=False, labels=gb['type'], legend=False, fontsize=14)
    sbplt1.set_ylabel('')
    
    ax2 = plt.subplot(222)
    ax2.set_title('Count how many API keys are active per account [commercial]', fontsize=16, fontweight='bold')
    gb_sub = gb_type.loc[gb_type['type'] == 'commercial']
    sbplt2 = gb_sub.set_index('key_count')['count'].plot.bar(ax=ax2, rot=0, fontsize=14)
    sbplt2.set_xlabel('Amount of API keys', fontsize=14, fontweight='bold')
    sbplt2.set_ylabel('Amount of account binned on API key amount', fontsize=14, fontweight='bold')
    sbplt2.annotate('Total commercial accounts: {}'.format(gb['count'].loc[gb['type'] == 'commercial'].sum()),
                    xy=(2,1), xytext=(1,700), textcoords='data', fontsize=14)
    

if __name__ == "__main__": 
    cwd = os.path.dirname(os.path.realpath(__file__))
    json_domain_path = os.path.join(cwd, 'data', 'domains.json')
    
    with open(json_domain_path, 'r') as json_out:
        old_domains = json.load(json_out)
    parseDB()
#    json_users_path = os.path.join(cwd, 'data', 'users.json')
    
#    with open(json_users_path) as json_users:
#        plotStats(json.load(json_users))
