<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class CustomAuthController extends Controller
{
    public function toRegister()
    {
        return view('auth.register');
    }
    public function toLogin()
    {
        return view('auth.login');
    }
    public function signout()
    {
        Session::flush();
        Auth::logout();
        return Redirect('login');
    }

    public function createUser(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'phone' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Kiểm tra file hình ảnh (tối đa 2MB)
        ]);

        $data = $request->all();

        // Lưu dữ liệu hình ảnh dưới dạng base64
        $imageData = base64_encode(file_get_contents($request->file('image')->path()));

        $check = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone' => $data['phone'],
            'image' => $imageData, // Lưu dữ liệu hình ảnh dưới dạng base64
        ]);

        return redirect("login");
    }
    
    public function checkUser(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
    
        $credentials = $request->only('email', 'password');
    
        if (Auth::attempt($credentials)) {
            return redirect()->intended('home')->withSuccess('Signed in');
        }
    
        return redirect("login")->withErrors(['login' => 'Login details are not valid']);
    }
    
    public function listUser()
    {
        // Kiểm tra xem người dùng đã đăng nhập hay chưa
        if (Auth::check()) {
            // Lấy danh sách người dùng phân trang
            $users = User::paginate(3); // Số lượng người dùng trên mỗi trang 

            // Trả về view 'auth.home' với dữ liệu người dùng phân trang
            return view('auth.home', ['users' => $users]);
        }

        // Nếu người dùng chưa đăng nhập
        return redirect("login")->withSuccess('You are not allowed to access');
    }
    /**
     * Delete user by id
     */
    public function deleteUser(Request $request)
    {
        $user_id = $request->get('id');
        $user = User::destroy($user_id);
        return redirect("home")->withSuccess('You have signed-in');
    }
    

    //

    
    public function editUser(Request $request)
    {
        $user_id = $request->get('id');
        $user = User::find($user_id);
        return view('auth.edit', ['user' => $user]);
    }



    //update thông tin
    public function cfeditUser(Request $request)
    {

        $input = $request->all();
        
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $input['id'],
            
            'phone' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Kiểm tra file hình ảnh (tối đa 2MB)// cho phep khong co anh moi van luu dc
        ]);

        $user = User::find($input['id']);
        $user->name = $input['name'];
        $user->email = $input['email'];
        $user->phone = $input['phone'];
        // Xử lý ảnh
        if ($request->hasFile('image')) {
            // Lưu dữ liệu hình ảnh dưới dạng base64
            $imageData = base64_encode(file_get_contents($request->file('image')->path()));
            $user->image = $imageData;
        }

        // if ($request->has('password')) {
        //     $user->password = Hash::make($input['password']);
        // }
        // Kiểm tra và cập nhật password nếu người dùng nhập password mới
        if ($input['password'] != null) {
            // $request->validate([
            //     'password' => 'required|min:6',
            // ]);

            $user->password = Hash::make($input['password']);
        }
        
        $user->save();
        
        return redirect("home")->withSuccess('Profile updated successfully');
    }
    
    
    public function getpost(Request $request)
    {
        $user_id = $request->get('id');
        $user = User::find($user_id);
        return view('auth.post', ['user' => $user]);
    }
}
