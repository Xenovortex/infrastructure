1. sudo docker build -t apache-img .
2. sudo docker run -dit -v "$PWD"/logs:/usr/local/apache2/logs/ -p 80:80 --name apache-hc apache-img
3. change logrotate in cron.daily to /bin/bash
4. make sure rsyslog is installed and cron is set up

