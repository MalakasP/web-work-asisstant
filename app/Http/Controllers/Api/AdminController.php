<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTeamUserRequest;
use App\Http\Requests\UpdateTeamUserRequest;
use App\Http\Requests\GetWorktimesRequest;
use App\Models\Team;
use App\Models\User;
use App\Models\Project;
use App\Models\TaskStatus;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Add new user to the team.
     *
     * @param \App\Models\Team $team
     * @param \App\Http\Requests\CreateTeamUserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(Team $team, CreateTeamUserRequest $request)
    {
        if (!$team->isUserAdmin(Auth::id())) {
            return response()->json([
                'message' => 'You are not the admin of this team!'
            ], 403);
        } else if ($team->users()->where('email', $request->validated()['email'])->exists()) {
            return response()->json([
                'message' => 'User is already added to the team!'
            ], 409);
        }

        $user = User::where('email', $request->validated()['email'])->firstOrFail();

        $team->users()->attach(
            $user->id,
            [
                'is_admin' => $request->validated()['is_admin'],
                'name_in_team' => $request->validated()['name_in_team']
            ]
        );

        return response()->json([
            'user' => $user,
            'message' => 'User added to the team!'
        ]);
    }


    /**
     * Remove the user from the team.
     *
     * @param \App\Models\Team $team
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Team $team, User $user)
    {
        if (!$team->isUserAdmin(Auth::id())) {
            return response()->json([
                'message' => 'You are not the admin of this team!'
            ], 403);
        }

        $team->users()->detach($user->id);

        return response()->json([
            'message' => 'User removed from the team!'
        ]);
    }

    /**
     * Update team user info.
     * 
     * @param \App\Models\Team $team
     * @param \App\Models\User $user
     * @param \App\Http\Requests\UpdateTeamUserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(Team $team, User $user, UpdateTeamUserRequest $request)
    {
        $request->validated();

        if (!$team->isUserAdmin(Auth::id())) {
            return response()->json([
                'message' => 'You are not the admin of this team!'
            ], 403);
        }

        $user->teams()->updateExistingPivot($team->id, [
            'is_admin' => $request->validated()['is_admin'],
            'name_in_team' => $request->validated()['name_in_team']
        ]);

        return response()->json([
            'message' => 'User information updated!'
        ]);
    }

    /**
     * Get team users worktimes
     * 
     * @param \App\Models\Team $team
     * @param \App\Http\Requests\GetWorktimesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function getTeamUsersWorktimes(Team $team, GetWorktimesRequest $request)
    {
        $request->validated();

        // if (!$team->isUserAdmin(Auth::id())) {
        //     return response()->json([
        //         'message' => 'You are not the admin of this team!'
        //     ], 403);
        // }

        if ($request->has('from') && $request->has('to')) {
            $from = date('Y-m-d', strtotime($request->from));
            $to = date('Y-m-d', strtotime($request->to));
            $users = $team->users;
            foreach ($users as $user) {
                $worktimes[$user->id] = $user->worktimes()->whereBetween('created_at', [$from, $to])->get()->groupBy(function ($worktime) {
                    return Carbon::parse($worktime->created_at)->format('Y-m-d');
                });
            }
        } else {
            return response()->json([
                'message' => 'No date range given.'
            ], 422);
        }

        if (empty($worktimes)) {
            return response()->json([
                'message' => 'You do not have saved worktimes.'
            ], 404);
        }

        return response()->json([
            'usersWorktimes' => $worktimes
        ]);
    }

    /**
     * Gets tasks grouped by status
     * 
     * @param \App\Models\Project $project
     * @return \Illuminate\Http\Response
     */
    public function getProjectTaskByStatus(Project $project)
    {
        if ($project->team != null) {
            $isAdmin = $project->team->isUserAdmin(Auth::id());
            $isAuthor = false;
        } else if ($project->author_id != null) {
            $isAuthor = $project->author_id == Auth::id();
            $isAdmin = false;
        } else {
            $isAdmin = false;
            $isAuthor = false;
        }

        if (!$isAdmin && !$isAuthor) {
            return response()->json([
                'message' => 'You do not have rights to do this!',
            ], 403);
        }

        $empty = true;

        $statuses = TaskStatus::get();

        foreach ($statuses as $status) {
            $tasks[$status->name] = $project->tasks()->where('status_id', $status->id)->get();
            if (!$tasks[$status->name]->isEmpty()) {
                $empty = false;
            }
        }

        if ($empty) {
            return response()->json([
                'message' => 'You do not have tasks in project'
            ], 404);
        }

        return response()->json([
            'tasks' => $tasks
        ]);
    }
}
