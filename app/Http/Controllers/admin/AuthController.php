<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    protected $redirectTo = 'admin.index';

    public function showLoginForm()
    {
        return view('admin.auth.login');
    }
    public function login(AdminLoginRequest $request)
    {

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->route('admin.index');
        }
        return redirect()->back()->with('error', 'Thông tin đăng nhập không chính xác.');
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('adminLogin');
    }
}
