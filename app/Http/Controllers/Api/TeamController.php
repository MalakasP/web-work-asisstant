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
                'error' => 'No teams found!'
            ], 404);
        }
        
        return response()->json([
            'teams' => $teams
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
        return response()->json([
            'team' => $team
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

        $team->users()->attach(Auth::user()->id, ['role_in_team' => 'admin' , 'name_in_team' => 'admin']);

        return response()->json([
            'team' => $team,
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
        if (!$team->isUserAdmin(Auth::user()->id)) {
            return response()->json([
                'error' => 'You do not have rights to do this!'
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
        if (!$team->isUserAdmin(Auth::user()->id)) {
            return response()->json([
                'error' => 'You do not have rights to do this!'
            ], 403);
        }

        $team->delete();

        return response()->json([
            'task' => $team,
            'message' => 'Team deleted successfully!'
        ]);
    }
}
