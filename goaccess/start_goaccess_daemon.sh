#!/bin/bash
goaccess -f /var/log/nginx/access.log \
	 -o /var/www/api.openrouteservice.org/html/report.html \
	 --real-time-html \
	 --daemonize \
	 --ssl-cert=/etc/letsencrypt/live/api.openrouteservice.org/fullchain.pem \
	 --ssl-key=/etc/letsencrypt/live/api.openrouteservice.org/privkey.pem \
         --ws-url=wss://api.openrouteservice.org:7890
