import sys
sys.path.insert(0, '/home/leo/infrastructure')

import json
import requests
import pandas as pd
from datetime import datetime
from elasticsearch import Elasticsearch
import pprint
import infrastructure_py.databases as db

es = Elasticsearch(hosts=['http://129.206.7.153:9200']) # http://localhost:9200/


"""
for i in range(1, 7, 1):
    print(es.get("movies", "movie", i))
"""

#file = open()

def is_date(date_text):
    try:
        datetime.strptime(date_text, '%Y.%m.%d')
        return True
    except ValueError:
        return False

def has_field(es, index, field, i):
    data = es.search(index=index, filter_path='hits.hits._source')
    try:
        data['hits']['hits'][i]['_source'][field]
        return True
    except KeyError:
        return False

def extract_apikey(es_data, index_lst):
    """
    Extract api-key of all indices provided in the index list from the Elastic Database. Create a list of dates
    corresponding to the api-keys.

    :param es_data: Elastic Database
    :param index_lst: list of indices
    :return: list of api-keys, list of corresponding dates
    """
    api_key_lst = []
    api_date_lst = []
    for index in index_lst:
        data = es.search(index=index, filter_path='hits.hits._source')
        name_without_date = index.split("-")[:-1]
        date = index.split("-")[-1]
        print(len(data['hits']['hits']))
        print(index)
        if (name_without_date[-1] == "tyk"):
            for i in range(0, len(data['hits']['hits'])):
                if has_field(es_data, index, 'key', i):
                    api_key_lst.append(data['hits']['hits'][i]['_source']['key'])
                    api_date_lst.append(date)
        elif (name_without_date[-1] == "nginx") or (name_without_date[-1] == "hybrid"):
            for i in range(0, len(data['hits']['hits'])):
                if has_field(es_data, index, 'arg_api_key', i):
                    api_key_lst.append(data['hits']['hits'][i]['_source']['arg_api_key'])
                    api_date_lst.append(date)
        else:
            pass
    return api_key_lst, api_date_lst

index_lst = []
indices = es.indices.get_alias().keys()
for index in indices:
    index_lst.append(index)

date_lst = []
for index in index_lst:
    date = index.split("-")[-1]
    #print(date, is_date(date))
    if (is_date(date)):
        date_lst.append(date)
    else:
        date_lst.append("no date")

for index in index_lst:
    print(index)


pp = pprint.PrettyPrinter(indent=4)

pp.pprint(es.search("tyk-hybrid-2017.10.26"))
print("-" * 10)

data = es.search(index="tyk-hybrid-2017.10.26", filter_path='hits.hits._source')
pp.pprint(data)
print('-' * 10)

print(len(index_lst))
api_key_lst, api_date_lst = extract_apikey(es, index_lst)
print(len(api_key_lst))
print(len(api_date_lst))


for i in range(0, len(api_key_lst)):
    print("key: ", api_key_lst[i])
    print("date: ", api_date_lst[i])

"""
for i in range(0, len(data['hits']['hits'])):
    pp.pprint(data['hits']['hits'][i])
    #print(has_field(es, "tyk-hybrid-2017.10.26", 'arg_api_key', i))
    print("-" * 20)

for i in range(0, len(data['hits']['hits'])):
    if has_field(es, "tyk-hybrid-2017.10.26", 'arg_api_key', i):
        print(data['hits']['hits'][i]['_source']['arg_api_key'])
"""



"""
Datatypes: 
- logstash-gateway-tyk-date: data['hits']['hits']['_source']['key']
- logstash-gateway-nginx-date
- tyk-hybrid-date

Not considered indexes:
- filebeat-date
- .reporting-date
- tutorial
- .kibana
- myindex
"""


"""
for i in range(0, len(index_lst)):
    print(index_lst[i])
    data = es.search(index_lst[i])
    print(data['hits']['hits'][i]['_source']['arg_api_key'])
"""

"""
api_key_lst = []
for index in index_lst:
    data = es.search(index)
    
    for i in range(0, len(data['hits']['hits'])):
        api_key = data['hits']['hits'][i]['_source']['arg_api_key']
        api_key_lst.append(api_key)
    
for api_key in api_key_lst:
    print(api_key)
"""


# body = {}

"""
# access all field "title" in local dump ES database
x = es.search("movies") # "movie"


for key, value in x.items() :
    print (key, value)

for i in range(0, len(x['hits']['hits'])):
    print(x['hits']['hits'][i]['_source']['title'])
"""

# api-key, counts, last access


"""
obj = db.Tyk()
x = pd.DataFrame(obj.getDevs())

file = open("tyk datatbase", "w")

for row in x.iterrows():
    file.write(str(row))


counter = 0
for _, row in x[['_id', 'date_created', 'api_keys', 'email']].iterrows():
    tyk_key, tyk_raw_date, tyk_api_keys, tyk_email = row
    print(tyk_key)
    print(tyk_raw_date)
    print(tyk_api_keys)
    print(tyk_email)
    print("-" * 10)
    counter += 1
    if (counter == 10):
        break

"""