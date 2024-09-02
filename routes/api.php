<?php

namespace App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ForgotPasswordController;

use Illuminate\Support\Facades\Password;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::controller(UserController::class)->group(function(){
    Route::post('signup', 'store')->name('signup');
    Route::post('login', 'login')->name('login');
});
// Route::middleware(['auth'=>'api'])->group(function(){
// });

Route::middleware('guest')->group(function()
{
    Route::post('/forgot_password', [ForgotPasswordController::class, 'submitForgotPasswordForm']);
    Route::post('/reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('password.update');

});
// Route::post('/reset-password', function (Request $request) {
//     $request->validate([
//         'token' => 'required',
//         'email' => 'required|email',
//         'password' => 'required|min:8|confirmed',
//     ]);
 
//     $status = Password::reset(
//         $request->only('email', 'password', 'password_confirmation', 'token'),
//         function ($user, $password) {
//             $user->forceFill([
//                 'password' => Hash::make($password)
//             ])->setRememberToken(Str::random(60));
 
//             $user->save();
 
//             event(new PasswordReset($user));
//         }
//     );
 
//     return $status === Password::PASSWORD_RESET
//                 ? redirect()->route('login')->with('status', __($status))
//                 : back()->withErrors(['email' => [__($status)]]);
// })->middleware('guest')->name('password.update');

