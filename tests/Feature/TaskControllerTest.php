<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Task;
use App\Models\Team;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testGetAssignedTasks()
    {
        Artisan::call('db:seed');
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $task = Task::create([
            'title' => 'task', 'description' => 'test task',
            'date_till_done' => Carbon::now(), 'status_id' => 1, 'priority_id' => 1, 'reporter_id' => $user->id,
            'assignee_id' => $user->id
        ]);
        $token = $user->createToken($user->id)->plainTextToken;

        $this->json('GET', 'api/assignedTasks',[], ['Accept' => 'application/json', 'Authorization' => 'Bearer '. $token .''])
            ->assertStatus(200);
    }

    public function testGetAssignedTasksNotFound()
    {
        Artisan::call('db:seed');
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $token = $user->createToken($user->id)->plainTextToken;

        $this->json('GET', 'api/assignedTasks',[], ['Accept' => 'application/json', 'Authorization' => 'Bearer '. $token .''])
            ->assertStatus(404);
    }

    public function testGetCreatedTasks()
    {
        Artisan::call('db:seed');
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $task = Task::create([
            'title' => 'task', 'description' => 'test task',
            'date_till_done' => Carbon::now(), 'status_id' => 1, 'priority_id' => 1, 'reporter_id' => $user->id,
            'assignee_id' => $user->id
        ]);
        $token = $user->createToken($user->id)->plainTextToken;

        $this->json('GET', 'api/createdTasks',[], ['Accept' => 'application/json', 'Authorization' => 'Bearer '. $token .''])
            ->assertStatus(200);
    }

    public function testGetCreatedTasksNotFound()
    {
        Artisan::call('db:seed');
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $token = $user->createToken($user->id)->plainTextToken;

        $this->json('GET', 'api/createdTasks',[], ['Accept' => 'application/json', 'Authorization' => 'Bearer '. $token .''])
            ->assertStatus(404);
    }

    public function testCreateTaskNoProject()
    {
        Artisan::call('db:seed');
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
    
        $token = $user->createToken($user->id)->plainTextToken;
        $data = ['title' => 'task', 'description' => 'test task',
        'date_till_done' => Carbon::now(), 'status_id' => 1, 'priority_id' => 1, 'reporter_id' => $user->id,
        'assignee_id' => $user->id];

        $this->json('POST', 'api/tasks',$data, ['Accept' => 'application/json', 'Authorization' => 'Bearer '. $token .''])
            ->assertStatus(200);
    }

    public function testCreateTaskProject()
    {
        Artisan::call('db:seed');
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $project = Project::create(['title' => 'NewProject', 'description' => 'Test project', 'author_id' => $user->id]);
        $token = $user->createToken($user->id)->plainTextToken;
        $data = ['title' => 'task', 'description' => 'test task', 'project_id' => $project->id,
        'date_till_done' => Carbon::now(), 'status_id' => 1, 'priority_id' => 1, 'reporter_id' => $user->id,
        'assignee_id' => $user->id];

        $this->json('POST', 'api/tasks',$data, ['Accept' => 'application/json', 'Authorization' => 'Bearer '. $token .''])
            ->assertStatus(200);
    }

    public function testCreateTaskAssigneeDoesNotExist()
    {
        Artisan::call('db:seed');
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $token = $user->createToken($user->id)->plainTextToken;
        $data = ['title' => 'task', 'description' => 'test task',
        'date_till_done' => Carbon::now(), 'status_id' => 1, 'priority_id' => 1, 'reporter_id' => $user->id,
        'assignee_id' => 99];

        $this->json('POST', 'api/tasks',$data, ['Accept' => 'application/json', 'Authorization' => 'Bearer '. $token .''])
            ->assertStatus(404);
    }

    public function testCreateTaskTeamProject()
    {
        Artisan::call('db:seed');
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $team = Team::create(['name' => 'Team name', 'description' => 'description']);
        $project = Project::create([
            'title' => 'SecondProject', 'description' => 'Test project 2',
            'author_id' => $user->id, 'team_id' => $team->id
        ]);
        $team->users()->attach(
            $user->id,
            [
                'is_admin' => true,
                'name_in_team' => "randomName"
            ]
        );
        $token = $user->createToken($user->id)->plainTextToken;
        $data = ['title' => 'task', 'description' => 'test task', 'project_id' => $project->id,
        'date_till_done' => Carbon::now(), 'status_id' => 1, 'priority_id' => 1, 'reporter_id' => $user->id,
        'assignee_id' => $user->id];

        $this->json('POST', 'api/tasks',$data, ['Accept' => 'application/json', 'Authorization' => 'Bearer '. $token .''])
            ->assertStatus(200);
    }

    public function testCreateTaskTeamProjectNoAdminRights()
    {
        Artisan::call('db:seed');
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $team = Team::create(['name' => 'Team name', 'description' => 'description']);
        $project = Project::create([
            'title' => 'SecondProject', 'description' => 'Test project 2',
            'author_id' => $user->id, 'team_id' => $team->id
        ]);
        $team->users()->attach(
            $user->id,
            [
                'is_admin' => false,
                'name_in_team' => "randomName"
            ]
        );
        $token = $user->createToken($user->id)->plainTextToken;
        $data = ['title' => 'task', 'description' => 'test task', 'project_id' => $project->id,
        'date_till_done' => Carbon::now(), 'status_id' => 1, 'priority_id' => 1, 'reporter_id' => $user->id,
        'assignee_id' => $user->id];

        $this->json('POST', 'api/tasks',$data, ['Accept' => 'application/json', 'Authorization' => 'Bearer '. $token .''])
            ->assertStatus(403);
    }

    public function testCreateTaskTeamProjectDifferentAssignee()
    {
        Artisan::call('db:seed');
        $user = User::factory()->create();
        $secondUser = User::factory()->create();
        $this->actingAs($user, 'api');
        $team = Team::create(['name' => 'Team name', 'description' => 'description']);
        $project = Project::create([
            'title' => 'SecondProject', 'description' => 'Test project 2',
            'author_id' => $user->id, 'team_id' => $team->id
        ]);
        $team->users()->attach(
            $user->id,
            [
                'is_admin' => true,
                'name_in_team' => "admin"
            ]
        );
        $team->users()->attach(
            $secondUser->id,
            [
                'is_admin' => false,
                'name_in_team' => "member"
            ]
        );
        $token = $user->createToken($user->id)->plainTextToken;
        $data = ['title' => 'task', 'description' => 'test task', 'project_id' => $project->id,
        'date_till_done' => Carbon::now(), 'status_id' => 1, 'priority_id' => 1, 'reporter_id' => $user->id,
        'assignee_id' => $secondUser->id];

        $this->json('POST', 'api/tasks',$data, ['Accept' => 'application/json', 'Authorization' => 'Bearer '. $token .''])
            ->assertStatus(200);
    }

    public function testUpdateTask()
    {
        Artisan::call('db:seed');
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $task = Task::create([
            'title' => 'task', 'description' => 'test task',
            'date_till_done' => Carbon::now(), 'status_id' => 1, 'priority_id' => 1, 'reporter_id' => $user->id,
            'assignee_id' => $user->id
        ]);
        $token = $user->createToken($user->id)->plainTextToken;
        $data = ['title' => 'edited task', 'description' => 'edit the task',
        'date_till_done' => Carbon::now(), 'status_id' => 1, 'priority_id' => 1, 'reporter_id' => $user->id,
        'assignee_id' => $user->id];

        $this->json('PUT', 'api/tasks/'.$task->id,$data, ['Accept' => 'application/json', 'Authorization' => 'Bearer '. $token .''])
            ->assertStatus(200);
    }

    public function testUpdateTaskAssigneeDoesNotExists()
    {
        Artisan::call('db:seed');
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $task = Task::create([
            'title' => 'task', 'description' => 'test task',
            'date_till_done' => Carbon::now(), 'status_id' => 1, 'priority_id' => 1, 'reporter_id' => $user->id,
            'assignee_id' => $user->id
        ]);
        $token = $user->createToken($user->id)->plainTextToken;
        $data = ['title' => 'edited task', 'description' => 'edit the task',
        'date_till_done' => Carbon::now(), 'status_id' => 1, 'priority_id' => 1, 'reporter_id' => $user->id,
        'assignee_id' => 99];

        $this->json('PUT', 'api/tasks/'.$task->id,$data, ['Accept' => 'application/json', 'Authorization' => 'Bearer '. $token .''])
            ->assertStatus(404);
    }

    public function testUpdateTaskProjectAuthor()
    {
        Artisan::call('db:seed');
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $project = Project::create(['title' => 'NewProject', 'description' => 'Test project', 'author_id' => $user->id]);
        $task = Task::create([
            'title' => 'task', 'description' => 'test task', 'project_id' => $project->id,
            'date_till_done' => Carbon::now(), 'status_id' => 1, 'priority_id' => 1, 'reporter_id' => $user->id,
            'assignee_id' => $user->id
        ]);
        $token = $user->createToken($user->id)->plainTextToken;
        $data = ['title' => 'edited task', 'description' => 'edit the task',
        'date_till_done' => Carbon::now(), 'status_id' => 1, 'priority_id' => 1, 'reporter_id' => $user->id,
        'assignee_id' => $user->id];

        $this->json('PUT', 'api/tasks/'.$task->id,$data, ['Accept' => 'application/json', 'Authorization' => 'Bearer '. $token .''])
            ->assertStatus(200);
    }


    public function testUpdateTaskTeamProject()
    {
        Artisan::call('db:seed');
        $user = User::factory()->create();
        $secondUser = User::factory()->create();
        $this->actingAs($user, 'api');
        $team = Team::create(['name' => 'Team name', 'description' => 'description']);
        $project = Project::create([
            'title' => 'SecondProject', 'description' => 'Test project 2',
            'author_id' => $secondUser->id, 'team_id' => $team->id
        ]);
        $team->users()->attach(
            $user->id,
            [
                'is_admin' => true,
                'name_in_team' => "randomName"
            ]
        );
        $task = Task::create([
            'title' => 'task', 'description' => 'test task', 'project_id' => $project->id,
            'date_till_done' => Carbon::now(), 'status_id' => 1, 'priority_id' => 1, 'reporter_id' => $secondUser->id,
            'assignee_id' => $secondUser->id
        ]);
        $token = $user->createToken($user->id)->plainTextToken;
        $data = ['title' => 'edited task', 'description' => 'edit the task',
        'date_till_done' => Carbon::now(), 'status_id' => 1, 'priority_id' => 1, 'reporter_id' => $user->id,
        'assignee_id' => $user->id];

        $this->json('PUT', 'api/tasks/'.$task->id,$data, ['Accept' => 'application/json', 'Authorization' => 'Bearer '. $token .''])
            ->assertStatus(200);
    }

    public function testUpdateTaskProjectForbbiden()
    {
        Artisan::call('db:seed');
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $secondUser = User::factory()->create();
        $this->actingAs($user, 'api');
        $team = Team::create(['name' => 'Team name', 'description' => 'description']);


        $task = Task::create([
            'title' => 'task', 'description' => 'test task',
            'date_till_done' => Carbon::now(), 'status_id' => 1, 'priority_id' => 1, 'reporter_id' => $secondUser->id,
            'assignee_id' => $secondUser->id
        ]);
        $token = $user->createToken($user->id)->plainTextToken;
        $data = ['title' => 'edited task', 'description' => 'edit the task',
        'date_till_done' => Carbon::now(), 'status_id' => 1, 'priority_id' => 1, 'reporter_id' => $user->id,
        'assignee_id' => $user->id];

        $this->json('PUT', 'api/tasks/'.$task->id,$data, ['Accept' => 'application/json', 'Authorization' => 'Bearer '. $token .''])
            ->assertStatus(403);
    }



    public function testDestoryTaskTeamProject()
    {
        Artisan::call('db:seed');
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $secondUser = User::factory()->create();
        $this->actingAs($user, 'api');
        $team = Team::create(['name' => 'Team name', 'description' => 'description']);
        $project = Project::create([
            'title' => 'SecondProject', 'description' => 'Test project 2',
            'author_id' => $user->id, 'team_id' => $team->id
        ]);
        $team->users()->attach(
            $user->id,
            [
                'is_admin' => false,
                'name_in_team' => "admin"
            ]
        );
        $team->users()->attach(
            $secondUser->id,
            [
                'is_admin' => true,
                'name_in_team' => "member"
            ]
        );
        $task = Task::create([
            'title' => 'task', 'description' => 'test task', 'project_id' => $project->id,
            'date_till_done' => Carbon::now(), 'status_id' => 1, 'priority_id' => 1, 'reporter_id' => $user->id,
            'assignee_id' => $user->id
        ]);
        $token = $user->createToken($user->id)->plainTextToken;
        $data = ['title' => 'edited task', 'description' => 'edit the task',
        'date_till_done' => Carbon::now(), 'status_id' => 1, 'priority_id' => 1, 'reporter_id' => $user->id,
        'assignee_id' => $user->id];

        $this->json('DELETE', 'api/tasks/'.$task->id,$data, ['Accept' => 'application/json', 'Authorization' => 'Bearer '. $token .''])
            ->assertStatus(200);
    }

    public function testDestoryTaskProjectAuthor()
    {
        Artisan::call('db:seed');
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $secondUser = User::factory()->create();
        $this->actingAs($user, 'api');
        $project = Project::create([
            'title' => 'SecondProject', 'description' => 'Test project 2',
            'author_id' => $secondUser->id
        ]);
        $task = Task::create([
            'title' => 'task', 'description' => 'test task', 'project_id' => $project->id,
            'date_till_done' => Carbon::now(), 'status_id' => 1, 'priority_id' => 1, 'reporter_id' => $secondUser->id,
            'assignee_id' => $secondUser->id
        ]);
        $token = $user->createToken($user->id)->plainTextToken;

        $this->json('DELETE', 'api/tasks/'.$task->id, [], ['Accept' => 'application/json', 'Authorization' => 'Bearer '. $token .''])
            ->assertStatus(403);
    }
    
}
