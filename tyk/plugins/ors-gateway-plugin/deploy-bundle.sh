#!/usr/bin/env bash
SSH_KEY=$1
BUNDLE_NAME=$2
VERSION=${3-`cat ./VERSION`}
BUNDLE_FILE="$BUNDLE_NAME-bundle-$VERSION.zip"
BUNDLE_PATH='/var/www/api.openrouteservice.org/html/api-plugins/'
scp -i $SSH_KEY $BUNDLE_FILE ubuntu@api.openrouteservice.org:~/
ssh -i $SSH_KEY ubuntu@api.openrouteservice.org "sudo mv ~/$BUNDLE_FILE $BUNDLE_PATH"
