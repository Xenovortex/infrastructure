#!/bin/sh

echo "${@}" | /home/ubuntu/projects/piwik-log-analytics/import_logs.py \
 --url=http://192.168.2.19:2322/piwik/ --token-auth=8b0a7c8dcc6049ece9c28ced34771b5b \
 --enable-http-errors --enable-http-redirects --enable-static --enable-bots \
 --idsite=2 --recorders=4 --log-format-name=nginx_json -
