<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TaskPriority;

class TaskPriorityController extends Controller
{
    public function index() {
        $taskPriorities = TaskPriority::get();

        return response()->json([
            'taskPriorities' => $taskPriorities
        ]);
    }
}
