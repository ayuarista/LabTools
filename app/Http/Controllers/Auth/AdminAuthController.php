<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function index()
    {
        // Admin::create([
        //     'name' => 'admins',
        //     'email' => 'admin@gmail.com',
        //     'password' => 'admin1234'
        // ]);
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('admin')->attempt($credentials)) {
            flash()->success('Login berhasil');
            return redirect()->route('admin.dashboard');
        }


        flash()->error('Login gagal');
        return back()->withErrors(['email' => 'Email atau password salah!']);
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
