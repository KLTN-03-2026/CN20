<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

// Lấy tất cả user
public function index(){
    return User::all();
}


// Lấy thông tin 1 user
public function show($id){
    $user = User::find($id);
    return response()->json($user);
}


// Cập nhật user
public function update(Request $request,$id)
{
    $user = User::findOrFail($id);

    $user->update($request->only([
        'name',
        'gender',
        'birth',
        'phone',
        'cmnd',
        'city',
        'district',
        'address'
    ]));

    return response()->json($user);
}


// khóa / mở khóa user
public function toggleStatus($id){

    $user = User::find($id);

    if($user->trang_thai == "hoatdong"){
        $user->trang_thai = "khoa";
    }else{
        $user->trang_thai = "hoatdong";
    }

    $user->save();

    return response()->json([
        "message"=>"Đã cập nhật trạng thái"
    ]);

}


// đổi mật khẩu
public function changePassword(Request $request, $id){

    $request->validate([
        'old_password' => 'required',
        'new_password' => 'required|min:6',
        'confirm_password' => 'required|same:new_password',
    ]);

    $user = User::findOrFail($id);

    if (!Hash::check($request->old_password, $user->password)) {
        return response()->json([
            'message' => 'Mật khẩu cũ không chính xác'
        ],400);
    }

    $user->password = Hash::make($request->new_password);
    $user->save();

    return response()->json([
        'message' => 'Thay đổi mật khẩu thành công'
    ]);
}
public function userTickets($user_id)
{
    return Ticket::where('user_id',$user_id)->get();
}

}
