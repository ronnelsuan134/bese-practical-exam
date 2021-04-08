<?php

namespace Database\Factories;

use App\Models\Guest;
use Illuminate\Database\Eloquent\Factories\Factory;

class GuestFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Guest::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => 'back end test',
            'email' => 'backend@multisyscorp.com',
            'password' => '$2y$12$PtblLG2tF9AGqMvSdOD1vObUVgut6s3vkQaeicD2IC7MPsasIz8Ju'
        ];
    }
}
