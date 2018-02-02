# -*- coding: utf-8 -*-
import json
import pandas as pd
from datetime import datetime
import time

import infrastructure_py.mail as mailer
import infrastructure_py.databases as db
#import MySQLdb as mysql

from kibana_dashboard_api import VisualizationsManager, DashboardsManager
from elasticsearch import Elasticsearch

"""Will parse Kibana/Elasticsearch DB for users who are inactive for more than 3 months 
and store the result in a JSON with {tyk_id: tyk_email} and sent it to status@ors.org.

NOTE, delete_inactive_users.py depends on the output of the JSON created here.
"""

es_connection = Elasticsearch(hosts=['http://login:pass@localhost:9200/']) # what to put here?

visualizations = VisualizationsManager(es_connection)

# list all visualizations
vis_list = visualizations.get_all()
for vis in vis_list:
    print(vis.title)


#change the title of the first visualization and save it
vis = vis_list[0]
vis.title = 'New Title'
visualizations.update(vis)