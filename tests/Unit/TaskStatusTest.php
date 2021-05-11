<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\TaskStatus;
use Illuminate\Support\Facades\Schema;

class TaskStatusTest extends TestCase
{

    public function test_task_statuses_database_has_expected_columns()
    {
        $this->assertTrue(
            Schema::hasColumns('task_statuses', [
                'id', 'name', 'created_at', 'updated_at'
            ]),
            1
        );
    }

    public function test_example()
    {
        $taskStatus = new TaskStatus;

        $this->assertInstanceOf(TaskStatus::class, $taskStatus);
    }
}
