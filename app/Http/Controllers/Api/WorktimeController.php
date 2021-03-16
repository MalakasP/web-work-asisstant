<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateWorktimeRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Worktime;
use App\Models\Team;
use Illuminate\Http\Request;

class WorktimeController extends Controller
{
    /**
     * Display a listing of the worktimes.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $worktimes = Auth::user()->worktimes;

        if ($worktimes->isEmpty()) {
            return response()->json([
                'error' => 'You do not have saved worktimes.'
            ], 404);
        }

        return response()->json([
            'worktimes' => $worktimes
        ]);
    }


    /**
     * Store a newly created worktime in storage.
     *
     * @param  \App\Http\Requests\CreateWorktimeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateWorktimeRequest $request)
    {
        $request->validated();

        if (Auth::id() != $request->validated()['user_id']) {
            return response()->json([
                'error' => 'You do not have rights to do this!'
            ], 403);
        } else if ($request->validated()['team_id'] != null) {
            $team = Team::find($request->validated()['team_id'])->get();
            if (!$team->isUserAdmin(Auth::id())) {
                return response()->json([
                    'error' => 'You do not have rights to do this!'
                ], 403);
            }
        }

        $worktime = Worktime::create($request->validated());

        return response()->json([
            'worktime' => $worktime,
            'message' => 'Worktime created successfully!'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Worktime $worktime
     * @return \Illuminate\Http\Response
     */
    public function show(Worktime $worktime)
    {
        return response()->json([
            'request' => $worktime
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Worktime  $worktime
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Worktime $worktime)
    {
        if (Auth::id() != $request->validated()['user_id']) {
            return response()->json([
                'error' => 'You do not have rights to do this!'
            ], 403);
        } else if ($request->validated()['team_id'] != null) {
            $team = Team::find($request->validated()['team_id'])->get();
            if (!$team->isUserAdmin(Auth::id())) {
                return response()->json([
                    'error' => 'You do not have rights to do this!'
                ], 403);
            }
        }

        $worktime->update($request->validated());

        return response()->json([
            'worktime' => $worktime,
            'message' => 'Worktime created successfully!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Worktime  $worktime
     * @return \Illuminate\Http\Response
     */
    public function destroy(Worktime $worktime)
    {
        //
    }
}
