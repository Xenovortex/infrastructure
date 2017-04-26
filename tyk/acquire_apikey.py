#!/usr/bin/env python
"""
author: Lu Liu
created at: 2017-04-26
Description:
    Get a new API key for the openrouteservice public web client, then save it
    to a plain text file `ors_apikey.txt` in the current working dir. If the
    key-fetching is failed, "error" will be written in the same file.
"""

import json
import requests
import time

tyk_auth_token = "fb537f41eef94b4c615a1b6414ae0920"
# key expiration period: 24 hours
expire_span = 24 * 60 * 60
tyk_token_session = {
    "apply_policy_id": "OnlyForPublicInstance",
    "allowance": 30,
    "rate": 30,
    "per": 1,
    "expires": int(time.time()) + expire_span,
    "quota_max": -1,
    "access_rights": {
        "34349e63a29a4c8d7faeea856548039a": {
            "api_id": "34349e63a29a4c8d7faeea856548039a",
            "api_name": "Places",
            "versions": ["Default"]
        },
        "60b3f4b7a26d45c76f87d96a4c0b2113": {
            "api_id": "60b3f4b7a26d45c76f87d96a4c0b2113",
            "api_name": "Geocoding",
            "versions": ["Default"]
        },
        "490caaed0d7a4db272cbf1c569835fb1": {
            "api_id": "490caaed0d7a4db272cbf1c569835fb1",
            "api_name": "Isochrones",
            "versions": ["Default"]
        },
        "d5b961bdf73d46cd5d8e6dfd194365f4": {
            "api_id": "d5b961bdf73d46cd5d8e6dfd194365f4",
            "api_name": "Directions",
            "versions": ["Default"]
        }
    },
    "meta_data": {}
}

tyk_dashboard_apikey_url = "http://admin.cloud.tyk.io/api/keys"
tyk_admin_headers = {
    "authorization": tyk_auth_token,
    "Content-Type": "application/json",
    "Cache-Control": "no-cache"
}

resp = requests.post(
    tyk_dashboard_apikey_url,
    data=json.dumps(tyk_token_session),
    headers=tyk_admin_headers)

key_file_name = "ors_apikey.txt"
json_response = resp.json()
print("Raw response from tyk dashboard: " + json.dumps(json_response))
with open(key_file_name, 'w') as key_file:
    if resp.status_code == 200:
        print("Successfully got a new api key for openrouteservice.org")
        key_file.write(json_response["key_id"])
        print("Wrote the new API key " + json_response["key_id"] +
              " to ors_apikey.txt file")
        print("The key will be expired after 24 hours")
    else:
        print("Failed to fetch the new key.")
        key_file.write("error")
