@extends('layouts.app')

@section('title', 'Users')

@section('content')

<main class="min-h-screen bg-background text-on-background flex">
    @include('admin.partials.sidebar')

    <section class="flex-1 min-w-0">
        <div class="max-w-[1180px] mx-auto px-6 md:px-10 py-8 md:py-10">

            <div class="mb-8">
                <p class="font-label-sm text-label-sm text-primary uppercase tracking-widest mb-3">
                    User Management
                </p>
            </div>

            <div class="max-w-sm mb-8">
                <div class="bg-surface border border-surface-variant rounded-2xl p-5 shadow-sm">
                    <p class="text-on-surface-variant text-sm mb-2">
                        Total Users
                    </p>
                    <p class="text-3xl font-bold text-on-background">
                        {{ $users->count() }}
                    </p>
                </div>
            </div>

            <div class="bg-surface border border-surface-variant rounded-2xl overflow-hidden shadow-sm">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 px-6 py-5 border-b border-surface-variant">
                    <div>
                        <h2 class="text-xl font-bold text-on-background">
                            Registered Users
                        </h2>
                        <p class="text-sm text-on-surface-variant mt-1">
                            Users who registered to like and comment on your photos.
                        </p>
                    </div>

                    <form action="{{ url('/admin/users') }}" method="GET" class="w-full md:w-[320px]">
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant text-[20px]">
                                search
                            </span>

                            <input
                                type="text"
                                name="search"
                                value="{{ $search ?? '' }}"
                                placeholder="Search users..."
                                class="w-full rounded-full border border-surface-variant bg-surface-container-low pl-11 pr-10 py-2.5 text-sm focus:outline-none focus:border-primary"
                            >

                            @if (!empty($search))
                                <a
                                    href="{{ url('/admin/users') }}"
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
                                <th class="px-6 py-4 font-semibold">Display Name</th>
                                <th class="px-6 py-4 font-semibold">Email</th>
                                <th class="px-6 py-4 font-semibold">Joined</th>
                                <th class="px-6 py-4 font-semibold text-right">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($users as $user)
                                <tr class="border-t border-surface-variant hover:bg-surface-container-low/60 transition-all duration-200">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-full bg-primary text-on-primary flex items-center justify-center font-bold">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>

                                            <div>
                                                <p class="font-semibold text-on-background">
                                                    {{ $user->name }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4">
                                        <span class="inline-flex px-3 py-1 rounded-full bg-surface-container-low text-sm font-semibold text-on-surface-variant">
                                            {{ $user->display_name ?? '-' }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 text-on-surface-variant">
                                        {{ $user->email }}
                                    </td>

                                    <td class="px-6 py-4 text-on-surface-variant">
                                        {{ $user->created_at->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex justify-end">
                                            <form
                                                action="{{ route('admin.users.destroy', $user->id) }}"
                                                method="POST"
                                                onsubmit="event.preventDefault(); openDeleteModal(this, 'Delete this user? Their likes and comments will also be removed.');"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="inline-flex items-center gap-1 text-red-600 font-semibold hover:text-red-700 transition"
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
                                            <span class="material-symbols-outlined text-[36px]">group</span>
                                        </div>

                                        <h3 class="text-xl font-bold text-on-background mb-2">
                                            No users found
                                        </h3>

                                        <p class="text-on-surface-variant">
                                            @if (!empty($search))
                                                No users matched "{{ $search }}".
                                            @else
                                                Registered users will appear here.
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
