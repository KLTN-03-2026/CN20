<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if(!$user){
            return response()->json(['message'=>'Email không tồn tại'],404);
        }

        if($user->trang_thai == 'khoa'){
            return response()->json(['message'=>'Tài khoản đã bị khóa'],403);
        }

        if(!Hash::check($request->password,$user->password)){
            return response()->json(['message'=>'Sai mật khẩu'],401);
        }

        return response()->json([
            'message'=>'Đăng nhập thành công',
            'user'=>[
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'member' => [
                    'type' => $user->member_type,
                    'discount' => $user->member_discount
                ]
            ]
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6|confirmed',
            'phone'=>'nullable',
            'birth'=>'nullable',
            'gender'=>'nullable',
            'cmnd'=>'nullable',
            'city'=>'nullable',
            'district'=>'nullable',
            'address'=>'nullable',
        ]);

        $type = $request->member_type ?? 'normal';

        $discount = 0;

        if($type == 'silver') $discount = 10;
        if($type == 'gold') $discount = 15;
        if($type == 'diamond') $discount = 20;

        $user = User::create([
    'name'=>$request->name,
    'email'=>$request->email,
    'password'=>Hash::make($request->password),
    'phone'=>$request->phone,
    'birth'=>$request->birth,
    'gender'=>$request->gender,
    'cmnd'=>$request->cmnd,
    'city'=>$request->city,
    'district'=>$request->district,
    'address'=>$request->address,
    'role'=>'user',
    'trang_thai'=>'hoatdong',

    'member_type' => 'normal',
    'member_discount' => 0
]);

        return response()->json([
            'message'=>'Đăng ký thành công',
            'user'=>$user
        ],201);
    }

    // 🔥 API cập nhật thẻ (PROFILE)
    public function updateMember(Request $request)
{
    $user = User::find($request->user_id);

    if(!$user){
        return response()->json(['message'=>'User không tồn tại'],404);
    }

    $type = $request->member_type;

    $discount = 0;

    if($type == 'silver') $discount = 10;
    if($type == 'gold') $discount = 15;
    if($type == 'diamond') $discount = 20;

    $user->update([
        'member_type' => $type,
        'member_discount' => $discount
    ]);

    return response()->json([
        'message' => 'Cập nhật thẻ thành công',
        'member' => [
            'type' => $type,
            'discount' => $discount
        ]
    ]);
}
}

