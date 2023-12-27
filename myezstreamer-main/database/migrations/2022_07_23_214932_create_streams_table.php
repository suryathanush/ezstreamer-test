<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('streams', function (Blueprint $table) {
        $table->id();
	    $table->foreignId('provider_id')->nullable()->references('id')->on('providers');
	   $table->foreignId('device_id')->references('username')->on('users');
        $table->text('stream_name')->nullable();
        $table->text('description')->nullable();
        $table->string('stream_service')->nullable();
        $table->string('standby_service')->nullable();
	    $table->boolean('send_audio')->default('1');
	    $table->string('input_url')->nullable();
	    $table->string('youtube_url')->nullable();
	    $table->string('youtube_backup_url')->nullable();
        $table->string('standby_stream_img')->nullable();
	    $table->string('youtube_key')->unique()->nullable();
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('streams');
    }
};
