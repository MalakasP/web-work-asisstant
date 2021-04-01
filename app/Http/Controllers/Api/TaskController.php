<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use App\Models\Project;
use App\Models\User;

class TaskController extends Controller
{
    /**
     * Get assigned tasks. 
     *
     * @return \Illuminate\Http\Response
     */
    public function getAssignedTasks()
    {
        $assignedTasks = Auth::user()->assignedTasksByProject();

        if ($assignedTasks->isEmpty()) {
            return response()->json([
                'error' => 'No tasks found!'
            ], 404);
        }

        return response()->json([
            'assignedTasks'    => $assignedTasks
        ]);
    }

    /**
     * Get created tasks.
     */
    public function getCreatedTasks()
    {
        $createdTasks = Auth::user()->createdTasks()->paginate(7);

        if ($createdTasks->isEmpty()) {
            return response()->json([
                'error' => 'No tasks found!'
            ], 404);
        }

        return response()->json([
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
        $request->validated();
        //check if project id is set and if the user does have right to create task in project

        if ($request->has('project_id')) {
            if (
                Project::find($request->input('project_id'))
                && Project::find($request->input('project_id'))->first()->team != null
            ) {
                $team = Project::find($request->input('project_id'))->first()->team;
            } 
        }
        
        if (
            User::find($request->validated()['assignee_id'])->id == Auth::id() ||
            User::find($request->validated()['assignee_id'])
            && isset($team)
            && $team->isTeamMember($request->validated()['assignee_id'])
        ) {
            $task = Task::create($request->validated());
            return response()->json([
                'task' => $task
            ]);
        } else {
            return response()->json([
                'error' => 'Selected assignee does not exist or is not in the project team!'
            ], 404);
        }
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
        if (
            $task->reporter_id != Auth::user()->id ||
            !$task->project->isEmpty() && $task->project->author_id  != Auth::user()->id
        ) {
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
        if (
            $task->reporter_id != Auth::user()->id ||
            !$task->project->isEmpty() && $task->project->author_id  != Auth::user()->id
        ) {
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
