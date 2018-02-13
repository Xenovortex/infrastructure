# -*- coding: utf-8 -*-
import json
import pandas as pd
#from datetime import datetime
#import time

#import infrastructure_py.mail as mailer
import infrastructure_py.databases as db
#import MySQLdb as mysql

#from kibana_dashboard_api import VisualizationsManager, DashboardsManager
from elasticsearch import Elasticsearch

"""Will parse Kibana/Elasticsearch DB for users who are inactive for more than 3 months 
and store the result in a JSON with {tyk_id: tyk_email} and sent it to status@ors.org.

NOTE, delete_inactive_users.py depends on the output of the JSON created here.
"""

def get_elastic_database(url):
    """
    Access Elastic Database from input url

    :param url:
    :return: elastic database
    """
    es_data = Elasticsearch(hosts=[url])
    return es_data


def extract_indices(es_data):
    """
    Extract indices from Elastic Database

    :param es_data:
    :return: list with all extracted indices
    """
    index_lst = []
    indices = es_data.indices.get_alias().keys()
    for index in indices:
        index_lst.append(index)
    return index_lst


"""
def search_index_last_3month(es_data):
    


def parse_database(es_data):
    data = es.search() # put index in here
    api_key_lst = []
    for i in range(0, len(data['hits']['hits'])):
        api_key = data['hits']['hits'][i]['_source']['arg_api_key']
        if (not (api_key in api_key_lst) ):
            api_key_lst.append(api_key)
    return api_key_lst
"""





