<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;

use function PHPUnit\Framework\isEmpty;

class TaskController extends Controller
{
    /**
     * Get created and assigned tasks. 
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $assignedTasks = Auth::user()->assignedTasks;

        $createdTasks = Auth::user()->createdTasks;

        if ($assignedTasks->isEmpty() && $createdTasks->isEmpty()) {
            return response()->json([
                'error' => 'No tasks found!'
            ], 404);
        }

        return response()->json([
            'assignedTasks'    => $assignedTasks,
            'createdTasks'    => $createdTasks
        ]);
    }

    /**
     * Store a newly created task in storage.
     *
     * @param  \App\Http\Request\CreateTaskRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateTaskRequest $request)
    {
        //check if project id is set and if the user does have right to create task in project
        // if (!$request->input('project_id')) {
        //     Project::find($request->input('project_id'))->team()->
        // }
        $task = Task::create($request->validated());

        return response()->json([
            'task' => $task
        ]);
    }

    /**
     * Display the specified task.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        return response()->json([
            'task' => $task
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Request\UpdateTaskRequest  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        // move to middleware 
        if ($task->reporter_id != Auth::user()->id ||
            !$task->project->isEmpty() && $task->project->author_id  != Auth::user()->id) {
            return response()->json([
                'error' => 'You do not have rights to do this!'
            ], 403);
        }

        $task->update($request->validated());

        return response()->json([
            'task' => $task,
            'message' => 'Task updated successfully!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        // move to middleware 
        if ($task->reporter_id != Auth::user()->id ||
            !$task->project->isEmpty() && $task->project->author_id  != Auth::user()->id) {
            return response()->json([
                'error' => 'You do not have rights to do this!'
            ], 403);
        }

        $task->delete();

        return response()->json([
            'task' => $task,
            'message' => 'Task deleted successfully!'
        ]);
    }
}
