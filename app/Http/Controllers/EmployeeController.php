<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    // ✅ LẤY DANH SÁCH
    public function index()
    {
        return response()->json(
            User::where('role', '!=', 'user')->get()
        );
    }

    // ✅ THÊM
    public function store(Request $request)
    {
        $emp = new User();

        $emp->name = $request->name;
        $emp->email = $request->email;
        $emp->phone = $request->phone;
        $emp->birth = $request->birth;
        $emp->role = $request->role;
        $emp->trang_thai = 'hoatdong';

        $emp->password = Hash::make($request->password);

        $emp->save();

        return response()->json(['message'=>'OK']);
    }

    // ✅ UPDATE
    public function update(Request $request, $id)
    {
        $emp = User::find($id);

        if(!$emp){
            return response()->json(['message'=>'Không tìm thấy'],404);
        }

        $emp->name = $request->name;
        $emp->email = $request->email;
        $emp->phone = $request->phone;
        $emp->role = $request->role;

        if($request->password){
            $emp->password = Hash::make($request->password);
        }

        $emp->save();

        return response()->json(['message'=>'Cập nhật OK']);
    }

    // ✅ XOÁ
    public function destroy($id)
    {
        $emp = User::find($id); // ✅ SỬA Ở ĐÂY

        if($emp){
            $emp->delete();
        }

        return response()->json([
            'message' => 'Xóa thành công'
        ]);
    }

    // ✅ TOGGLE STATUS
    public function toggleStatus($id)
    {
        $emp = User::find($id);

        if(!$emp){
            return response()->json(['message'=>'Không tìm thấy'],404);
        }

        if($emp->trang_thai == 'hoatdong'){
            $emp->trang_thai = 'khoa';
        }else{
            $emp->trang_thai = 'hoatdong';
        }

        $emp->save();

        return response()->json(['message'=>'OK']);
    }
}
