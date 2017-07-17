from tyk.decorators import Hook
from gateway import TykGateway as tyk
from math import radians, cos, sin, asin, sqrt
from functools import reduce
from time import gmtime, strftime
import json
import os

cwd = os.path.dirname(os.path.realpath(__file__))
with open(os.path.join(cwd, 'plugin_conf.json')) as pf:
    plugin_conf = json.load(pf)

with open(os.path.join(cwd, 'ors_api_conf.json')) as cf:
    ors_api_conf = json.load(cf)

with open(os.path.join(cwd, 'rules.json')) as rf:
    rules = json.load(rf)

response_msg = ""
dist_classes = plugin_conf['distance-classes']
stats_log = {
    'remote_addr': '',
    'remote_user': '',
    'time_local': strftime("%d/%b/%Y:%H:%M:%S +0000", gmtime()),
    'request': '',
    'status': '',
    'body_bytes_sent': '',
    'http_referer': '',
    'http_user_agent': ''
}
stats_info = {'profile': '', 'estimated_distance': '', 'distance_class': ''}
stats_log_formatter = '{remote_addr} - {remote_user} [{time_local}] "{request}" {status} {body_bytes_sent} "{http_referer}" "{http_user_agent}"\n'
stats_log_file = plugin_conf['stats-log-file']


@Hook
def query_params_validator(request, session, spec):
    if is_request_valid(request.object.params, session) is not True:
        request.object.return_overrides.headers[
            'content-type'] = 'application/json'
        request.object.return_overrides.headers['x-sender'] = 'ORS gateway'
        request.object.return_overrides.response_code = 464
        request.object.return_overrides.response_error = json.dumps({
            'ORS gateway error': response_msg
        })

    stats_info['profile'] = request.object.params['profile']
    stats_log['request'] = 'GET /{0}?{1} HTTP/2.0'.format(
        plugin_conf['api-endpoint'], '&'.join(
            ['%s=%s' % (str(k), str(v)) for (k, v) in stats_info.items()]))
    with open(stats_log_file, 'w') as slf:
        slf.write(stats_log_formatter.format(**stats_log))
    return request, session


def get_distance_class(dist):
    """ Get which slot/class the @dist parameter falls in.
        The slot/class range is defined in plugin_conf.json
    """
    if (dist < dist_classes[0]):
        return 1
    if (dist >= dist_classes[-1]):
        return len(dist_classes) + 1
    for i, c in enumerate(dist_classes):
        if (dist >= dist_classes[i] and dist < dist_classes[i + 1]):
            return (i + 1)


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
    stats_info['estimated_distance'] = str(round(total_dist / 1000))
    stats_info['distance_class'] = str(
        get_distance_class(round(total_dist / 1000, 2)))
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
