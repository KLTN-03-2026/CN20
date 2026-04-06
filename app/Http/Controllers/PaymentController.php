<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use Carbon\Carbon;

class PaymentController extends Controller
{

public function store(Request $request)
{

$showDate = Carbon::createFromFormat('d/m/Y', $request->show_date)->format('Y-m-d');

$payment = Payment::create([
    'order_code' => $request->order_code,
    'movie' => $request->movie,
    'show_date' => $showDate,
    'show_time' => $request->show_time,
    'seats' => $request->seats,
    'amount' => $request->amount,
    'method' => $request->method,
    'status' => $request->status
]);

return response()->json([
    "message" => "Thanh toán lưu thành công",
    "data" => $payment
]);

}
public function destroy($id) {
    $payment = Payment::find($id);
    if (!$payment) {
        return response()->json(['message' => 'Không tìm thấy hóa đơn'], 404);
    }

    $payment->delete();
    return response()->json(['message' => 'Hóa đơn đã xóa'], 200);
}


public function index()
{
return Payment::latest()->get();
}

}
