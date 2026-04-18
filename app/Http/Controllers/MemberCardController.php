<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\MemberCard;
use Illuminate\Http\Request;

class MemberCardController extends Controller
{
  public function linkCard(Request $request)
{
    $card = MemberCard::where('code', trim($request->code))->first();

    if (!$card) {
        return response()->json([
            'message' => 'Không tìm thấy thẻ'
        ], 404);
    }

    $user = User::find($request->user_id);

    if (!$user) {
        return response()->json([
            'message' => 'Không tìm thấy user'
        ], 404);
    }

    if ($user->member_card_id) {
        return response()->json([
            'message' => 'User đã có thẻ rồi'
        ], 400);
    }

    $user->member_card_id = $card->id;
    $user->save();

    return response()->json([
        'message' => 'Liên kết thành công',
        'card' => $card
    ]);
}
public function getCard($userId)
{
    $user = User::with('memberCard')->find($userId);

    if (!$user || !$user->memberCard) {
        return response()->json(null);
    }

    $total = $user->memberCard->total_spent;

    if ($total >= 1000000) {
        $level = 'KIM CƯƠNG';
        $discount = 20;
    } elseif ($total >= 500000) {
        $level = 'VÀNG';
        $discount = 15;
    } else {
        $level = 'BẠC';
        $discount = 5;
    }

    return response()->json([
        'code' => $user->memberCard->code,
        'total_spent' => $total,
        'level' => $level,
        'discount' => $discount
    ]);
}
 public function getByUser($id){
        $card = MemberCard::where('user_id', $id)->first();

        if(!$card){
            return response()->json(null);
        }

        return response()->json($card);
    }
}

