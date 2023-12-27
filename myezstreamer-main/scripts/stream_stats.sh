#!/usr/bin/env bash
# Universal Streamer
trap 'exit 1' KILL
#set -x
# Set variables for the specified stream

while getopts "s:fb" stream;do
  case $stream in
    s) 
            logfile=/dev/shm/stream$OPTARG.log
            servicefile=stream@$OPTARG.service
            standbyservice=standbystream@$OPTARG.service
	    ;;
    f)      grep_for="fps=" ;;
    b)      grep_for="bitrate=" ;;
    \?) echo "?";exit 1;;
   esac
done

if systemctl is-active $standbyservice &>/dev/null;then
  echo "Standby Stream Active"
elif systemctl is-active $servicefile &>/dev/null;then
  results=$(grep --text $grep_for <(tail -n12 $logfile) | cut -d '=' -f2)
  if [ -z $results ];then echo "updating...";else echo $results;fi
else
  echo "Stream not enabled"
fi
