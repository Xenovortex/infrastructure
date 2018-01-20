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
    
        
    def _headerGet(self):
        return {
                "authorization": self.auth_token,
                "Content-Type": "application/json",
                "Cache-Control": "no-cache"
                }