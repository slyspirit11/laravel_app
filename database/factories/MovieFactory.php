<?php

namespace Database\Factories;

use App\Models\Movie;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MovieFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Movie::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $users = User::select('id')->get();
        $default_image_name = '1638265565.jpg';
        return [
            'title' => $this->faker->words(2, true),
            'user_id' => $this->faker->randomElement($users->modelKeys()),
            'director' => $this->faker->name(),
            'year' => $this->faker->numberBetween(1890, date("Y")),
            'synopsys' => $this->faker->text(),
            'poster_path' => $default_image_name,
            'created_at' => $this->faker->dateTimeBetween('-20 years', 'now'),

        ];
    }
}
