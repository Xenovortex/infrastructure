from tyk.decorators import *
from gateway import TykGateway as tyk
from math import radians, cos, sin, asin, sqrt
from functools import reduce
import json
import os

cwd = os.path.dirname(os.path.realpath(__file__))
with open(os.path.join(cwd, 'ors_api_conf.json')) as cf:
    ors_api_conf = json.load(cf)

with open(os.path.join(cwd, 'rules.json')) as rf:
    rules = json.load(rf)

response_msg = ""


@Hook
def query_params_validator(request, session, spec):
    if is_request_valid(request.object.params, session) is not True:
        request.object.return_overrides.response_code = 464
        request.object.return_overrides.response_error = response_msg
    return request, session


def is_request_valid(queryparams, session):
    profile = queryparams['profile']
    if (len(rules['policies'][session.apply_policy_id]['profiles']) > 0) and (
            profile not in
            rules['policies'][session.apply_policy_id]['profiles']):
        response_msg = "Routing profile " + profile + " is unavailale for your API subscription"
        return False
    # split each coordinate param value into the list like
    # [{'lon': 110.12, 'lat': 36.36}, {'lon':111.32, 'lat': 19.19}]
    # with the map function. Then, reduce it to get the sum-up distance
    coords = queryparams['coordinates'].split('|')
    cl = list(map(lambda c: {'lon': float(c.split(',')[0]), 'lat': float(c.split(',')[1])}, coords))
    total_dist = reduce(
        lambda d, seg_d: d + seg_d,
        map(lambda cp: geo_distance(cp[0]['lon'], cp[0]['lat'], cp[1]['lon'], cp[1]['lat']),
            zip(cl[0:-1], cl[1:])))
    tyk.log("[PLUGIN] [Directions Guard::post] Geodistance of the request: " +
            str(total_dist), 'info')
    tyk.log("[PLUGIN] [Directions Guard::post] Policy: " +
            ors_api_conf['policies'][session.apply_policy_id]['name'], 'info')
    if rules['policies'][session.apply_policy_id]['distance-limit'] and (
            total_dist > rules['policies'][session.apply_policy_id][
                'distance-limit'][profile]):
        response_msg = "Requested distance is too long for your API subscription"
        return False
    return True


def geo_distance(lon1, lat1, lon2, lat2):
    """
    Calculate the great circle distance (in km) between two points
    on the earth (specified in decimal degrees)
    """
    # convert decimal degrees to radians
    lon1, lat1, lon2, lat2 = map(radians, [lon1, lat1, lon2, lat2])

    # haversine formula
    dlon = lon2 - lon1
    dlat = lat2 - lat1
    a = sin(dlat / 2)**2 + cos(lat1) * cos(lat2) * sin(dlon / 2)**2
    c = 2 * asin(sqrt(a))
    r = 6371  # Radius of earth in kilometers. Use 3956 for miles
    return c * r
