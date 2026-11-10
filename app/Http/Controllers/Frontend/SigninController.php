<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SigninController extends Controller
{
    public function maanSigninIndex()
    {
        return view('frontend.pages.signin');
    }
    public function maanSigninLogin(Request $request)
    {

        $credentials = ['email' => $request->email, 'password' => $request->password];

        if (Auth::guard('maanuser')->attempt($credentials)) {
            $request->session()->regenerate();
            Session::flash('message', 'Success message !');
            return redirect()->route('maanuser.index');
        }

        // Staff (admin / super admin / editors) sign in from the same form.
        $staff = \App\Models\User::where('email', $request->email)->first();
        if ($staff && (int) $staff->is_active === 1 && \Illuminate\Support\Facades\Hash::check((string) $request->password, $staff->password)) {
            Auth::guard('web')->login($staff);
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        $this->setError('Invalid Email or Password !');
        return redirect()->back()->withInput($request->only('email'))->with('nahau_panel', 'login');
    }
    public function maanSignout()
    {
        \auth()->logout() ;
        $this->setSuccess('User logout Successfully !');
        return redirect()->route('home');
    }
}
