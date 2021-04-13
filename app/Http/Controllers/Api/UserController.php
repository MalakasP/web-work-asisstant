<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Gets authenticated user information
     * 
     */
    public function index()
    {
        $users = Auth::user()->teamsUsers();

        if ($users->isEmpty()) {
            return response()->json([
                'error' => 'No users found!'
            ], 404);
        }

        return response()->json([
            'users' => $users
        ]);
    }

    /**
     * Gets all the users informations by given IDs
     */
    public function show()
    {
        return auth()->user(); 
    }
}
