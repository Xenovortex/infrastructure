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

"""
data = es.search("my_index")
pp = pprint.PrettyPrinter(indent=4)
pp.pprint(data)
"""



"""
Datatypes: 
- logstash-gateway-tyk-date
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