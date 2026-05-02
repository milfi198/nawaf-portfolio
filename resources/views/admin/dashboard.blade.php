@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')

<main class="min-h-screen bg-background text-on-background flex">
    @include('admin.partials.sidebar')

    <section class="flex-1 min-w-0">
        <div class="max-w-[1180px] mx-auto px-6 md:px-10 py-8 md:py-10">

            <div class="mb-8">
                <p class="font-label-sm text-label-sm text-primary uppercase tracking-widest mb-3">
                    Overview
                </p>

                <h1 class="font-display-md text-display-md text-on-background mb-3">
                    Dashboard
                </h1>

                <p class="text-on-surface-variant max-w-2xl">
                    Overview of your portfolio gallery, users, and comments.
                </p>
            </div>

            @if (session('success'))
                <div class="bg-green-100 text-green-700 px-5 py-4 rounded-xl mb-6 border border-green-200">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-surface border border-surface-variant rounded-2xl p-5 shadow-sm">
                    <p class="text-on-surface-variant text-sm mb-2">Total Photos</p>
                    <p class="text-3xl font-bold">{{ $totalPhotos }}</p>
                </div>

                <div class="bg-surface border border-surface-variant rounded-2xl p-5 shadow-sm">
                    <p class="text-on-surface-variant text-sm mb-2">Registered Users</p>
                    <p class="text-3xl font-bold">{{ $totalUsers }}</p>
                </div>

                <div class="bg-surface border border-surface-variant rounded-2xl p-5 shadow-sm">
                    <p class="text-on-surface-variant text-sm mb-2">Total Comments</p>
                    <p class="text-3xl font-bold">{{ $totalComments }}</p>
                </div>

                <div class="bg-surface border border-surface-variant rounded-2xl p-5 shadow-sm">
                    <p class="text-on-surface-variant text-sm mb-2">Total Likes</p>
                    <p class="text-3xl font-bold">{{ $totalLikes }}</p>
                </div>
            </div>

            <div class="bg-surface border border-surface-variant rounded-2xl shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-surface-variant">
                    <h2 class="text-xl font-bold">
                        Latest Uploads
                    </h2>
                    <p class="text-sm text-on-surface-variant mt-1">
                        Recently uploaded photos.
                    </p>
                </div>

                <div class="divide-y divide-surface-variant">
                    @forelse ($latestPhotos as $photo)
                        <div class="px-6 py-4 flex items-center justify-between gap-4">
                            <div class="flex items-center gap-4">
                                <img
                                    src="{{ asset('storage/' . $photo->image) }}"
                                    alt="{{ $photo->title }}"
                                    class="w-20 h-14 object-cover rounded-xl border border-surface-variant"
                                >

                                <div>
                                    <p class="font-semibold">
                                        {{ $photo->title }}
                                    </p>
                                    <p class="text-sm text-on-surface-variant">
                                        {{ $photo->category ?? '-' }} • {{ $photo->created_at->format('d M Y') }}
                                    </p>
                                </div>
                            </div>

                            <a href="{{ url('/my-photography/' . $photo->id) }}" class="text-primary font-semibold">
                                View
                            </a>
                        </div>
                    @empty
                        <div class="px-6 py-10 text-center text-on-surface-variant">
                            No photos uploaded yet.
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </section>
</main>

@endsection
