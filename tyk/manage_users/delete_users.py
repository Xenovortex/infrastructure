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

Will parse latest users_without_api_keys.json, see if users created API keys
and delete the ones who didn't from WP and Tyk.

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
    
    return pd.concat([actual_devs, cached_devs], axis=1, join='inner')[['email']]
    

def deleteFromTyk(delete_devs):
    """delete leftover records from Tyk"""
    for tyk_key, _ in delete_devs.iterrows():
        print tyk_key#tyk.deleteDevs(dev)
    
    
if __name__== '__main__':   
    """Set up DB accesses"""
    tyk = db.Tyk()
#    wp = db.WP()
    
    cached_users = parseJSON()
    
    delete_devs = validate(cached_users)
    
    deleteFromTyk(delete_devs)
#    
#    sendMail(cached_dict)