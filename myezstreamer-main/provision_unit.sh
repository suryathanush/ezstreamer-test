#!/usr/bin/env bash
################################################################################
#                                                                              #  
#    This script provisions the unit based on the arguments that get passed    #
#                                                                              #  
#                    See usage() below for more information                    #
#                                                                              #  
################################################################################

#set -x # Remove the comment at the front of this line to turn on debugging
set -e  # This causes the script to exit if anything fails

usage() {
  cat <<EOF

Usage: $(basename $0) [-d device_id] [-u uuid ] [-h]

  -d "device_id" is the 'id' column of the 'devices' table on the 
     'ezstreamer' database on the cloud.

  -u "uuid" is the 'uuid' column of the 'devices' table on the
     'ezstreamer' database on the cloud.

  -r If this flag is present, the provisioning is consider a "reprovisioning"
     in which case the git repo is checked out first

  -h Print this help menu.

EOF
exit 1
}

# Get command line options
while getopts "d:u:rh" option;do
  case $option in
    d) device_id=$OPTARG
      ;;
    u) uuid=$OPTARG
       escaped_uuid=$(printf '%s\n' "$uuid" | sed -e 's/[\/&]/\\&/g')
      ;;
    r) git -C ~/ezstreamer checkout -f database/database.sqlite database/factories/UserFactory.php hostapd.conf
       sudo chmod ugo+wrx ~/ezstreamer/database/database.sqlite
      ;;
    h) usage
      ;;
   \?) usage
      ;;
  esac
done

if [ ! -z $device_id ] && [ ! -z $uuid ];then
  echo Provisioning this device as unit $device_id.
  echo UUID:$uuid

  # Prepare the database by replacing the unprovisioned variables with the ones
  # for the new user.
  echo "Preparing the database."
  sed -i "s|DEVICE_ID|$device_id|;s|UUID|$escaped_uuid|" ~/ezstreamer/database/factories/UserFactory.php
  [ $? -eq 0 ] || (echo Something when wrong -- add some debugging; exit 1)
  
  # Seed the database
  echo "Seeding the database for the new user."
  cd ~/ezstreamer; php artisan migrate:fresh --seed

  # Configuring the Access Point SSID and Password
  sudo sed -i "s|SSID|ez$device_id|;s|UUID|$escaped_uuid|" ~/ezstreamer/hostapd.conf
  [ $? -eq 0 ] || (echo Something when wrong -- add some debugging; exit 1)
  sudo systemctl restart hostapd

else
  usage
fi
