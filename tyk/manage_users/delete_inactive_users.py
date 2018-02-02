# -*- coding: utf-8 -*-
import json
import pandas as pd
from datetime import datetime
import time

import infrastructure_py.mail as mailer
import infrastructure_py.databases as db
#import MySQLdb as mysql

"""Will parse Kibana/Elasticsearch DB for users who are inactive for more than 3 months 
and store the result in a JSON with {tyk_id: tyk_email} and sent it to status@ors.org.

NOTE, delete_inactive_users.py depends on the output of the JSON created here.
"""