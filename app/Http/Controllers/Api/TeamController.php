<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTeamRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Team;

class TeamController extends Controller
{
    /**
     * Get teams that user belongs to.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teams = Auth::user()->teams;

        if ($teams->isEmpty()) {
            return response()->json([
                'message' => 'No teams found!'
            ], 404);
        }

        return response()->json([
            'teams' => $teams->load('users')
        ]);
    }

    /**
     * Display the specified team.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function show(Team $team)
    {
        if (!$team->users()->where('user_id', Auth::id())->exists()) {
            return response()->json([
                'message' => 'You do not have permission!'
            ], 403);
        }

        return response()->json([
            'team' => $team->load('users')
        ]);
    }

    /**
     * Store a newly created team in storage.
     *
     * @param  \App\Http\Request\CreateTeamRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateTeamRequest $request)
    {
        $team = Team::create($request->validated());

        $team->users()->attach(Auth::id(), ['is_admin' => 1, 'name_in_team' => 'admin']);

        return response()->json([
            'team' => $team->load('users'),
            'message' => 'Team created successfully!'
        ]);
    }

    /**
     * Update the specified team in storage.
     *
     * @param  \App\Http\Requests\CreateTeamRequest  $request
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function update(CreateTeamRequest $request, Team $team)
    {
        if (!$team->isUserAdmin(Auth::id())) {
            return response()->json([
                'message' => 'You do not have rights to do this!'
            ], 403);
        }

        $team->update($request->validated());

        return response()->json([
            'team' => $team,
            'message' => 'Team updated successfully!'
        ]);
    }

    /**
     * Remove the specified team from storage.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function destroy(Team $team)
    {
        if (!$team->isUserAdmin(Auth::id())) {
            return response()->json([
                'message' => 'You do not have rights to do this!'
            ], 403);
        }

        $team->users()->detach();

        $team->delete();

        return response()->json([
            'team' => $team,
            'message' => 'Team deleted successfully!'
        ]);
    }
}
