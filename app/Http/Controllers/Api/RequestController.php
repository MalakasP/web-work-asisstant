<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateRequestRequest;
use App\Http\Requests\UpdateRequestRequest;
use App\Models\Request as UserRequest;
use App\Models\Team;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    /**
     * Get all the requests that bellongs to the user.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $createdRequests = Auth::user()->createdRequests;

        $gottenRequests = Auth::user()->gottenRequests;

        if ($createdRequests->isEmpty() && $gottenRequests->isEmpty()) {
            return response()->json([
                'message' => 'No requests found!'
            ], 404);
        }

        return response()->json([
            'gottenRequests' => $gottenRequests,
            'createdRequests' => $createdRequests
        ]);
    }

    /**
     * Store a newly created request in storage.
     *
     * @param  \App\Http\Requests\CreateRequestRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequestRequest $request)
    {
        if (
            !Auth::user()->usersInTeam($request->validated()['responser_id'])
            && Auth::id() != $request->validated()['responser_id']
        ) {
            return response()->json([
                'message' => 'The addressee is not in the same team!'
            ], 403);
        }

        $new_request = UserRequest::create($request->validated());

        return response()->json([
            'new_request' => $new_request,
            'message' => 'Request created successfully!'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(UserRequest $request)
    {
        return response()->json([
            'request' => $request
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRequestRequest  $request
     * @param  \App\Models\Request  $userRequest
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequestRequest $request, UserRequest $userRequest)
    {
        if (Auth::id() != $userRequest->requester_id) {
            return response()->json([
                'message' => 'You do not have the rights to do this!'
            ], 403);
        }

        $userRequest->update($request->validated());

        return response()->json([
            'userRequest' => $userRequest,
            'message' => 'Request updated successfully!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserRequest $request)
    {
        if (Auth::id() != $request->requester_id) {
            return response()->json([
                'message' => 'You do not have the rights to do this!'
            ], 403);
        }

        $request->delete();

        return response()->json([
            'userRequest' => $request,
            'message' => 'Request deleted successfully!'
        ]);
    }
}
