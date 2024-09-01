<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;

use App\Http\Requests\SignupRequest;
use App\Models\User;
class UserController extends Controller
{
    public function __construct()
    {

    }
    public function store(SignupRequest $request)
    {
        $validated = $request->validated();
        User::create($validated);
        return response()->json([
            'message'=>'Signed up successfully'
        ], 201);
    }
    public function login(LoginRequest $request)
    {
        $validatedData = $request->validated();
        // check if user exists
        $user  = User::Exists($validatedData);

    }
}
