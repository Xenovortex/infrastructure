#!/bin/bash
/usr/bin/docker container stop tyk_hybrid
/bin/systemctl stop nginx
/usr/bin/letsencrypt renew
/bin/systemctl start nginx
/usr/bin/docker container start tyk_hybrid
