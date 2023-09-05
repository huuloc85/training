<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $redirectTo = 'admin.index';

    public function showLoginForm()
    {
        return view('admin.auth.login');
    }
    public function login(Request $request)
    {

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->route('admin.index');
        }
        return redirect()->back()->with('error', 'Thông tin đăng nhập không chính xác.');
    }
}
