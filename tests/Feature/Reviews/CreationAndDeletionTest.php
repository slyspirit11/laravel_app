<?php

namespace Tests\Feature;

use App\Models\Movie;
use App\Models\Review;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreationAndDeletionTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_authorized_can_create_a_review_to_any_movie()
    {
        $users = User::factory(2)->create();
        $movies = Movie::factory(10)->create();
        $response = $this
            ->actingAs($users[0])
            ->withSession(['banned' => false])
            ->get(route('movies.show', ['user' => $users[1]->name, 'movie' => $users[1]->movies[0]->id]));
        $response->assertStatus(200);
        $response->assertSeeText('Рецензия');
        $newReviewData = [
            'content' => $this->faker->text(),
            'rating' => $this->faker->randomDigit() + 1,
        ];
        $response = $this
            ->actingAs($users[0])
            ->withSession(['banned' => false])
            ->post(route('reviews.store', ['user' => $users[1]->name, 'movie' => $users[1]->movies[0]->id]), $newReviewData);
        $this->assertDatabaseHas(Review::class, $newReviewData);
        $response->assertRedirect(route('movies.show', ['user' => $users[1]->name, 'movie' => $users[1]->movies[0]->id]));
        $response = $this
            ->actingAs($users[0])
            ->withSession(['banned' => false])
            ->get(route('movies.show', ['user' => $users[1]->name, 'movie' => $users[1]->movies[0]->id]));
        $response->assertSeeText($newReviewData['content']);

    }


    public function test_reviews_are_softdeleted_along_with_softdeleted_movie()
    {
        $user = User::factory()->create();
        $movie = Movie::factory()->create();
        $reviews = Review::factory(3)->create();
        $response = $this
            ->actingAs($user)
            ->withSession(['banned' => false])
            ->delete(route('movies.destroy', ['user' => $user->name, 'movie' => $movie->id]));
        $this->assertSoftDeleted(Movie::class, $movie->toArray());
        foreach ($reviews as $review) {
            $this->assertSoftDeleted($review);
        }
        $response->assertRedirect(route('movies', ['user' => $user->name]));
    }

    public function test_reviews_are_forcedeleted_along_with_forcedeleted_movie()
    {
        $admin = User::factory()->administrator()->create();
        $movie = Movie::factory()->create();
        $reviews = Review::factory(3)->create();
        $response = $this
            ->actingAs($admin)
            ->withSession(['banned' => false])
            ->delete(route('movies.forceDelete', ['user' => $admin->name, 'movie' => $movie->id]));
        $response->assertRedirect(route('movies', ['user' => $admin->name]));
        $this->assertDatabaseMissing(Movie::class, $movie->toArray());
        foreach ($reviews as $review) {
            $this->assertDatabaseMissing(Review::class, $review->toArray());
        }
    }
}
