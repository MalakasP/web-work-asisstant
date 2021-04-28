<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TaskStatus;

class TaskStatusController extends Controller
{
    public function index() {
        $taskStatuses = TaskStatus::get();

        return response()->json([
            'taskStatuses' => $taskStatuses
        ]);
    }
}
