#!/usr/bin/env bash
BUNDLE_NAME=$1
VERSION=${2-`cat ./VERSION`}
tyk-cli bundle build -y -o "$BUNDLE_NAME-bundle-$VERSION.zip"
