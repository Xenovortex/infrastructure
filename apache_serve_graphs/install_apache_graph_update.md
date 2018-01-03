sudo docker run -v /opt/ors/data/latest:/var/www/html/ors/ -p 80:80 -p 443:443 -d --name ors-apache birgerk/apache-letsencrypt

sudo docker cp ors-graphs.conf f19:/etc/apache2/sites-available/

sudo docker exec -it f19 a2ensite ors-graphs.conf

sudo docker restart ors-apache