<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Showtime;
use Illuminate\Support\Facades\Session;

class ChatbotController extends Controller
{
    public function chat(Request $request)
    {
        $userMessage = $request->message;
        $lowerMessage = mb_strtolower($userMessage);

        try {

            if (str_contains($lowerMessage, 'sắp chiếu') || str_contains($lowerMessage, 'sap chieu')) {

                $movies = Movie::where('tinh_trang', 'sapchieu')->pluck('ten_phim');

                return response()->json([
                    "reply" => $movies->isEmpty()
                        ? "Hiện chưa có phim sắp chiếu"
                        : "Phim sắp chiếu: " . $movies->implode(', ')
                ]);
            }

            $movieMatch = Movie::whereIn('tinh_trang', ['dangchieu', 'sapchieu'])
                ->get()
                ->first(function ($movie) use ($lowerMessage) {

                    $name = mb_strtolower(
                        preg_replace('/[^\p{L}\p{N}\s]/u', '', $movie->ten_phim)
                    );

                    return str_contains($lowerMessage, $name);
                });

            if ($movieMatch) {

                Session::forget('last_showtime_ids');
                Session::forget('last_room');

                Session::put('last_movie_id', $movieMatch->id);
            }

            $movie = null;

            if (Session::has('last_movie_id')) {
                $movie = Movie::find(Session::get('last_movie_id'));
            }

            $room = null;
            $roomShowtimes = collect();

            if (preg_match('/phòng\s*(\d+)/iu', $lowerMessage, $m)) {
                $room = 'Phòng ' . $m[1];
                Session::put('last_room', $room);
            } elseif (Session::has('last_room')) {
                $room = Session::get('last_room');
            }

            if (
                str_contains($lowerMessage, 'suất') ||
                str_contains($lowerMessage, 'chiếu') ||
                str_contains($lowerMessage, 'mấy giờ')
            ) {

                if (!$movie) {
                    return response()->json([
                        "reply" => "Bạn hãy nhập tên phim trước"
                    ]);
                }

                $today = now()->toDateString();

            $showtimes = Showtime::where('movie_id', $movie->id)
                ->whereDate('date', $today)
                ->orderBy('start_time')
                ->get()
                ->values();

            Session::put('last_showtime_ids', $showtimes->pluck('id')->toArray());
                    return response()->json([
                    "reply" => $movie->ten_phim . " suất chiếu hôm nay:\n\n" .
                        $showtimes->map(function ($s) {
                            return "⏰ " .
                                date('H:i', strtotime($s->start_time)) .
                                "-" .
                                date('H:i', strtotime($s->end_time)) .
                                " | " . $s->room;
                        })->implode("\n")
                ]);
            }

        if (str_contains($lowerMessage, 'giá') || str_contains($lowerMessage, 'vé')) {


    if (!$movie && $room) {

        $showtime = Showtime::where('room', $room)
            ->latest()
            ->first();

        if ($showtime) {
            $movie = Movie::find($showtime->movie_id);
            Session::put('last_movie_id', $movie->id);
        }
    }

    if (!$movie && Session::has('last_showtime_ids')) {

        $showtime = Showtime::whereIn('id', Session::get('last_showtime_ids'))
            ->latest()
            ->first();

        if ($showtime) {
            $movie = Movie::find($showtime->movie_id);
            Session::put('last_movie_id', $movie->id);
        }
    }

    if (!$movie) {
        return response()->json([
            "reply" => "Bạn cần chọn phim hoặc hỏi suất chiếu trước khi xem giá vé"
        ]);
    }

    $showtimes = Showtime::where('movie_id', $movie->id)
        ->when($room, function ($q) use ($room) {
            $q->where('room', $room);
        })
        ->orderBy('start_time')
        ->get()
        ->unique(function ($s) {
            return $s->start_time . '-' . $s->room;
        })
        ->values();

    if ($showtimes->isEmpty()) {
        return response()->json([
            "reply" => "Không tìm thấy suất chiếu"
        ]);
    }

    $reply = "🎬 Giá vé phim " . $movie->ten_phim . " - " . ($room ?? "tất cả phòng") . "\n";
    $reply .= str_repeat("─", 20) . "\n\n";

    $reply .= $showtimes->map(function ($s) {

        $time = date('H:i', strtotime($s->start_time)) .
                "-" .
                date('H:i', strtotime($s->end_time));

        return
            "🕒 $time | " . $s->room . "\n" .
            "💺 A-C: " . number_format($s->price) . "đ | " .
            "D-G: " . number_format($s->price + 25000) . "đ | " .
            "H: " . number_format($s->price + 40000) . "đ\n" .
            str_repeat("─", 20);

    })->implode("\n\n");

    return response()->json([
        "reply" => $reply
    ]);
}
         
            if (str_contains($lowerMessage, 'phim') && str_contains($lowerMessage, 'chiếu')) {

                $movies = Movie::where('tinh_trang', 'dangchieu')->pluck('ten_phim');

                return response()->json([
                    "reply" => "Phim đang chiếu: " . $movies->implode(', ')
                ]);
            }

            return response()->json([
                "reply" => "Không tìm thấy thông tin"
            ]);

        } catch (\Exception $e) {
            return response()->json([
                "reply" => "Server lỗi",
                "error" => $e->getMessage()
            ]);
        }
    }
}
