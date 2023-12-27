#!/usr/bin/env bash
#Reload the streams
current_streams=$(grep stream <(ls /etc/systemd/system/multi-user.target.wants/))

if [ ! -z $current_streams ];then
  for stream in $current_streams;do
    sudo systemctl restart $stream
  done
else
  echo "No streams currently enabled"
fi
