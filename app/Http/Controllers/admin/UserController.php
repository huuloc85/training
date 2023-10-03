<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateInforRequest;
use App\Http\Requests\UpdateUserRequest;
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
    public function save(CreateUserRequest $request)
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

    public function update($id, UpdateUserRequest $request)
    {
        // Đảm bảo bạn sử dụng đúng tên trường trong request để cập nhật thông tin người dùng
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->username = $request->username;

        // Kiểm tra xem mật khẩu mới đã được nhập và hash nó
        if ($request->has('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->role = $request->role;
        $user->mobile = $request->mobile;
        $oldImg = $user->photo;

        if ($request->hasFile('new_image')) {
            $fileExtension = $request->file('new_image')->getClientOriginalExtension();
            $fileName = time();
            $newFileName = $fileName . '.' . $fileExtension;
            $request->file('new_image')->storeAs('public/user', $newFileName);
            $user->photo = $newFileName;
        }

        $updateSuccess = $user->save();

        // Xóa hình ảnh cũ nếu có
        if ($updateSuccess && $request->hasFile('new_image')) {
            Storage::delete('public/user/' . $oldImg);
        }

        if ($updateSuccess) {
            return redirect()->back()->with('success', 'User updated successfully!');
        } else {
            // Xử lý lỗi khi cập nhật không thành công
            if ($request->hasFile('new_image')) {
                // Nếu có lỗi, xóa hình ảnh mới nếu đã tải lên
                Storage::delete('public/user/' . $newFileName);
            }
            return redirect()->back()->with('error', 'User update failed!!!');
        }
    }



    public function delete($id)
    {
        $user = User::findOrFail($id);

        // Kiểm tra xem người dùng có vai trò là "admin" không
        if ($user->role === 1) {
            return redirect()->back()->with('error', 'Không thể xóa người dùng với vai trò là admin.');
        }

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

    public function changePassword(ChangePasswordRequest $request)
    {
        // Lấy email của người dùng đang đăng nhập
        $email = Auth::user()->email;

        // Kiểm tra xác thực

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
    public function changeInfor()
    {
        $user = Auth::user(); // Lấy người dùng hiện tại
        // Hiển thị trang thay đổi thông tin với thông tin người dùng
        return view('admin.user_employee.change-infor', compact('user'));
    }
    public function updateInfor(UpdateInforRequest $request)
    {
        // Lấy ID người dùng hiện tại
        $userId = Auth::id();

        // Kiểm tra nếu người dùng không tồn tại
        if (!$userId) {
            return redirect()->back()->with('error', 'User not found');
        }

        // Lấy thông tin người dùng theo ID
        $user = User::find($userId);

        // Kiểm tra nếu người dùng không tồn tại
        if (!$user) {
            return redirect()->back()->with('error', 'User not found');
        }
        if ($user->role == 2) {
            return redirect()->back()->with('error', 'You are not allowed to change your role.');
        }

        // Cập nhật thông tin người dùng
        $user->name = $request->name;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->role = $request->role;
        $user->mobile = $request->mobile;

        $oldImg = $user->photo;
        $file = $request->file('new_image');

        if ($request->hasFile('new_image')) {
            $fileExtension = $file->getClientOriginalName();
            $fileName = time();
            $newFileName = $fileName . '.' . $fileExtension;

            $request->file('new_image')->storeAs('public/user', $newFileName);
            $user->photo = $newFileName;

            // Xóa ảnh cũ nếu tồn tại
            if ($oldImg) {
                Storage::delete('public/user/' . $oldImg);
            }
        }

        try {
            $user->save();
            return redirect()->back()->with('success', 'Change Information Successfully!');
        } catch (\Exception $th) {
            // Xử lý lỗi (log và thực hiện các hành động cần thiết)
            dd($th->getMessage());
            // Đảo ngược thay đổi ảnh nếu có lỗi
            if ($request->hasFile('new_image')) {
                $image = 'public/user/' . $newFileName;
                Storage::delete($image);
            }

            return redirect()->back()->with('error', 'Change Information Failed!!!');
        }
    }
}
