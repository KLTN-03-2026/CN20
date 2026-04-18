<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Movie;
use App\Models\Showtime;

class ChatbotController extends Controller
{
    public function chat(Request $request)
    {
        $userMessage = $request->message;

        try {

            $lowerMessage = mb_strtolower($userMessage);

            $cleanMessage = mb_strtolower(
                preg_replace('/[^\p{L}\p{N}\s]/u', '', $userMessage)
            );

            /*
            ======================================================
            0. MATCH PHIM (PHẢI ĐẶT TRÊN CÙNG)
            ======================================================
            */
            $movieMatch = Movie::where('tinh_trang', 'dangchieu')
    ->get()
    ->first(function ($movie) use ($cleanMessage) {

        $movieName = mb_strtolower(
            preg_replace('/[^\p{L}\p{N}\s]/u', '', $movie->ten_phim)
        );

        $words = explode(' ', $movieName);

        foreach ($words as $word) {
            if (strlen($word) > 2 && str_contains($cleanMessage, $word)) {
                return true;
            }
        }

        return false;
    });
            /*
            ======================================================
            1. GIÁ VÉ
            ======================================================
            */
            if (str_contains($lowerMessage, 'giá') || str_contains($lowerMessage, 'vé')) {

                // tìm phòng nếu người dùng có nhắc "phòng 1 / phòng 2 / phòng 3"
                $room = null;

                if (preg_match('/phòng\s*\d+/u', $lowerMessage, $matches)) {
                    $room = trim($matches[0]);
                }

                $query = Showtime::query();

                if ($movieMatch) {
                    $query->where('movie_id', $movieMatch->id);
                }

                if ($room) {
                    $query->where('room', 'like', "%$room%");
                }

                $showtime = $query->orderBy('price', 'desc')->first();

                if (!$showtime) {
                    return response()->json([
                        "reply" => "Không có dữ liệu giá vé"
                    ]);
                }

                $basePrice = $showtime->price;

                $a_c = $basePrice;
                $d_g = $basePrice + 25000;
                $h = $basePrice + 40000;

                return response()->json([
                    "reply" =>
            "Giá vé:
            - Ghế A-C: " . number_format($a_c) . "đ
            - Ghế D-G: " . number_format($d_g) . "đ (+25,000đ)
            - Ghế H: " . number_format($h) . "đ (+40,000đ)"
                ]);
            }

            /*
            ======================================================
            2. PHIM THEO THỂ LOẠI
            ======================================================
            */
           if (
    str_contains($lowerMessage, 'thể loại') ||
    str_contains($lowerMessage, 'hành động') ||
    str_contains($lowerMessage, 'hài') ||
    str_contains($lowerMessage, 'tình cảm') ||
    str_contains($lowerMessage, 'gia đình') ||
    str_contains($lowerMessage, 'tâm lý')
) {

                $keyword = null;

                $movies = Movie::where('tinh_trang', 'dangchieu')->get();

                foreach ($movies as $movie) {
                    $genres = array_map('trim', explode(',', mb_strtolower($movie->the_loai)));

                    foreach ($genres as $g) {
                        if (str_contains($lowerMessage, $g)) {
                            $keyword = $g;
                            break 2;
                        }
                    }
                }

                if (!$keyword) {
                    return response()->json([
                        "reply" => "Các phim đang chiếu: " . $movies->pluck('ten_phim')->implode(', ')
                    ]);
                }

                $result = $movies->filter(function ($movie) use ($keyword) {
                    $genres = array_map('trim', explode(',', mb_strtolower($movie->the_loai)));
                    return in_array($keyword, $genres);
                })->pluck('ten_phim');

                return response()->json([
                    "reply" => "Phim thể loại $keyword: " . $result->implode(', ')
                ]);
            }

            /*
            ======================================================
            3. SUẤT CHIẾU
            ======================================================
            */
            if ($movieMatch &&
    (
        str_contains($lowerMessage, 'thông tin') ||
        str_contains($lowerMessage, 'độ tuổi') ||
        str_contains($lowerMessage, 'giới hạn')
    )
) {

    return response()->json([
    "reply" =>
    "Tên phim: " . $movieMatch->ten_phim . "\n" .
    "Thể loại: " . $movieMatch->the_loai . "\n" .
    "Thời lượng: " . $movieMatch->thoi_luong . " phút\n" .
    "Ngày chiếu: " . $movieMatch->ngay_chieu . "\n" .
    "Giới hạn độ tuổi: " . $movieMatch->gioi_han_do_tuoi
]);
}
            if ($movieMatch) {

                $showtimes = Showtime::where('movie_id', $movieMatch->id)
                ->whereDate('date', '>=', now()->toDateString())
                ->orderBy('date', 'asc')
                ->orderBy('start_time', 'asc')
                ->get();

                if ($showtimes->isEmpty()) {
                    return response()->json([
                        "reply" => "Phim này chưa có lịch chiếu"
                    ]);
                }

                $showtimesText = $showtimes->map(function ($s) {

                    $start = date('H:i', strtotime($s->start_time));
                    $end = date('H:i', strtotime($s->end_time));

                    return $s->date . " | " . $start . "-" . $end . " | " . $s->room;
                })->implode("\n");

                return response()->json([
                    "reply" => $movieMatch->ten_phim . " có suất chiếu:\n" . $showtimesText
                ]);
            }

            /*
            ======================================================
            4. PHIM ĐANG CHIẾU
            ======================================================
            */
            if (str_contains($lowerMessage, 'phim') &&
                str_contains($lowerMessage, 'chiếu')) {

                $movies = Movie::where('tinh_trang', 'dangchieu')
                    ->pluck('ten_phim')
                    ->implode(', ');

                return response()->json([
                    "reply" => "Phim đang chiếu: " . $movies
                ]);
            }

            /*
            ======================================================
            5. FALLBACK
            ======================================================
            */
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
