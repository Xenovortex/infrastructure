# -*- coding: utf-8 -*-
import json
import requests
import pandas as pd
import MySQLdb as mysql

#tyk_auth_token = "fb537f41eef94b4c615a1b6414ae0920"
#
#api_id = "60b3f4b7a26d45c76f87d96a4c0b2113"
#key_id = "58d904a497c67e00015b45fc72754973a3e84c02a0d3cd73135fbba5"
#
#tyk_dashboard_apikey_url = "http://admin.cloud.tyk.io/api/apis/" + api_id + "/keys/" + key_id
#tyk_admin_headers = {
#    "authorization": tyk_auth_token,
#    "Content-Type": "application/json",
#    "Cache-Control": "no-cache"
#}
#
#resp = requests.delete(
#    tyk_dashboard_apikey_url,
#    headers=tyk_admin_headers)
#
#json_response = resp.json()
#
#print("Raw response from tyk dashboard: " + json.dumps(json_response))



base_url = r"https://admin.cloud.tyk.io/api/portal/developers?p=-1"
auth = r"fb537f41eef94b4c615a1b6414ae0920"

response = requests.get(base_url, headers={"authorization": auth})
data = json.loads(response.text)['Data']   

print "JSON downloaded."
print "Start parsing..."

data_df = pd.DataFrame(data)

data_dups = pd.concat(g for _, g in data_df.groupby('email') if len(g) > 1)

data_dups = data_dups[data_dups['email'].isin(['nils.nolde@zalando.de',
                                                  'nilsnolde@geophox.com'])]

conn = mysql.connect(host='127.0.0.1',
                     user='root',
                     passwd='admin',
                     db='wordpress')
    
cur = conn.cursor()

for _, row in data_dups[['_id', 'email']].iterrows():
    tyk_key, tyk_email = row
    print tyk_email, tyk_key
    sql = """SELECT user_id FROM wp_usermeta WHERE 
            meta_key = 'tyk_user_id' AND
            meta_value = %s
          """
    data = cur.execute(sql, (tyk_key, ))
    print str(data) + '\n'
    


conn = mysql.connect(host='127.0.0.1',
                     user='root',
                     passwd='admin',
                     db='wordpress')
    
cur = conn.cursor()

#"""Parse users and add new domains if necessary, then write JSONs to disk.""" 
#for entry in data:
#    user_id = entry['_id']
#    user_name = entry['fields'].get('Name', 'NA')
#    user_keys = entry['api_keys'].keys()
#    user_email = entry['email']
#    user_date = entry['date_created']
#    
#    users[user_id] = dict()
#    users[user_id]['name'] = user_name
#    users[user_id]['keys'] = user_keys
#    users[user_id]['email'] = user_email
#    users[user_id]['subscription_date'] = user_date
#    
#    try:
#        user_domain = user_email.split("@")[1].lower()
#    except:
#        user_domain = 'NA'
#    
#    if user_domain in old_domains['commercial']:
#        users[user_id]['type'] = "commercial"
#    elif user_domain in old_domains['private']:
#        users[user_id]['type'] = "private"
#    elif user_domain in old_domains['edu']:
#        users[user_id]['type'] = "edu"
#    elif user_domain in old_domains['junk']:
#        users[user_id]['type'] = "junk"
#    else:
#        domain_type = None
#        while domain_type == None:                
#            try:
#                domain_type = userInput(user_domain)
#            except ValueError, e:
#                print "\nWrong input! Choose from (-1, 0, 1, 2, 3)."
#                domain_type = userInput(user_domain)
#        users[user_id]['type'] = domain_type
#        if user_domain not in domains[domain_type]:
#            domains[domain_type].append(user_domain)
#            print "Domain {} was added to {}.".format(user_domain, domain_type)
#        else:
#            print "Domain {} already existed in {}".format(user_domain, domain_type)
#    users[user_id]['domain'] = user_domain
#        