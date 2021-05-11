<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;

class TaskStatusControllerTest extends TestCase
{
    use RefreshDataBase, WithFaker;

    public function testGetTeams()
    {
        Artisan::call('db:seed');
        $user = User::factory()->create();
        $this->actingAs($user, 'api');
        $token = $user->createToken($user->id)->plainTextToken;

        $this->json('GET', 'api/taskStatuses', [],['Accept' => 'application/json', 'Authorization' => 'Bearer '. $token .''])
            ->assertStatus(200);
    }
}
