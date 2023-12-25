<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;
use App\Models\User;
use App\Models\Stream;
use App\Models\Provider;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

	 Provider::create([
		 'streaming_service' => 'YouTube',
	 ]);
	 Provider::create([
		 'streaming_service' => 'Facebook',
	 ]);
         User::factory(1)->create();
         //Stream::factory(4)->create();
    }
}
