<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class RoleCheck
{
    public function handle(Request $request, Closure $next)
    {
        $userRole = auth()->user()->role; // Lấy vai trò của người dùng

        if ($userRole == User::ROLE_ADMIN) {
            return $next($request); // Cho phép truy cập nếu vai trò là Admin
        }

        // Nếu vai trò không phải Admin, chuyển hướng hoặc xử lý lỗi
        return redirect()->route('admin.index')->with('error', 'Mày đéo phải admin đâu thằng ngu');
    }
}
