# on normal server
docker run -d --cap-add SYS_PTRACE \
           -v /proc:/host/proc:ro \
           -v /sys:/host/sys:ro \
           -v /var/run/docker.sock:/var/run/docker.sock \
           -e SSMTP_TO=status@openrouteservice.org \
           -e SSMTP_SERVER=mail.urz.uni-heidelberg.de \
           -e SSMTP_PORT=587 \
           -e SSMTP_USER=o1r \
           -e SSMTP_HOSTNAME=gistools.geog.uni-heidelberg.de \
           -e SSMTP_PASS=hettner1875 \
           -p 19999:19999 \
           --hostname=$(hostname) \
           --name="netdata" \
           titpetric/netdata

# on web server
docker run -d --cap-add SYS_PTRACE \
           -v /proc:/host/proc:ro \
           -v /sys:/host/sys:ro \
           -v /var/log/nginx:/var/log/nginx \
           -v /var/run/docker.sock:/var/run/docker.sock \
           -e SSMTP_TO=status@openrouteservice.org \
           -e SSMTP_SERVER=mail.urz.uni-heidelberg.de \
           -e SSMTP_PORT=587 \
           -e SSMTP_USER=o1r \
           -e SSMTP_HOSTNAME=gistools.geog.uni-heidelberg.de \
           -e SSMTP_PASS=hettner1875 \
           -p 19999:19999 \
           --hostname=$(hostname) \
           --name="netdata" \
           titpetric/netdata
