# -*- coding: utf-8 -*-

import requests
import json

class Tyk():
    def __init__(self):
        self.auth_token = 'fb537f41eef94b4c615a1b6414ae0920'
        self.base_url = r"http://admin.cloud.tyk.io/api/portal"
        
        
    def getDevs(self):
        """Returns all developers registered on Tyk.
        
        :rtype dict
        """
        url = self.base_url + "/developers?p=-1"
        response = requests.get(url,
                                headers=self._headerGet())
        
        return json.loads(response.text)['Data']
    
        
    def deleteDev(self, tyk_id):
        """CAUTION: Delete developers from Tyk."""
        
        url = self.base_url + "/developers/" + tyk_id
        
        requests.delete(url,
                        headers=self._headerGet())
    
    
    def _headerGet(self):
        return {
                "authorization": self.auth_token,
                "Content-Type": "application/json",
                "Cache-Control": "no-cache"
                }
        

class WP():
    """Instantiates a MySQL class for a WordPress database.
    
    :param inst: 'local' for local MySQL instance, 'live' for deployed ORS instance, 'test' for test ORS instance
    :type inst: str
    """
    def __init__(self,
                 inst = 'local'):
        
        mysql = __import__('MySQLdb')
        
        if inst == 'local':
            self.host = '127.0.0.1'
        elif inst == 'live':
            self.host = '172.18.0.2'
        elif inst == 'test':
            self.host = '172.19.0.3'
        
        self.conn = mysql.connect(host=self.host,
                             user='root',
                             passwd='admin',
                             db='wordpress')
        
        
    def deleteUserByWPids(self, ids):
        """Deletes all specified users on wp_users and wp_usermeta.
        
        :param ids: List of WP user_ids.
        :type ids: 1D list or tuple"""
        
        sql1 = """DELETE FROM wp_users 
                 WHERE ID in %s
              """
        sql2 = """DELETE FROM wp_usermeta
                  WHERE user_id in %s
               """
        cur = self.conn.cursor()
        cur.execute(sql1, (ids, ))
        cur.execute(sql2, (ids, ))
        cur.close()
        
        
    def getWPidsByEmail(self,emails):
        """Get WP ID's from wp_users by emails.
        
        :param emails: List of WP emails.
        :type emails: 1D list or tuple"""
        
        sql = """SELECT ID 
                 FROM wp_users
                 WHERE user_email in %s
              """
              
        cur = self.conn.cursor()
        cur.execute(sql, (emails,))
        data = cur.fetchall()
        cur.close()
        
        return data
    
    def getEmailsByClass(self, classification):
        """Get emails from WP users by classification (priority).
        
        :param classification: commercial, private, edu, junk.
        :type classification: str"""
        
        sql = """SELECT user_email 
                 FROM wp_users
                 WHERE 
                  ID IN (
                    SELECT user_id 
                    FROM wp_usermeta
                    WHERE 
                      meta_key = 'priority'
                      AND
                      meta_value = %s)
              """
        cur = self.conn.cursor()
        cur.execute(sql, (classification,))
        data = cur.fetchall()
        cur.close()
        
        return data
        
        
    def commit(self):
        self.conn.commit()
        
    
    def close(self):
        self.conn.close()