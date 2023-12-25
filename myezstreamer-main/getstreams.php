<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

use App\Models\Stream;

define('LARAVEL_START', microtime(true));

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Kernel::class);

$response = tap($kernel->handle(
    $request = Request::capture()
));

$kernel->terminate($request, $response);

$streams = Stream::all();

foreach($streams as $stream)
{
  echo "stream_id".$stream->id.'="'.$stream->id."\"\n";
  echo "input_url".$stream->id.'="'.$stream->input_url."\"\n";
  echo "youtube_url".$stream->id.'="'.$stream->youtube_url."/".$stream->youtube_key."\"\n";
  echo "youtube_backup_url".$stream->id.'="'.$stream->youtube_backup_url."/".$stream->youtube_key."\"\n";
  echo "standby_stream_img".$stream->id.'="'.$stream->standby_stream_img."\"\n";
  echo "send_audio".$stream->id.'="'.$stream->send_audio."\"\n";
}
