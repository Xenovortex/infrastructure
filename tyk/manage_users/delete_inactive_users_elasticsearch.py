# -*- coding: utf-8 -*-
import json
import pandas as pd
from datetime import datetime
#import time

#import infrastructure_py.mail as mailer
#import infrastructure_py.databases as db
#import MySQLdb as mysql

#from kibana_dashboard_api import VisualizationsManager, DashboardsManager
from elasticsearch import Elasticsearch

"""Will parse Elasticsearch DB for users who are inactive for more than 3 months 
and store the result in a JSON with {tyk_id: tyk_email} and sent it to status@ors.org.

NOTE, delete_inactive_users.py depends on the output of the JSON created here.
"""

def get_elastic_database(url):
    """
    Access Elastic Database with input url

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
    Take 2 lists of same length and a list of indices to delete. Delete elements in both lists at those indices.

    :param lst_1: list 1
    :param lst_2: list 2
    :param to_delete_indices: list of indices to delete
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
    :return: index_lst, date_lst (all "no date" entries in date_lst and the corresponding entries in index_lst deleted)
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


def has_field(es_data, index, field, i=0):
    """
    Check if a field exists within '_source' of the given index. If the index has more than one '_source'
    (list of '_source'), use index i to select the _source you want to check. By default the first _source in the list
    will be picked.

    :param es_data: Elastic Database
    :param index: index from the Elastic Database
    :param field: field to search for
    :param i: index (used to select one '_source', if there are more than one. By default the first one is picked)
    :return: boolean
    """
    data = es_data.search(index=index, filter_path='hits.hits._source')
    try:
        data['hits']['hits'][i]['_source'][field]
        return True
    except KeyError:
        return False


def check_valid_key(key):
    """
    Check if a extracted key is valid. Current validation conditions include:
        1) key must have 56 characters (including numbers)

    :param key: key to check as string
    :return: boolean
    """
    return True if len(key) == 56 else False



def extract_apikey(es_data, index_lst):
    """
    Extract api-key of all indices provided in the index list from the Elastic Database. Create a list of dates
    corresponding to the api-keys.

    :param es_data: Elastic Database
    :param index_lst: list of indices
    :return: list of api-keys, list of corresponding dates, list of identified indices, list of not valid api-keys
    """
    api_key_lst = []
    api_date_lst = []
    api_index_lst = [] #Debug: to delete later
    not_identified_indices = []
    not_valid_keys = []
    for index in index_lst:
        data = es_data.search(index=index, filter_path='hits.hits._source')
        name_without_date = index.split("-")[:-1]
        date = index.split("-")[-1]
        if name_without_date[-1] == "tyk":
            for i in range(0, len(data['hits']['hits'])):
                if has_field(es_data, index, 'key', i):
                    api_key = data['hits']['hits'][i]['_source']['key']
                    if check_valid_key(api_key):
                        api_key_lst.append(api_key)
                        api_date_lst.append(date)
                        api_index_lst.append(index)  # Debug: to delete later
                    else:
                        not_valid_keys.append(api_key)
        elif (name_without_date[-1] == "nginx"):  #name_without_date[-1] == "hybrid"
            for i in range(0, len(data['hits']['hits'])):
                if has_field(es_data, index, 'arg_api_key', i):
                    api_key = data['hits']['hits'][i]['_source']['arg_api_key']
                    if check_valid_key(api_key):
                        api_key_lst.append(api_key)
                        api_date_lst.append(date)
                        api_index_lst.append(index) #Debug: to delete later
                    else:
                        not_valid_keys.append(api_key)
        else:
            not_identified_indices.append(index)
    return api_key_lst, api_date_lst, not_identified_indices, not_valid_keys, api_index_lst  #Debug: api_index_lst to delete later



es_data = get_elastic_database('http://129.206.7.153:9200')
index_lst = extract_indices(es_data)
date_lst = extact_date(index_lst)
index_lst, date_lst = delete_no_date_indices(index_lst, date_lst)
#index_lst, date_lst = filter_indices_last_days(index_lst, date_lst, 90)
api_key_lst, api_date_lst, not_identified_indices, not_valid_keys, api_index_lst = extract_apikey(es_data, index_lst)





##################################################################################################

# test executions:


# show all valid keys with date and index
for i in range(0, len(api_key_lst)):
    print("key:", api_key_lst[i], " date:", api_date_lst[i], " index:", api_index_lst[i])

# show not identified indices
print(len(not_identified_indices))
for i in range(0, len(not_identified_indices)):
    print(not_identified_indices[i])

# show not valid keys
print(len(not_valid_keys))
for i in range(0, len(not_valid_keys)):
    print(not_valid_keys[i])






