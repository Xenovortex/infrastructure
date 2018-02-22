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

"""Will parse Elasticsearch DB for users who are inactive for more than 3 months 
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
        datetime.strptime(date_text, "%Y.%m.%d")
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

def concurrent_delete(lst_1, lst_2, to_delete_indices):
    """
    Take 2 lists of same length and a list of indices to delete. Delete elements in both lists at the indices.

    :param lst_1: list 1
    :param lst_2: list 2
    :param to_delete_indices: indices to delete
    :return: lst_1, lst_2 (elements deleted at all indices in to_delete_indices)
    """
    to_delete_indices.sort()
    for i in reversed(to_delete_indices):
        del lst_1[i]
        del lst_2[i]
    return lst_1, lst_2


def delete_no_date_indices(index_lst, date_lst):
    """
    Delete all entries in date_lst that has "no date" and the corresponding entries in index_lst

    :param index_lst: list of indices
    :param date_lst: list of dates corresponding to the indices
    :return: index_lst, date_lst
    """
    to_delete_indices = []
    for i in range(0, len(date_lst)):
        if (date_lst[i] == "no date"):
            to_delete_indices.append(i)
    index_lst, date_lst = concurrent_delete(index_lst, date_lst, to_delete_indices)
    return  index_lst, date_lst


def filter_indices_last_days(index_lst, date_lst, last_days):
    """
    Filter all the indices and dates, which happened in the last x days. (x = last_days)

    :param index_lst: list of indices
    :param date_lst: list of dates corresponding to the indices
    :param last_days: number of days to filter from
    :return: list of filtered indices, list of filtered dates
    """
    date_today = datetime.strptime(datetime.now().strftime("%Y.%m.%d"), "%Y.%m.%d")
    to_delete_indices = []
    for i in range(0, len(date_lst)):
        if abs((date_today - datetime.strptime(date_lst[i], "%Y.%m.%d")).days) > last_days:
            to_delete_indices.append(i)
    index_lst, date_lst = concurrent_delete(index_lst, date_lst, to_delete_indices)
    return index_lst, date_lst


def has_field(index, field, i=0):
    """
    Check if a field exists within '_source' of the given index. If the index has more than one '_source'
    (list of '_source'), use index i to select the _source you want to check. By default the first _source in the list
    will be picked.

    :param index: index from the Elastic Database
    :param field: field to search for
    :param i: index (used to select one '_source', if there are more than one. By default the first one is picked)
    :return: bool value
    """
    data = es.search(index=index, filter_path='hits.hits._source')
    try:
        data['hits']['hits'][i]['_source'][field]
        return True
    except KeyError:
        return False


def extract_apikey(es_data, index_lst):
    """
    Extract api-key of all indices provided in the index list from the Elastic Database

    :param es_data: Elastic Database
    :param index_lst: list of indices
    :return: list of api-keys
    """
    for index in index_lst:
        data = es.search(index)
    data = es.search() # put index in here
    api_key_lst = []
    for i in range(0, len(data['hits']['hits'])):
        # issue: index logstash-gateway-nginx has api-key under arg_api_key
        # whereas index logstash-gateway-tyk has api-key under key
        api_key = data['hits']['hits'][i]['_source']['arg_api_key']
        if (not (api_key in api_key_lst) ):
            api_key_lst.append(api_key)
    return api_key_lst






