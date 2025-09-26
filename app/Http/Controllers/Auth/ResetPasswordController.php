<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    public function forgottenPassword()
    {
        return view('auth.passwords.reset_password_page');
    }

    protected function resetForgottenPassword()
    {
        $data = request()->validate([
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        $userForResetPassword = User::where('email', $data['email'])->firstOrFail();
        $data['password'] = Hash::make($data['password']);
        $data['updated_at'] = now();
        $userForResetPassword->fill($data)->save();
        return redirect()->route('login');
    }
}
