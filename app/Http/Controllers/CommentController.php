<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Photo $photo)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'You need to login before commenting.'
            ], 401);
        }

        $request->validate([
            'body' => 'required|string|max:1000',
        ]);

        $comment = Comment::create([
            'user_id' => Auth::id(),
            'photo_id' => $photo->id,
            'body' => $request->body,
        ]);

        $animal = explode(' ', Auth::user()->display_name ?? '')[0] ?? 'User';

            $avatars = [
                'Kucing' => '🐱',
                'Panda' => '🐼',
                'Koala' => '🐨',
                'Rubah' => '🦊',
                'Elang' => '🦅',
                'Kelinci' => '🐰',
                'Harimau' => '🐯',
                'Serigala' => '🐺',
                'Burung' => '🐦',
                'Kura-kura' => '🐢',
            ];

            $avatar = $avatars[$animal] ?? '👤';
        return response()->json([
            'success' => true,
            'comment' => [
                'id' => $comment->id,
                'body' => $comment->body,
                'display_name' => Auth::user()->role === 'admin'
                    ? 'Admin'
                    : Auth::user()->display_name,
                'avatar' => Auth::user()->role === 'admin'
                    ? 'admin'
                    : $avatar,
                'is_admin' => Auth::user()->role === 'admin',
                'time' => 'Just now',
            ],
            'comments_count' => $photo->comments()->count(),
        ]);
    }

    public function destroy(Comment $comment)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'You need to login first.'
            ], 401);
        }

        if ($comment->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'You can only delete your own comment.'
            ], 403);
        }

        $photo = $comment->photo;

        $comment->delete();

        return response()->json([
            'success' => true,
            'comments_count' => $photo->comments()->count(),
        ]);
    }
}
