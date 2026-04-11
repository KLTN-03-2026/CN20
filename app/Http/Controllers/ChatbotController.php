<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

public function chat(Request $request)
{
    $message = $request->message;

    $response = Http::withHeaders([
        'Authorization' => 'Bearer YOUR_API_KEY',
        'Content-Type' => 'application/json'
    ])->post('https://api.openai.com/v1/chat/completions', [
        'model' => 'gpt-4o-mini',
        'messages' => [
            [
                'role' => 'system',
                'content' => 'Bạn là nhân viên rạp phim, tư vấn phim, hỗ trợ đặt vé, trả lời ngắn gọn'
            ],
            [
                'role' => 'user',
                'content' => $message
            ]
        ]
    ]);

    return response()->json([
        'reply' => $response['choices'][0]['message']['content']
    ]);
}
