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
        $createdTasks = Auth::user()->createdTasksByProject();

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

        if ($request->has('project_id') && Project::find($request->input('project_id'))) {
            $project = Project::find($request->input('project_id'))->first();
            if ($project->team != null) {
                $team = $project->team;
            } else if ($project->author_id != null) {
                $author_id = $project->author_id;
            }
        }

        if (
            User::find($request->input('assignee_id'))
            && (User::find($request->input('assignee_id'))->id == Auth::id()
                || isset($team)
                && $team->isTeamMember($request->input('assignee_id')))
        ) {
            if (
                isset($author_id)
                && Auth::id() != $author_id
                || isset($team)
                && !$team->isAdmin(Auth::id())
            ) {
                return response()->json([
                    'error' => 'You do not have the rights to add task to this project!'
                ], 403);
            } else {
                $task = Task::create($request->validated());
                return response()->json([
                    'task' => $task
                ]);
            }
        } else {
            return response()->json([
                'error' => 'Selected assignee does not exist or is not in the selected team!'
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
        $request->validated();

        if (!$task->project->isEmpty()) {
            $project = $task->project;
            if ($project->team != null) {
                $team = $project->team;
            } else if ($project->author_id != null) {
                $author_id = $project->author_id;
            }
        }

        if (
            User::find($request->input('assignee_id'))
            && (User::find($request->input('assignee_id'))->id == Auth::id()
                || isset($team)
                && $team->isTeamMember($request->input('assignee_id')))
        ) {
            if (
                isset($author_id)
                && Auth::id() == $author_id
                || isset($team)
                && $team->isAdmin(Auth::id())
                || $task->reporter_id == Auth::user()->id
            ) {
                $task->update($request->validated());

                return response()->json([
                    'task' => $task,
                    'message' => 'Task updated successfully!'
                ]);
            } else {
                return response()->json([
                    'error' => 'You do not have the rights to add task to this project!'
                ], 403);
            }
        } else {
            return response()->json([
                'error' => 'Selected assignee or reporter does not exist!'
            ], 404);
        }
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
            $task->reporter_id != Auth::user()->id
            || !$task->project
            && ($task->project->author_id  != Auth::user()->id
                || $task->project->team)
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
