<?php

namespace App\Http\Controllers;
use Illuminate\Auth\Events\PasswordReset;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;

use App\Models\User;

class ForgotPasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api',[ "except"=>['index', 'submitResetPasswordForm']]);
    }
    public function index()
    {
        Mail::to('testreceiver@gmail.com')->send(new ResetPasswordMail('hadiay'));

    }
    public function submitForgotPasswordForm() #for sending reset password link
    {
        $validatedData = $request->validated();
        $email = $validatedData['email'];
        $status = Password::sendResetLink(
           ["email"=>$email]
        );
        // get token from reset password link
        Mail::send('mails.send-forgot-password-mail', ['token'=>''], function($message) use($request)
        {
            $message->to($email);
            $message->subject('Reset Password');
        });
    }
    public function showResetPasswrodForm() #web function not needed
    {

    }
    public function submitResetPasswordForm(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);
    
        $user = User::query()->where('email', $request->email);
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => bcrypt($password)
                ]);
     // setremembertoekn
                $user->save();
     
                event(new PasswordReset($user));
            }
        );
     
        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __($status))
                    : back()->withErrors(['email' => [__($status)]]);
    }

}

