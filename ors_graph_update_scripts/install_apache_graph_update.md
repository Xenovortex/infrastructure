sudo docker run -v /opt/ors/data/latest:/var/www/html/ors/ -p 80:80 -d --name ors-apache birgerk/apache-letsencrypt

sudo docker cp ors-graphs.conf 5c8:/etc/apache2/sites-available/

sudo docker exec -it 5c8 a2ensite ors-graphs.conf

sudo docker restart ors-apache