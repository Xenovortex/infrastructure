# -*- coding: utf-8 -*-
"""
Created on Wed Dec 06 17:44:06 2017

@author: gisadmin
"""
import os, json

import pandas as pd
import requests

"""Build domain database from scratch.
CAREFUL: it will override domains.json
"""

base_url = r"https://admin.cloud.tyk.io/api/portal/developers?p=-1"
auth = r"fb537f41eef94b4c615a1b6414ae0920"
cwd = os.path.dirname(os.path.realpath(__file__))

response = requests.get(base_url, headers={"authorization": auth})
data = json.loads(response.text)['Data']

print "JSON downloaded."
print "Start parsing...\n"

users = {} # key is the 'id' field

domains = {}

"""Predefined categories""" 
domains['private'] = set(["gmail.com", "gmx.net", "gmx.de", "gmx.com", "hotmail.com", "outlook.com", "yahoo.com", "naver.com", 
                   "nate.com", "freenet.com", "web.com", "web.de", "t-online.de", "infinito.it",
                   "manetmail.com","live.co.uk", "libero.it", "live.nl", "mac.com", "posteo.net",
                   'live.ca', 'posteo.eu', 'web1.de', 'live.com', 'live.at', 'versatel.nl',
                   'msn.com', 'live.fr', 'sebastian-krebs.com', 'free.fr', 'live.be', 'aol.de', 'fastmail.fm',
                   'orange.fr', 'live.com.mx', 'aol.com', 'o2.pl', 'googlemail.com',
                   'icloud.com', 'me.com', 'arcor.de', 'live.de', 'email.cz', 'live.com.pt',
                   'florian-thiery.de', 'email.de', 'posteo.de', 'fastwebnet.it', 'yopmail.com', 'yahoo.com.br',
                   'yahoo.es', 'outlook.de', 'int.pl', 'cs.com', 'aol.nl', 'home.nl', 'hotmail.es', 'outlook.es',
                   'hotmail.com.tw'])
domains['edu'] = set(['uni-bremen.de', 'rwth-aachen.de', 'uwindsor.ca', 'berkeley.edu', 'wesleyan.edu',
               'kth.se', 'smail.th-koeln.de', 'griffith.edu.au', 'uwa.edu.au', 'ubc.ca',
               'students.mq.edu.ai','partner.kit.edu', 'nu.edu.kz', 'uni-heidelberg.de',
               'clarku.edu', 'live.unigis.net', 'uni-kassel.de', 'gdufs.edu.cn', 'mit.edu',
               'fh-muenster.de', 'stud.uni-heidelberg.de', 'med.uni-muenchen.de',
               'ncku.mail.edu.tw', 'uclmail.net', 'mail.ndhu.edu.tw', 'student.unimelb.edu.au',
               'uni-wuppertal.de', 'uach.mx', 'geo.uu.se', 'upenn.edu', 'hof-university.de','uam.es',
               'student.aau.dk', 'utwente.nl', 'comunidad.unam.mx', 'geo.tuwien.ac.at', 'th-wildau.de',
               'uhi.ac.uk', 'umd.edu', 'uni-hohenheim.de', 'fu-berlin.de', 'student.uantwerpen.be',
               'ems.ndhu.edu.tw', 'geo.uni-augsburg.de', 'buu.ac.th', 'tu-dortmund.de', 'media.ucla.edu',
               'student.dtu.dk', 'cuc.edu.cn', 'tu-berlin.de', 'ciencias.unam.mx', 'tu-bs.de', 'students.hs-mainz.de',
               'udc.es', 'geographie.uni-tuebingen.de', 'uni-osnabrueck.de', 'ntu.edu.tw', 'hks18.harvard.edu',
               'mail.usf.edu', 'ivk.uni-stuttgart.de', 'htw-berlin.de', 'mail.harvard.edu', 'upf.edu', 'uiowa.edu',
               'fa.ulisboa.pt', 'ruhr-uni-bochum.de', 'gms.ndhu.edu.tw', 'fas.harvard.edu', 'usal.es',
               'uni-due.de', 'student.hpi.de', 'post.rwth-aachen.de', 'email.arizona.edu', 'smail.uni-koeln.de',
               'unc.edu', 'tecnocampus.cat', 'eagles.usm.edu', 'epfl.ch', 'uniovi.es', 'jhu.edu', 'umu.se'])
domains['junk'] = set(['emailfake.ml', 'gtmail.com'])
domains['commercial'] = set()

for idx, entry in enumerate(data):
    user_id = entry['_id']
    user_email = entry['email']
    try:
        user_domain_ext = user_email.split("@")[1].lower()
        user_domain = user_domain_ext.split(".")[0]
    except:
        user_domain_ext = 'NA'
        user_domain = 'NA'
    
    users[user_id] = dict()
    users[user_id]['domain'] = user_domain_ext
    
    if user_domain_ext in domains['private']:
        users[user_id]['type'] = "private"
    elif user_domain_ext in domains['edu']:
        users[user_id]['type'] = "edu"
    elif user_domain_ext in domains['junk']:
        users[user_id]['type'] = "junk"
    else:
        try:
            res = requests.get("http://www." + user_domain_ext)
            if res.status_code in (200, 403, 410):
                domains['commercial'].add(user_domain_ext)
                users[user_id]['type'] = "commercial"
            else:
                print "{} {}: {}".format(idx, res.status_code, user_domain_ext)
                domains['junk'].add(user_domain_ext)
        except (requests.ConnectionError, requests.TooManyRedirects), e:
            domains['junk'].add(user_domain_ext)
            print "{} {}: {}".format(idx, e.__class__.__name__, user_domain_ext)

with open('domains.json', 'wb') as json_out:
    json.dump(domains, json_out)
    print "JSON written to disk."