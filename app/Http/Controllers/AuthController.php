<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

// ✅ LOGIN
public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    $user = User::where('email',$request->email)->first();

    if(!$user){
        return response()->json([
            'message'=>'Email không tồn tại'
        ],404);
    }

    if($user->trang_thai == 'khoa'){
        return response()->json([
            'message'=>'Tài khoản đã bị khóa'
        ],403);
    }

    if(!Hash::check($request->password,$user->password)){
        return response()->json([
            'message'=>'Sai mật khẩu'
        ],401);
    }

    return response()->json([
        'message'=>'Đăng nhập thành công',
        'user'=>$user
    ],200);
}


// ✅ REGISTER
public function register(Request $request)
{
    $request->validate([
        'name'=>'required',
        'email'=>'required|email|unique:users',
        'password'=>'required|min:6'
    ]);

    $user = User::create([
        'name'=>$request->name,
        'email'=>$request->email,
        'password'=>Hash::make($request->password),
        'role'=>'user',
        'trang_thai'=>'hoatdong'
    ]);

    return response()->json([
        'message'=>'Đăng ký thành công',
        'user'=>$user
    ],201);
}

}
