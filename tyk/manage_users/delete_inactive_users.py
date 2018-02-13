# -*- coding: utf-8 -*-
import json
import pandas as pd
from datetime import datetime
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

    :param url: url of the Elastic Database
    :return: Elastic Database
    """
    es_data = Elasticsearch(hosts=[url])
    return es_data


def extract_indices(es_data):
    """
    Extract indices from Elastic Database

    :param es_data: Elastic Database
    :return: list with all extracted indices
    """
    index_lst = []
    indices = es_data.indices.get_alias().keys()
    for index in indices:
        index_lst.append(index)
    return index_lst


def is_date(date_text):
    """
    Check if a string represents a date

    :param date_text: string to check
    :return: boolean (true or false)
    """
    try:
        datetime.strptime(date_text, '%Y.%m.%d')
        return True
    except ValueError:
        return False



def extact_date(index_lst):
    """
    Extract dates from the indices

    :param index_lst: list of indices
    :return: list with the dates corresponding to the indices
    """
    date_lst = []
    for index in index_lst:
        date = index.split("-")[-1]
        if (is_date(date)):
            date_lst.append(date)
        else:
            date_lst.append("no date")
    return date_lst






def filter_index(index_lst, date_lst, last_days):
    """
    Filter all the indices and dates, which happened in the last x days. (x = last_days)

    :param index_lst: list of indices
    :param date_lst: list of dates corresponding to the indices
    :param last_days: number of days to filter from
    :return: list of filtered indices, list of filtered dates
    """
    pass
    


def extract_apikey(es_data, index_lst):
    """
    Extract api-key of all indices provided in the index list from the Elastic Database

    :param es_data: Elastic Database
    :param index_lst: list of indices
    :return: list of api-keys
    """
    data = es.search() # put index in here
    api_key_lst = []
    for i in range(0, len(data['hits']['hits'])):
        # issue: index logstash-gateway-nginx has api-key under arg_api_key
        # whereas index logstash-gateway-tyk has api-key under key
        api_key = data['hits']['hits'][i]['_source']['arg_api_key']
        if (not (api_key in api_key_lst) ):
            api_key_lst.append(api_key)
    return api_key_lst






