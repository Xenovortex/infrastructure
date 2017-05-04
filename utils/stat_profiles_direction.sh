#!/bin/bash
STATS_PAGE=/var/www/api.openrouteservice.org/html/stats.html
echo "<html>" > $STATS_PAGE
echo "<h1>Statistics of routing profiles</h1>" >> $STATS_PAGE
echo "<h2>Requests from API calls:</h2>" >> $STATS_PAGE
echo "<p>" >> $STATS_PAGE
/usr/bin/awk -v api=directions -v qsparam=profile= -f /home/ubuntu/projects/ORS_api_gateway/utils/qsparser.awk /var/log/nginx/access.log | sort | uniq -c | sort -rn | awk '{printf "<p> %20s </p>\n", $0}' >> $STATS_PAGE
echo "</p>" >> $STATS_PAGE
echo "<h2>Requests from public web client:</h2>" >> $STATS_PAGE
echo "<p>" >> $STATS_PAGE
/usr/bin/awk -v api=pdirections -v qsparam=profile= -f /home/ubuntu/projects/ORS_api_gateway/utils/qsparser.awk /var/log/nginx/access.log | sort | uniq -c | sort -rn | awk '{printf "<p> %20s </p>\n", $0}' >> $STATS_PAGE
echo "</p>" >> $STATS_PAGE
echo "</html>" >> $STATS_PAGE

