<?php

namespace Database\Factories;

use App\Models\Movie;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Review::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $users = User::select('id')->get();
        $random_user_id = $this->faker->randomElement($users->modelKeys());
        $movies = Movie::select('id')->get();
        $random_movie_id = $this->faker->randomElement($movies->modelKeys());
        $selected_movie_created_at = Movie::find($random_movie_id)->created_at;
        return [
            'user_id' => $random_user_id,
            'movie_id' => $random_movie_id,
            'published_at' => $this->faker->dateTimeBetween($selected_movie_created_at, 'now'),
            'content' => $this->faker->text(),
            'rating' => $this->faker->randomDigit() + 1,
        ];
    }
}
