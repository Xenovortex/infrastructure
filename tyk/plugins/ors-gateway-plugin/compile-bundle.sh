#!/usr/bin/env bash
VERSION=$1
tyk-cli bundle build -y -o "directions-bundle-$VERSION.zip"
