# coding=utf-8
#!/usr/bin/python
import smtplib
from email.mime.multipart import MIMEMultipart
from email.mime.text import MIMEText

recipients = ['nilsnolde@gmail.com',
#              'tim@openrouteservice.org',
#              'hendrik@openrouteservice.org',
#              'zipf@uni-heidelberg.de',
#              'adam@openrouteservice.org'
              ]
#
#with open(r'mailchimp_permission_mail_test.html','r') as text:
#    body = text.read()
with open(r'welcome_mail.html','r') as text:
    body = text.read()
    
msg_from = 'openrouteservice.org <survey@openrouteservice.org>'
msg_reply = 'ORS Support <support@openrouteservice.org>'

msg = MIMEMultipart('alternative')

msg['Subject'] = 'openrouteservice needs your help'
msg['From'] = msg_from
msg['To'] = ','.join(recipients)
msg.add_header('reply-to', msg_reply)

msg_body = MIMEText(body, 'html', "utf-8")
msg.attach(msg_body)

s = smtplib.SMTP('smtp.strato.de', port=587)
s.login('support@openrouteservice.org', 'h4KABE2cgxF0')
s.sendmail(msg_from, recipients, msg.as_string())
s.quit()