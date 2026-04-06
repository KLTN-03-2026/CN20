<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Showtime;
use App\Http\Controllers\Controller;

class ShowtimeController extends Controller
{
    public function index()
    {
        return response()->json(
            Showtime::with('movie')->get()
        );
    }

    public function store(Request $request)
    {
        $show = Showtime::create([
    'movie_id' => $request->movie_id,
    'date' => $request->date,
    'start_time' => $request->start_time,
    'end_time' => $request->end_time,
    'room' => $request->room
]);

        return response()->json($show);
    }

    public function destroy($id)
    {
        Showtime::findOrFail($id)->delete();

        return response()->json([
            'message' => 'Deleted'
        ]);
    }
}
