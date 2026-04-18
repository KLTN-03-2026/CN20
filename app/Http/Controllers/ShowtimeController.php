<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Showtime;

class ShowtimeController extends Controller
{
    // LẤY DANH SÁCH SUẤT CHIẾU + LOAD PHIM
   public function index()
{
    return response()->json(
        Showtime::with('movie')->get()->map(function ($s) {
            $s->start_time = substr($s->start_time, 0, 5);
            $s->end_time = substr($s->end_time, 0, 5);
            return $s;
        })
    );
}

    // THÊM SUẤT CHIẾU
    public function store(Request $request)
{
    $request->validate([
        'movie_id' => 'required|exists:movies,id',
        'date' => 'required',
        'start_time' => 'required',
        'end_time' => 'required',
        'room' => 'required',
        'format' => 'required',
        'price' => 'required',
    ]);

    $showtime = Showtime::create([
        'movie_id' => $request->movie_id,
        'date' => $request->date,
        'start_time' => substr($request->start_time, 0, 5),
        'end_time' => substr($request->end_time, 0, 5),
        'room' => $request->room,
        'format' => $request->format,
        'price' => $request->price,
        'status' => 'dangchieu'
    ]);

    return response()->json(
        $showtime->load('movie')
    );
}

    // CẬP NHẬT SUẤT CHIẾU
    public function update(Request $request, $id)
    {
        $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'room' => 'required',
            'format' => 'required',
            'price' => 'required|numeric',
        ]);

        $showtime = Showtime::findOrFail($id);

        $showtime->update([
            'movie_id' => $request->movie_id,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'room' => $request->room,
            'format' => $request->format,
            'price' => $request->price,
        ]);

        return response()->json(
            $showtime->load('movie')
        );
    }

    // XOÁ SUẤT CHIẾU
    public function destroy($id)
    {
        $showtime = Showtime::findOrFail($id);
        $showtime->delete();

        return response()->json([
            'message' => 'Deleted'
        ]);
    }
}
