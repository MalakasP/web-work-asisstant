<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTeamUserRequest;
use App\Http\Requests\UpdateTeamUserRequest;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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

        $user = User::where('email', $request->validated()['email'])->first();
        
        $team->users()->attach($user->id,
            ['is_admin' => $request->validated()['is_admin'],
            'name_in_team' => $request->validated()['name_in_team']]);

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
    public function update(Team $team, User $user, UpdateTeamUserRequest $request) {

    }

    /**
     * Get team user worktimes
     */
    public function getUserWorktimes(User $user)
    {

    }

    /**
     * Gets users of the team
     */
    public function getTeamUsers(Team $team)
    {

    }

    // /**
    //  * 
    //  * @param \Illuminate\Http\Request $request
    //  */
    // public function getTeamUsers(Request $request) 
    // {
    //     Team::find()
    // }
}
