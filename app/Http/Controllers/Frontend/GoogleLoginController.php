<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Maanuser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

/**
 * "Continue with Google" for readers (guard: maanuser).
 * Google verifies the identity server-side (authorization-code flow), so no token is trusted from the browser.
 * Needs GOOGLE_CLIENT_ID and GOOGLE_CLIENT_SECRET in .env; the redirect URI to register in Google Cloud is
 * {APP_URL}/auth/google/callback (or set GOOGLE_REDIRECT_URI).
 */
class GoogleLoginController extends Controller
{
    protected function configured(): bool
    {
        return filled(config('services.google.client_id')) && filled(config('services.google.client_secret'));
    }

    protected function driver()
    {
        config(['services.google.redirect' => config('services.google.redirect') ?: route('auth.google.callback')]);

        return Socialite::driver('google');
    }

    public function redirect()
    {
        if (! $this->configured()) {
            return redirect()->route('home')->with('nahau_panel', 'login')
                ->with(['message' => __('Google sign-in is not available yet. Please use your email and password.'), 'type' => 'warning']);
        }

        return $this->driver()->redirect();
    }

    public function callback()
    {
        if (! $this->configured() || request()->has('error')) {
            return redirect()->route('home')->with('nahau_panel', 'login');
        }
        try {
            $g = $this->driver()->user();
        } catch (\Throwable $e) {
            report($e);

            return redirect()->route('home')->with('nahau_panel', 'login')
                ->with(['message' => __('Google sign-in failed. Please try again.'), 'type' => 'warning']);
        }
        $email = strtolower((string) $g->getEmail());
        $verified = data_get($g->user, 'email_verified', data_get($g->user, 'verified_email', true));
        if ($email === '' || ! $verified) {
            return redirect()->route('home')->with('nahau_panel', 'login')
                ->with(['message' => __('Your Google email could not be verified.'), 'type' => 'warning']);
        }

        $name = trim((string) $g->getName());
        $user = Maanuser::firstOrCreate(['email' => $email], [
            'first_name' => data_get($g->user, 'given_name') ?: Str::before($name, ' ') ?: 'Reader',
            'last_name' => data_get($g->user, 'family_name') ?: Str::after($name, ' '),
        ]);

        Auth::guard('maanuser')->login($user);
        request()->session()->regenerate();

        return redirect()->intended(route('maanuser.index'));
    }
}
