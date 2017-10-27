FROM docker.elastic.co/logstash/logstash:5.6.3
RUN logstash-plugin install logstash-output-elasticsearch
RUN logstash-plugin install logstash-filter-grok
RUN logstash-plugin install logstash-filter-geoip
RUN logstash-plugin install logstash-filter-kv
RUN logstash-plugin install logstash-filter-date
RUN logstash-plugin install logstash-filter-ruby
RUN logstash-plugin install logstash-filter-json
RUN rm -f /usr/share/logstash/pipeline/logstash.conf
ADD pipeline/ /usr/share/logstash/pipeline/
ADD config/ /usr/share/logstash/config/
USER root
RUN usermod -a -G adm logstash
USER logstash
