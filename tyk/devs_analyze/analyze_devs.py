# -*- coding: utf-8 -*-
import os, json
import pandas as pd
import requests
import matplotlib.pyplot as plt
import numpy as np

"""Download all developer data, determine if domain is already registered in 
domains.json and if necessary, user registers new domains manually with raw_input.
"""

cwd = os.path.dirname(os.path.realpath(__file__))
json_domain_path = os.path.join(cwd, 'data', 'domains.json')
json_users_path = os.path.join(cwd, 'data', 'users.json')
    
def userInput(user_domain):
    choice = int(raw_input('Domain {} is not registered yet.\nPlease specify type:\n'
                           '0 [Commercial], 1 [Private], 2 [Edu], 3 [Junk]\n> '.format(user_domain)))
    
    if choice == 0:
        return 'commercial'
    elif choice == 1:
        return 'private'
    elif choice == 2:
        return 'edu'
    elif choice == 3:
        return 'junk'
    else:
        print "\nWrong input! Choose from (0, 1, 2, 3)."
        userInput(user_domain)
        
def main():
    base_url = r"https://admin.cloud.tyk.io/api/portal/developers?p=-1"
    auth = r"fb537f41eef94b4c615a1b6414ae0920"
    
    response = requests.get(base_url, headers={"authorization": auth})
    data = json.loads(response.text)['Data']
    with open(json_domain_path, 'r') as json_out:
        domains = json.load(json_out)
    
    print "JSON downloaded."
    print "Start parsing..."
    
    users = {} # key is the 'id' field
    
    """Parse users and add new domains if necessary, then write JSON´s to disk.""" 
    for entry in data:
        user_id = entry['_id']
        user_name = entry['fields'].get('Name', 'NA')
        user_keys = entry['api_keys'].keys()
        user_email = entry['email']
        user_date = entry['date_created']
        
        users[user_id] = dict()
        users[user_id]['name'] = user_name
        users[user_id]['keys'] = user_keys
        users[user_id]['email'] = user_email
        users[user_id]['subscription_date'] = user_date
        
        try:
            user_domain = user_email.split("@")[1].lower()
        except:
            user_domain = 'NA'
        
        if user_domain in domains['commercial']:
            users[user_id]['type'] = "commercial"
        elif user_domain in domains['private']:
            users[user_id]['type'] = "private"
        elif user_domain in domains['edu']:
            users[user_id]['type'] = "edu"
        elif user_domain in domains['junk']:
            users[user_id]['type'] = "junk"
        else:
            domain_type = userInput(user_domain)
            print domain_type
            users[user_id]['type'] = domain_type
            if user_domain not in domains[domain_type]:
                domains[domain_type].append(user_domain)
                print "Domain {} was added to {}.".format(user_domain, domain_type)
            else:
                print "Domain {} already existed in {}".format(user_domain, domain_type)
        users[user_id]['domain'] = user_domain
            
    with open(json_domain_path, 'wb') as jd:
        json.dump(domains, jd)
    with open(json_users_path, 'wb') as ju:
        json.dump(users, ju)

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
#    main()
    with open(json_users_path) as json_users:
        plotStats(json.load(json_users))
    
#TODO: Count 'keys' to proxy usage per channel and plot.