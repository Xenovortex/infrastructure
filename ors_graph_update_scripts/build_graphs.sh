#!/bin/sh
echo "=============================================================================== "
echo "   ___                    __             _       __                 _           "
echo "  /___\_ __   ___ _ __   /__\ ___  _   _| |_ ___/ _\ ___ _ ____   _(_) ___ ___  "
echo " //  // '_ \ / _ \ '_ \ / \/// _ \| | | | __/ _ \ \ / _ \ '__\ \ / / |/ __/ _ \ "
echo "/ \_//| |_) |  __/ | | / _  \ (_) | |_| | ||  __/\ \  __/ |   \ V /| | (_|  __/ "
echo "\___/ | .__/ \___|_| |_\/ \_/\___/ \__,_|\__\___\__/\___|_|    \_/ |_|\___\___| "
echo "      |_|                                                                       "

ORS_ROOT="$PWD"
ORS_TOMCAT_DATA_DIR="/tomcat/data"
ORS_OSM_DATA_DIR="/hayloft/osm"

Compute_graphs () {
    echo "==> Graphs are built, starting to update graphs"

    if [ -d ${ORS_ROOT}${ORS_TOMCAT_DATA_DIR}/latest ]; then
       rm -r ${ORS_ROOT}${ORS_TOMCAT_DATA_DIR}/latest/*
    fi

    rm -r ${ORS_ROOT}${ORS_TOMCAT_DATA_DIR}/latest/*

    DATE_NOW=$(date +%Y%m%d_%H%M%S)
    LATEST_DIR="${ORS_ROOT}${ORS_TOMCAT_DATA_DIR}/latest/graphs.${DATE_NOW}"
    mkdir -p $LATEST_DIR
    cp -R ${ORS_ROOT}${ORS_TOMCAT_DATA_DIR}/graphs/* $LATEST_DIR

    MD5SUM_CLOUD=$(curl https://planet.osm.org/pbf/planet-latest.osm.pbf.md5 | head -n 1 | cut -c -32)
    wget -q -O ${ORS_ROOT}${ORS_OSM_DATA_DIR}/planet-latest.osm.pbf https://planet.osm.org/pbf/planet-latest.osm.pbf
    MD5SUM_LOCAL=$(md5sum ${ORS_ROOT}${ORS_OSM_DATA_DIR}/planet-latest.osm.pbf | head -n 1 | cut -c -32)
    if [ "$MD5SUM_CLOUD" == "$MD5SUM_LOCAL" ]; then
        rm -rf ${ORS_ROOT}${ORS_TOMCAT_DATA_DIR}/graphs/*
        docker restart ors-app
    else
        Compute_graphs
    fi
}

echo "==> Checking if graphs can be updated"
STATUS="$(curl -s "localhost:8080/ors/health" | jq -r '.status')"
if [ "$STATUS" = "not ready" ]; then
    echo "==> Not yet, still building graphs"
elif [ "$STATUS" = "ready" ]; then
    Compute_graphs
fi