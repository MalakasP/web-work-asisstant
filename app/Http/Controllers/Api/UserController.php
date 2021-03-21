<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Gets authenticated user information
     * 
     */
    public function index()
    {
        return auth()->user();
    }
}
