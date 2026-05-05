<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Photo;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    public function index()
    {
        $photos = Photo::withCount(['likes', 'comments'])->latest()->get();

        return view('admin.photos.index', compact('photos'));
    }

    public function create()
    {
        return view('admin.photos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:12000',
        ]);

        $imagePath = $request->file('image')->store('photos', 'public');

        $hostingPublicPath = base_path('../../public_html/storage/' . $imagePath);

        if (!file_exists(dirname($hostingPublicPath))) {
            mkdir(dirname($hostingPublicPath), 0755, true);
        }

        copy(storage_path('app/public/' . $imagePath), $hostingPublicPath);

        Photo::create([
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'image' => $imagePath,
        ]);

        return redirect($request->input('redirect_to', '/admin/photos'))
            ->with('success', 'Photo uploaded successfully.');
    }

    public function destroy(Photo $photo)
    {
        $photo->delete();

        return redirect('/admin/photos')->with('success', 'Photo deleted successfully.');
    }
}
