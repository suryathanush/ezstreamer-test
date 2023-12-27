<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Models\Stream;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Storage;

define('LARAVEL_START', microtime(true));

require '/home/ezstreamer/ezstreamer/vendor/autoload.php';

$app = require_once '/home/ezstreamer/ezstreamer/bootstrap/app.php';

$kernel = $app->make(Kernel::class);

$response = tap($kernel->handle(
    $request = Request::capture()
));

$kernel->terminate($request, $response);

$streams_url = env('EZ_CLOUD_URL')."/api/streams";
//$stats_url = env('EZ_CLOUD_URL')."/api/stats";

$streams_curl = curl_init($streams_url);
//$stats_curl = curl_init($stats_url);

curl_setopt($streams_curl, CURLOPT_URL, $streams_url);
//curl_setopt($stats_curl, CURLOPT_URL, $stats_url);
curl_setopt($streams_curl, CURLOPT_RETURNTRANSFER, true);
//curl_setopt($stats_curl, CURLOPT_RETURNTRANSFER, true);
//curl_setopt($stats_curl, CURLOPT_CUSTOMREQUEST, "POST");
//curl_setopt($stats_curl, CURLOPT_POSTFIELDS, 
//"-----011000010111000001101001\r\nContent-Disposition: form-data; name=\"fps\"\r\n\r\n15\r\n-----011000010111000001101001\r\nContent-Disposition: form-data; name=\"bitrate\"\r\n\r\nanother test\r\n-----011000010111000001101001\r\nContent-Disposition: form-data; name=\"stream_id\"\r\n\r\n1\r\n-----011000010111000001101001\r\nContent-Disposition: form-data; name=\"user_id\"\r\n\r\n2\r\n-----011000010111000001101001--\r\n");

$streams_headers = array(
   "Accept: application/json",
   "Authorization: Bearer ".env('CLOUD_API_KEY'),
);

//$stats_headers = array(
//   "Accept: application/json",
//   "Authorization: Bearer ".env('CLOUD_API_KEY'),
//   "Content-Type: multipart/form-data; boundary=---011000010111000001101001"
//);

curl_setopt($streams_curl, CURLOPT_HTTPHEADER, $streams_headers);
//curl_setopt($stats_curl, CURLOPT_HTTPHEADER, $stats_headers);

$streams_resp = curl_exec($streams_curl);
//$stats_resp = curl_exec($stats_curl);
curl_close($streams_curl);
//curl_close($stats_curl);

//dump($stats_resp);die;

// Get streams from the cloud
$cloud_streams = collect(json_decode($streams_resp));

// Get the current APP_ENV
$current_app_env = env('APP_ENV');
// Find our source of truth
$source = shell_exec('chooser');


if($cloud_streams->isEmpty())
{
  echo "No streams";
  $sed_results = shell_exec("sed -iv 's/APP_ENV=cloud/APP_ENV=local/' /home/ezstreamer/ezstreamer/.env 2>&1; echo $?");
  // echo "sed_results = $sed_results";
  echo "Local configuration only.";
}
elseif($cloud_streams->count() && $source == "cloud")
{
  // If the truth is in the cloud, delete all local streams
  $current_streams = Stream::all();
  // dump("current_streams = $current_streams");
  foreach ($current_streams as $local_stream)
  {
    $disable_stream = shell_exec("sudo systemctl disable --now $local_stream->stream_service");
    $disable_standby = shell_exec("sudo systemctl disable --now $local_stream->standby_service");
    $remove_screenshot = shell_exec("rm /home/ezstreamer/ezstreamer/storage/app/public/screenshots/stream$local_stream->id.jpg");
    if (isset($local_stream->standby_stream_img)){
        if(Storage::exists($local_stream->standby_stream_img)){
          Storage::delete($local_stream->standby_stream_img);
          $local_stream->standby_stream_img = null;
          $local_stream->save();
        }
    }
    $remove_logfile = "/dev/shm/stream".$local_stream->id.".log";
    shell_exec("sudo rm $remove_logfile");

    // dump("local stream = $local_stream");
    // dump(Http::post("http://localhost/streams/delete/$local_stream"));
    // dump("destroying Stream::destroy($local_stream->id)");
    Stream::destroy($local_stream->id);
  }
  // Then create new streams from the cloud streams
  foreach ($cloud_streams as $stream)
  {
     $new_stream = new Stream;
     $new_stream->id = $stream->id;
     $new_stream->provider_id = $stream->provider_id;
     //$new_stream->user_id = $stream->user_id;
     $new_stream->device_id = User::first()->username;
     $new_stream->stream_name = $stream->stream_name;
     $new_stream->description = $stream->description;
     $new_stream->stream_service = $stream->stream_service;
     $new_stream->standby_service = $stream->standby_service;
     $new_stream->send_audio = $stream->send_audio;
     $new_stream->input_url = $stream->input_url;
     $new_stream->youtube_url = $stream->youtube_url;
     $new_stream->youtube_backup_url = $stream->youtube_backup_url;
     $new_stream->standby_stream_img = $stream->standby_stream_img;
     $new_stream->youtube_key = $stream->youtube_key;
     $new_stream->save();
    };
    // Set the app environment to "cloud" since that is our most recent source of truth
    $sed_results = shell_exec("sed -iv 's/APP_ENV=local/APP_ENV=cloud/' /home/ezstreamer/ezstreamer/.env 2>&1; echo $?");
    // echo "sed_results = $sed_results";
    dump($reload_streams = shell_exec('reload_streams.sh'));
}
else
{
  // Set the app environment to "local" since that is our most recent source of truth
  $sed_results = shell_exec("sed -iv 's/APP_ENV=cloud/APP_ENV=local/' /home/ezstreamer/ezstreamer/.env 2>&1; echo $?");
  // echo "sed_results = $sed_results";
  echo "Local configuration more recent";
}
