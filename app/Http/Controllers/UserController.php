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
        return response()->json([
            'message'=>'Signed up successfully'
        ], 201);
    }
    public function login(LoginRequest $request)
    {
        $validatedData = $request->validated();
    
        $email = $validatedData['email'];
        $password = $validatedData['password'];
        $token = Auth::attempt(["email"=>$email, "password"=>$password]);

        if (!$token) 
        {
            return response()->json([
                            "status" => 0,
                            "message" => "Invalid credentials"
                        ]);
        }
            
        return response()->json([
            "status" => 1,
            "message" => "Logged in successfully",
            "access_token" => $token
        ]);
    }
    public function getPermissions(Request $request)
    {
        $userId = $request->user_id;
        $user  = User::role('contributor')->get();
        $permissionNames = $user->getAllPermissions();
        return response()->json(
            [
                'data'=>$permissionNames
            ]
        );
    }

}
