# ORS API gateway 

## Top-level load balancer

The nginx running on `ors-gateway` performs as the major and only entrance of
all OpenRouteService API traffic from both the ORS developers and the
[openrouteservice.org](https://openrouteservice.org) public web client.

### API endpoints and rate limits

It manages all the API endpoints including:

- `/directions`
- `/geocoding`
- `/isochrones`
- `/places`
- `/pdirections`
- `/pgeocoding`
- `/pisochrones`
- `/pplaces`

For each API endpoint dedicated for ORS public client (only with the `p`
prefix), an IP-based rate limit rule is defined. All other policy or key-level
rate limits are defined in tyk gateway.

### Tyk gateway load-balancing

The incomming http requests will be balanced proxies to two tyk gateways
running in docker containers on `ors-gateway` and `ors-gateway-worker`.

### Configuration and logging analytics

The config file is located at
`/etc/nginx/site-available/api.openrouteservice.org` . When modified this file,
use `service nginx reload` or `service nginx restart` with root privilege to
enable it. The access and error log of nginx is located in `/var/log/nginx/`
directory. **Note** that the access log should NOT be disabled because it is
the data source of piwik log analyzer on `ors-sentinel`.

All the access log record will be sent to the piwik service on `ors-sentinel`
as mentioned above via this pipeline:

`nginx access.log -> rsyslog -> piwik`

It should be noted that sometimes this will get stuck. It's usually the problem
of rsyslog. So just restart the rsyslog service on `ors-gateway` with the following 
command will let it back on duty.

`service rsyslog restart`

## Tyk gateway

docker 

### Fresh start a new container

### Restart the container

### Check the logs

### Python plugins

### Event handling
