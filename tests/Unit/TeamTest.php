<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Team;


class TeamTest extends TestCase
{
    use RefreshDataBase, WithFaker;

    public function test_teams_database_has_expected_columns()
    {
        $this->assertTrue(
            Schema::hasColumns('teams', [
                'id', 'name', 'description', 'created_at', 'updated_at'
            ]),
            1
        );
    }

    public function test_team_isUserAdmin_return_true()
    {
        $user = User::factory()->create();
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
        
        $this->assertEquals(1, $team->isUserAdmin($user->id));
    }

    public function test_team_isUserAdmin_return_false()
    {
        $user = User::factory()->create();
        $team = Team::create([
            'name' => 'Team name',
            'description' => 'description'
        ]);

        $this->assertFalse($team->isUserAdmin($user->id));
    }

    public function test_team_isTeamMember_return_true()
    {
        $user = User::factory()->create();
        $team = Team::create([
            'name' => 'Team name',
            'description' => 'description'
        ]);
        $team->users()->attach(
            $user->id,
            [
                'is_admin' => true,
                'name_in_team' => "admin"
            ]
        );


        $this->assertTrue($team->isTeamMember($user->id));
    }

    public function test_team_isTeamMember_return_false()
    {
        $user = User::factory()->create();
        $team = Team::create([
            'name' => 'Team name',
            'description' => 'description'
        ]);

        $this->assertFalse($team->isTeamMember($user->id));
    }
}
