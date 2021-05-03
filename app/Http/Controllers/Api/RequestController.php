<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateRequestRequest;
use App\Http\Requests\UpdateRequestRequest;
use App\Models\Request as UserRequest;
use Illuminate\Support\Facades\Auth;

class RequestController extends Controller
{
    /**
     * Get all the requests that user has been created.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCreatedRequests()
    {
        $createdRequests = Auth::user()->createdRequests()->paginate(10);

        if ($createdRequests->isEmpty()) {
            return response()->json([
                'message' => 'No requests found!'
            ], 404);
        }

        return response()->json([
            'createdRequests' => $createdRequests
        ]);
    }

    /**
     * Get all gotten requests that are not yet aswered by the user.
     *
     * @return \Illuminate\Http\Response
     */
    public function getNotAnsweredRequests()
    {
        $gottenRequests = Auth::user()->gottenRequests()->whereNull('confirmed_at')->paginate(10);

        if ($gottenRequests->isEmpty()) {
            return response()->json([
                'message' => 'No requests found!'
            ], 404);
        }

        return response()->json([
            'gottenRequests' => $gottenRequests
        ]);
    }

    /**
     * Get all gotten requests that are already been aswered by the user.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAnsweredRequests()
    {
        $answeredRequests = Auth::user()->gottenRequests()->whereNotNull('confirmed_at')->paginate(10);

        if ($answeredRequests->isEmpty()) {
            return response()->json([
                'message' => 'No requests found!'
            ], 404);
        }

        return response()->json([
            'answeredRequests' => $answeredRequests
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
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, UpdateRequestRequest $updateRequest)
    {
        if (Auth::id() != $request->requester_id && Auth::id() != $request->responser_id) {
            return response()->json([
                'message' => 'You do not have the rights to do this!'
            ], 403);
        }

        $request->update($updateRequest->validated());

        return response()->json([
            'request' => $request,
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
