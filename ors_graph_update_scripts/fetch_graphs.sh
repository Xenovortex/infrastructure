#!/bin/bash
set -e
echo "=============================================================================== "
echo "   ___                    __             _       __                 _           "
echo "  /___\_ __   ___ _ __   /__\ ___  _   _| |_ ___/ _\ ___ _ ____   _(_) ___ ___  "
echo " //  // '_ \ / _ \ '_ \ / \/// _ \| | | | __/ _ \ \ / _ \ '__\ \ / / |/ __/ _ \ "
echo "/ \_//| |_) |  __/ | | / _  \ (_) | |_| | ||  __/\ \  __/ |   \ V /| | (_|  __/ "
echo "\___/ | .__/ \___|_| |_\/ \_/\___/ \__,_|\__\___\__/\___|_|    \_/ |_|\___\___| "
echo "      |_|                                                                       "
USAGE="==> Usage: sudo ./fetch_graphs.sh GRAPH_TYPE SIBLING_WORKER ORS_APP (GRAPH_SERVER) (WDIR)"

GRAPH_TYPE=$1
SIBLING_WORKER=$2
ORS_APP=$3
GRAPH_SERVER=${4-129.206.228.124}
WDIR=${5-/opt/ors/data}

cd $WDIR

# CHECK IF OTHER WORKER IS HEALTHY
CNT=0
for i in `seq 1 10`; do

    if [ $(curl -s -o /dev/null -I -w "%{http_code}" http://$SIBLING_WORKER:8080/ors/health) = 200 ]; then

        CNT=$(expr $CNT + 1)

    fi

done

# IF HEALTHY COMPARE MD5SUMS
if [ $CNT = 10 ]; then

    wget -q -O md5sums.$GRAPH_TYPE.remote http://$GRAPH_SERVER/md5sums.$GRAPH_TYPE

    if cmp -s md5sums.$GRAPH_TYPE md5sums.$GRAPH_TYPE.remote; then

       #echo 'The files match'
       rm md5sums.$GRAPH_TYPE.remote
       exit 1

    else

       docker stop $ORS_APP
       #echo 'The files are different'
       mv md5sums.$GRAPH_TYPE.remote md5sums.$GRAPH_TYPE
       rm -rf graphs/$GRAPH_TYPE
       #echo http://$GRAPH_SERVER/graphs/$GRAPH_TYPE
       wget -r -nH -np -l1 -R 'index.html*' -q http://$GRAPH_SERVER/graphs/$GRAPH_TYPE/
       docker start $ORS_APP

    fi

fi