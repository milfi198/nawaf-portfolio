<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Photo;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class DashboardController extends Controller
{
    public function index()
        {
            $totalPhotos = Photo::count();
            $totalUsers = User::where('role', 'user')->count();
            $totalComments = Comment::count();
            $totalLikes = \App\Models\Like::count();
            $latestPhotos = Photo::latest()->take(5)->get();

            return view('admin.dashboard', compact(
                'totalPhotos',
                'totalUsers',
                'totalComments',
                'totalLikes',
                'latestPhotos'
            ));
        }

    public function users(Request $request)
        {
            $search = $request->query('search');

            $users = User::where('role', 'user')
                ->when($search, function ($query) use ($search) {
                    $query->where(function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%')
                        ->orWhere('display_name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%');
                    });
                })
                ->latest()
                ->get();

            return view('admin.users', compact('users', 'search'));
        }

    public function comments(Request $request)
        {
            $search = $request->query('search');

            $comments = Comment::with(['user', 'photo'])
                ->when($search, function ($query) use ($search) {
                    $query->where(function ($q) use ($search) {
                        $q->where('body', 'like', '%' . $search . '%')
                            ->orWhereHas('user', function ($userQuery) use ($search) {
                                $userQuery->where('display_name', 'like', '%' . $search . '%')
                                    ->orWhere('email', 'like', '%' . $search . '%')
                                    ->orWhere('name', 'like', '%' . $search . '%');
                            })
                            ->orWhereHas('photo', function ($photoQuery) use ($search) {
                                $photoQuery->where('title', 'like', '%' . $search . '%')
                                    ->orWhere('category', 'like', '%' . $search . '%');
                            });
                    });
                })
                ->latest()
                ->get();

            return view('admin.comments', compact('comments', 'search'));
        }

    public function destroyComment(Comment $comment)
    {
        $comment->delete();

        return back()->with('success', 'Comment deleted successfully.');
    }

    public function settings()
        {
            return view('admin.settings');
        }

        public function updateSettings(Request $request)
            {
                $admin = User::findOrFail(Auth::id());

                $request->validate([
                    'password' => 'required|string|min:6|confirmed',
                ]);

                $admin->password = Hash::make($request->password);
                $admin->save();

                return back()->with('success', 'Admin password updated successfully.');
            }

        public function destroyUser(User $user)
        {
            if ($user->role === 'admin') {
                abort(403, 'Admin account cannot be deleted.');
            }

            $user->delete();

            return back()->with('success', 'User deleted successfully.');
        }

}
