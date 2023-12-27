#!/usr/bin/env bash
set -x
trap 'exit 1' KILL

# Set variables for the specified standby stream

while getopts "s:" stream;do
  case $stream in
    s)
		source <(grep -e "youtube_backup_url$OPTARG" \
			-e "standby_stream_img$OPTARG" <(php /home/ezstreamer/ezstreamer/getstreams.php) |\
			sed "s/youtube_backup_url$OPTARG/youtube_backup_url/;s/standby_stream_img$OPTARG/standby_stream_img/")
	    ;;
    \?) echo "?";exit 1;;
   esac
done
echo "youtube_backup_url=$youtube_backup_url"
echo "standby_stream_img=$standby_stream_img"

if [ -z $standby_stream_img ];then
  image_path=/home/ezstreamer/ezstreamer/images/EZ-Icon-NegativePNG.png
else
  image_path=/home/ezstreamer/ezstreamer/storage/app/public/$standby_stream_img
fi

ffmpeg -re -f image2 -loop 1 -i "$image_path"  -re -f lavfi -i anullsrc -vf format=yuv420p -c:v libx264 -vf scale=1280:720 -b:v 4000k -maxrate 4500k -minrate 1000k -g 50 -c:a aac -f flv "$youtube_backup_url" -force_key_frames 'expr:gte(t,n_forced*2)' -hide_banner
