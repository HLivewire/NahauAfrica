<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Display a listing of the login.
     *
     */
    public function maanIndex()
    {
        // One sign-in for everybody: the site's own login drawer (the "Get Started" button).
        if (auth()->check()) {
            return redirect()->route('admin.dashboard');
        }
        return redirect('/')->with('nahau_panel', 'login');
    }
    /**
     * Check login user email password.
     *
     */
    public function maanLogin(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password, 'is_active' => 1])){
            $this->setSuccess('User login Successfully !');
            return redirect()->route('admin.dashboard');
        }else{
            \App\Nahau\Audit::log('login_failed', null, 'Kuingia kumeshindwa: '.$request->email, null, 'web');
            $this->setError('Invalid Email or Password !');
            return redirect('/')->withInput($request->only('email'))->with('nahau_panel', 'login');
        }


    }
    public function maanLogout()
    {
        //If logout redirect to login page
        // Sign out of BOTH guards (staff and readers) and drop the whole session, so nobody stays half signed in.
        \Illuminate\Support\Facades\Auth::guard('web')->logout();
        \Illuminate\Support\Facades\Auth::guard('maanuser')->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/')->with('message', 'Umetoka kwa usalama. Karibu tena!')->with('type', 'success');
    }
}
