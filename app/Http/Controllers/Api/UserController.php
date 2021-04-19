<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Gets all the users of teams the user is in.
     */
    public function index()
    {
        $users = Auth::user()->teamsUsers();

        if ($users->isEmpty()) {
            return response()->json([
                'message' => 'No users found!'
            ], 404);
        }

        return response()->json([
            'users' => $users
        ]);
    }

    /**
     * Gets authenticated user information.
     */
    public function show()
    {
        return auth()->user(); 
    }
}
