#!/usr/bin/env python
# -*- coding: utf-8 -*-
import os
import sys
import logging.config
import json

LOGGING_CONF_FILE = 'logging.json'
DEFAULT_LOGGING_LVL = logging.INFO
path = LOGGING_CONF_FILE
value = os.getenv('LOG_CFG', None)
if value:
    path = value
if os.path.exists(path):
    with open(path, 'rt') as f:
       config = json.load(f)
    logging.config.dictConfig(config)
else:
    logging.basicConfig(
        format='%(asctime)s - %(name)s - %(levelname)s - %(message)s',
        level=logging.INFO)
logger = logging.getLogger(__name__)

from flask import Flask

PROJECT_DIR, PROJECT_MODULE_NAME = os.path.split(
    os.path.dirname(os.path.realpath(__file__))
)

ORS_GATEWAY_EVENT_HANDLER_DIR = os.path.join(PROJECT_DIR, os.pardir)
if os.path.exists(ORS_GATEWAY_EVENT_HANDLER_DIR) \
        and ORS_GATEWAY_EVENT_HANDLER_DIR not in sys.path:
    sys.path.append(ORS_GATEWAY_EVENT_HANDLER_DIR)

import smtplib
from email.mime.multipart import MIMEMultipart
from email.mime.text import MIMEText
from flask import request

app = Flask(__name__)


@app.route('/', methods=['POST'])
def gateway_events_handler():
    if request.headers['x-auth'] == 'ors-tyk-gateway':
        event_body = request.get_json()
        msg_subject = "ORS Gateway Event: " + str(event_body['event'])
        with open('contacts.json') as cf:
            contacts = json.load(cf)
        for r in contacts['receivers']:
            send_mail(contacts['sender']['smtp'], contacts['sender']['port'],
                      contacts['sender']['email'],
                      contacts['sender']['password'], r['email'], msg_subject,
                      json.dumps(event_body))
        return "Alert e-mails have been sent"
    return ("Unauthorised request", 401, {})


def send_mail(smtp_host, smtp_port, from_addr, password, to_addr, msg_subject,
              msg_text):
    s = smtplib.SMTP_SSL(smtp_host)
    s.login(from_addr, str(password))

    mime_msg = MIMEMultipart()  # create a message
    mime_msg['From'] = from_addr
    mime_msg['To'] = to_addr
    mime_msg['Subject'] = msg_subject
    mime_msg.attach(MIMEText(msg_text, 'plain'))

    s.sendmail(from_addr, to_addr, mime_msg.as_string())
    s.quit()

if __name__ == '__main__':
    app.run(host='127.0.0.1', debug=True)
