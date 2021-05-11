<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Team;

class TeamControllerTest extends TestCase
{
    use RefreshDataBase, WithFaker;

    public function testTeamCreatedSuccessfully()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $data = [
            "name" => "Test team",
            "description" => "Team description",
        ];
        $token = $user->createToken($user->id)->plainTextToken;

        $this->json('POST', 'api/teams', $data, ['Accept' => 'application/json', 'Authorization' => 'Bearer '. $token .''])
            ->assertStatus(200);
    }

    public function testGetTeam()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $team = Team::create(['name' => 'Team name', 'description' => 'description']);

        $team->users()->attach(
            $user->id,
            [
                'is_admin' => true,
                'name_in_team' => "randomName"
            ]
        );

        $token = $user->createToken($user->id)->plainTextToken;

        $this->json('GET', 'api/teams/'. $team->id, [],['Accept' => 'application/json', 'Authorization' => 'Bearer '. $token .''])
            ->assertStatus(200);
    }

    public function testGetTeamForbbiden()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $team = Team::create(['name' => 'Team name', 'description' => 'description']);

        $token = $user->createToken($user->id)->plainTextToken;

        $this->json('GET', 'api/teams/'. $team->id, [],['Accept' => 'application/json', 'Authorization' => 'Bearer '. $token .''])
            ->assertStatus(403);
    }

    public function testGetTeams()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $team = Team::create(['name' => 'Team name', 'description' => 'description']);

        $team->users()->attach(
            $user->id,
            [
                'is_admin' => true,
                'name_in_team' => "randomName"
            ]
        );

        $token = $user->createToken($user->id)->plainTextToken;

        $this->json('GET', 'api/teams', [],['Accept' => 'application/json', 'Authorization' => 'Bearer '. $token .''])
            ->assertStatus(200);
    }

    public function testGetTeamsNotFound()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $token = $user->createToken($user->id)->plainTextToken;

        $this->json('GET', 'api/teams', [],['Accept' => 'application/json', 'Authorization' => 'Bearer '. $token .''])
            ->assertStatus(404);
    }

    public function testTeamUpdate()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $token = $user->createToken($user->id)->plainTextToken;

        $team = Team::create(['name' => 'Team name', 'description' => 'description']);

        $team->users()->attach(
            $user->id,
            [
                'is_admin' => true,
                'name_in_team' => "randomName"
            ]
        );

        $data = [
            'name' => 'Edited team name', 'description' => 'description'
        ];

        $this->json('PUT', 'api/teams/'. $team->id, $data,['Accept' => 'application/json', 'Authorization' => 'Bearer '. $token .''])
            ->assertStatus(200);
    }

    public function testTeamUpdateForbbiden()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $token = $user->createToken($user->id)->plainTextToken;

        $team = Team::create(['name' => 'Team name', 'description' => 'description']);

        $data = [
            'name' => 'Edited team name', 'description' => 'description'
        ];

        $this->json('PUT', 'api/teams/'. $team->id, $data,['Accept' => 'application/json', 'Authorization' => 'Bearer '. $token .''])
            ->assertStatus(403);
    }

    public function testTeamUpdateRequestValidationNameRequired()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $token = $user->createToken($user->id)->plainTextToken;

        $team = Team::create(['name' => 'Team name', 'description' => 'description']);

        $team->users()->attach(
            $user->id,
            [
                'is_admin' => true,
                'name_in_team' => "randomName"
            ]
        );

        $data = [
            'description' => 'description'
        ];

        $this->json('PUT', 'api/teams/'. $team->id, $data,['Accept' => 'application/json', 'Authorization' => 'Bearer '. $token .''])
            ->assertStatus(422);
    }

    public function testTeamDestroy()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $token = $user->createToken($user->id)->plainTextToken;

        $team = Team::create(['name' => 'Team name', 'description' => 'description']);

        $team->users()->attach(
            $user->id,
            [
                'is_admin' => true,
                'name_in_team' => "randomName"
            ]
        );

        $this->json('DELETE', 'api/teams/'. $team->id, [],['Accept' => 'application/json', 'Authorization' => 'Bearer '. $token .''])
            ->assertStatus(200);
    }

    public function testTeamDestroyForbbiden()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $token = $user->createToken($user->id)->plainTextToken;

        $team = Team::create(['name' => 'Team name', 'description' => 'description']);

        $team->users()->attach(
            $user->id,
            [
                'is_admin' => false,
                'name_in_team' => "randomName"
            ]
        );

        $this->json('DELETE', 'api/teams/'. $team->id, [],['Accept' => 'application/json', 'Authorization' => 'Bearer '. $token .''])
            ->assertStatus(403);
    }
}
