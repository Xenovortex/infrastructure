# -*- coding: utf-8 -*-
import json
import requests
import pandas as pd
from datetime import datetime
import MySQLdb as mysql

"""CAUTION: Will delete users from WordPress and Tyk.

Will parse Tyk DB, look for duplicate emails and delete
the ones that don't have API keys set up from Tyk and WP DBs.

KNOW WHAT YOU'RE DOING!
"""

now = datetime.now()
today = '_'.join([str(x) for x in [now.year, now.month, now.day]])
"""Set up Tyk access"""
tyk_base_url = r"http://admin.cloud.tyk.io/api/portal/developers"
tyk_auth_token = r"fb537f41eef94b4c615a1b6414ae0920"
tyk_admin_headers = {
    "authorization": tyk_auth_token,
    "Content-Type": "application/json",
    "Cache-Control": "no-cache"
}

"""Set up WP DB access"""
conn = mysql.connect(host='127.0.0.1',
                     user='root',
                     passwd='admin',
                     db='wordpress')
#
#resp = requests.delete(
#    tyk_dashboard_apikey_url,
#    headers=tyk_admin_headers)
#
#json_response = resp.json()
#
#print("Raw response from tyk dashboard: " + json.dumps(json_response))


"""Parse Tyk DB"""
tyk_parse_url= tyk_base_url + "?p=-1"

response = requests.get(tyk_parse_url,
                        headers=tyk_admin_headers)

tyk_data = json.loads(response.text)['Data']   

print "Tyk data downloaded."
print "Start parsing..."

data_df = pd.DataFrame(tyk_data)
data_dups = pd.concat(g for _, g in data_df.groupby('email') if len(g) > 1)
#data_dups = data_dups[data_dups['email'].isin([
#                                                'nils.nolde@zalando.de',
#                                                #'nilsnolde@geophox.com'
#                                                  ])]
print "Parsing finished."
print "Deletion in progress..." 

"""Cache user details which should be deleted"""
deleted_emails = []
deleted_tyk_ids = []

"""Delete duplicate users"""
cur = conn.cursor()

for _, row in data_dups[['_id', 'api_keys', 'email']].iterrows():
    """Find out if user_id exists in WP"""
    
    tyk_key, tyk_api_keys, tyk_email = row
    sql = """SELECT user_id FROM wp_usermeta WHERE 
            meta_key = 'tyk_user_id' AND
            meta_value = %s
          """
    user_exists = cur.execute(sql, (tyk_key, ))
    
    if user_exists == 0:
        """Delete from Tyk if it doesn't"""
        tyk_delete_url = tyk_base_url + '/' + tyk_key
        resp = requests.delete(
            tyk_delete_url,
            headers=tyk_admin_headers)
        
    elif user_exists == 1:
        if tyk_api_keys:
            """Keep record in WP if API keys exist"""
            pass
        elif not tyk_api_keys:
            """Else cache email for notification"""
            deleted_tyk_ids.append(tyk_key)
            deleted_emails.append(tyk_email)

#TODO: Decide what to do with tyk_id's which don't have api_keys, 
#but are in the WP DB. Maybe implement 4 weeks latency
#sql = """SELECT user_id FROM wp_usermeta WHERE meta_value IN %s"""
#cur.execute(sql, (tuple(deleted_tyk_ids), ))
#deleted_wp_ids = cur.fetchall()

deleted_dict = {key: email for key, email in zip(deleted_tyk_ids, deleted_emails)}
print len(deleted_dict)

with open('WP_users_without_api_keys_{}.json'.format(today), 'wb') as f:
    json.dump(deleted_dict, f)
#data_dups.to_csv(r'duplicate_users_tyk.csv')       