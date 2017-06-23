#!/usr/bin/env bash
set -e
cd ~
GIT_USER=$1
GIT_PASSWD=$2
ORS_DATA_DIR=$3
TARGET=${4-development}
GIT_BRANCH=${5-development}

ORS_PROJ_ROOT=$(pwd)/ors
ORS_CORE_DOCKER_PROJ_DIR=$ORS_PROJ_ROOT/ors-docker
ORS_CORE_DOCKER_REPO_URL=https://$GIT_USER:$GIT_PASSWD@gitlab.gistools.geog.uni-heidelberg.de/giscience/openrouteservice/core-docker.git
if [ -e $ORS_CORE_DOCKER_PROJ_DIR/.git ]
then
    cd $ORS_CORE_DOCKER_PROJ_DIR
    git pull
else
    rm -rf $ORS_CORE_DOCKER_PROJ_DIR
    mkdir -p $ORS_CORE_DOCKER_PROJ_DIR
    cd $ORS_PROJ_ROOT
    git clone $ORS_CORE_DOCKER_REPO_URL $ORS_CORE_DOCKER_PROJ_DIR

cd $ORS_CORE_DOCKER_PROJ_DIR
sudo ./start-ors.sh $GIT_USER $GIT_PASSWD $ORS_DATA_DIR $TARGET $GIT_BRANCH ../core

