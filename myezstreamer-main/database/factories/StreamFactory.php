<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Stream;
use Illuminate\Support\Facades\Crypt;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Stream>
 */
class StreamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
		'provider_id' => '1',
        'device_id' => '42',
        'user_id' => '42',
		'stream_name' => $this->faker->name,
		'description' => $this->faker->sentence(3),
        'stream_service' => 'test',        
        'standby_service' => 'test',
        'send_audio' => '1',
		'input_url' => Crypt::encryptString($this->faker->url),
		'youtube_url' => Crypt::encryptString($this->faker->url),
		'youtube_backup_url' => Crypt::encryptString($this->faker->url),
        'standby_stream_img' => $this->faker->url,
		'youtube_key' => Crypt::encryptString($this->faker->regexify('[A-Za-z0-9\-]{20}'))
        ];
    }
}
