<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\TaskPriority;
use Illuminate\Support\Facades\Schema;

class TaskPriorityTest extends TestCase
{

    public function test_task_priorities_database_has_expected_columns()
    {
        $this->assertTrue(
            Schema::hasColumns('task_priorities', [
                'id', 'name', 'created_at', 'updated_at'
            ]),
            1
        );
    }

    public function test_example()
    {
        $taskPriority = new TaskPriority;

        $this->assertInstanceOf(TaskPriority::class, $taskPriority);
    }
}
