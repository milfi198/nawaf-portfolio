@extends('layouts.app')

@section('title', 'Photo Management')

@section('content')

<main class="min-h-screen bg-background text-on-background flex">
    @include('admin.partials.sidebar')

    <section class="flex-1 min-w-0">
        <div class="max-w-[1180px] mx-auto px-6 md:px-10 py-8 md:py-10">

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-5 mb-8">
                <div>
                    <p class="font-label-sm text-label-sm text-primary uppercase tracking-widest mb-3">
                        Photo Management
                    </p>
                </div>

                <a
                    href="{{ url('/admin/photos/create') }}"
                    class="inline-flex items-center justify-center gap-2 bg-primary text-on-primary px-6 py-3 rounded-full font-label-sm text-label-sm hover:scale-[1.02] transition-all duration-200 shadow-sm"
                >
                    <span class="material-symbols-outlined text-[20px]">add_a_photo</span>
                    Upload Photo
                </a>
            </div>

            @if (session('success'))
                <div class="bg-green-100 text-green-700 px-5 py-4 rounded-xl mb-6 border border-green-200">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-surface border border-surface-variant rounded-2xl overflow-hidden shadow-sm">
                <div class="flex items-center justify-between gap-4 px-6 py-5 border-b border-surface-variant">
                    <div>
                        <h2 class="text-xl font-bold text-on-background">
                            Uploaded Photos
                        </h2>
                        <p class="text-sm text-on-surface-variant mt-1">
                            Photos uploaded to your My Photography gallery.
                        </p>
                    </div>

                    <a
                        href="{{ url('/my-photography') }}"
                        class="hidden md:inline-flex items-center gap-2 text-primary font-semibold hover:underline"
                    >
                        <span class="material-symbols-outlined text-[20px]">visibility</span>
                        View Gallery
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-surface-container-low">
                            <tr class="text-sm text-on-surface-variant">
                                <th class="px-6 py-4 font-semibold">Photo</th>
                                <th class="px-6 py-4 font-semibold">Title</th>
                                <th class="px-6 py-4 font-semibold">Category</th>
                                <th class="px-6 py-4 font-semibold">Likes</th>
                                <th class="px-6 py-4 font-semibold">Comments</th>
                                <th class="px-6 py-4 font-semibold">Created</th>
                                <th class="px-6 py-4 font-semibold text-right">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($photos as $photo)
                                <tr class="border-t border-surface-variant hover:bg-surface-container-low/60 transition-all duration-200">
                                    <td class="px-6 py-4">
                                        <a href="{{ url('/my-photography/' . $photo->id) }}">
                                            <img
                                                src="{{ asset('storage/' . $photo->image) }}"
                                                alt="{{ $photo->title }}"
                                                class="w-24 h-16 object-cover rounded-xl border border-surface-variant"
                                            >
                                        </a>
                                    </td>

                                    <td class="px-6 py-4">
                                        <p class="font-semibold text-on-background">
                                            {{ $photo->title }}
                                        </p>

                                        <p class="text-sm text-on-surface-variant mt-1 max-w-[300px] truncate">
                                            {{ $photo->description ?: 'No description.' }}
                                        </p>
                                    </td>

                                    <td class="px-6 py-4">
                                        <span class="inline-flex px-3 py-1 rounded-full bg-surface-container-low text-sm font-semibold text-on-surface-variant">
                                            {{ $photo->category ?? '-' }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 text-on-surface-variant">
                                        {{ $photo->likes_count ?? $photo->likes()->count() }}
                                    </td>

                                    <td class="px-6 py-4 text-on-surface-variant">
                                        {{ $photo->comments_count ?? $photo->comments()->count() }}
                                    </td>

                                    <td class="px-6 py-4 text-on-surface-variant">
                                        {{ $photo->created_at->format('d M Y') }}
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-end gap-3">
                                            <a
                                                href="{{ url('/my-photography/' . $photo->id) }}"
                                                class="inline-flex items-center gap-1 text-primary font-semibold hover:underline"
                                            >
                                                View
                                            </a>

                                            <form
                                                action="{{ url('/admin/photos/' . $photo->id) }}"
                                                method="POST"
                                                onsubmit="event.preventDefault(); openDeleteModal(this, 'Delete this photo? This action cannot be undone.');"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="inline-flex items-center gap-1 text-red-600 font-semibold hover:text-red-700"
                                                >
                                                    <span class="material-symbols-outlined text-[18px]">delete</span>
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-16 text-center">
                                        <div class="mx-auto w-16 h-16 rounded-2xl bg-surface-container-low flex items-center justify-center text-primary mb-4">
                                            <span class="material-symbols-outlined text-[36px]">photo_library</span>
                                        </div>

                                        <h3 class="text-xl font-bold text-on-background mb-2">
                                            No photos uploaded yet
                                        </h3>

                                        <p class="text-on-surface-variant mb-6">
                                            Start uploading your first photography content.
                                        </p>

                                        <a
                                            href="{{ url('/admin/photos/create') }}"
                                            class="inline-flex items-center gap-2 bg-primary text-on-primary px-6 py-3 rounded-full font-semibold"
                                        >
                                            <span class="material-symbols-outlined text-[20px]">add_a_photo</span>
                                            Upload Photo
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </section>
</main>

@include('admin.partials.delete-modal')
@endsection
