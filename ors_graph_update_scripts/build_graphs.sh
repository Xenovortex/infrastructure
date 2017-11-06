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

#declare -A ORS_WORKERS
#ORS_WORKERS[129.206.7.158]=vehicles
#ORS_WORKERS[129.206.7.36]=vehicles

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

    MD5SUM_CLOUD=$(curl https://planet.osm.org/pbf/planet-latest.osm.pbf.md5 | head -n 1 | cut -c -32)
    wget -q -O ${ORS_ROOT}${ORS_OSM_DATA_DIR}/planet-latest.osm.pbf https://planet.osm.org/pbf/planet-latest.osm.pbf
    MD5SUM_LOCAL=$(md5sum ${ORS_ROOT}${ORS_OSM_DATA_DIR}/planet-latest.osm.pbf | head -n 1 | cut -c -32)

    echo "==> Comparing planet file hashes, cloud $MD5SUM_CLOUD vs local $MD5SUM_LOCAL ..."
    if [ "$MD5SUM_CLOUD" = "$MD5SUM_LOCAL" ]; then

        echo "==> Planet file hashes match ... restarting docker container"
        # keep latest directory if many exist
        #cd ${ORS_ROOT}${ORS_TOMCAT_DATA_DIR}/latest
        #rm -r `ls -t ${ORS_ROOT}${ORS_TOMCAT_DATA_DIR}/latest | tail -n +2`

        #echo "==> Sending graphs to ors workers ..."
        #cd */
	#for worker in "${!ORS_WORKERS[@]}"
	#do

            #echo "IP  : $worker"
            #echo "TYPE: ${ORS_WORKERS[$worker]}"
            #rsync -Pavq -e "ssh -oStrictHostKeyChecking=no -i ssh_access_workers.pem" ${ORS_WORKERS[$worker]} ubuntu@$worker:/opt/ors/data/graphs/
            # ssh to ors worker and call restart
            #ssh -o StrictHostKeyChecking=no -p22 ubuntu@$worker "sudo docker restart ors-app"
            # wait for worker to load new graphs
            #sleep 20
            #until [ $(curl -s -o /dev/null -I -w "%{http_code}" http://$worker:8080/ors/health) -eq 200 ]; do
            #    printf '.'
            #    sleep 1s
            #done

        #done

        docker restart ors-app

    else

	echo "==> Planet file hashes do not match, restarting download ..."
        Compute_graphs

    fi
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