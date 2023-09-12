<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;

use App\Jobs\SendEmployeeRegistrationEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function list()
    {
        $users = User::all();
        return view('admin.user_employee.list', compact('users'));
    }
    public function add()
    {
        return view('admin.user_employee.add');
    }
    public function save(Request $request)
    {
        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->username = $request->username;
            $user->password = bcrypt($request->password); // Hash mật khẩu trước khi lưu
            $user->role = $request->role;
            $user->mobile = $request->mobile;

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $fileExtension = $file->getClientOriginalExtension();
                $fileName = time(); // Tạo tên file dựa trên thời gian
                $newFileName = $fileName . '.' . $fileExtension; // Tên file mới
                //Lưu file vào thư mục storage/app/public/user với tên mới
                $file->storeAs('public/user', $newFileName);
                // Gán trường image của đối tượng user với tên mới
                $user->photo = $newFileName;
            }

            $user->save();

            // Gửi email và mật khẩu cho nhân viên
            $employeeData = [
                'name' => $user->name,
                'email' => $user->email,
                'password' => $request->password,
            ];

            dispatch(new SendEmployeeRegistrationEmail($employeeData));

            return redirect()->route('user-add')->with('success', 'Successful Add Employee!!!');
        } catch (\Exception $th) {
            dd($th->getMessage());
            // Xử lý lỗi và xóa hình ảnh nếu cần thiết
            if (isset($user->photo)) {
                $image = 'public/user/' . $user->photo;
                Storage::delete($image);
            }
            return redirect()->back()->with('error', 'Add Employee Failed!!!');
        }
    }

    public function edit($id)
    {
        $user = User::find($id);
        return view('admin.user_employee.edit', compact('user'));
    }

    public function update($id, Request $request)
    {
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->password = $request->password;
        $user->role = $request->role;
        $user->mobile = $request->mobile;
        $oldImg = $user->image;
        $file = $request->new_image;
        if ($request->hasFile('new_image')) {
            $fileExtension = $file->getClientOriginalName();
            $fileName = time(); // Tạo tên file dựa trên thời gian
            $newFileName = $fileName . '.' . $fileExtension; // Tên file mới
            //Lưu file vào thư mục storage/app/public/image với tên mới
            $request->file('new_image')->storeAs('public/user', $newFileName);
            // Gán trường image của đối tượng task với tên mới
            $user->photo = $newFileName;
        }
        try {
            $user->save();
            if ($request->hasFile('new_image')) {
                $image = 'public/user/' . $oldImg;
                Storage::delete($image);
            }
            return redirect()->back()->with('success', 'User updated successfully!');
        } catch (\Exception $th) {
            dd($th);
            if ($request->hasFile('new_image')) {
                $image = 'public/user/' . $newFileName;
                Storage::delete($image);
            }
            return redirect()->back()->with('error', 'User updated failed!!!');
        }
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        $image = 'public/user/' . $user->photo;
        Storage::delete($image);
        $user->delete();
        return redirect()->back()->with('success', 'User delete successfully!');
    }
    public function showViewChangePassword()
    {
        // Đưa code để hiển thị view thay đổi mật khẩu ở đây
        return view('admin.user_employee.change-password');
    }

    public function changePassword(Request $request)
    {
        // Lấy email của người dùng đang đăng nhập
        $email = Auth::user()->email;

        // Kiểm tra xác thực
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6',
            'new_password_confirmation' => 'required|same:new_password',
        ]);

        // Lấy thông tin từ biểu mẫu
        $oldPassword = $request->old_password;
        $newPassword = $request->new_password;
        // Tìm người dùng theo email
        $user = User::where('email', $email)->first();

        if ($user) {
            // Kiểm tra mật khẩu cũ
            if (Hash::check($oldPassword, $user->password)) {
                // Cập nhật mật khẩu mới
                $user->password = bcrypt($newPassword);
                $user->save();
                // Chuyển hướng với thông báo thành công
                return redirect()->route('adminLogin')->with('success', 'Password changed successfully!!');
            } else {
                // Chuyển hướng với thông báo lỗi nếu mật khẩu cũ không khớp
                return redirect()->back()->with('error', 'Old password is incorrect');
            }
        } else {
            // Chuyển hướng với thông báo lỗi nếu email không tồn tại
            return redirect()->back()->with('error', 'Email is not correct');
        }
    }
    public function changInfor($id)
    {
        $user = User::find($id);
        return view('admin.user_employee.change-infor', compact('user'));
    }
}
