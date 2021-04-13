<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateWorktimeRequest;
use App\Http\Requests\UpdateWorktimeRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Worktime;
use App\Models\Team;
use App\Models\User;
use App\Services\WorktimeService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class WorktimeController extends Controller
{
    /**
     * Display a listing of the worktimes.
     *
     * @param Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->validator($request->all())->validate();

        if ($request->has('date')) {
            $worktimes = Auth::user()->worktimes()->whereDate('created_at', date('Y-m-d', strtotime($request->date)))->get();
        } else {
            $worktimes = Auth::user()->worktimes;
        }

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

        if (!User::find($request->validated()['user_id'])) {
            return response()->json([
                'error' => 'User not found!'
            ], 404);
        }

        if ($request->has('team_id')) {
            $team = Team::find($request->validated()['team_id'])->get();
        }

        if (
            (isset($team) ?? $team->isUserAdmin(Auth::id()))
            && Auth::id() != $request->validated()['user_id']
        ) {
            return response()->json([
                'error' => 'You do not have rights to do this!'
            ], 403);
        }

        $worktime = Worktime::create($request->validated());

        return response()->json([
            'worktime' => $worktime,
            'message' => 'Worktime created successfully!'
        ]);
    }

    /**
     * Display the specified worktime.
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
     * Update the specified worktime in storage.
     *
     * @param  \App\Http\Requests\UpdateWorktimeRequest  $request
     * @param  \App\Models\Worktime  $worktime
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateWorktimeRequest $request, Worktime $worktime)
    {
        $request->validated();

        if ($request->has('team_id')) {
            $team = Team::find($request->validated()['team_id'])->get();
        }

        if (
            (isset($team) ?? !$team->isUserAdmin(Auth::id())) &&
            Auth::id() != $request->validated()['user_id']
        ) {
            return response()->json([
                'error' => 'You do not have rights to do this!'
            ], 403);
        }
        
        if (!$request->has('duration')) {
            $endTime = Carbon::parse($request->end_time)->toDateTimeString();
            $duration = WorktimeService::calculateTime($worktime->created_at, $endTime);
        } elseif ((isset($team) ?? !$team->isUserAdmin(Auth::id()))) {
            $duration = $request->validated()['duration'];
            $duration = gmdate("H:i", $duration);
        }
        // var_dump($duration);die;
        if (strtotime($duration) - strtotime('TODAY') == 0) {
            return response()->json([
                'error' => 'You have worked less than 15 minutes after You started working.'
            ], 406);
        }

        $worktime->update([
            'duration' => $duration,
            'end_time' => $endTime
        ]);

        return response()->json([
            'worktime' => $worktime,
            'message' => 'Worktime updated successfully!'
        ]);
    }

    /**
     * Remove the specified worktime from storage.
     *
     * @param  \App\Models\Worktime  $worktime
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Worktime $worktime, Request $request)
    {
        if ($request->has('team_id')) {
            $team = Team::find($request->validated()['team_id'])->get();
        }

        if (
            !Auth::user()->usersInTeam($worktime->user_id) ||
            (isset($team) ?? !$team->isUserAdmin(Auth::id())) &&
            Auth::id() != $worktime->user_id
        ) {
            return response()->json([
                'error' => 'You do not have the rights to do this!'
            ], 403);
        }

        $worktime->delete();

        return response()->json([
            'worktime' => $worktime,
            'message' => 'Worktime deleted successfully!'
        ]);
    }

    /**
     * Get a validator for an incoming index worktime request.
     *
     * @param  array  $data
     * @return Illuminate\Support\Facades\Validator;
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'date' => ['date'],
        ]);
    }
}
