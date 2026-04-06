<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use App\Models\UserVoucher; // THÊM DÒNG NÀY
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function index(){
        return Voucher::all();
    }

    public function store(Request $request){
        return Voucher::create([
            'code' => $request->code,
            'type' => 'fixed',
            'value' => $request->value,
            'start' => $request->start,
            'end' => $request->end
        ]);
    }

    public function destroy($id){
        Voucher::findOrFail($id)->delete();
        return response()->json(['message'=>'deleted']);
    }

    // LƯU VOUCHER CHO USER
    public function saveVoucher(Request $req)
    {
        $voucher = new UserVoucher();
        $voucher->user_id = $req->user_id;
        $voucher->code = $req->code;
        $voucher->save();

        return response()->json(["message"=>"saved"]);
    }

    // LẤY VOUCHER CỦA USER
  public function getUserVoucher($id)
{
    return \DB::table('user_vouchers')
        ->join('vouchers','user_vouchers.code','=','vouchers.code')
        ->where('user_vouchers.user_id',$id)
        ->select(
            'vouchers.code',
            'vouchers.value',
            'vouchers.start',
            'vouchers.end'
        )
        ->get();
}
}
