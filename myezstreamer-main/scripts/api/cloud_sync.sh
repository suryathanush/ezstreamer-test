#!/usr/bin/env bash
#Sync with the cloud (if possible)
HOME=/home/ezstreamer
source $HOME/ezstreamer/.env

[ -z $CLOUD_API_KEY ] && exit 0

php $HOME/ezstreamer/scripts/api/downloadstreams.php
