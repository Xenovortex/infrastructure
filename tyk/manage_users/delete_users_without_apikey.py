# -*- coding: utf-8 -*-
import json
import pandas as pd

import infrastructure_py.databases as db
import infrastructure_py.mail as mail
#import MySQLdb as mysql

"""CAUTION: Will delete users from WordPress and Tyk.

Will parse latest users_without_api_keys.json, see if users created API keys
and delete the ones who didn't from WP and Tyk.

KNOW WHAT YOU'RE DOING!
"""

def parseJSON():    
    """Parse JSON"""
    return json.load(open('data/users_without_api_keys.json', 'r'))
    

def validate(cached_users):
    """validate with Tyk if anything changed"""
    tyk = db.Tyk()
    actual_devs = pd.DataFrame(tyk.getDevs()).set_index('_id')
    actual_devs = actual_devs[actual_devs['api_keys'] == {}]
    cached_devs = pd.DataFrame.from_dict(cached_users, orient='index')
    
    return pd.concat([actual_devs, cached_devs], axis=1, join='inner')[['email']]
    

def deleteFromTyk(delete_devs):
    """delete leftover records from Tyk"""
    tyk = db.Tyk()
    for tyk_key, email in delete_devs.iterrows():
        tyk.deleteDev(tyk_key)
    return
    

def deleteFromWP(delete_devs):
    wp = db.WP()
    """delete leftover records from WP"""
    ids = wp.getWPidsByEmail(delete_devs['email'].tolist())
    try:
        wp.deleteUserByWPids(ids)
        wp.commit()
    except:
        raise
    finally:
        wp.close()
    
    return


def sendMailToORS(deleted_number):
    """Send mail to status@ors.org upon completion of script"""
    mailer = mail.Mailer()
    cont = ("Hi Team,\n"
           "{} developers were deleted from Tyk and WP.").format(deleted_number)
           
    mailer.sendText(subject="{} users deleted".format(deleted_number),
                    source='CRM ORS <crm@openrouteservice.org>',
                    to=['nilsnolde@gmail.com'],
                    content=cont)
    
    return
    
    
if __name__== '__main__':       
    cached_users = parseJSON()
    
    test_mail = ['nils.nolde@zalando.de']
    
    delete_devs = validate(cached_users)
    
    deleteFromWP(delete_devs)
    
    sendMailToORS(len(delete_devs))
    
#    deleteFromTyk(delete_devs)
#    
#    sendMail(cached_dict)