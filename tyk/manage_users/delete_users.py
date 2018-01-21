# -*- coding: utf-8 -*-
import json
import pandas as pd
from datetime import datetime
import time

import smtplib
from email.mime.multipart import MIMEMultipart
from email.mime.text import MIMEText

import infrastructure_py.databases as db
#import MySQLdb as mysql

"""CAUTION: Will delete users from WordPress and Tyk.

Will parse Tyk DB, look for duplicate emails and delete
the ones that don't have API keys set up from Tyk and WP DBs.

Also will notify users without api_keys since > 2 weeks to create
one, otherwise their accounts will be deleted, too.

KNOW WHAT YOU'RE DOING!
"""

def parseJSON():    
    """Parse JSON"""
    return json.load(open('users_without_api_keys.json', 'r'))
    

def validate(cached_users):
    """validate with Tyk if anything changed"""
    actual_devs = pd.DataFrame(tyk.getDevs()).set_index('_id')
    actual_devs = actual_devs[actual_devs['api_keys'] == {}]
    cached_devs = pd.DataFrame.from_dict(cached_users, orient='index')
    
    print pd.concat([actual_devs, cached_devs], axis=1, join='inner')['email']
    

def deleteFromDB(data_dups):
    
    """Cache user details which should be deleted"""
    cached_emails = []
    cached_tyk_ids = []
    deleted_tyk_ids = []
    
    """Delete duplicate users"""
    cur = conn.cursor()
    
    for _, row in data_dups[['_id', 'date_created', 'api_keys', 'email']].iterrows():
        """Find out if user_id exists in WP"""
        
        tyk_key, tyk_raw_date, tyk_api_keys, tyk_email = row
        sql = """SELECT user_id
                FROM wp_usermeta
                WHERE 
                meta_key = 'tyk_user_id'
                AND
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
    emails_users = ['support@openrouteservice.org'] + cached_dict.values() + ['support@openrouteservice.org']

    with open(r'user_notification_apology.html', 'r') as f:
        html_doc = f.read()
        
    msg_from = 'openrouteservice.org <notification@openrouteservice.org>'
    msg_reply = 'ORS Support <support@openrouteservice.org>'
    
    for idx, user in enumerate(emails_users):
        try:
        #    msg_to += cc_users        
            msg = MIMEMultipart('alternative')
            
            msg['To'] = user
            msg['Subject'] = "Please register an API key"
            msg['From'] = msg_from
        #    msg['Cc'] = ','.join(cc_users)
            msg.add_header('reply-to', msg_reply)
            
            msg_body = MIMEText(html_doc, 'html', "utf-8")
            msg.attach(msg_body)
            
            s = smtplib.SMTP('smtp.strato.de', port=587)
            s.login('support@openrouteservice.org', 'h4KABE2cgxF0')
            s.sendmail(msg_from, user, msg.as_string())
            s.quit()
            
            print "{}, {}: success".format(idx, user)
        except:
            print "{}, {}: failure".format(idx, user)
            pass
        
        finally:
            time.sleep(1)
    
    return
    
    
if __name__== '__main__':   
    """Set up Tyk access"""
    tyk = db.Tyk()
    wp = db.WP()
    
    cached_users = parseJSON()
    
    validate(cached_users)
    
#    print "Deletion in progress..." 
#    
#    cached_dict = updateDB(data_dups)
#    
#    sendMail(cached_dict)