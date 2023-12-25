#!/usr/bin/env bash
# Universal Streamer
source /home/ezstreamer/ezstreamer/.env
trap 'exit 1' KILL
set -x
# Set variables for the specified stream

while getopts "s:" stream;do
  case $stream in
    s) 
      source <(grep -e "input_url$OPTARG" \
      -e "youtube_url$OPTARG" \
      -e "send_audio$OPTARG" <(php /home/ezstreamer/ezstreamer/getstreams.php) |\
      sed "s/input_url$OPTARG/input_url/;s/youtube_url$OPTARG/youtube_url/;s/send_audio$OPTARG/send_audio/")
      standby_stream=standbystream@${OPTARG}.service
      logfile=/dev/shm/stream${OPTARG}.log
      servicefile=stream@${OPTARG}.service
	    ;;
    \?) echo "SOME bullshit happened -- call Patrick";exit 1;;
   esac
done
echo "input_url=$input_url"
echo "youtube_url=$youtube_url"
echo "send_audio=$send_audio"

if [ -z "$input_url" ] || [ -z "$youtube_url" ];then
  echo "Stream not configured properly"
  echo "/home/ezstreamer/ezstreamer/getstreams.php:"
  php /home/ezstreamer/ezstreamer/getstreams.php
  exit 1
fi

>$logfile

if [ $send_audio -eq 1 ];then
  #WITH AUDIO
  ffmpeg -re -rtsp_transport tcp -i "$input_url" -c:v copy -c:a aac -ar 44100 -strict -2 -b:a 64k -progress $logfile -filter:a loudnorm -f flv "$youtube_url" -nostats -hide_banner -loglevel error &
else
  #NO AUDIO
  ffmpeg -re -rtsp_transport tcp -i "$input_url" -f lavfi -i anullsrc -c:v copy -c:a aac -strict -2 -b:a 64k -progress $logfile -f flv "$youtube_url" -nostats -hide_banner -loglevel error &
fi


sleep 7

while pgrep ffmpeg &>/dev/null;do
  sleep 4
  currentFrame=$(grep "frame=" <(tail -n12 $logfile))
  bitRate=$(grep "bitrate=" <(tail -n12 $logfile))
  fps=$(grep "fps=" <(tail -n12 $logfile))
  curl --request POST \
      --url $EZ_CLOUD_URL/api/stats \
      --header 'Accept: application/json' \
      --header "Authorization: Bearer $CLOUD_API_KEY" \
      --header 'Content-Type: multipart/form-data' \
      --form "$fps" \
      --form "$bitRate" \
      --form "stream_id=1" \
      --form "user_id=2"
  echo "---------------$(date)---------------"
  echo "         current $currentFrame"
  echo "         $bitRate"
  echo "         $fps"
  if [ "$lastFrame" == "$currentFrame" ];then
    >$logfile
    sleep 12
    lastFrame=$currentFrame
    currentFrame=$(grep "frame=" <(tail -n12 $logfile))
    if [ "$lastFrame" == "$currentFrame" ] || [ -z "$currentFrame" ];then
      systemctl restart $servicefile & exit 1
    fi
  else
    if [ "$(systemctl is-active $standby_stream)" == "active" ];then
      systemctl stop $standby_stream
    fi
    lastFrame=$currentFrame
  fi
  #>$logfile
done
exit 1
