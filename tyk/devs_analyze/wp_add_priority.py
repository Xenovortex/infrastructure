
# coding: utf-8

# In[1]:


import os, json, webbrowser
import pandas as pd
import MySQLdb as mysql
import matplotlib.pyplot as plt
import requests
import numpy as np


# In[2]:


with open('users_wp.json', 'r') as f:
    users_wp = json.load(f)
with open ('users_tyk.json', 'r') as f:
    users_tyk = json.load(f)


# In[3]:


wp_mail = [user['user_email'] for user in users_wp]
users_wp_df = pd.DataFrame([user['ID'] for user in users_wp], index=wp_mail, columns=['ID'])
tyk_mail=[user['email'] for user in users_tyk.values()]
users_tyk_df = pd.DataFrame([user['type'] for user in users_tyk.values()], index=tyk_mail, columns=['type'])


# In[4]:


users_tyk_df = users_tyk_df[~users_tyk_df.index.duplicated(keep='first')]
print "Tyk unique users: {}\nWP unique users: {}".format(len(users_tyk_df),len(users_wp_df))


# In[20]:


result = pd.concat([users_tyk_df, users_wp_df], axis=1, join='inner')
result_ids = result.ID.tolist()
result_types = result.type.tolist()

print "Joined unique users:  {}".format(len(result))
print result.head()


# In[23]:


conn = mysql.connect(host='172.19.0.3', user='root', passwd='admin', db='wordpress')
cur = conn.cursor()
sql_insert_row = "INSERT INTO wp_usermeta (user_id, meta_key) SELECT * FROM (SELECT %s, 'priority') AS tmp WHERE NOT EXISTS (SELECT * from wp_usermeta where user_id = %s and meta_key = 'priority' ) LIMIT 1;"
sql_update_row = "UPDATE wp_usermeta SET meta_value = %s WHERE meta_key = 'priority' AND user_id = %s"
for idx, typ in zip(result_ids, result_types):
    cur.execute(SQL, (idx, idx))
    cur.execute(sql_update_row, (typ, idx))
    
cur.close()
conn.commit()
conn.close()

