#!/usr/bin/env python
"""
author: Lu Liu
created at: 2017-04-26
Description:
    Get a new API key for the openrouteservice public web client
"""

import json
import requests
try:
    from urlparse import urljoin
except ImportError:
    from urllib.parse import urljoin

openrouteservice_org_id = "58d904a497c67e00015b45fc"
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
    "x-tyk-authorization": "fb537f41eef94b4c615a1b6414ae0920",
    "Cache-Control": "no-cache"
}

resp = requests.post(
    urljoin(tyk_gateway_addr, apikey_mgt_url),
    data=json.dumps(tyk_token_session),
    headers=tyk_admin_headers)

print(resp)
