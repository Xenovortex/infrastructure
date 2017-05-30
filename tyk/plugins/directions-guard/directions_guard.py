import tyk
from math import radians, cos, sin, asin, sqrt
from tyk.decorators import *
from gateway import TykGateway as tyk

@Hook
def query_params_validator(request, session, metadata, spec):
    tyk.log("[BUNDLE] [Directions Guard] Got request: " + str(request.params), 'info')
    tyk.log("[BUNDLE] [Directions Guard] Rate limit of this key: " + session.rate, 'info')
    tyk.log("[BUNDLE] [Directions Guard] limit per " + session.per, 'info')
    tyk.log("[BUNDLE] [Directions Guard] Policy on this key: " + session.apply_policy_id, 'info')
    return request, session, metadata

def geo_distance(lon1, lat1, lon2, lat2):
    """
    Calculate the great circle distance between two points 
    on the earth (specified in decimal degrees)
    """
    # convert decimal degrees to radians 
    lon1, lat1, lon2, lat2 = map(radians, [lon1, lat1, lon2, lat2])

    # haversine formula 
    dlon = lon2 - lon1 
    dlat = lat2 - lat1 
    a = sin(dlat/2)**2 + cos(lat1) * cos(lat2) * sin(dlon/2)**2
    c = 2 * asin(sqrt(a)) 
    r = 6371 # Radius of earth in kilometers. Use 3956 for miles
    return c * r
