FROM httpd:2.4.28
COPY conf/healthchecker_lb.conf /usr/local/apache2/conf/extra/healthchecker_lb.conf
COPY conf/httpd.conf /usr/local/apache2/conf/httpd.conf

RUN apt-get -y update \
    && apt-get -y upgrade \
    && apt-get -y install logrotate

COPY conf/apache2 /etc/logrotate.d/apache2