#!/usr/bin/env bash
#Reload streams after a cloud_sync.sh
db='/home/ezstreamer/ezstreamer/database/database.sqlite'
new_streams=$(sqlite3 $db 'SELECT stream_service FROM streams')

for stream in $new_streams;do
  sudo systemctl enable --now $stream
  sudo systemctl restart $stream
done
