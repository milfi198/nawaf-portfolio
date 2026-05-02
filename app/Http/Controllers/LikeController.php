<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function toggle(Photo $photo)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'You need to login before liking a photo.'
            ], 401);
        }

        $existingLike = Like::where('user_id', Auth::id())
            ->where('photo_id', $photo->id)
            ->first();

        if ($existingLike) {
            $existingLike->delete();

            return response()->json([
                'success' => true,
                'liked' => false,
                'likes_count' => $photo->likes()->count(),
                'message' => 'Like removed.'
            ]);
        }

        Like::create([
            'user_id' => Auth::id(),
            'photo_id' => $photo->id,
        ]);

        return response()->json([
            'success' => true,
            'liked' => true,
            'likes_count' => $photo->likes()->count(),
            'message' => 'Photo liked.'
        ]);
    }
}
