#!/bin/sh
echo "=============================================================================== "
echo "   ___                    __             _       __                 _           "
echo "  /___\_ __   ___ _ __   /__\ ___  _   _| |_ ___/ _\ ___ _ ____   _(_) ___ ___  "
echo " //  // '_ \ / _ \ '_ \ / \/// _ \| | | | __/ _ \ \ / _ \ '__\ \ / / |/ __/ _ \ "
echo "/ \_//| |_) |  __/ | | / _  \ (_) | |_| | ||  __/\ \  __/ |   \ V /| | (_|  __/ "
echo "\___/ | .__/ \___|_| |_\/ \_/\___/ \__,_|\__\___\__/\___|_|    \_/ |_|\___\___| "
echo "      |_|                                                                       "

ORS_ROOT=/opt/openrouteservice/webfrastructure

Compute_graphs () {
    echo "==> Graphs are built, starting to update graphs"
    cp -R $ORS_ROOT/tomcat/data/graphs $ORS_ROOT/tomcat/data/graphs_latest/
    wget -P $ORS_ROOT/tomcat/data/osm/ https://planet.osm.org/pbf/planet-latest.osm.pbf
    rm -rf $ORS_ROOT/tomcat/data/graphs/*
    docker restart ors-app
}

echo "==> Checking if graphs can be updated"
STATUS="$(curl -s "localhost:8080/ors/health" | jq -r '.status')"
if [ "$STATUS" = "not ready" ]; then
    echo "==> Not yet, still building graphs"
elif [ "$STATUS" = "ready" ]; then
    Compute_graphs
fi