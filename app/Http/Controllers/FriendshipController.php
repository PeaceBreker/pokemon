<?php

namespace App\Http\Controllers;

use App\Models\Friendship;
use App\Models\User;
use Illuminate\Http\Request;

class FriendshipController extends Controller
{
    public function sendFriendRequest(User $recipient)
    {
        // 取用登入者object
        $sender = auth()->user();

        // 檢查是否已經是好友
        if ($sender->isFriendWith($recipient) == true) {
            return response()->json(['message' => 'You are already friends'], 400);
        }

        // 檢查是否是自己
        if ($sender->id === $recipient->id) {
            return response()->json(['message' => 'You cannot send a friend request to yourself'], 400);
        }

        // 創建好友邀請
        Friendship::create([
            'user_id' => $sender->id,
            'friend_id' => $recipient->id,
            'status' => 'pending',
        ]);


        return response()->json(['message' => 'Friend invitation sent successfully'], 200);
    }

    public function acceptFriendRequest(Request $request)
    {
        $request->validate([
            'friendship_id' => 'required|exists:friendships,id',
        ]);

        $friendship = Friendship::find($request->input('friendship_id'));

        // 檢查是否已經處於被接受的狀態
        if ($friendship->status === 'accepted') {
            return response()->json(['message' => 'Friend invitation already accepted'], 400);
        }

        // 更新好友邀請的狀態
        $friendship->update(['status' => 'accepted']);

        return response()->json(['message' => 'Friend invitation accepted successfully'], 200);
    }

    public function rejectFriendRequest(Request $request)
    {
        $request->validate([
            'friendship_id' => 'required|exists:friendships,id',
        ]);

        $friendship = Friendship::find($request->input('friendship_id'));
        // 檢查是否已經處於被接受或被拒絕的狀態
        if ($friendship->status === 'accepted' || $friendship->status === 'rejected') {
            return response()->json(['message' => 'Friend invitation already processed'], 400);
        }

        // 更新好友邀請的狀態為 'rejected'
        $friendship->update(['status' => 'rejected']);

        return response()->json(['message' => 'Friend invitation rejected successfully'], 200);
    }

    public function removeFriend(User $friend)
    {
        // 獲取當前登入使用者
        $user = auth()->user();
        // 查找符合條件的 friendship
        $friendship = $user->friends()
            ->where('friendships.user_id', $user->id)
            ->where('friendships.friend_id', $friend->id)
            ->where('friendships.status', 'accepted')
            ->first();

        // 如果找到符合條件的 friendship，則刪除
        if ($friendship) {
            $user->friends()->detach($friendship->id);
            return response()->json(['message' => 'Friend removed'], 200);
        } else {
            return response()->json(['message' => 'Friend not found or not accepted'], 404);
        }
    }

    public function getFriends()
    {
        // 獲取當前已認證的用戶
        $user = auth()->user();

        // 通過關聯獲取用戶的朋友清單（已按照順序排序）
        $friends = $user->friends()->orderBy('name')->get();

        $friendshipsData = [];

        foreach ($friends as $friend) {
            $friendship = Friendship::where('friend_id', $friend->id)->first();
            // 將資訊添加到陣列中
            $friendshipsData[] = [
                'friend_id' => $friend->id,
                'friend_name' => $friend->name,
                'status' => $friendship->status,
            ];
        }
        // 返回 JSON 格式的朋友清單
        return response()->json(['friends' => $friendshipsData], 200);
    }
}
