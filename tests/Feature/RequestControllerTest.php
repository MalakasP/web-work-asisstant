<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Team;
use App\Models\Request;
use Carbon\Carbon;

class RequestControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testgetCreatedRequests()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $token = $user->createToken($user->id)->plainTextToken;
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

        $this->json('GET', 'api/createdRequests', [], ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . $token . ''])
            ->assertStatus(200);
    }

    public function testGetNotAnsweredRequests()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $token = $user->createToken($user->id)->plainTextToken;
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

        $this->json('GET', 'api/getNotAnsweredRequests', [], ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . $token . ''])
            ->assertStatus(200);
    }


    public function testgetCreatedRequestsNotFound()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $token = $user->createToken($user->id)->plainTextToken;

        $this->json('GET', 'api/createdRequests', [], ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . $token . ''])
            ->assertStatus(404);
    }

    public function testGetNotAnsweredRequestsNotFound()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $token = $user->createToken($user->id)->plainTextToken;

        $this->json('GET', 'api/getNotAnsweredRequests', [], ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . $token . ''])
            ->assertStatus(404);
    }

    public function testGetAnsweredRequests()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $token = $user->createToken($user->id)->plainTextToken;
        $team = Team::create(['name' => 'Team name', 'description' => 'description']);
        $request = Request::create([
            'date_from' => Carbon::now(),
            'date_to' => Carbon::now(),
            'description' => 'Random data',
            'type' => 'test type',
            'confirmed_at' => Carbon::now(),
            'requester_id' => $user->id,
            'responser_id' => $user->id,
            'team_id' => $team->id
        ]);

        $this->json('GET', 'api/getAnsweredRequests', [], ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . $token . ''])
            ->assertStatus(200);
    }

    public function testGetAnsweredRequestsNotFound()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $token = $user->createToken($user->id)->plainTextToken;

        $this->json('GET', 'api/getAnsweredRequests', [], ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . $token . ''])
            ->assertStatus(404);
    }

    public function testStoreRequest()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $token = $user->createToken($user->id)->plainTextToken;
        $team = Team::create(['name' => 'Team name', 'description' => 'description']);
        $data = [
            'date_from' => '2021-05-10 08:00:00',
            'date_to' => '2021-05-11 18:00:00',
            'description' => 'Random data',
            'type' => 'test type',
            'requester_id' => $user->id,
            'responser_id' => $user->id,
            'team_id' => $team->id
        ];

        $this->json('POST', 'api/requests', $data, ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . $token . ''])
            ->assertStatus(200);
    }

    public function testStoreRequestForbbiden()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $token = $user->createToken($user->id)->plainTextToken;
        $team = Team::create(['name' => 'Team name', 'description' => 'description']);
        $data = [
            'date_from' => '2021-05-10 18:00:00',
            'date_to' => '2021-05-11 18:00:00',
            'description' => 'Random data',
            'type' => 'test type',
            'requester_id' => $user->id,
            'responser_id' => 6,
            'team_id' => $team->id
        ];

        $this->json('POST', 'api/requests', $data, ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . $token . ''])
            ->assertStatus(403);
    }

    public function testUpdateRequest()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $token = $user->createToken($user->id)->plainTextToken;
        $team = Team::create(['name' => 'Team name', 'description' => 'description']);
        $request = Request::create([
            'date_from' => '2021-05-10 08:00:00',
            'date_to' => '2021-05-11 18:00:00',
            'description' => 'Random data',
            'type' => 'test type',
            'requester_id' => $user->id,
            'responser_id' => $user->id,
            'team_id' => $team->id
        ]);
        $data = [
            'date_from' => '2021-05-12 08:00:00',
            'date_to' => '2021-05-13 18:00:00',
            'description' => 'Random data',
            'type' => 'test type',
            'requester_id' => $user->id,
            'responser_id' => $user->id,
            'team_id' => $team->id
        ];

        $this->json('PUT', 'api/requests/'. $request->id, $data, ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . $token . ''])
            ->assertStatus(200);
    }

    public function testUpdateRequestForbbiden()
    {
        $user = User::factory()->create();
        $secondUser = User::factory()->create();
        $this->actingAs($user, 'api');
        $token = $user->createToken($user->id)->plainTextToken;
        $team = Team::create(['name' => 'Team name', 'description' => 'description']);
        $request = Request::create([
            'date_from' => '2021-05-10 08:00:00',
            'date_to' => '2021-05-11 18:00:00',
            'description' => 'Random data',
            'type' => 'test type',
            'requester_id' => $secondUser->id,
            'responser_id' => $secondUser->id,
            'team_id' => $team->id
        ]);
        $data = [
            'date_from' => '2021-05-12 08:00:00',
            'date_to' => '2021-05-13 18:00:00',
            'description' => 'Random data',
            'type' => 'test type',
            'requester_id' => $user->id,
            'responser_id' => $user->id,
            'team_id' => $team->id
        ];

        $this->json('PUT', 'api/requests/'. $request->id, $data, ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . $token . ''])
            ->assertStatus(403);
    }

    public function testDestroyRequest()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $token = $user->createToken($user->id)->plainTextToken;
        $team = Team::create(['name' => 'Team name', 'description' => 'description']);
        $request = Request::create([
            'date_from' => '2021-05-10 08:00:00',
            'date_to' => '2021-05-11 18:00:00',
            'description' => 'Random data',
            'type' => 'test type',
            'requester_id' => $user->id,
            'responser_id' => $user->id,
            'team_id' => $team->id
        ]);

        $this->json('DELETE', 'api/requests/'. $request->id,[], ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . $token . ''])
            ->assertStatus(200);
    }

    public function testDestroyForbbiden()
    {
        $user = User::factory()->create();
        $secondUser = User::factory()->create();
        $this->actingAs($user, 'api');
        $token = $user->createToken($user->id)->plainTextToken;
        $team = Team::create(['name' => 'Team name', 'description' => 'description']);
        $request = Request::create([
            'date_from' => '2021-05-10 08:00:00',
            'date_to' => '2021-05-11 18:00:00',
            'description' => 'Random data',
            'type' => 'test type',
            'requester_id' => $secondUser->id,
            'responser_id' => $secondUser->id,
            'team_id' => $team->id
        ]);

        $this->json('DELETE', 'api/requests/'. $request->id, [], ['Accept' => 'application/json', 'Authorization' => 'Bearer ' . $token . ''])
            ->assertStatus(403);
    }
}
