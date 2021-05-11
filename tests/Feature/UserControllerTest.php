<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Team;

class UserControllerTest extends TestCase
{
    use RefreshDataBase, WithFaker;

    public function testIndexNoUsersFound()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $token = $user->createToken($user->id)->plainTextToken;

        $this->json('GET', 'api/users', [],['Accept' => 'application/json', 'Authorization' => 'Bearer '. $token .''])
            ->assertStatus(404);
    }

    public function testIndex()
    {
        $user = User::factory()->create();
        $secondUser = User::factory()->create();
        $thirdUser = User::factory()->create();
        $this->actingAs($user, 'api');
        $token = $user->createToken($user->id)->plainTextToken;

        $team = Team::create(['name' => 'Team name', 'description' => 'description']);

        $team->users()->attach(
            $user->id,
            [
                'is_admin' => true,
                'name_in_team' => "first"
            ]
        );
        $team->users()->attach(
            $secondUser->id,
            [
                'is_admin' => false,
                'name_in_team' => "second"
            ]
        );
        $team->users()->attach(
            $thirdUser->id,
            [
                'is_admin' => false,
                'name_in_team' => "third"
            ]
        );


        $this->json('GET', 'api/users', [],['Accept' => 'application/json', 'Authorization' => 'Bearer '. $token .''])
            ->assertStatus(200);
    }

    public function testShow()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $token = $user->createToken($user->id)->plainTextToken;

        $this->json('GET', 'api/users/'. $user->id, [],['Accept' => 'application/json', 'Authorization' => 'Bearer '. $token .''])
            ->assertStatus(200);
    }
}
