<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {


        $credentials = $request->only('email', 'password');



        if (Auth::guard('admin')->attempt($credentials)) {
       
            // Authentication passed, redirect to admin dashboard or desired page
            return redirect()->route('admindashboard');
        }

        // Authentication failed, redirect back with an error message
        return redirect()->route('admin.login')->with('error', 'Invalid credentials.');
    }
    public function logout()
    {
        Auth::guard('admin')->logout();

        return redirect()->route('admin.login');
    }
}
