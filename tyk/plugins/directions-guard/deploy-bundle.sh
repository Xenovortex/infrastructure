#!/usr/bin/env bash
SSH_KEY=$1
VERSION=$2
BUNDLE_FILE="directions-bundle-$VERSION.zip"
BUNDLE_PATH='/var/www/api.openrouteservice.org/html/api-plugins/'
scp -i $SSH_KEY $BUNDLE_FILE ubuntu@api.openrouteservice.org:~/
ssh -i $SSH_KEY ubuntu@api.openrouteservice.org "sudo mv ~/$BUNDLE_FILE $BUNDLE_PATH"
