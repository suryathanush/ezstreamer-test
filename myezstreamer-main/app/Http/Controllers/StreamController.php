<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Stream;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Storage;


class StreamController extends Controller
{
	
	public function update(Stream $id) 
	{
		$attributes = request()->validate([
			'id' => 'integer',
			'provider_id' => 'integer',
			'stream_name' => 'max:255|nullable',
			'description' => 'max:255|nullable',
			'send_audio' => 'boolean',
			'stream_service' => 'string',
			'standby_service' => 'string',
			'input_url' => 'required|starts_with:"rtsp://"',
			'youtube_url' => 'required|starts_with:"rtmp://","rtmps://"',
			'youtube_backup_url' => 'required|starts_with:"rtmp://","rtmps://"',
			'standby_stream_img' => 'image|nullable',
			'youtube_key' => 'string|max:255'
		]);

		if (substr($attributes['input_url'], -1) == "/" && $attributes['input_url'] != "rtsp://") $attributes['input_url'] = substr($attributes['input_url'], 0, -1);
		$attributes['input_url'] = Crypt::encryptString($attributes['input_url']);
		
		if (substr($attributes['youtube_url'], -1) == "/" && ! preg_match("/rtmp*:\/\//", $attributes['youtube_url'])) $attributes['youtube_url'] = substr($attributes['youtube_url'], 0, -1);
		$attributes['youtube_url'] = Crypt::encryptString($attributes['youtube_url']);

		if (substr($attributes['youtube_backup_url'], -1) == "/" && ! preg_match("/rtmp*:\/\//", $attributes['youtube_backup_url'])) $attributes['youtube_backup_url'] = substr($attributes['youtube_backup_url'], 0, -1);
		$attributes['youtube_backup_url'] = Crypt::encryptString($attributes['youtube_backup_url']);

		$attributes['youtube_key'] = Crypt::encryptString($attributes['youtube_key']);
		if (!isset($attributes['send_audio'])) $attributes['send_audio'] = 0;

		if (isset($attributes['standby_stream_img'])) {
		$attributes['standby_stream_img'] = request()->file('standby_stream_img')->store('standby_stream_images');
		}

		$update_results = Stream::where("id", $attributes['id'])->update($attributes);
		if(is_null($attributes['stream_name']))
		{
			$flash_message = "Stream settings updated successfully!";
		} else
		{
			$flash_message = $attributes['stream_name'] . " settings updated successfully!";
		}
		session()->flash('success', "$flash_message");
		return redirect('/streams');
	}

	public function new() 
	{
		$new_stream = new Stream;
		$new_stream->device_id = User::first()->username;
		$new_stream->input_url = 'rtsp://';
		$new_stream->youtube_url = 'rtmps://a.rtmps.youtube.com/live2';
		$new_stream->youtube_backup_url = 'rtmps://b.rtmps.youtube.com/live2?backup=1';
		$new_stream->standby_stream_img = null;
		$new_stream->youtube_key = 'Stream key';
		//@dd($new_stream);
		if(Stream::count() < 4 ) {
			$new_stream->save();
			session()->flash('success', 'New stream created successfully');
			return redirect('/streams');
		}else{ abort(403); }
	}	
  
	public function monitor()
	{
		return view('monitor', [
			'streams' => Stream::all()
		]);
	}

	public function overview()
	{
		return view('overview', [
			'streams' => Stream::all()
		]);
	}
	
	public function edit()
	{
		if(env('CLOUD_API_KEY')){
			shell_exec('php /home/ezstreamer/ezstreamer/scripts/api/downloadstreams.php');
		}
		return view('streams.edit', [
            'streams' => Stream::all(),
        ]);
	}

	public function destroy(Stream $id)
	{
		$disable_stream = shell_exec("sudo systemctl disable --now $id->stream_service");
		$disable_standby = shell_exec("sudo systemctl disable --now $id->standby_service");
		$remove_screenshot = shell_exec("rm /home/ezstreamer/ezstreamer/storage/app/public/screenshots/stream$id->id.jpg");
		if (isset($id->standby_stream_img)){
		    if(Storage::exists($id->standby_stream_img)){
		    	Storage::delete($id->standby_stream_img);
		    	$id->standby_stream_img = null;
		    	$id->save();
		    }
		}
		$logfile = "/dev/shm/stream".$id->id.".log";
		shell_exec("sudo rm $logfile");
		$id->delete();
		session()->flash('success', 'Stream deleted successfully');
		return redirect('/streams');
	}


	public function remove_image($id) {
		$stream = Stream::find($id);
		//if(Storage::exists($stream->standby_stream_img)){
			Storage::delete($stream->standby_stream_img);
			$stream->standby_stream_img = null;
			$stream->save();
		//}
    //die(dump(request()));
		return redirect('/streams');
	}

	public function restart()
	{
		$stream_service = request()->stream_service;
		$enable_service = shell_exec("sudo systemctl enable --now $stream_service");
		$restart_service = shell_exec("sudo systemctl restart $stream_service");
		if(is_null(request()->stream_name))
		{
			$flash_message = "Streaming service successfully enabled!";
		} else
		{
			$flash_message = request()->stream_name . " streaming service successfully enabled!";
		}
		session()->flash('success', "$flash_message");
		return redirect('/streams');
	}

	public function standbytest()
	{
		$stream_service = request()->stream_service;
		$standby_service = request()->standby_service;
		shell_exec("sudo systemctl stop $stream_service");
		shell_exec("sudo systemctl restart $standby_service");
		session()->flash('success', 'Standby Stream Started');
		return redirect('/streams');
	}


	public function about(){
		return view('about');

	}

	public function setting(){

		$user = Auth::user();
		return view('setting', [
            'streams' => $user,
        ]);
	}
}
