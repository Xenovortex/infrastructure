sudo docker build -t apache-img .
sudo docker run -dit -v "$PWD"/logs:/usr/local/apache2/logs/ -p 80:80 --name apache-hc apache-img
