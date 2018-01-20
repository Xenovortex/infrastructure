# -*- coding: utf-8 -*-

import os
import smtplib

from email.mime.multipart import MIMEMultipart
from email.mime.text import MIMEText

class Mailer:
    def __init__(self, user='support@openrouteservice.org',
                 password='h4KABE2cgxF0',
                 server='smtp.strato.de',
                 port=587
                 ):
        self.server = server
        self.port = port
        self.user = user
        self.password = password

    def _send(self, **kwargs):
        
        mandatory_args = ["subject","source","to","content","content_type"]
        for x in mandatory_args:
            if not kwargs.get(x, False):
                raise ValueError("{} is mandatory".format(x))

        msg = MIMEMultipart('alternative')
        msg['Subject'] = kwargs['subject']
        msg['From'] = kwargs['source']
        msg['To'] = ",".join(kwargs['to'])
        
        if kwargs.get('cc', False):
            msg['Cc'] = ','.join(kwargs['cc'])
            kwargs['to'] += kwargs['cc']
        if kwargs.get('reply_to', False):
            msg.add_header('reply-to', kwargs['reply_to'])

        content = MIMEText(kwargs['content'], kwargs['content_type'], 'utf-8')
        msg.attach(content)
        s = smtplib.SMTP(self.server, self.port)
        s.login(self.user, self.password)
        s.sendmail(msg['From'], kwargs['to'], msg.as_string())
        s.quit()
        
    def sendHTML(self,**kwargs):
        """Send HTML emails.
        
        Accepts only keyworded arguments.
        
        :param subject: Subject of email.
        :type subject: list or tuple
        
        :param source: From address.
        :type source: str
        
        :param to: To Address(es).
        :type to: list or tuple
        
        :param content: Content in HTML.
        :type content: str
        
        :param cc: Cc addresses(es)
        :type cc: list or tuple
        
        :param reply_to: If 'source' is not a valid email account, e.g. survey@ors.org
        :type reply_to: str
        """
        
        kwargs['content_type'] = "html"
        return self._send(**kwargs)

    def sendText(self, **kwargs):
        """Send plain text emails.
        
        Accepts only keyworded arguments.
        
        :param subject: Subject of email.
        :type subject: list or tuple
        
        :param source: From address.
        :type source: str
        
        :param to: To Address(es).
        :type to: list or tuple
        
        :param content: Content in plain text.
        :type content: str
        
        :param cc: Cc addresses(es)
        :type cc: list or tuple
        
        :param reply_to: If 'source' is not a valid email account.
        :type reply_to: str
        """
        kwargs['content_type'] = "plain"
        return self._send(**kwargs)