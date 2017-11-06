#!/bin/bash
cd $WDIR
GRAPH_TYPE=vehicles
SIBLING_WORKER=129.206.7.36

# CHECK IF OTHER WORKER IS HEALTHY
CNT=0
for i in `seq 1 10`; do
    if [ $(curl -s -o /dev/null -I -w "%{http_code}" http://$SIBLING_WORKER:8080/ors/health) = 200 ]; then

        CNT=$(expr $CNT + 1)

    fi
done


if [ $CNT = 10 ]; then
    wget -q -O md5sums.$GRAPH_TYPE.remote http://129.206.228.124/md5sums.$GRAPH_TYPE
    if cmp -s md5sums.$GRAPH_TYPE md5sums.$GRAPH_TYPE.remote
    then

       echo 'The files match'
       mv md5sums.$GRAPH_TYPE.remote md5sums.$GRAPH_TYPE
       rm -rf graphs/$GRAPH_TYPE
       wget -r -nH -np -R "index.html*" -q http://129.206.228.124/graphs/$GRAPH_TYPE

    else

      echo 'The files are different'

    fi

fi