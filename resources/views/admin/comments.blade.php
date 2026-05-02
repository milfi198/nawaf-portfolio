@extends('layouts.app')

@section('title', 'Comments')

@section('content')

<main class="min-h-screen bg-background text-on-background flex">
    @include('admin.partials.sidebar')

    <section class="flex-1 min-w-0">
        <div class="max-w-[1180px] mx-auto px-6 md:px-10 py-8 md:py-10">

            <div class="mb-8">
                <p class="font-label-sm text-label-sm text-primary uppercase tracking-widest mb-3">
                    User Comments
                </p>
            </div>

            @if (session('success'))
                <div class="bg-green-100 text-green-700 px-5 py-4 rounded-xl mb-6 border border-green-200">
                    {{ session('success') }}
                </div>
            @endif

            <div class="max-w-sm mb-8">
                <div class="bg-surface border border-surface-variant rounded-2xl p-5 shadow-sm">
                    <p class="text-on-surface-variant text-sm mb-2">
                        Total Comments
                    </p>
                    <p class="text-3xl font-bold text-on-background">
                        {{ $comments->count() }}
                    </p>
                </div>
            </div>

            <div class="bg-surface border border-surface-variant rounded-2xl overflow-hidden shadow-sm">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 px-6 py-5 border-b border-surface-variant">
                    <div>
                        <h2 class="text-xl font-bold text-on-background">
                            Comment List
                        </h2>
                        <p class="text-sm text-on-surface-variant mt-1">
                            All user comments are listed here.
                        </p>
                    </div>

                    <form action="{{ url('/admin/comments') }}" method="GET" class="w-full md:w-[340px]">
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant text-[20px]">
                                search
                            </span>

                            <input
                                type="text"
                                name="search"
                                value="{{ $search ?? '' }}"
                                placeholder="Search comments..."
                                class="w-full rounded-full border border-surface-variant bg-surface-container-low pl-11 pr-10 py-2.5 text-sm focus:outline-none focus:border-primary"
                            >

                            @if (!empty($search))
                                <a
                                    href="{{ url('/admin/comments') }}"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-on-surface-variant hover:text-primary"
                                >
                                    <span class="material-symbols-outlined text-[20px]">close</span>
                                </a>
                            @endif
                        </div>
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-surface-container-low">
                            <tr class="text-sm text-on-surface-variant">
                                <th class="px-6 py-4 font-semibold">User</th>
                                <th class="px-6 py-4 font-semibold">Comment</th>
                                <th class="px-6 py-4 font-semibold">Photo</th>
                                <th class="px-6 py-4 font-semibold">Created</th>
                                <th class="px-6 py-4 font-semibold text-right">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($comments as $comment)
                                <tr class="border-t border-surface-variant hover:bg-surface-container-low/60 transition-all duration-200">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-full bg-primary text-on-primary flex items-center justify-center font-bold">
                                                @if ($comment->user && $comment->user->role === 'admin')
                                                    <span class="material-symbols-outlined text-[20px]">admin_panel_settings</span>
                                                @else
                                                    {{ strtoupper(substr($comment->user->display_name ?? 'U', 0, 1)) }}
                                                @endif
                                            </div>

                                            <div>
                                                <p class="font-semibold text-on-background">
                                                    @if ($comment->user && $comment->user->role === 'admin')
                                                            Admin
                                                            <span class="ml-2 inline-flex px-2 py-0.5 rounded-full bg-primary text-on-primary text-xs font-semibold">
                                                                Owner
                                                            </span>
                                                        @else
                                                            {{ $comment->user->display_name ?? 'Unknown User' }}
                                                        @endif
                                                </p>
                                                <p class="text-sm text-on-surface-variant">
                                                    {{ $comment->user->email ?? '-' }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4">
                                        <p class="text-on-background max-w-[360px]">
                                            {{ $comment->body }}
                                        </p>
                                    </td>

                                    <td class="px-6 py-4">
                                        @if ($comment->photo)
                                            <div class="flex items-center gap-3">
                                                <img
                                                    src="{{ asset('storage/' . $comment->photo->image) }}"
                                                    alt="{{ $comment->photo->title }}"
                                                    class="w-16 h-12 object-cover rounded-lg border border-surface-variant"
                                                >

                                                <div>
                                                    <p class="font-semibold text-on-background max-w-[220px] truncate">
                                                        {{ $comment->photo->title }}
                                                    </p>
                                                    <p class="text-sm text-on-surface-variant">
                                                        {{ $comment->photo->category ?? '-' }}
                                                    </p>
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-on-surface-variant">
                                                Photo deleted
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 text-on-surface-variant">
                                        {{ $comment->created_at->format('d M Y') }}
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-end gap-3">
                                            @if ($comment->photo)
                                                <a
                                                    href="{{ url('/my-photography/' . $comment->photo->id) }}"
                                                    class="inline-flex items-center gap-1 text-primary font-semibold hover:underline"
                                                >
                                                    View
                                                </a>
                                            @endif

                                            <form
                                                action="{{ route('admin.comments.destroy', $comment->id) }}"
                                                method="POST"
                                                onsubmit="event.preventDefault(); openDeleteModal(this, 'Delete this comment? This action cannot be undone.');"
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
                                    <td colspan="5" class="px-6 py-16 text-center">
                                        <div class="mx-auto w-16 h-16 rounded-2xl bg-surface-container-low flex items-center justify-center text-primary mb-4">
                                            <span class="material-symbols-outlined text-[36px]">chat_bubble</span>
                                        </div>

                                        <h3 class="text-xl font-bold text-on-background mb-2">
                                                No comments found
                                            </h3>

                                            <p class="text-on-surface-variant">
                                                @if (!empty($search))
                                                    No comments matched "{{ $search }}".
                                                @else
                                                    User comments will appear here.
                                                @endif
                                            </p>
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
