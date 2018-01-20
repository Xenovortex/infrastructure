# -*- coding: utf-8 -*-
import json
import pandas as pd
from datetime import datetime
import time

import infrastructure_py.mail as mailer
import infrastructure_py.databases as db
#import MySQLdb as mysql

"""Will parse Tyk DB and notify users without api_keys since > 2 weeks to create
one. It will store a JSON with {tyk_id: tyk_email} to check 2 weeks later which
accounts created API keys and delete the ones which didn't.
"""

#TODO: Re-Write to only cache 28 day old accounts without API Keys to JSON and 
# also use Kibana/Lucene to find accounts which are inactive > 3-6 months,
# have separate script to delete those accounts.

def parseData():
    """Parse Tyk DB"""
    
    return pd.DataFrame(tyk.getDevs())


def updateDB(users_data):
    
    """Cache user details which should be deleted"""
    cached_emails = []
    cached_tyk_ids = []
    deleted_tyk_ids = []
    
    for _, row in users_data[['_id', 'date_created', 'api_keys', 'email']].iterrows():
        """Find out if user_id exists in WP"""
        
        tyk_key, tyk_raw_date, tyk_api_keys, tyk_email = row
        
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
    
    print "DB updated, {} devs deleted from Tyk.".format(len(deleted_tyk_ids))
    print "{} devs have no api_keys since > 28 days.".format(len(cached_dict))
    
    return cached_dict
    
    
def sendMailUsers(cached_dict):
    
    emails_users = ['support@openrouteservice.org'] + cached_dict.values() + ['support@openrouteservice.org']

    with open(r'user_notification_apology.html', 'r') as f:
        html_doc = f.read()
        
    msg_from = 'openrouteservice.org <notification@openrouteservice.org>'
    msg_reply = 'ORS Support <support@openrouteservice.org>'
    
    for idx, user in enumerate(emails_users):
        try:            
            smtp.sendHTML(subject="Please register an API key",
                          source=msg_from,
                          to=user,
                          content=html_doc,
                          reply_to=msg_reply
                          )
            
            print "{}, {}: success".format(idx, user)
        except:
            print "{}, {}: failure".format(idx, user)
            pass
        
        finally:
            time.sleep(1)
            
def sendMailors(users_amount):
    """Email notification to status@ors.org"""
    
    content = """Dear Team,
                this month, {} users have been notified to create API keys before their accounts
                will be deleted in 2 weeks.""".format(users_amount)

    smtp.sendText(subject="User overview for past month",
                  to=['status@openrouteservice.org'],
                  source='openrouteservice.org <notification@openrouteservice.org>',
                  content=content,
                  )
    
    return
    
    
if __name__== '__main__':   
    """Set up DB classes"""
    tyk = db.Tyk()
    
    """Set up mail instance"""
    smtp = mailer.Mailer()
    
    now = datetime.now()
    today = '_'.join([str(x) for x in [now.year, now.month, now.day]])
    
    users_data = parseData()
    
    print "Tyk data downloaded."
    
#    cached_dict = updateDB(users_data)
#    
#    sendMailUsers(cached_dict)
#    
#    sendMailors(len(cached_dict))

