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
    os.path.dirname(os.path.realpath(__file__)))

ORS_GATEWAY_EVENT_HANDLER_DIR = os.path.join(PROJECT_DIR, os.pardir)
if os.path.exists(ORS_GATEWAY_EVENT_HANDLER_DIR) \
        and ORS_GATEWAY_EVENT_HANDLER_DIR not in sys.path:
    sys.path.append(ORS_GATEWAY_EVENT_HANDLER_DIR)

import smtplib
from email.mime.multipart import MIMEMultipart
from email.mime.text import MIMEText
from string import Template
from flask import request
from socket import error as socket_err

app = Flask(__name__)
with open('ors_api_conf.json') as cf:
    ors_api_conf = json.load(cf)


@app.route('/', methods=['POST'])
def gateway_events_handler():
    logger.info("Get POST request from tyk gateway.")
    event_body = request.get_json(force=True)
    if event_body == None:
        logger.error("Request body in the request has problems")
        return ("Bad request content", 400, {})
    logger.info("Event body: " + json.dumps(event_body))
    if request.headers['x-auth'] == 'ors-tyk-gateway':
        msg_subject = "ORS Gateway Event: " + str(event_body['event'])
        msg_template = read_template('event_message_template.txt')
        with open('contacts.json') as cf:
            contacts = json.load(cf)
        for r in contacts['receivers']:
            send_mail(
                contacts['sender']['smtp'],
                contacts['sender']['port'],
                contacts['sender']['email'],
                contacts['sender']['password'],
                r['email'],
                msg_subject,
                msg_template.substitute(
                    NAME=r['name'], EVENT_CONTENT=format_event(event_body)))
        return "Alert e-mails have been sent"
    return ("Unauthorised request", 401, {})

def format_event(body):
    formatted_msg = ""
    for k,v in body.items():
        formatted_msg += (str(k) + ': ' + str(v) + '\n')
    return formatted_msg

def send_mail(smtp_host, smtp_port, from_addr, password, to_addr, msg_subject,
              msg_text):
    try:
        s = None
        s = smtplib.SMTP_SSL(smtp_host, smtp_port)
        s.login(from_addr, str(password))

        mime_msg = MIMEMultipart()  # create a message
        mime_msg['From'] = from_addr
        mime_msg['To'] = to_addr
        mime_msg['Subject'] = msg_subject
        mime_msg.attach(MIMEText(msg_text, 'plain'))

        s.sendmail(from_addr, to_addr, mime_msg.as_string())
        logger.info("Message: " + msg_subject + " sent successfully to " +
                    smtp_host + ":" + str(smtp_port))
        logger.info("Message: " + msg_subject + " had sender: " + from_addr)
        logger.info("Message: " + msg_subject + " had recipient(s): " +
                    to_addr)
    except socket_err as e:
        logger.error("Could not connect to " + smtp_host + ":" + str(smtp_port)
                     + " - is it listening / up?")
    except:
        logger.error("Unknown error:" + sys.exc_info()[0])
    finally:
        if s != None:
            s.quit()


def read_template(filename):
    """
    Returns a Template object comprising the contents of the
    file specified by filename.
    """
    with open(filename, 'r') as template_file:
        template_file_content = template_file.read()
    return Template(template_file_content)


if __name__ == '__main__':
    app.run(host='127.0.0.1', debug=True)
