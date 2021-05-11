<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Team;
use App\Models\Project;

class ProjectControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testGetCreatedAndTeamProjects()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $token = $user->createToken($user->id)->plainTextToken;
        $team = Team::create(['name' => 'Team name', 'description' => 'description']);
        $project = Project::create(['title' => 'NewProject', 'description' => 'Test project', 'author_id' => $user->id, 'team_id' => $team->id]);


        $this->json('GET', 'api/users/'.$user->id.'/teamProjects', [], ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . $token . ''])
            ->assertStatus(200);
    }

    public function testGetCreatedAndTeamProjectsNotFound()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $token = $user->createToken($user->id)->plainTextToken;
        $team = Team::create(['name' => 'Team name', 'description' => 'description']);


        $this->json('GET', 'api/users/'.$user->id.'/teamProjects', [], ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . $token . ''])
            ->assertStatus(404);
    }

    public function testGetCreatedAndTeamProjectsForbbiden()
    {
        $user = User::factory()->create();
        $secondUser = User::factory()->create();
        $this->actingAs($user, 'api');
        $token = $user->createToken($user->id)->plainTextToken;
        $team = Team::create(['name' => 'Team name', 'description' => 'description']);
        $project = Project::create(['title' => 'NewProject', 'description' => 'Test project', 'author_id' => $user->id, 'team_id' => $team->id]);

        $this->json('GET', 'api/users/'.$secondUser->id.'/teamProjects', [], ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . $token . ''])
            ->assertStatus(403);
    }

    public function testGetCreatedAndTeamProjectsTeam()
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
        $project = Project::create(['title' => 'NewProject', 'description' => 'Test project', 'author_id' => $user->id, 'team_id' => $team->id]);

        $this->json('GET', 'api/users/'.$user->id.'/teamProjects', [], ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . $token . ''])
            ->assertStatus(200);
    }

    public function testGetUserProjects()
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
        $project = Project::create(['title' => 'NewProject', 'description' => 'Test project', 'author_id' => $user->id, 'team_id' => $team->id]);
        $this->json('GET', 'api/users/'.$user->id.'/projects', [], ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . $token . ''])
            ->assertStatus(200);
    }

    public function testGetUserProjectsNotFound()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $token = $user->createToken($user->id)->plainTextToken;

        $this->json('GET', 'api/users/'.$user->id.'/projects', [], ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . $token . ''])
            ->assertStatus(404);
    }

    public function testStoreProjects()
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
        $data = ['title' => 'NewProject', 'description' => 'Test project', 'author_id' => $user->id, 'team_id' => $team->id];
        $this->json('POST', 'api/projects', $data, ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . $token . ''])
            ->assertStatus(200);
    }

    public function testStoreProjectsDifferentUser()
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
        $data = ['title' => 'NewProject', 'description' => 'Test project', 'author_id' => $secondUser->id, 'team_id' => $team->id];
        $this->json('POST', 'api/projects', $data, ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . $token . ''])
            ->assertStatus(422);
    }

    public function testStoreProjectsHasTeamButNotAdmin()
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
        $data = ['title' => 'NewProject', 'description' => 'Test project', 'author_id' => $user->id, 'team_id' => $team->id];
        $this->json('POST', 'api/projects', $data, ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . $token . ''])
            ->assertStatus(403);
    }

    public function testShowProject()
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
        $project = Project::create(['title' => 'NewProject', 'description' => 'Test project', 'author_id' => $user->id, 'team_id' => $team->id]);
        $this->json('GET', 'api/projects/'.$project->id,[], ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . $token . ''])
            ->assertStatus(200);
    }

    public function testShowProjectNoTeam()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $token = $user->createToken($user->id)->plainTextToken;
        $project = Project::create(['title' => 'NewProject', 'description' => 'Test project', 'author_id' => $user->id]);
        $this->json('GET', 'api/projects/'.$project->id,[], ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . $token . ''])
            ->assertStatus(200);
    }

    public function testShowProjectForbbiden()
    {
        $user = User::factory()->create();
        $secondUser = User::factory()->create();
        $this->actingAs($user, 'api');
        $token = $user->createToken($user->id)->plainTextToken;
        $project = Project::create(['title' => 'NewProject', 'description' => 'Test project', 'author_id' => $secondUser->id]);
        $this->json('GET', 'api/projects/'.$project->id,[], ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . $token . ''])
            ->assertStatus(403);
    }

    public function testUpdateProjects()
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
        $project = Project::create(['title' => 'NewProject', 'description' => 'Test project', 'author_id' => $user->id, 'team_id' => $team->id]);
        $data =['title' => 'edited', 'description' => 'edited project', 'team_id' => $team->id];
        $this->json('PUT', 'api/projects/'.$project->id, $data, ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . $token . ''])
            ->assertStatus(200);
    }

    public function testUpdateProjectsDifferentUser()
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
        $project = Project::create(['title' => 'NewProject', 'description' => 'Test project', 'author_id' => $secondUser->id, 'team_id' => $team->id]);
        $data =['title' => 'edited', 'description' => 'edited project', 'team_id' => $team->id];
        $this->json('PUT', 'api/projects/'.$project->id, $data, ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . $token . ''])
            ->assertStatus(200);
    }

    public function testUpdateProjectsHasTeamButNotAdmin()
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
        $project = Project::create(['title' => 'NewProject', 'description' => 'Test project', 'author_id' => $user->id, 'team_id' => $team->id]);
        $data =['title' => 'edited', 'description' => 'edited project', 'team_id' => $team->id];
        $this->json('PUT', 'api/projects/'.$project->id, $data, ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . $token . ''])
            ->assertStatus(403);
    }

    public function testDestroyProject()
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
        $project = Project::create(['title' => 'NewProject', 'description' => 'Test project', 'author_id' => $user->id, 'team_id' => $team->id]);
        $this->json('DELETE', 'api/projects/'.$project->id,[], ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . $token . ''])
            ->assertStatus(200);
    }

    public function testDestroyProjectForbbiden()
    {
        $user = User::factory()->create();
        $secondUser = User::factory()->create();
        $this->actingAs($user, 'api');
        $token = $user->createToken($user->id)->plainTextToken;

        $project = Project::create(['title' => 'NewProject', 'description' => 'Test project', 'author_id' => $secondUser->id]);
        $this->json('DELETE', 'api/projects/'.$project->id,[], ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . $token . ''])
            ->assertStatus(200);
    }
}
