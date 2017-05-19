import json
import smtplib
from email.mime.multipart import MIMEMultipart
from email.mime.text import MIMEText
from flask import Flask
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
    return "Unauthorised request"


def send_mail(smtp_host, smtp_port, from_addr, password, to_addr, msg_subject,
              msg_text):
    s = smtplib.SMTP_SSL(smtp_host)
    s.login(from_addr, password)

    mime_msg = MIMEMultipart()  # create a message
    mime_msg['From'] = from_addr
    mime_msg['To'] = to_addr
    mime_msg['Subject'] = msg_subject
    mime_msg.attach(MIMEText(msg_text, 'plain'))

    s.sendmail(from_addr, to_addr, mime_msg.as_string())
    s.quit()
