#!/bin/bash
STATS_PAGE=/var/www/api.openrouteservice.org/html/stats.html
echo "<html>" > $STATS_PAGE
echo "<title>Routing Profile Statistics</title>" >> $STATS_PAGE
echo "<head>" >> $STATS_PAGE
echo "<link rel=\"stylesheet\" href=\"https://unpkg.com/purecss@0.6.2/build/pure-min.css\">" >> $STATS_PAGE
echo "</head>" >> $STATS_PAGE
echo "<body>" >> $STATS_PAGE
echo "<h1>Statistics of routing profiles</h1>" >> $STATS_PAGE
START=$(head -n 1 /var/log/nginx/access.log | awk '{print $4,$5}')
echo "<p>Data collected since: $START</p>" >> $STATS_PAGE
NOW=$(date)
echo "<p>Data refreshed at: $NOW</p>" >> $STATS_PAGE
echo "<h2>Requests from API calls:</h2>" >> $STATS_PAGE
echo "<table class=\"pure-table pure-table-horizontal\"><thead><tr><th>Hits</th><th>Profile</th></tr></thead><tbody>" >> $STATS_PAGE
/usr/bin/awk -v api=directions -v qsparam=profile= -f /home/ubuntu/projects/ORS_api_gateway/utils/qsparser.awk /var/log/nginx/access.log | sort | uniq -c | sort -rn | awk '{printf "<tr><td> %10s </td><td> %15s </td><tr>\n", $1, $2}'  >> $STATS_PAGE
echo "</tbody></table>" >> $STATS_PAGE
echo "<h2>Requests from public web client:</h2>" >> $STATS_PAGE
echo "<table class=\"pure-table pure-table-horizontal\"><thead><tr><th>Hits</th><th>Profile</th></tr></thead><tbody>" >> $STATS_PAGE
/usr/bin/awk -v api=pdirections -v qsparam=profile= -f /home/ubuntu/projects/ORS_api_gateway/utils/qsparser.awk /var/log/nginx/access.log | sort | uniq -c | sort -rn | awk '{printf "<tr><td> %10s </td><td> %15s </td><tr>\n", $1, $2}' >> $STATS_PAGE
echo "</tbody></table>" >> $STATS_PAGE
echo "</body>" >> $STATS_PAGE
echo "</html>" >> $STATS_PAGE

