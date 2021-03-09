<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class AuthenticationController extends Controller
{
    /**
     * Gets authenticated user information
     * 
     */
    public function user()
    {
        return auth()->user();
    }
}
