<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;


class Stream extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function booted()
    {
      parent::booted();
      static::creating(function ($streams)
      {
        $stream_source = shell_exec('chooser');
        if(Stream::count() == 0)
        {
          DB::update('update "sqlite_sequence" SET "seq" = "0" WHERE "name" = ?', ['streams']);
          $id = 1;
        }
        else
        {
          $id = Stream::latest()->first()->id;
          ++$id;
        }
        $streams->stream_service = "stream@" . $id . ".service";
        $streams->standby_service = "standbystream@" . $id . ".service";
        $streams->id = $id;
      });

      static::creating(function ($streams)
      {
        $streams->input_url = Crypt::encryptString("$streams->input_url");
        $streams->youtube_url = Crypt::encryptString("$streams->youtube_url");
        $streams->youtube_backup_url = Crypt::encryptString("$streams->youtube_backup_url");
        $streams->youtube_key = Crypt::encryptString("$streams->youtube_key");
      });

      static::retrieved(function ($streams)
      {
        $streams->input_url = Crypt::decryptString("$streams->input_url");
        $streams->youtube_url = Crypt::decryptString("$streams->youtube_url");
        $streams->youtube_backup_url = Crypt::decryptString("$streams->youtube_backup_url");
        $streams->youtube_key = Crypt::decryptString("$streams->youtube_key");
      });

      static::updating(function ($streams)
      {
        $streams->input_url = Crypt::encryptString("$streams->input_url");
        $streams->youtube_url = Crypt::encryptString("$streams->youtube_url");
        $streams->youtube_backup_url = Crypt::encryptString("$streams->youtube_backup_url");
        $streams->youtube_key = Crypt::encryptString("$streams->youtube_key");
      });

      static::deleted(function ($streams)
      {
        $current_streams = Stream::all()->pluck('id');
        foreach ($current_streams as $remaining_streams)
        {
          Stream::find($remaining_streams)->touch();
        }
      });

    }
    public function provider() 
    {
	    return $this->belongsTo(Provider::class);
    }
}
