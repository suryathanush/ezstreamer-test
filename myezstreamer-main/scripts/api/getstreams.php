<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Models\Stream;

define('LARAVEL_START', microtime(true));

require '/home/ezstreamer/ezstreamer/vendor/autoload.php';

$app = require_once '/home/ezstreamer/ezstreamer/bootstrap/app.php';

$kernel = $app->make(Kernel::class);

$response = tap($kernel->handle(
    $request = Request::capture()
));

$kernel->terminate($request, $response);

$streams = Stream::all();

foreach($streams as $stream)
{
  echo "input_url".$stream->id.'="'.$stream->input_url."\"\n";
  $youtubeKey = $stream->youtube_key;
  echo "youtube_url".$stream->id.'="'.$stream->youtube_url."/".$youtubeKey."\"\n";
  echo "youtube_backup_url".$stream->id.'="'.$stream->youtube_backup_url."/".$youtubeKey."\"\n";
  echo "send_audio".$stream->id.'='.$stream->send_audio."\n";
  echo "updated_at".$stream->id.'='.$stream->updated_at."\n";
}
