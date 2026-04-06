<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use Carbon\Carbon;

class TicketController extends Controller
{

    // Lưu ticket
    public function store(Request $request)
    {

        $ticket = Ticket::create([
            'user_id' => $request->user_id,
            'movie' => $request->movie,
            'room' => $request->room,
            'seat' => $request->seat,
            'showtime' => $request->showtime,
            'price' => $request->price,
            'poster' => $request->poster
        ]);

        return response()->json([
            "message" => "Ticket saved",
            "data" => $ticket
        ]);
    }

    // Vé của user
    public function userTickets($user_id)
    {
        $tickets = Ticket::where('user_id',$user_id)->get();
        return response()->json($tickets);
    }

    // Xóa vé
    public function destroy($id)
    {
        $ticket = Ticket::find($id);

        if(!$ticket){
            return response()->json([
                'message' => 'Không tìm thấy vé'
            ],404);
        }

        $ticket->delete();

        return response()->json([
            'message' => 'Xóa thành công'
        ]);
    }

    // Chart doanh thu
   public function revenueChart()
{
    $data = Ticket::whereDate('created_at', Carbon::today())
        ->selectRaw('HOUR(created_at) as hour, SUM(price) as total')
        ->groupBy('hour')
        ->orderBy('hour')
        ->get();

    return response()->json($data);
}

}
