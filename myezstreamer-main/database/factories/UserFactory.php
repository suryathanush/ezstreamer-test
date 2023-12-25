<?php

namespace Database\Factories;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => 'New User',
            'username' => 'DEVICE_ID',// This is the 'id' on the 'devices' table
//            'email_verified_at' => now(),
            'password' => bcrypt('UUID'), //This is the 'uuid' on the 'devices' table
            'remember_token' => Str::random(10),
        ];
    }
}
