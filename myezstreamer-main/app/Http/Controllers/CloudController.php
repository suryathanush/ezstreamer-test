<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CloudController extends Controller
{
	public function viewtoken()
    {
		return view('cloud.edit');
    }

    public function settoken()
	{
		$attributes = request()->validate([
			'cloud_token' => 'alpha_num|max:255|nullable'
		]);
		if(is_null($attributes['cloud_token']))
		{
			file_put_contents(app()->environmentFilePath(), str_replace(
				'CLOUD_API_KEY=' . env('CLOUD_API_KEY'),
				'CLOUD_API_KEY=',
				file_get_contents(app()->environmentFilePath())
			));
		}
		else
		{
			file_put_contents(app()->environmentFilePath(), str_replace(
				'CLOUD_API_KEY=' . env('CLOUD_API_KEY'),
				'CLOUD_API_KEY=' . $attributes['cloud_token'],
				file_get_contents(app()->environmentFilePath())
			));

			// Test the key
			$url = env('EZ_CLOUD_URL')."/api/streams";

			$curl = curl_init($url);
			curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

			$headers = array(
			   "Accept: application/json",
			   "Authorization: Bearer ".$attributes['cloud_token'],
			);
			curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

			$resp = curl_exec($curl);
			if(curl_getinfo($curl, CURLINFO_HTTP_CODE) == "200")
			{
				$flash_message = "Successfully connected to the cloud!";
				curl_close($curl);
				session()->flash('success', "$flash_message");
				return back()->withInput();
			}
			else
			{
				$flash_message = "Unable to connected to the cloud. Please double check your Cloud Token.";
				curl_close($curl);
				session()->flash('failed', "$flash_message");
				return back()->withInput();
			}
		}
    }
}
