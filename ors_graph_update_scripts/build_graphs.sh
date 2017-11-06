#!/bin/bash
echo "=============================================================================== "
echo "   ___                    __             _       __                 _           "
echo "  /___\_ __   ___ _ __   /__\ ___  _   _| |_ ___/ _\ ___ _ ____   _(_) ___ ___  "
echo " //  // '_ \ / _ \ '_ \ / \/// _ \| | | | __/ _ \ \ / _ \ '__\ \ / / |/ __/ _ \ "
echo "/ \_//| |_) |  __/ | | / _  \ (_) | |_| | ||  __/\ \  __/ |   \ V /| | (_|  __/ "
echo "\___/ | .__/ \___|_| |_\/ \_/\___/ \__,_|\__\___\__/\___|_|    \_/ |_|\___\___| "
echo "      |_|                                                                       "

ORS_ROOT="/opt/docker-files/webfrastructure"
ORS_TOMCAT_DATA_DIR="/tomcat/data"
ORS_OSM_DATA_DIR="/hayloft/osm"

Compare_planetfiles () {

    MD5SUM_CLOUD=$(curl https://planet.osm.org/pbf/planet-latest.osm.pbf.md5 | head -n 1 | cut -c -32)
    wget -q -O ${ORS_ROOT}${ORS_OSM_DATA_DIR}/planet-latest.osm.pbf https://planet.osm.org/pbf/planet-latest.osm.pbf
    MD5SUM_LOCAL=$(md5sum ${ORS_ROOT}${ORS_OSM_DATA_DIR}/planet-latest.osm.pbf | head -n 1 | cut -c -32)

    echo "==> Comparing planet file hashes, cloud $MD5SUM_CLOUD vs local $MD5SUM_LOCAL ..."
    if [ "$MD5SUM_CLOUD" = "$MD5SUM_LOCAL" ]; then

        echo "==> Planet file hashes match ... restarting docker container"
        docker restart ors-app
        exit 1

    else

        echo "==> Planet file hashes do not match, restarting download ..."
        Compare_planetfiles

    fi


}

Compute_graphs () {

    DATE_NOW=$(date +%Y%m%d_%H%M%S)
    LATEST_DIR="${ORS_ROOT}${ORS_TOMCAT_DATA_DIR}/latest"
    mkdir -p $LATEST_DIR
    cd ${ORS_ROOT}${ORS_TOMCAT_DATA_DIR}
    chmod -R 755 graphs
    for i in graphs/* ; do
  	if [ -d "$i" ]; then
	   hashdeep -rs graphs/$(basename "$i") > md5sums.$(basename "$i")
           echo $(basename "$i")
    	fi
    done
    mv graphs $LATEST_DIR

    Compare_planetfiles

}

echo "==> Checking if graphs can be updated ..."
STATUS="$(curl -s "localhost:8080/ors/health" | jq -r '.status')"

if [ "$STATUS" = "not ready" ]; then

    echo "==> Not ready yet, still building graphs ..."

elif [ "$STATUS" = "ready" ]; then

    echo "==> Graphs are built, starting update graph process ..."
    Compute_graphs

else

    exit 1

fi