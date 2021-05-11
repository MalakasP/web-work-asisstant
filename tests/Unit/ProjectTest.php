<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;
use App\Models\Project;
use App\Models\Team;
use App\Models\User;

class ProjectTest extends TestCase
{

    use RefreshDataBase, WithFaker;

    public function test_projects_database_has_expected_columns()
    {
        $this->assertTrue(
            Schema::hasColumns('projects', [
                'id', 'title', 'description', 'author_id',
                'team_id', 'created_at', 'updated_at'
            ]),
            1
        );
    }

    public function test_project_team_relationship()
    {
        $user = User::factory()->create();
        $team = Team::create([
            'name' => 'Team name',
            'description' => 'description'
        ]);
        $project = Project::create(['title' => 'NewProject', 'description' => 'Test project', 'author_id' => $user->id, 'team_id' => $team->id]);

        $this->assertInstanceOf(Team::class, $project->team);
        $this->assertEquals(1, $project->team->count());
    }
}
