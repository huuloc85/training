<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleCheck
{
    public function handle(Request $request, Closure $next)
    {
        $userRole = auth()->user()->role; // Lấy vai trò của người dùng

        if ($userRole === 1) {
            return $next($request); // Cho phép truy cập nếu vai trò là 1
        }

        // Nếu vai trò không phải 1, chuyển hướng hoặc xử lý lỗi
        return redirect('/'); // Ví dụ: Chuyển hướng về trang chính hoặc xử lý lỗi khác
    }
}
