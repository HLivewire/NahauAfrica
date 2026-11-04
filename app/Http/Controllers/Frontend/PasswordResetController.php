<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

/**
 * Forgot / reset password for frontend readers (guard "maanuser").
 */
class PasswordResetController extends Controller
{
    /** Drawer form: email a reset link. Always answers the same way so emails can't be probed. */
    public function sendLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        try {
            Password::broker('maanusers')->sendResetLink($request->only('email'));
        } catch (\Throwable $e) {
            report($e);
        }

        return back()
            ->with('nahau_panel', 'forgot')
            ->with('nahau_notice', __('If that email is registered, a reset link has been sent.'));
    }

    public function form(Request $request, string $token)
    {
        return view('frontend.pages.reset_password', [
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $status = Password::broker('maanusers')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill(['password' => Hash::make($password)])->save();
                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('home')
                ->with('nahau_panel', 'login')
                ->with('nahau_notice', __('Password updated. Please sign in.'));
        }

        return back()->withInput($request->only('email'))->withErrors(['email' => __($status)]);
    }
}
