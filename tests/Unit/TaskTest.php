<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use App\Models\User;
use App\Models\Task;
use App\Models\Project;
use Carbon\Carbon;

class TaskTest extends TestCase
{
    use RefreshDataBase, WithFaker;

    public function test_tasks_database_has_expected_columns()
    {
        $this->assertTrue(
            Schema::hasColumns('tasks', [
                'id', 'title', 'description', 'date_till_done',
                'status_id', 'priority_id', 'project_id', 'reporter_id',
                'assignee_id', 'created_at', 'updated_at'
            ]),
            1
        );
    }

    public function test_task_project_relationship()
    {
        Artisan::call('db:seed');
        $user = User::factory()->create();
        $project = Project::create(['title' => 'NewProject', 'description' => 'Test project', 'author_id' => $user->id]);
        $task = Task::create([
            'title' => 'task', 'description' => 'test task', 'project_id' => $project->id,
            'date_till_done' => Carbon::now(), 'status_id' => 1, 'priority_id' => 1, 'reporter_id' => $user->id,

            'assignee_id' => $user->id
        ]);

        $this->assertInstanceOf(Project::class, $task->project);
        $this->assertEquals(1, $task->project->count());
    }
}
