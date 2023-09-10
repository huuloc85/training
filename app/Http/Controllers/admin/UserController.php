<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Jobs\SendEmail;
use App\Mail\MailNotify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Mail\EmployeeAccountCreated;
use Illuminate\Support\Facades\Mail;

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
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->password = $request->password;
        $user->role = $request->role;
        $user->mobile = $request->mobile;

        $file = $request->image;

        if ($request->hasFile('image')) {
            $fileExtension = $file->getClientOriginalName();
            $fileName = time(); // Tạo tên file dựa trên thời gian
            $newFileName = $fileName . '.' . $fileExtension; // Tên file mới
            //Lưu file vào thư mục storage/app/public/image với tên mới
            $request->file('image')->storeAs('public/user', $newFileName);
            // Gán trường image của đối tượng task với tên mới
            $user->photo = $newFileName;
        }
        try {

            $user->save();
            return redirect()->route('user-add')->with('success', 'Successful Add Employee!!!');
        } catch (\Exception $th) {
            dd($th->getMessage());
            $image = 'public/user/' . $user->image;
            Storage::delete($image);
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
    public function createEmployeeAccount(Request $request)
    {
        // Tạo tài khoản cho employee và lấy mật khẩu tạm thời
        $password = 'your_generated_password'; // Thay thế bằng mật khẩu tạm thời thực tế

        // Gửi email với mật khẩu
        $email = $request->input('email');
        Mail::to($email)->send(new EmployeeAccountCreated($password));

        // Rest of your code...
    }
}
