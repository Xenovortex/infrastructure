#!/usr/bin/env python
"""
author: Lu Liu
created at: 2017-04-26
Description:
    Get a new API key for the openrouteservice public web client, then save it
    to a plain text file `ors_apikey.txt` in the current working dir
"""

import json
import requests
try:
    from urlparse import urljoin
except ImportError:
    from urllib.parse import urljoin

openrouteservice_org_id = "58d904a497c67e00015b45fc"
tyk_auth_token = "36010471e7c6aa3e0d91104ceb09119f"
tyk_token_session = {
    "last_check": 0,
    "allowance": 1000,
    "rate": 30,
    "per": 1,
    "quota_max": -1,
    "org_id": openrouteservice_org_id,
    "hmac_enabled": False,
    "hmac_string": "",
    "is_inactive": False,
    "apply_policy_id": "OnlyForPublicInstance"
}

tyk_gateway_addr = "http://192.168.2.17:8080"
apikey_mgt_url = "/tyk/keys/create"
tyk_admin_headers = {
    "x-tyk-authorization": tyk_auth_token,
    "Cache-Control": "no-cache"
}

resp = requests.post(
    urljoin(tyk_gateway_addr, apikey_mgt_url),
    data=json.dumps(tyk_token_session),
    headers=tyk_admin_headers)

key_file_name = "ors_apikey.txt"
if resp.status_code == 200:
    print("Successfully got a new api key for openrouteservice.org")
    json_response = resp.json()
    print("raw response: " + json_response)
    with open(key_file_name, 'w') as key_file:
        key_file.write(json_response["key"])
    print("Wrote the new API key to ors_apikey.txt file")
    print("The key will be expired in 24 hours")
else:
    print("Failed to fetch the new key.")
    print("raw response: " + resp.json())
