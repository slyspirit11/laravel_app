<?php

namespace Tests\Feature;

use App\Models\Movie;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CRUDOperationsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @covers \App\Http\Controllers\MovieController::index()
     */
    public function test_authorized_can_see_his_movies()
    {
        $user = User::factory()->create();
        $movies = Movie::factory(3)->create();
        $response = $this
            ->actingAs($user)
            ->withSession(['banned' => false])
            ->get(route('movies', ['user' => $user->name]));
        $response->assertStatus(200);
        $response->assertSeeText($movies[0]->title);
    }

    public function test_authorized_can_see_movies_of_another_user()
    {
        $users = User::factory(2)->create();
        $movies_of_another_user = Movie::factory(5)->create([
            'user_id' => $users[1]->id,
        ]);
        $response = $this
            ->actingAs($users[0])
            ->withSession(['banned' => false])
            ->get(route('movies', ['user' => $users[1]->name]));
        $response->assertStatus(200);
        $response->assertSeeText($movies_of_another_user[0]->title);
    }

    public function test_created_user_is_administrator()
    {
        $admin = User::factory()->administrator()->create();
        $this->assertTrue($admin->is_admin);
    }

    public function test_authorized_can_create_a_movie()
    {
        $user = User::factory()->create();
        $response = $this
            ->actingAs($user)
            ->withSession(['banned' => false])
            ->get(route('movies.create', ['user' => $user->id]));
        $response->assertStatus(200);
        $response->assertSeeText('Фотография для обложки');
        $newMovieData = [
            'title' => $this->faker->words(2, true),
            'director' => $this->faker->name(),
            'year' => $this->faker->numberBetween(1890, date("Y")),
            'synopsys' => $this->faker->text(),
            'poster_path' => null,
        ];
        $response = $this
            ->actingAs($user)
            ->withSession(['banned' => false])
            ->post(route('movies.store'), $newMovieData);
        $this->assertDatabaseHas(Movie::class, $newMovieData);
        $response->assertRedirect(route('movies', ['user' => $user->name]));
    }

    public function test_authorized_cannot_see_edit_delete_forcedelete_restore_buttons_at_a_movie_card_of_another_user()
    {
        $users = User::factory(2)->create();
        $movie_of_another_user = Movie::factory()->create([
            'user_id' => $users[1]->id,
        ]);
        $response = $this
            ->actingAs($users[0])
            ->withSession(['banned' => false])
            ->get(route('movies.show', ['user' => $users[1]->id, 'movie' => $movie_of_another_user->id]));
        $response->assertDontSeeText('Редактировать');
        $response->assertDontSeeText('Удалить');
        $response->assertDontSeeText('Force delete');
        $response->assertDontSeeText('Восстановить');
    }

    public function test_authorized_can_edit_his_movie()
    {
        $user = User::factory()->create();
        $movie = Movie::factory()->create();
        $response = $this
            ->actingAs($user)
            ->withSession(['banned' => false])
            ->get(route('movies.edit', ['user' => $user->name, 'movie' => $movie->id]));
        $response->assertStatus(200);
        $response->assertSeeText('Фотография для обложки');
        $newMovieData = [
            'title' => $this->faker->words(2, true),
            'director' => $this->faker->name(),
            'year' => $this->faker->numberBetween(1890, date("Y")),
            'synopsys' => $this->faker->text(),
        ];
        $response = $this
            ->actingAs($user)
            ->withSession(['banned' => false])
            ->put(route('movies.update', ['user' => $user->name, 'movie' => $movie->id]), $newMovieData);
        $this->assertDatabaseHas(Movie::class, $newMovieData);
        $response->assertRedirect(route('movies.show', ['user' => $user->name, 'movie' => $movie->id]));
    }

    public function test_authorized_cannot_edit_a_movie_of_another_user()
    {
        $users = User::factory(2)->create();
        $movie_of_another_user = Movie::factory()->create([
            'user_id' => $users[1]->id
        ]);
        $response = $this
            ->actingAs($users[0])
            ->withSession(['banned' => false])
            ->get(route('movies.edit', ['user' => $users[1]->name, 'movie' => $movie_of_another_user->id]));
        $response->assertStatus(403);
        $newMovieData = [
            'title' => $this->faker->words(2, true),
            'director' => $this->faker->name(),
            'year' => $this->faker->numberBetween(1890, date("Y")),
            'synopsys' => $this->faker->text(),
        ];
        $response = $this
            ->actingAs($users[0])
            ->withSession(['banned' => false])
            ->put(route('movies.update', ['user' => $users[1]->name, 'movie' => $movie_of_another_user->id]), $newMovieData);
        $this->assertDatabaseMissing(Movie::class, $newMovieData);
        $response->assertStatus(403);
    }

    public function test_authorized_admin_can_edit_a_movie_of_another_user()
    {
        $admin = User::factory()->administrator()->create();
        $user = User::factory()->create();
        $movie_of_another_user = Movie::factory()->create([
            'user_id' => $user->id
        ]);
        $response = $this
            ->actingAs($admin)
            ->withSession(['banned' => false])
            ->get(route('movies.edit', ['user' => $user->name, 'movie' => $movie_of_another_user->id]));
        $response->assertStatus(200);
        $newMovieData = [
            'title' => $this->faker->words(2, true),
            'director' => $this->faker->name(),
            'year' => $this->faker->numberBetween(1890, date("Y")),
            'synopsys' => $this->faker->text(),
        ];
        $response = $this
            ->actingAs($admin)
            ->withSession(['banned' => false])
            ->put(route('movies.update', ['user' => $user->name, 'movie' => $movie_of_another_user->id]), $newMovieData);
        $this->assertDatabaseHas(Movie::class, $newMovieData);
        $response->assertRedirect(route('movies.show', ['user' => $user->name, 'movie' => $movie_of_another_user->id]));
    }

    public function test_authorized_can_softdelete_his_movie()
    {
        $user = User::factory()->create();
        $movie = Movie::factory()->create();
        $response = $this
            ->actingAs($user)
            ->withSession(['banned' => false])
            ->get(route('movies', ['user' => $user->name]));
        $response->assertSeeText($movie->title);
        $response = $this
            ->actingAs($user)
            ->withSession(['banned' => false])
            ->delete(route('movies.destroy', ['user' => $user->name, 'movie' => $movie->id]));
        $this->assertSoftDeleted($movie);
        $response->assertRedirect(route('movies', ['user' => $user->name]));
        $response = $this
            ->actingAs($user)
            ->withSession(['banned' => false])
            ->get(route('movies', ['user' => $user->name]));
        $response->assertSeeText('Коллекция пуста');
    }

    public function test_authorized_cannot_softdelete_a_movie_of_another_user()
    {
        $users = User::factory(2)->create();
        $movie = Movie::factory()->create(['user_id' => $users[1]]);
        $response = $this
            ->actingAs($users[0])
            ->withSession(['banned' => false])
            ->delete(route('movies.destroy', ['user' => $users[1]->name, 'movie' => $movie->id]));
        $this->assertNotSoftDeleted($movie);
        $response->assertStatus(403);
    }

    public function test_authorized_admin_can_softdelete_a_movie_of_another_user()
    {
        $admin = User::factory()->administrator()->create();
        $user = User::factory()->create();
        $movie_of_another_user = Movie::factory()->create([
            'user_id' => $user->id
        ]);
        $response = $this
            ->actingAs($admin)
            ->withSession(['banned' => false])
            ->get(route('movies', ['user' => $user->name]));
        $response->assertSeeText($movie_of_another_user->title);
        $response = $this
            ->actingAs($admin)
            ->withSession(['banned' => false])
            ->delete(route('movies.destroy', ['user' => $user->name, 'movie' => $movie_of_another_user->id]));
        $this->assertSoftDeleted($movie_of_another_user);
        $response->assertRedirect(route('movies', ['user' => $user->name]));
    }

    public function test_softdeleted_movie_visibility()
    {
        $admin = User::factory()->administrator()->create();
        $user = User::factory()->create();
        $movie_of_another_user = Movie::factory()->create([
            'user_id' => $user->id
        ]);
        $this
            ->actingAs($admin)
            ->withSession(['banned' => false])
            ->delete(route('movies.destroy', ['user' => $user->name, 'movie' => $movie_of_another_user->id]));
        $response = $this
            ->actingAs($admin)
            ->withSession(['banned' => false])
            ->get(route('movies', ['user' => $user->name]));
        $response->assertSeeText('Удалённый объект');
        $response = $this
            ->actingAs($user)
            ->withSession(['banned' => false])
            ->get(route('movies', ['user' => $user->name]));
        $response->assertSeeText('Коллекция пуста');
    }

    public function test_authorized_admin_can_restore_any_softdeleted_movie()
    {
        $admin = User::factory()->administrator()->create();
        $user = User::factory()->create();
        $movie_of_another_user = Movie::factory()->create([
            'user_id' => $user->id
        ]);
        $response = $this
            ->actingAs($admin)
            ->withSession(['banned' => false])
            ->delete(route('movies.destroy', ['user' => $user->name, 'movie' => $movie_of_another_user->id]));
        $response->assertRedirect(route('movies', ['user' => $user->name]));
        $response = $this
            ->actingAs($admin)
            ->withSession(['banned' => false])
            ->put(route('movies.restore', ['user' => $user->name, 'movie' => $movie_of_another_user->id]));
        $response->assertRedirect(route('movies', ['user' => $user->name]));
        $response = $this
            ->actingAs($user)
            ->withSession(['banned' => false])
            ->get(route('movies', ['user' => $user->name]));
        $response->assertSeeText($movie_of_another_user->title);

    }

    public function test_authorized_cannot_forcedelete_a_movie()
    {
        $user = User::factory()->create();
        $movie = Movie::factory()->create();
        $response = $this
            ->actingAs($user)
            ->withSession(['banned' => false])
            ->delete(route('movies.forceDelete', ['user' => $user->name, 'movie' => $movie->id]));
        $this->assertDatabaseHas(Movie::class, $movie->toArray());
        $response->assertStatus(403);
    }

    public function test_authorized_admin_can_forcedelete_a_movie()
    {
        $admin = User::factory()->administrator()->create();
        $user = User::factory()->create();
        $movie = Movie::factory()->create(['user_id' => $user->id]);
        $response = $this
            ->actingAs($admin)
            ->withSession(['banned' => false])
            ->delete(route('movies.forceDelete', ['user' => $user->name, 'movie' => $movie->id]));
        $this->assertDatabaseMissing(Movie::class, $movie->toArray());
        $response->assertRedirect(route('movies', ['user' => $user->name]));
        $response = $this
            ->actingAs($user)
            ->withSession(['banned' => false])
            ->get(route('movies', ['user' => $user->name]));
        $response->assertDontSeeText($movie->title);
    }

}
