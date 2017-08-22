from tyk.decorators import Hook
from gateway import TykGateway as tyk
from math import radians, cos, sin, asin, sqrt
from functools import reduce
from time import gmtime, strftime
from datetime import datetime, timezone
import urllib.request
import json
import os
import traceback

cwd = os.path.dirname(os.path.realpath(__file__))
with open(os.path.join(cwd, 'plugin_conf.json')) as pf:
    plugin_conf = json.load(pf)

with open(os.path.join(cwd, 'ors_api_conf.json')) as cf:
    ors_api_conf = json.load(cf)

with open(os.path.join(cwd, 'rules.json')) as rf:
    rules = json.load(rf)

dist_classes = plugin_conf['distance-classes']
stats_log = {
    'remote_addr': '-',
    'remote_user': '-',
    'time_local': strftime("%d/%b/%Y:%H:%M:%S +0000", gmtime()),
    'request': '',
    'status': '',
    'body_bytes_sent': '0',
    'http_referer': '',
    'http_user_agent': ''
}
stats_info = {
    'api': plugin_conf['api-endpoint'],
    'profile': '',
    'estimated_distance': '',
    'distance_class': '',
    'policy': '',
    'status': '',
    'forbidden': ''
}
stats_log_formatter = '{remote_addr} - {remote_user} [{time_local}] "{request}" {status} {body_bytes_sent} "{http_referer}" "{http_user_agent}"\n'

stats_log_file = plugin_conf['stats-log-file']
forbidden = {200: 'none', 400: 'gateway', 403: 'tyk', 500: 'ors'}

ors_backends = {
    'sesame': '192.168.2.11',
    'rice': '192.168.2.35',
    'chia': '192.168.2.29'
}
ors_status_url = 'http://{0}:8080/ors/status'.format(ors_backends['sesame'])
with urllib.request.urlopen(ors_status_url) as osreq:
    ors_status = json.loads(osreq.read().decode('utf8'))
tyk.log('[PLUGIN] [{0}::preparation] Current working dir: {1}'.format(
    plugin_conf['api-endpoint'], str(cwd)), 'info')
tyk.log('[PLUGIN] [{0}::preparation] ORS backend engine version: {1}'.format(
    plugin_conf['api-endpoint'], str(ors_status['app_info']['version'])), 'info')
error_response_body = {
    'error': {
        'code': 0,
        'message': ''
    },
    'info': {
        'reporter': 'ORS API gateway',
        'version': ors_status['app_info']['version'],
        'build_date': ors_status['app_info']['build_date'],
        'timestamp': 0
    }
}


@Hook
def check_pdirections_querystr(request, session, spec):
    tyk.log('[PLUGIN] [{0}::post::init] Current working dir: {1}'.format(
        plugin_conf['api-endpoint'], str(cwd)), 'debug')
    resp_status = 200
    querystr = request.object.params
    headers = request.object.headers
    is_valid, err_code, resp_msg = validate_request(querystr, session)
    if not is_valid:
        construct_error_response(
            request.object.return_overrides, err_code, resp_msg)
        resp_status = 400
    write_piwik_log(querystr, session, headers, resp_status)
    return request, session

def write_piwik_log(querystr, session, headers, status):
    stats_info['profile'] = querystr['profile']
    stats_info['policy'] = rules['policies'][session.apply_policy_id]['name']
    stats_info['status'] = str(status)
    stats_info['forbidden'] = forbidden[status]
    stats_log['request'] = 'GET /{0}?{1} HTTP/2.0'.format(
        plugin_conf['api-endpoint'], '&'.join(
            ['%s=%s' % (str(k), str(v)) for (k, v) in stats_info.items()]))
    stats_log['status'] = str(status)
    if 'X-Forwarded-For' in headers:
        stats_log['remote_addr'] = headers['X-Forwarded-For'].split(',')[0]
    if 'Content-Length' in headers:
        stats_log['body_bytes_sent'] = headers['Content-Length']
    if 'Referer' in headers:
        stats_log['http_referer'] = headers['Referer']
    if 'User-Agent' in headers:
        stats_log['http_user_agent'] = headers['User-Agent']
    with open(stats_log_file, 'a+') as slf:
        slf.write(stats_log_formatter.format(**stats_log))

def construct_error_response(override, err_code, err_msg):
    override.response_code = 400
    # for getting the current UNIX timestamp in ms, needs python > 3
    error_response_body['info']['timestamp'] = int(
        datetime.utcnow().replace(tzinfo=timezone.utc).timestamp() * 1000.0)
    error_response_body['error']['code'] = err_code
    error_response_body['error']['message'] = err_msg
    override.response_error = json.dumps(error_response_body)


def get_distance_class(dist):
    """ Get which slot/class the @dist parameter falls in.
        The slot/class range is defined in plugin_conf.json
    """
    if dist < dist_classes[0]:
        return 1
    if dist >= dist_classes[-1]:
        return len(dist_classes) + 1
    for i, c in enumerate(dist_classes[:-1]):
        if dist >= dist_classes[i] and dist < dist_classes[i + 1]:
            return (i + 2)


def validate_request(queryparams, session):
    """ Check if the URL query string is valid
    """
    try:
        if 'profile' not in queryparams:
            return False, plugin_conf['error-codes']['MISSING_PARAMETER'], "Parameter 'profile' is required"
        if 'coordinates' not in queryparams:
            return False, plugin_conf['error-codes']['MISSING_PARAMETER'], "Parameter 'coordinates' is required"
        profile = queryparams['profile']
        policy = session.apply_policy_id
        tyk.log(
            "[PLUGIN] [{0}::post] Processing request with profile={1} and policy_id={2}".
            format(plugin_conf['api-endpoint'], str(profile), str(policy)),
            'info')
        if profile not in rules['policies'][policy]['profiles']:
            response_msg = "Routing profile {0} is unavailale for your API subscription".format(
                profile)
            return False, plugin_conf['error-codes']['INVALID_PARAMETER_VALUE'], response_msg
        # split each coordinate param value into the list like
        # [{'lon': 110.12, 'lat': 36.36}, {'lon':111.32, 'lat': 19.19}]
        # with the map function. Then, reduce it to get the sum-up distance
        coords = queryparams['coordinates'].split('|')
        cl = list(map(lambda c: {
            'lon': float(c.split(',')[0]),
            'lat': float(c.split(',')[1])
        }, coords))
        total_dist = reduce(
            lambda d, seg_d: d + seg_d,
            map(lambda cp: geo_distance(cp[0]['lon'], cp[0]['lat'], cp[1]['lon'], cp[1]['lat']),
                zip(cl[0:-1], cl[1:])))
        tyk.log("[PLUGIN] [{0}::post] Geodistance of the request: {1}".format(
            plugin_conf['api-endpoint'], str(total_dist)), 'info')
        tyk.log("[PLUGIN] [{0}::post] Policy: {1}".format(
            plugin_conf['api-endpoint'],
            ors_api_conf['policies'][policy]['name']), 'info')
        stats_info['estimated_distance'] = str(round(total_dist))
        stats_info['distance_class'] = str(
            get_distance_class(round(total_dist)))
        if (rules['policies'][policy]['total-distance-limit'] and
                total_dist >
                rules['policies'][policy]['total-distance-limit'][profile]):
            response_msg = "The approximated route distance must not be greater than {0} km".format(
                rules['policies'][policy]['total-distance-limit'][profile])
            return False, plugin_conf['error-codes']['REQUEST_EXCEEDS_SERVER_LIMIT'], response_msg
    except ValueError as val_err:
        tyk.log(
            "[PLUGIN] [{0}::post] [plugin ValueError] coordinates: {1}".format(
                plugin_conf['api-endpoint'], str(queryparams['coordinates'])),
            'error')
        tyk.log("[PLUGIN] [{0}::post] [plugin ValueError] {1}".format(
            plugin_conf['api-endpoint'], str(val_err)), 'error')
        response_msg = "Parameter 'coordinates' has incorrect value or format"
        return False, plugin_conf['error-codes']['INVALID_PARAMETER_VALUE'], response_msg
    except IndexError as idx_err:
        tyk.log(
            "[PLUGIN] [{0}::post] [plugin IndexError] Conversion of coordinates {1} failed".
            format(plugin_conf['api-endpoint'],
                   str(queryparams['coordinates'])), 'error')
        tyk.log("[PLUGIN] [{0}::post] [plugin ValueError] {1}".format(
            plugin_conf['api-endpoint'], str(idx_err)), 'error')
        response_msg = "Parameter 'coordinates' has incorrect value or format"
        return False, plugin_conf['error-codes']['INVALID_PARAMETER_VALUE'], response_msg
    except Exception as err:
        tyk.log("[PLUGIN] [{0}::post] [plugin unexpected error] {1}".format(
            plugin_conf['api-endpoint'], str(err)), 'error')
        tyk.log(
            "[PLUGIN] [{0}::post] [plugin unexpected error] trackback info: {1}".
            format(plugin_conf['api-endpoint'], traceback.format_exc()), 'error')
        return False, plugin_conf['error-codes']['UNKNOWN'], "Unexpected error: {0}".format(str(err))
    return True, 0, ''


def geo_distance(lon1, lat1, lon2, lat2):
    """ Calculate the great circle distance (in km) between two points
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
