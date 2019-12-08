<?php

namespace Tests\Unit;

use App\Game;
use App\Match;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseMigrations;
    private $user;
    private function create_user(){
        $this->user = factory(User::class)->create([
            'name' => 'user',
            'email' => 'user@user.com',
            'role' => '0',
            'games_played' => '0',
            'password' => bcrypt('password')
        ]);
    }
    public function test_user_register()
    {
        $response = $this->post('/api/register', [
            'name' => 'user',
            'email' => 'user@user.com',
            'password' => 'password'
        ]);
        $response->assertStatus(200);
    }
    public function test_user_register_incorrect_email()
    {
        $response = $this->post('/api/register', [
            'name' => 'user',
            'email' => 'user',
            'password' => 'password'
        ]);
        $response->assertStatus(302);
    }
    public function test_user_login()
    {
        $this->create_user();
        $response = $this->post('/api/login', [
            'email' => 'user@user.com',
            'password' => 'password'
        ]);
        $response->assertStatus(200);
    }
    public function test_user_login_incorrect(){
        $this->create_user();
        $response = $this->post('/api/login', [
            'email' => 'user@user.com',
            'password' => 'bad password'
        ]);
        $response->assertStatus(422);
    }
    public function test_get_user()
    {
        $this->create_user();
        $response = $this->actingAs($this->user)->get('/api/user');
        $response->assertStatus(200);
    }
    public function test_user_logout(){
        $this->create_user();
        $result = json_decode($this->json('POST','/api/login', [
            'email' => 'user@user.com',
            'password' => 'password'
        ])->getContent(), true);
        $result = $this->json('POST','/api/logout/', [], ['Authentication' => "'Bearer {$result['meta']['token']}"]);
        $result->assertStatus(200);
    }
    public function test_create_game(){
        $this->create_user();
        $response = $this->actingAs($this->user)->post('/api/games', [
            'location' => 'Vilnius',
            'start_at' => '2019-12-09 15:00:00',
        ]);
        $response->assertStatus(201);
    }
    public function test_create_game_empty(){
        $this->create_user();
        $response = $this->actingAs($this->user)->json('POST','/api/games', [
        ]);
        $response->assertStatus(422);
    }
    public function test_update_game(){
        $this->create_user();
        $game = factory(Game::class)->create();
        $response = $this->actingAs($this->user)->json('PATCH', '/api/games/'. $game->id, [
            'location' => 'updated title',
            'start_at' => '2019-12-30 23:59:59',
        ]);
        $response->assertStatus(200);
    }
    public function test_delete_game(){
        $this->create_user();
        $game = factory(Game::class)->create();
        $response = $this->actingAs($this->user)->delete('/api/games/'. $game->id);
        $response->assertStatus(204);
    }
    public function test_create_match(){
        $this->create_user();
        $game = factory(Game::class)->create();
        $response = $this->actingAs($this->user)->post('/api/games/'. $game->id .'/match', [
            'team' => 'Test Team Name',
            'game_id' => $game->id,
        ]);
        $response->assertStatus(201);
    }
    public function test_create_match_empty(){
        $this->create_user();
        $game = factory(Game::class)->create();
        $match = factory(Match::class)->create(['game_id' => $game->id]);
        $response = $this->actingAs($this->user)->post('/api/games/'. $game->id .'/match', [
        ]);
        $response->assertStatus(302);
    }
    public function test_update_match(){
        $this->create_user();
        $game = factory(Game::class)->create();
        $match = factory(Match::class)->create(['game_id' => $game->id]);
        $response = $this->actingAs($this->user)->json('PATCH', '/api/games/'. $game->id . '/match/' . $match->id, [
            'team' => 'New Team B',
        ]);
        $response->assertStatus(200);
    }

    public function test_delete_match(){
        $this->create_user();
        $game = factory(Game::class)->create();
        $match = factory(Match::class)->create(['game_id' => $game->id]);

        $response = $this->actingAs($this->user)->delete('/api/games/'. $game->id . '/match/'. $match->id);
        $response->assertStatus(204);
    }
    public function test_join_game(){
        $this->create_user();
        $game = factory(Game::class)->create();
        $response = $this->actingAs($this->user)->post('/api/games/join/'. $game->id);
        $response->assertStatus(204);
    }
    public function test_leave_game(){
        $this->create_user();
        $game = factory(Game::class)->create();
        $response = $this->actingAs($this->user)->post('/api/games/join/'. $game->id);

        $response = $this->actingAs($this->user)->post('/api/games/leave/'. $game->id);
        $response->assertStatus(204);
    }
}
