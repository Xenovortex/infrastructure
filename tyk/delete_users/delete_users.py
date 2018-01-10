# -*- coding: utf-8 -*-
import json
import requests
import pandas as pd
from datetime import datetime

import smtplib
from email.mime.multipart import MIMEMultipart
from email.mime.text import MIMEText
import MySQLdb as mysql

"""CAUTION: Will delete users from WordPress and Tyk.

Will parse Tyk DB, look for duplicate emails and delete
the ones that don't have API keys set up from Tyk and WP DBs.

Also will notify users without api_keys since > 2 weeks to create
one, otherwise their accounts will be deleted, too.

KNOW WHAT YOU'RE DOING!
"""

def parseData():    
    """Parse Tyk DB"""
    tyk_parse_url= tyk_base_url + "?p=-1"
    
    response = requests.get(tyk_parse_url,
                            headers=tyk_admin_headers)
    
    tyk_data = json.loads(response.text)['Data']   
    
    print "Tyk data downloaded."
    print "Start parsing..."
    
    data_df = pd.DataFrame(tyk_data)
    data_dups = data_df
#    data_dups = pd.concat(g for _, g in data_df.groupby('email') if len(g) > 1)
#    data_dups = data_dups[data_dups['email'].isin([
#                                                    'nils.nolde@zalando.de',
#                                                    #'nilsnolde@geophox.com'
#                                                      ])]
    print "Parsing finished."
    
    return data_dups


def updateDB(data_dups):
    """Set up WP DB access"""
    conn = mysql.connect(host='172.18.0.2',
                         user='root',
                         passwd='admin',
                         db='wordpress')
    
    """Cache user details which should be deleted"""
    cached_emails = []
    cached_tyk_ids = []
    deleted_tyk_ids = []
    
    """Delete duplicate users"""
    cur = conn.cursor()
    
    for _, row in data_dups[['_id', 'date_created', 'api_keys', 'email']].iterrows():
        """Find out if user_id exists in WP"""
        
        tyk_key, tyk_raw_date, tyk_api_keys, tyk_email = row
        sql = """SELECT user_id FROM wp_usermeta WHERE 
                meta_key = 'tyk_user_id' AND
                meta_value = %s
              """
        user_exists = cur.execute(sql, (tyk_key, ))
        
        if user_exists == 0:
            """Delete from Tyk if it doesn't"""
#            tyk_delete_url = tyk_base_url + '/' + tyk_key
#            resp = requests.delete(
#                tyk_delete_url,
#                headers=tyk_admin_headers)
#            deleted_tyk_ids.append(tyk_key)
            
        elif user_exists == 1:
            if tyk_api_keys:
                """Keep record in WP if API keys exist"""
                pass
            elif not tyk_api_keys:
                try:
                    py_date = datetime.strptime(tyk_raw_date, "%Y-%m-%dT%H:%M:%S.%fZ")
                except ValueError:
                    py_date = datetime.strptime(tyk_raw_date, "%Y-%m-%dT%H:%M:%SZ")
                delta = now - py_date
                if delta.days >= 28:
                    """Else cache email for notification"""
                    cached_tyk_ids.append(tyk_key)
                    cached_emails.append(tyk_email)
    
    cached_dict = {key: email for key, email in zip(cached_tyk_ids, cached_emails)}
    
    with open('WP_users_without_api_keys_{}.json'.format(today), 'wb') as f:
        json.dump(cached_dict, f)
    #data_dups.to_csv(r'duplicate_users_tyk.csv')
    
    print "DB updated, {} devs deleted from Tyk.".format(len(deleted_tyk_ids))
    print "{} devs have no api_keys since > 28 days.".format(len(cached_dict))
    
    return cached_dict
    
    
def sendMail(cached_dict):
    bcc_users = cached_dict.values() + ['nils.nolde@gmail.com']
    
    with open(r'user_notification.html', 'r') as f:
        html_doc = f.read()
        
    msg_to = 'support@openrouteservice.org'
    msg_from = 'openrouteservice.org <notification@openrouteservice.org>'
    msg_reply = 'ORS Support <support@openrouteservice.org>'
    
    msg = MIMEMultipart('alternative')
    
    msg['Subject'] = "Please register an API key"
    msg['From'] = msg_from
    msg['To'] = msg_to
#    msg['Cc'] = ','.join(cc_users)
    msg.add_header('reply-to', msg_reply)
    
    msg_to = [msg_to]
#    msg_to += cc_users
    msg_to += bcc_users
    
    msg_body = MIMEText(html_doc, 'html', "utf-8")
    msg.attach(msg_body)
    
    s = smtplib.SMTP('smtp.strato.de', port=587)
    s.login('support@openrouteservice.org', 'h4KABE2cgxF0')
    s.sendmail(msg_from, msg_to, msg.as_string())
    s.quit()
    
    return
    
    
if __name__== '__main__':   
    """Set up Tyk access"""
    tyk_auth_token = r"fb537f41eef94b4c615a1b6414ae0920"
    tyk_admin_headers = {
        "authorization": tyk_auth_token,
        "Content-Type": "application/json",
        "Cache-Control": "no-cache"
    }
    tyk_base_url = r"http://admin.cloud.tyk.io/api/portal/developers"
    
    now = datetime.now()
    today = '_'.join([str(x) for x in [now.year, now.month, now.day]])
    
    data_dups = parseData()
    
    print "Deletion in progress..." 
    
    cached_dict = updateDB(data_dups)
    
    sendMail(cached_dict)