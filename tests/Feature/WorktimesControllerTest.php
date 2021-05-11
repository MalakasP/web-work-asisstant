<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Worktime;
use App\Models\Team;
use Carbon\Carbon;


class WorktimesControllerTest extends TestCase
{

    use RefreshDatabase, WithFaker;
    
    public function testGetWorktimesWithDate()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $worktime = Worktime::create([
            'user_id' => $user->id
        ]);
        $token = $user->createToken($user->id)->plainTextToken;
        $data = [
            'date' => Carbon::now()
        ];

        $this->json('GET', 'api/worktimes',$data, ['Accept' => 'application/json', 'Authorization' => 'Bearer '. $token .''])
            ->assertStatus(200);
    }

    public function testGetWorktimesWithDateRange()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $worktime = Worktime::create([
            'user_id' => $user->id
        ]);
        $token = $user->createToken($user->id)->plainTextToken;
        $data = [
            'from' => Carbon::now()->subDays(1),
            'to' => Carbon::now()->addDays(1)
        ];
        $worktime = Worktime::create([
            'user_id' => $user->id
        ]);
        $this->json('GET', 'api/worktimes',$data, ['Accept' => 'application/json', 'Authorization' => 'Bearer '. $token .''])
            ->assertStatus(200);
    }

    public function testGetWorktimes()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $worktime = Worktime::create([
            'user_id' => $user->id
        ]);
        $token = $user->createToken($user->id)->plainTextToken;

        $this->json('GET', 'api/worktimes',[], ['Accept' => 'application/json', 'Authorization' => 'Bearer '. $token .''])
            ->assertStatus(200);
    }

    public function testGetWorktimesNotFound()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $token = $user->createToken($user->id)->plainTextToken;

        $this->json('GET', 'api/worktimes',[], ['Accept' => 'application/json', 'Authorization' => 'Bearer '. $token .''])
            ->assertStatus(404);
    }

    public function testPostWorktime()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $token = $user->createToken($user->id)->plainTextToken;
        $data = [
            'user_id' => $user->id,
        ];
        $this->json('POST', 'api/worktimes',$data, ['Accept' => 'application/json', 'Authorization' => 'Bearer '. $token .''])
            ->assertStatus(200);
    }

    public function testPostWorktimeUserNotFound()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $token = $user->createToken($user->id)->plainTextToken;
        $data = [
            'user_id' => 99,
        ];
        $this->json('POST', 'api/worktimes',$data, ['Accept' => 'application/json', 'Authorization' => 'Bearer '. $token .''])
            ->assertStatus(404);
    }

    public function testUpdateWorktime()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $token = $user->createToken($user->id)->plainTextToken;
        $worktime = Worktime::create([
            'user_id' => $user->id
        ]);
        $data = [
            'user_id' => $user->id,
            'end_time' => Carbon::now()
        ];
        $this->json('PUT', 'api/worktimes/'. $worktime->id,$data, ['Accept' => 'application/json', 'Authorization' => 'Bearer '. $token .''])
            ->assertStatus(200);
    }

    public function testUpdateWorktimeTeam()
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
        $worktime = Worktime::create([
            'user_id' => $user->id
        ]);
        $data = [
            'user_id' => $user->id,
            'end_time' => Carbon::now(),
            'team_id' => $team->id
        ];
        $this->json('PUT', 'api/worktimes/'. $worktime->id,$data, ['Accept' => 'application/json', 'Authorization' => 'Bearer '. $token .''])
            ->assertStatus(200);
    }

 
}
