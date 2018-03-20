import requests
import json


url = "http://admin.cloud.tyk.io/api/activity/keys/a2a53f4cf/19/3/2018/20/3/2018?&p=-1&res=day"
tyk_auth_token = "fb537f41eef94b4c615a1b6414ae0920"

res = requests.get(url, headers={"authorization": tyk_auth_token})
response = res.json()
print(response)


"""

tyk_auth_token = "fb537f41eef94b4c615a1b6414ae0920"

api_id = "60b3f4b7a26d45c76f87d96a4c0b2113"
key_id = "58d904a497c67e00015b45fc72754973a3e84c02a0d3cd73135fbba5"

tyk_dashboard_apikey_url = "http://admin.cloud.tyk.io/api/apis/" + api_id + "/keys/" + key_id
tyk_admin_headers = {
    "authorization": tyk_auth_token,
    "Content-Type": "application/json",
    "Cache-Control": "no-cache"
}

resp = requests.get(
    tyk_dashboard_apikey_url,
    headers=tyk_admin_headers)

json_response = resp.json()

print("Raw response from tyk dashboard: " + json.dumps(json_response))
"""