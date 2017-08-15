#!/usr/bin/env bash
# usage:
# ./fetch_ors_developers.sh (START_PAGE) (END_PAGE) 
START_PAGE=${1-0}
END_PAGE=${2-1}
for i in $(seq $START_PAGE $END_PAGE)
do
    echo "Fetching page $i of ORS developers..."
    curl --header "authorization: fb537f41eef94b4c615a1b6414ae0920" https://admin.cloud.tyk.io/api/portal/developers?p=$i | python -m json.tool > ors_developers_p$i.json
    echo "done."
done
