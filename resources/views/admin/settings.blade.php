@extends('layouts.app')

@section('title', 'Admin Settings')

@section('content')

<main class="min-h-screen bg-background text-on-background flex">
    @include('admin.partials.sidebar')

    <section class="flex-1 min-w-0">
        <div class="max-w-[900px] mx-auto px-6 md:px-10 py-8 md:py-10">

            <div class="mb-8">
                <p class="font-label-sm text-label-sm text-primary uppercase tracking-widest mb-3">
                    Admin Settings
                </p>
            </div>

            @if (session('success'))
                <div class="bg-green-100 text-green-700 px-5 py-4 rounded-xl mb-6 border border-green-200">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 text-red-700 px-5 py-4 rounded-xl mb-6 border border-red-200">
                    <ul class="list-disc ml-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-surface border border-surface-variant rounded-2xl shadow-sm overflow-hidden">
                <div class="px-6 md:px-8 py-6 border-b border-surface-variant">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-primary text-on-primary flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-[28px]">admin_panel_settings</span>
                        </div>

                        <div>
                            <h2 class="text-2xl font-bold text-on-background">
                                Admin Account
                            </h2>

                            <p class="text-on-surface-variant mt-1">
                                Manage your login credentials.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="p-6 md:p-8">
                    <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-5">
                        @csrf

                        <div>
                            <label class="block font-label-sm text-label-sm text-on-background mb-2">
                                Admin Name
                            </label>

                            <input
                                type="text"
                                value="Admin"
                                disabled
                                class="w-full rounded-xl border border-surface-variant bg-surface-container-low px-4 py-3 text-on-surface-variant"
                            >

                            <p class="text-sm text-on-surface-variant mt-2">
                                Admin public name is fixed as Admin.
                            </p>
                        </div>

                        <div>
                            <label class="block font-label-sm text-label-sm text-on-background mb-2">
                                Email
                            </label>

                            <input
                                type="email"
                                value="{{ Auth::user()->email }}"
                                disabled
                                class="w-full rounded-xl border border-surface-variant bg-surface-container-low px-4 py-3 text-on-surface-variant"
                            >
                        </div>

                        <div>
                            <label class="block font-label-sm text-label-sm text-on-background mb-2">
                                New Password
                            </label>

                            <input
                                type="password"
                                name="password"
                                placeholder="Leave empty if you don't want to change it"
                                class="w-full rounded-xl border border-surface-variant bg-surface-container-low px-4 py-3 focus:outline-none focus:border-primary"
                            >
                        </div>

                        <div>
                            <label class="block font-label-sm text-label-sm text-on-background mb-2">
                                Confirm New Password
                            </label>

                            <input
                                type="password"
                                name="password_confirmation"
                                placeholder="Confirm new password"
                                class="w-full rounded-xl border border-surface-variant bg-surface-container-low px-4 py-3 focus:outline-none focus:border-primary"
                            >
                        </div>

                        <div class="flex flex-col sm:flex-row gap-3 pt-2">
                            <button
                                type="submit"
                                class="inline-flex justify-center items-center gap-2 bg-primary text-on-primary px-8 py-3 rounded-full font-label-sm text-label-sm hover:scale-[1.01] transition-all duration-200"
                            >
                                <span class="material-symbols-outlined text-[20px]">save</span>
                                Save Changes
                            </button>

                            <a
                                href="{{ url('/admin/dashboard') }}"
                                class="inline-flex justify-center items-center gap-2 border border-surface-variant text-on-surface-variant px-8 py-3 rounded-full font-label-sm text-label-sm hover:border-primary hover:text-primary transition-all duration-200"
                            >
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </section>
</main>

@endsection
