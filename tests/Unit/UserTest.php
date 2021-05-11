<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Project;
use App\Models\Task;
use App\Models\Team;
use App\Models\Worktime;
use App\Models\Request;
use Carbon\Carbon;

class UserTest extends TestCase
{

    use RefreshDataBase, WithFaker;


    public function test_users_database_has_expected_columns()
    {
        $this->assertTrue(
            Schema::hasColumns('users', [
                'id', 'name', 'email', 'password',
            ]),
            1
        );
    }

    public function test_user_created_projects_relationship()
    {
        $user = User::factory()->create();
        $project = Project::create(['title' => 'NewProject', 'description' => 'Test project', 'author_id' => $user->id]);
        $projects = $user->createdProjects;

        $this->assertTrue($projects->contains($project));
        $this->assertEquals(1, $projects->count());
    }

    public function test_user_created_tasks_relationship()
    {
        Artisan::call('db:seed');
        $user = User::factory()->create(['name' => 'John Marly']);
        $task = Task::create([
            'title' => 'task', 'description' => 'test task',
            'date_till_done' => Carbon::now(), 'status_id' => 1, 'priority_id' => 1, 'reporter_id' => $user->id,
            'assignee_id' => $user->id
        ]);
        $tasks = $user->createdTasks;

        $this->assertTrue($tasks->contains($task));
        $this->assertEquals(1, $tasks->count());
    }

    public function test_user_onlyTeamsId_relationship()
    {
        $user = User::factory()->create(['name' => 'John Marly']);
        $team = Team::create([
            'name' => 'Team name',
            'description' => 'description'
        ]);
        $team->users()->attach(
            $user->id,
            [
                'is_admin' => true,
                'name_in_team' => "randomName"
            ]
        );
        $teamsId = $user->onlyTeamsId->pluck('team_id')->toArray();

        $this->assertTrue(in_array($team->id, $teamsId));
        $this->assertEquals(1, count($teamsId));
    }

    public function test_user_worktimes_relationship()
    {
        $user = User::factory()->create();
        $worktime = Worktime::create([
            'user_id' => $user->id
        ]);

        $worktimes = $user->worktimes;

        $this->assertTrue($worktimes->contains($worktime));
        $this->assertEquals(1, $worktimes->count());
    }

    public function test_user_assignedTasks_relationship()
    {
        Artisan::call('db:seed');
        $user = User::factory()->create();
        $task = Task::create([
            'title' => 'task', 'description' => 'test task',
            'date_till_done' => Carbon::now(), 'status_id' => 1, 'priority_id' => 1, 'reporter_id' => $user->id,
            'assignee_id' => $user->id
        ]);
        $tasks = $user->assignedTasks;

        $this->assertTrue($tasks->contains($task));
        $this->assertEquals(1, $tasks->count());
    }

    public function test_user_projects_relationship()
    {
        $user = User::factory()->create();
        $secondUser = User::factory()->create();
        $team = Team::create(['name' => 'Team name', 'description' => 'description']);
        $team->users()->attach(
            $user->id,
            [
                'is_admin' => true,
                'name_in_team' => "randomName"
            ]
        );

        $projectOne = Project::create([
            'title' => 'FirstProject', 'description' => 'Test project 1',
            'author_id' => $user->id
        ]);
        $projectTwo = Project::create([
            'title' => 'SecondProject', 'description' => 'Test project 2',
            'author_id' => $secondUser->id, 'team_id' => $team->id
        ]);

        $projects = $user->projects();

        $this->assertTrue($projects->contains($projectOne));
        $this->assertTrue($projects->contains($projectTwo));
        $this->assertEquals(2, $projects->count());
    }

    public function test_user_createdRequests_relationship()
    {
        $user = User::factory()->create();
        $team = Team::create(['name' => 'Team name', 'description' => 'description']);
        $request = Request::create([
            'date_from' => Carbon::now(),
            'date_to' => Carbon::now(),
            'description' => 'Random data',
            'type' => 'test type',
            'requester_id' => $user->id,
            'responser_id' => $user->id,
            'team_id' => $team->id
        ]);
        $requests = $user->createdRequests;

        $this->assertTrue($requests->contains($request));
        $this->assertEquals(1, $requests->count());
    }

    public function test_user_gottenRequests_relationship()
    {
        $user = User::factory()->create();
        $team = Team::create(['name' => 'Team name', 'description' => 'description']);
        $request = Request::create([
            'date_from' => Carbon::now(),
            'date_to' => Carbon::now(),
            'description' => 'Random data',
            'type' => 'test type',
            'requester_id' => $user->id,
            'responser_id' => $user->id,
            'team_id' => $team->id
        ]);
        $requests = $user->gottenRequests;

        $this->assertTrue($requests->contains($request));
        $this->assertEquals(1, $requests->count());
    }

    public function test_user_teamsUsers_relationship()
    {
        $user = User::factory()->create();
        $secondUser = User::factory()->create();
        $thirdUser = User::factory()->create();
        $team = Team::create(['name' => 'Team name', 'description' => 'description']);
        $secondTeam = Team::create(['name' => 'Second team', 'description' => 'description']);

        $team->users()->attach(
            $user->id,
            [
                'is_admin' => true,
                'name_in_team' => "randomName"
            ]
        );

        $team->users()->attach(
            $thirdUser->id,
            [
                'is_admin' => true,
                'name_in_team' => "randomName"
            ]
        );

        $secondTeam->users()->attach(
            $user->id,
            [
                'is_admin' => true,
                'name_in_team' => "randomName"
            ]
        );

        $secondTeam->users()->attach(
            $secondUser->id,
            [
                'is_admin' => true,
                'name_in_team' => "randomName"
            ]
        );
        $count = $user->teamsUsers()->count();
        $allUsers = $user->teamsUsers()->pluck('id')->toArray();

        $this->assertTrue(in_array($user->id, $allUsers));
        $this->assertTrue(in_array($secondUser->id, $allUsers));
        $this->assertTrue(in_array($thirdUser->id, $allUsers));
        $this->assertEquals(4, $count);
    }

    public function test_user_usersInTeam_return_true()
    {
        $user = User::factory()->create();
        $secondUser = User::factory()->create();
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
                'is_admin' => true,
                'name_in_team' => "randomName"
            ]
        );

        $this->assertTrue($user->usersInTeam($secondUser->id));
    }

    public function test_user_usersInTeam_return_false()
    {
        $user = User::factory()->create();
        $secondUser = User::factory()->create();

        $this->assertFalse($user->usersInTeam($secondUser->id));
    }

    public function test_user_assignedTasksByProject_relationship()
    {
        Artisan::call('db:seed');
        $user = User::factory()->create();
        $team = Team::create(['name' => 'Team name', 'description' => 'description']);
        $task = Task::create([
            'title' => 'task', 'description' => 'test task',
            'date_till_done' => Carbon::now(), 'status_id' => 1, 'priority_id' => 1, 'reporter_id' => $user->id,
            'assignee_id' => $user->id
        ]);
        $project = Project::create(['title' => 'NewProject', 'description' => 'Test project', 'author_id' => $user->id, 'team_id' => $team->id]);
        $projectTask = Task::create([
            'title' => 'task', 'description' => 'test task',
            'date_till_done' => Carbon::now(), 'status_id' => 3, 'priority_id' => 3, 'reporter_id' => $user->id,
            'assignee_id' => $user->id, 'project_id' => $project->id
        ]);

        $team->users()->attach(
            $user->id,
            [
                'is_admin' => true,
                'name_in_team' => "randomName"
            ]
        );

        $tasks = $user->assignedTasksByProject();

        $this->assertTrue(in_array($task->id,$tasks[0]->pluck('id')->toArray()));
        $this->assertTrue(in_array($projectTask->id, $tasks[1]->tasks->pluck('id')->toArray()));
        $this->assertEquals(2,$tasks->count());
    }

    public function test_user_createdTasksByProject_relationship()
    {
        Artisan::call('db:seed');
        $user = User::factory()->create();
        $team = Team::create(['name' => 'Team name', 'description' => 'description']);
        $task = Task::create([
            'title' => 'task', 'description' => 'test task',
            'date_till_done' => Carbon::now(), 'status_id' => 1, 'priority_id' => 1, 'reporter_id' => $user->id,
            'assignee_id' => $user->id
        ]);
        $project = Project::create(['title' => 'NewProject', 'description' => 'Test project', 'author_id' => $user->id, 'team_id' => $team->id]);
        $projectTask = Task::create([
            'title' => 'task', 'description' => 'test task',
            'date_till_done' => Carbon::now(), 'status_id' => 3, 'priority_id' => 3, 'reporter_id' => $user->id,
            'assignee_id' => $user->id, 'project_id' => $project->id
        ]);

        $team->users()->attach(
            $user->id,
            [
                'is_admin' => true,
                'name_in_team' => "randomName"
            ]
        );

        $tasks = $user->createdTasksByProject();

        $this->assertTrue(in_array($task->id,$tasks[0]->pluck('id')->toArray()));
        $this->assertTrue(in_array($projectTask->id, $tasks[1]->tasks->pluck('id')->toArray()));
        $this->assertEquals(2,$tasks->count());
    }
}
