<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Team;
use App\Models\Project;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;

class AdminControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testAddUserToTeam()
    {
        $user = User::factory()->create();
        $secondUser = User::factory()->create();
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
            'email' => $secondUser->email,
            'is_admin' => false,
            'name_in_team' => 'new member'
        ];
        $this->json('POST', 'api/teams/' . $team->id . '/addUser', $data, ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . $token . ''])
            ->assertStatus(200);
    }

    public function testAddSameUserToTeam()
    {
        $user = User::factory()->create();
        $secondUser = User::factory()->create();
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

        $team->users()->attach(
            $secondUser->id,
            [
                'is_admin' => false,
                'name_in_team' => "randomName"
            ]
        );

        $data = [
            'email' => $secondUser->email,
            'is_admin' => false,
            'name_in_team' => 'new member'
        ];
        $this->json('POST', 'api/teams/' . $team->id . '/addUser', $data, ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . $token . ''])
            ->assertStatus(409);
    }


    public function testRemoveUserFromTeam()
    {
        $user = User::factory()->create();
        $secondUser = User::factory()->create();
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

        $team->users()->attach(
            $secondUser->id,
            [
                'is_admin' => false,
                'name_in_team' => "randomName"
            ]
        );
        $this->json('DELETE', 'api/teams/'.$team->id.'/users/'.$secondUser->id, [], ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . $token . ''])
            ->assertStatus(200);
    }

    public function testRemoveUserFromTeamForbbiden()
    {
        $user = User::factory()->create();
        $secondUser = User::factory()->create();
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

        $team->users()->attach(
            $secondUser->id,
            [
                'is_admin' => false,
                'name_in_team' => "randomName"
            ]
        );
        $this->json('DELETE', 'api/teams/'.$team->id.'/users/'.$secondUser->id, [], ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . $token . ''])
            ->assertStatus(403);
    }

    public function testUpdateUserInTeam()
    {
        $user = User::factory()->create();
        $secondUser = User::factory()->create();
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

        $team->users()->attach(
            $secondUser->id,
            [
                'is_admin' => false,
                'name_in_team' => "randomName"
            ]
        );

        $data = [
            'is_admin' => true,
            'name_in_team' => "edited"
        ];

        $this->json('PUT', 'api/teams/'.$team->id.'/users/'.$secondUser->id, $data, ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . $token . ''])
            ->assertStatus(200);
    }

    public function testUpdateUserInTeamForbbiden()
    {
        $user = User::factory()->create();
        $secondUser = User::factory()->create();
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

        $team->users()->attach(
            $secondUser->id,
            [
                'is_admin' => false,
                'name_in_team' => "randomName"
            ]
        );

        $data = [
            'is_admin' => true,
            'name_in_team' => "edited"
        ];

        $this->json('PUT', 'api/teams/'.$team->id.'/users/'.$secondUser->id, $data, ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . $token . ''])
            ->assertStatus(403);
    }

    public function testGetProjectByStatusNoTasks()
    {
        $user = User::factory()->create();
        $secondUser = User::factory()->create();
        $this->actingAs($user, 'api');
        $token = $user->createToken($user->id)->plainTextToken;
        $team = Team::create(['name' => 'Team name', 'description' => 'description']);
        $project = Project::create(['title' => 'NewProject', 'description' => 'Test project', 'author_id' => $user->id, 'team_id' => $team->id]);


        $this->json('GET', 'api/project/'.$project->id.'/tasks',[], ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . $token . ''])
            ->assertStatus(403);
    }

    public function testGetProjectByStatus()
    {
        Artisan::call('db:seed');
        $user = User::factory()->create();
        $secondUser = User::factory()->create();
        $this->actingAs($user, 'api');
        $token = $user->createToken($user->id)->plainTextToken;
        $team = Team::create(['name' => 'Team name', 'description' => 'description']);
        $project = Project::create(['title' => 'NewProject', 'description' => 'Test project', 'author_id' => $user->id, 'team_id' => $team->id]);
        $team->users()->attach(
            $user->id,
            [
                'is_admin' => true,
                'name_in_team' => "randomName"
            ]
        );
        $projectTask = Task::create([
            'title' => 'task', 'description' => 'test task',
            'date_till_done' => Carbon::now(), 'status_id' => 3, 'priority_id' => 3, 'reporter_id' => $user->id,
            'assignee_id' => $user->id, 'project_id' => $project->id
        ]);

        $this->json('GET', 'api/project/'.$project->id.'/tasks',[], ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . $token . ''])
            ->assertStatus(403);
    }
}
