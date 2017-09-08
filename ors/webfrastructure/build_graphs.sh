#!/bin/sh
echo "=============================================================================== "
echo "   _____             _       ___           "
echo "  /___\_ __   ___ _ __   /__\ ___  _   _| |_ ___/ _\ ___ _ ____   _(_) ___ ___  "
echo " //  // '_ \ / _ \ '_ \ / \/// _ \| | | | __/ _ \ \ / _ \ '__\ \ / / |/ __/ _ \ "
echo "/ \_//| |_) |  __/ | | / _  \ (_) | |_| | ||  __/\ \  __/ |   \ V /| | (_|  __/ "
echo "\___/ | .__/ \___|_| |_\/ \_/\___/ \__,_|\__\___\__/\___|_|    \_/ |_|\___\___| "
echo "      |_|"
USAGE="==> Usage: nohup sudo -b ./build_graphs.sh > build_graphs.out 2>&1 &"


Compute_graphs () {
    echo "==> Graphs are built, starting to update graphs"
    cp -R /tomcat/data/graphs /tomcat/data/graphs_latest/
    wget -P /tomcat/data/osm/ https://planet.osm.org/pbf/planet-latest.osm.pbf
    docker container rm -f ors-app
    rm -rf /tomcat/data/graphs/*
    docker-compose up -d
    sleep 20
    docker cp /tomcat/conf/app.config ors-app:/usr/local/tomcat/webapps/ors/WEB-INF
    docker restart ors-app
}

while true
do
    echo "==> Checking if graphs can be updated"
    STATUS="$(curl -s "localhost:8080/ors/health" | jq -r '.status')"
    if [ "$STATUS" = "not ready" ]; then
        echo "==> Not yet, still building graphs"
    elif [ "$STATUS" = "ready" ]; then
        Compute_graphs
    fi
    sleep 60
done