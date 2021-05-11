<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Team;
use App\Models\Request;
use Carbon\Carbon;

class RequestTest extends TestCase
{
    use RefreshDataBase, WithFaker;

    public function test_requests_database_has_expected_columns()
    {
        $this->assertTrue(
            Schema::hasColumns('requests', [
                'id', 'date_from', 'date_to', 'description',
                'type', 'is_confirmed', 'confirmed_at', 'requester_id', 'responser_id',
                'team_id', 'created_at', 'updated_at'
            ]),
            1
        );
    }

    public function test_request_user_relationship()
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

        $this->assertInstanceOf(User::class, $request->user);
        $this->assertEquals(1, $request->user->count());
    }
}
