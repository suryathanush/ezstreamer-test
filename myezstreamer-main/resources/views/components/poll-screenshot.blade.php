<div wire:poll.15s>
  @php
    exec("ffmpeg -y -rtsp_transport tcp -i \"$input_url\" -frames:v 1 /home/ezstreamer/ezstreamer/storage/app/public/screenshots/stream$stream_id.jpg > /dev/null &");
  @endphp
  @if (file_exists("/home/ezstreamer/ezstreamer/storage/app/public/screenshots/stream".$stream_id.".jpg"))
     <img alt="Loading preview . . ." class="max-h-full" src="/storage/screenshots/stream<?= $stream_id.'.jpg?'.time();?>">
  @else
     <p>Preview unavailable</p>
  @endif
</div>
