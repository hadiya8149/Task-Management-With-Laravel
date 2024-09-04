<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

use App\Http\Requests\SignupRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ForgotPassword;
use ILluminate\Support\Facades\Auth;
use JWTAuth;

use App\Models\User;
class UserController extends Controller
{

    public function store(SignupRequest $request)
    {
        $validated = $request->validated();
        $email = $validated["email"];
        $password = bcrypt($validated["password"]);
        $name = $validated["name"];
        User::create(
            [
                "email"=>$email,
                "password"=>$password,
                "name"=>$name
            ]
            );
        return sendSuccessResponse("User signed up successfully");
    }
    
    public function login(LoginRequest $request)
    {
        $validatedData = $request->validated();
    
        $email = $validatedData['email'];
        $password = $validatedData['password'];
        $token = Auth::attempt(["email"=>$email, "password"=>$password]);

        if (!$token) 
        {
            return sendJsonResponse(401, "Invalid credentials", []);
        }
            
        return sendJsonResponse(200, "Logged in successfully", [$token]);
    }

    public function getPermissions()
    {
        $user = User::find(4);
        $role = $user->getRoleNames();
        $perm = $user->permissions;
        return response($perm);
    }
}
