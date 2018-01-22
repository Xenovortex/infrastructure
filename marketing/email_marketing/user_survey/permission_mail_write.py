# -*- coding: utf-8 -*-

import os.path
import sys
sys.path.insert(0, os.path.abspath(__file__ + "/../../../../"))
print sys.path

import time

import infrastructure_py.databases as db
import infrastructure_py.mail as mail

cwd = os.path.dirname(os.path.realpath(__file__))

wp = db.WP(inst='live')
failed_emails = []
recipients = [tup[0] for tup in wp.getEmailsByClass('commercial')] + ['support@openrouteservice.org']

#
#recipients = ['nils@openrouteservice.org',
##              'timothy@openrouteservice.org',
##              'zipf@uni-heidelberg.de',
##              'hendrik@openrouteservice.org',
##              'adam@openrouteservice.org'
#              ]

with open(os.path.join(cwd, 'permission_mail_v01.html')) as f:
    html_doc = f.read()
    
msg_from = 'openrouteservice.org <survey@openrouteservice.org>'
msg_reply = 'ORS Support <support@openrouteservice.org>'

smtp = mail.Mailer()
for email in recipients:
    try:
        smtp.sendHTML(subject="openrouteservice needs your help",
                      source=msg_from,
                      to=[email],
                      content=html_doc,
                      reply_to=msg_reply
                      )
        print "{}: success.".format(email)
    except:
        failed_emails.append(email)
        print "{}: failed.".format(email)
        pass
    
    finally:
        time.sleep(1)
    
        
contents = ("Huhu,\n"
           "the emails are out and out of {}:\n"
           "    - {} addresses worked\n"
           "    - {} addresses failed to send:\n{}"
           ).format(len(recipients),
                   len(recipients) - len(failed_emails),
                   len(failed_emails),
                   "\n".join(failed_emails)
                   )

smtp.sendText(subject="Status of survey mass mailing",
              source=msg_from,
              to=[msg_reply],
              content=contents
              )