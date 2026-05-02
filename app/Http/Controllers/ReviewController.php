<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index($movieId)
    {
        return Review::where('movie_id', $movieId)
            ->latest()
            ->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'movie_id' => 'required',
            'user_name' => 'required',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required'
        ]);

        $review = Review::create($request->all());

        return response()->json([
            'message' => 'Đánh giá thành công',
            'review' => $review
        ]);
    }
}
