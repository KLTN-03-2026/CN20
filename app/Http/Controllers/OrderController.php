<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use App\Models\Ticket;

class OrderController extends Controller
{
    // User thanh toán
    public function checkout(Request $request)
    {
        $order = Order::create([
            'user_id' => Auth::id(),
            'movie_id' => $request->movie_id,
            'quantity' => $request->quantity,
            'total_price' => $request->total_price,
            'status' => 'paid'
        ]);

        return response()->json([
            'message' => 'Thanh toán thành công',
            'order' => $order
        ]);
    }

    // Admin lấy thống kê
    public function stats()
    {
        $totalOrders = Order::where('status','paid')->count();
        $revenue = Order::where('status','paid')->sum('total_price');
        $tickets = Order::where('status','paid')->sum('quantity');

        return response()->json([
            'orders' => $totalOrders,
            'revenue' => $revenue,
            'tickets' => $tickets
        ]);
    }
}
