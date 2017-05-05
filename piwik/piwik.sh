#!/bin/sh

echo "${@}" | /home/ubuntu/projects/piwik-log-analytics/import_logs.py \
 --url=https://korona.geog.uni-heidelberg.de/stats/piwik.php --token-auth=85df4e72fb4c1b403b20e6a3d9a77604 \
 --enable-http-errors --enable-http-redirects --enable-static --enable-bots \
 --idsite=1 --recorders=4 --log-format-name=nginx_json -
