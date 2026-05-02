@extends('layouts.app')

@section('title', 'My Photography')

@push('styles')
    <link href="{{ asset('css/photography-animations.css') }}" rel="stylesheet">
@endpush

@push('head-scripts')
    <script src="{{ asset('js/photography-animations.js') }}"></script>
@endpush

@section('content')

@include('partials.navbar', ['navType' => 'photography'])


<main class="photo-page pt-[72px]">
    @if (session('success'))
    <div
        id="toastSuccess"
       class="fixed top-24 left-8 z-[9999] bg-green-100 text-green-700 px-5 py-4 rounded-xl shadow-lg border border-green-200 transition-all duration-500"
    >
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div
        id="toastError"
        class="fixed top-24 left-8 z-[9999] bg-red-100 text-red-700 px-5 py-4 rounded-xl shadow-lg border border-red-200 transition-all duration-500"
    >
        <ul class="list-disc ml-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    @if (!Auth::check() || Auth::user()->role !== 'admin')
        <section class="photo-hero bg-surface-container-low py-16 md:py-20">
            <div class="max-w-[1280px] mx-auto px-8 md:px-12 text-center" data-photo-reveal>
                <p class="photo-kicker font-label-sm text-label-sm text-primary mb-4 uppercase tracking-widest">
                    Photography Gallery
                </p>

                <h1 class="text-[48px] md:text-display-xl leading-[1.05] font-bold text-on-background mb-6">
                    My Photography
                </h1>

                <p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl mx-auto">
                    A collection of moments, places, and visual stories captured through my photography.
                </p>
            </div>
        </section>
    @endif

    <section class="@auth @if(Auth::user()->role === 'admin') pt-8 md:pt-10 pb-16 md:pb-20 @else py-16 md:py-20 @endif @else py-16 md:py-20 @endauth">
        <div class="max-w-[1280px] mx-auto px-8 md:px-12">

            @if (!Auth::check() || Auth::user()->role !== 'admin')
                <div class="mb-12" data-photo-reveal="left">
                    <p class="font-label-sm text-label-sm text-primary mb-3 uppercase tracking-widest">
                        Gallery
                    </p>
                    <h2 class="font-headline-lg text-headline-lg text-on-background">
                        Featured Shots
                    </h2>
                </div>
            @endif

            @auth
                @if (Auth::user()->role === 'admin')
                    @php
                        $uploadCategories = collect(['People', 'Nature', 'Street', 'School', 'Event', 'Personal', 'Other'])
                            ->merge($categories ?? collect())
                            ->unique()
                            ->values();
                    @endphp

                    <div class="max-w-3xl mx-auto mb-8" data-photo-reveal>
                        <div class="gallery-composer bg-surface border border-surface-variant rounded-2xl shadow-sm p-4">
                            <div class="flex items-center gap-3">
                                <div class="w-11 h-11 rounded-full bg-primary text-on-primary flex items-center justify-center">
                                    <span class="material-symbols-outlined text-[24px]">add_a_photo</span>
                                </div>

                                <button
                                    type="button"
                                    onclick="openPostModal()"
                                    class="flex-1 text-left rounded-full bg-surface-container-low px-5 py-3 text-on-surface-variant hover:bg-surface-container-high transition-all duration-200"
                                >
                                    Share a new photo...
                                </button>
                            </div>
                        </div>
                    </div>
                @endif
            @endauth
            <div class="filter-strip flex flex-wrap items-center gap-3 mb-8" data-photo-reveal>
                <a
                    href="{{ url('/my-photography') }}"
                    class="filter-pill px-4 py-2 rounded-full text-sm font-semibold transition
                    {{ ($selectedCategory ?? 'All') === 'All'
                        ? 'bg-primary text-on-primary'
                        : 'bg-surface-container-low text-on-surface-variant hover:text-primary' }}"
                >
                    All
                </a>

                @foreach ($categories as $category)
                    <a
                        href="{{ url('/my-photography?category=' . urlencode($category)) }}"
                        class="filter-pill px-4 py-2 rounded-full text-sm font-semibold transition
                        {{ ($selectedCategory ?? 'All') === $category
                            ? 'bg-primary text-on-primary'
                            : 'bg-surface-container-low text-on-surface-variant hover:text-primary' }}"
                    >
                        {{ $category }}
                    </a>
                @endforeach
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-7">
            @forelse ($photos as $photo)
                <article
                    class="photo-card bg-surface rounded-lg overflow-hidden border border-surface-variant shadow-sm hover:shadow-lg transition-all duration-300 group"
                    data-photo-reveal
                    data-photo-tilt
                    style="--photo-delay: {{ min($loop->index * 70, 420) }}ms;"
                >
                    <div class="photo-card-media aspect-[4/5] overflow-hidden bg-surface-container-high">
                        <a href="{{ url('/my-photography/' . $photo->id) }}">
                            <img
                                src="{{ asset('storage/' . $photo->image) }}"
                                alt="{{ $photo->title }}"
                                class="w-full h-full object-cover group-hover:scale-[1.03] transition-all duration-300"
                            >
                        </a>
                    </div>

                    <div class="p-5">
                        <h3 class="text-[24px] leading-tight font-bold text-on-background mb-2">
                            {{ $photo->title }}
                        </h3>

                        <p class="text-on-surface-variant text-sm mb-4">
                            {{ Str::limit($photo->description, 70) }}
                        </p>

                        <div class="flex items-center gap-5 text-sm">
                            <button
                                type="button"
                                onclick="toggleLike({{ $photo->id }})"
                                id="likeButton-{{ $photo->id }}"
                                class="photo-action flex items-center gap-1 transition-all duration-200
                                @auth
                                    {{ $photo->isLikedBy(Auth::user()) ? 'text-red-500' : 'text-on-surface-variant hover:text-red-500' }}
                                @else
                                    text-on-surface-variant hover:text-red-500
                                @endauth"
                            >
                                <span class="material-symbols-outlined text-[18px]">
                                    favorite
                                </span>

                                <span id="likeCount-{{ $photo->id }}">
                                    {{ $photo->likes_count ?? $photo->likes()->count() }}
                                </span>
                            </button>

                            <a
                                href="{{ url('/my-photography/' . $photo->id) }}"
                                class="photo-action flex items-center gap-1 text-on-surface-variant hover:text-primary transition-all duration-200"
                            >
                                <span class="material-symbols-outlined text-[18px]">
                                    chat_bubble
                                </span>

                                {{ $photo->comments_count ?? $photo->comments()->count() }}
                            </a>
                        </div>
                    </div>
                </article>
            @empty
                <div class="empty-gallery col-span-full bg-surface border border-surface-variant rounded-xl p-10 text-center" data-photo-reveal>
                    <span class="material-symbols-outlined text-primary text-[56px] mb-4">photo_library</span>
                    <h3 class="font-headline-md text-headline-md mb-2">
                        No photos yet
                    </h3>
                    <p class="text-on-surface-variant">
                        Photos uploaded by admin will appear here.
                    </p>
                </div>
            @endforelse
            </div>

        </div>
    </section>

</main>

<footer class="bg-surface py-8 border-t border-surface-variant text-center text-on-surface-variant">
    &copy; {{ date('Y') }} Nawaf Portfolio. All rights reserved.
</footer>

<div
    id="loginModal"
    class="fixed inset-0 z-[9999] hidden items-center justify-center bg-black/40 backdrop-blur-sm px-6"
>
    <div
        class="absolute inset-0"
        onclick="closeLoginModal()"
    ></div>

    <div class="relative w-full max-w-[420px] bg-surface rounded-xl border border-surface-variant shadow-[0_20px_60px_rgba(0,0,0,0.25)] p-8">
        <button
            type="button"
            onclick="closeLoginModal()"
            class="absolute top-4 right-4 text-on-surface-variant hover:text-primary transition"
        >
            <span class="material-symbols-outlined">close</span>
        </button>

        <div class="mb-5">
            <p class="font-label-sm text-label-sm text-primary uppercase tracking-widest mb-3">
                Login
            </p>

            <h2 class="font-headline-lg text-headline-lg text-on-background mb-3">
                Welcome Back
            </h2>

            <p class="text-on-surface-variant">
                Login to like photos and write comments.
            </p>
        </div>

        <form action="{{ route('login') }}" method="POST" class="space-y-3">
            @csrf
            <div>
                <label class="block font-label-sm text-label-sm text-on-background mb-2">
                    Email
                </label>
                <input
                    type="email"
                    name="email"
                    placeholder="your@email.com"
                    class="w-full rounded-lg border-outline bg-surface-container-low px-4 py-2.5"
                >
            </div>

            <div>
                <label class="block font-label-sm text-label-sm text-on-background mb-2">
                    Password
                </label>
                <input
                    type="password"
                    name="password"
                    placeholder="Enter your password"
                    class="w-full rounded-lg border-outline bg-surface-container-low px-4 py-2.5"
                >
            </div>

            <button
                type="submit"
                class="w-full bg-primary text-on-primary px-6 py-3 rounded-full font-label-sm text-label-sm hover:scale-[1.01] transition-all duration-200"
            >
                Login
            </button>
        </form>

        <p class="text-center text-on-surface-variant mt-6">
            Don't have an account?
            <button
                type="button"
                onclick="switchToRegisterModal()"
                class="text-primary font-semibold">
                    Register
            </button>
        </p>
    </div>
</div>

<div
    id="registerModal"
    class="fixed inset-0 z-[9999] hidden items-center justify-center bg-black/40 backdrop-blur-sm px-6"
>
    <div
        class="absolute inset-0"
        onclick="closeRegisterModal()"
    ></div>

    <div class="relative w-full max-w-[430px] max-h-[90vh] overflow-y-auto bg-surface rounded-xl border border-surface-variant shadow-[0_20px_60px_rgba(0,0,0,0.25)] p-6">
        <button
            type="button"
            onclick="closeRegisterModal()"
            class="absolute top-4 right-4 text-on-surface-variant hover:text-primary transition"
        >
            <span class="material-symbols-outlined">close</span>
        </button>

        <div class="mb-5">
            <p class="font-label-sm text-label-sm text-primary uppercase tracking-widest mb-3">
                Register
            </p>

            <h2 class="font-headline-lg text-headline-lg text-on-background mb-3">
                Create Account
            </h2>

            <p class="text-on-surface-variant">
                Register to like photos and comment with a random animal-fruit display name.
            </p>
        </div>

        <form action="{{ route('register') }}" method="POST" class="space-y-3">
            @csrf
            <div>
                <label class="block font-label-sm text-label-sm text-on-background mb-2">
                    Full Name
                </label>
                <input
                    type="text"
                    name="name"
                    placeholder="Your real name"
                    class="w-full rounded-lg border-outline bg-surface-container-low px-4 py-2.5"
                >
            </div>

            <div>
                <label class="block font-label-sm text-label-sm text-on-background mb-2">
                    Email
                </label>
                <input
                    type="email"
                    name="email"
                    placeholder="your@email.com"
                    class="w-full rounded-lg border-outline bg-surface-container-low px-4 py-2.5"
                >
            </div>

            <div>
                <label class="block font-label-sm text-label-sm text-on-background mb-2">
                    Password
                </label>
                <input
                    type="password"
                    name="password"
                    placeholder="Create password"
                    class="w-full rounded-lg border-outline bg-surface-container-low px-4 py-2.5"
                >
            </div>

            <div>
                <label class="block font-label-sm text-label-sm text-on-background mb-2">
                    Confirm Password
                </label>
                <input
                    type="password"
                    name="password_confirmation"
                    placeholder="Confirm password"
                    class="w-full rounded-lg border-outline bg-surface-container-low px-4 py-2.5"
                >
            </div>

            <div class="bg-surface-container-low rounded-xl p-3 text-on-surface-variant">
                <p class="font-semibold text-on-background mb-1">
                    Public Display Name
                </p>
                <p class="text-xs leading-relaxed">
                    After registration, your public name will be generated randomly, for example
                    <strong>Kucing Mangga</strong>, <strong>Panda Apel</strong>, or <strong>Koala Jeruk</strong>.
                </p>
            </div>

            <button
                type="submit"
                class="w-full bg-primary text-on-primary px-6 py-2.5 rounded-full font-label-sm text-label-sm hover:scale-[1.01] transition-all duration-200"
            >
                Register
            </button>
        </form>

        <p class="text-center text-on-surface-variant mt-6">
            Already have an account?
            <button
                type="button"
                onclick="switchToLoginModal()"
                class="text-primary font-semibold"
            >
                Login
            </button>
        </p>
    </div>
</div>

@auth
<div
    id="editProfileModal"
    class="fixed inset-0 z-[9999] hidden items-center justify-center bg-black/40 backdrop-blur-sm px-6"
>
    <div
        class="absolute inset-0"
        onclick="closeEditProfileModal()"
    ></div>

    <div class="relative w-full max-w-[430px] bg-surface rounded-xl border border-surface-variant shadow-[0_20px_60px_rgba(0,0,0,0.25)] p-6">
        <button
            type="button"
            onclick="closeEditProfileModal()"
            class="absolute top-4 right-4 text-on-surface-variant hover:text-primary transition"
        >
            <span class="material-symbols-outlined">close</span>
        </button>

        <div class="mb-6">
            <p class="font-label-sm text-label-sm text-primary uppercase tracking-widest mb-3">
                Profile
            </p>

            <h2 class="font-headline-lg text-headline-lg text-on-background mb-3">
                Edit Profile
            </h2>

            <p class="text-on-surface-variant">
                You can update your email and password here.
            </p>
        </div>

        <form action="{{ route('profile.update') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block font-label-sm text-label-sm text-on-background mb-2">
                    Display Name
                </label>
                <input
                    type="text"
                    value="{{ Auth::user()->display_name }}"
                    disabled
                    class="w-full rounded-lg border-outline bg-surface-container-low px-4 py-2.5 text-on-surface-variant"
                >
                <p class="text-xs text-on-surface-variant mt-1">
                    Display name is generated automatically.
                </p>
            </div>

            <div>
                <label class="block font-label-sm text-label-sm text-on-background mb-2">
                    Email
                </label>
                <input
                    type="email"
                    name="email"
                    value="{{ Auth::user()->email }}"
                    class="w-full rounded-lg border-outline bg-surface-container-low px-4 py-2.5"
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
                    class="w-full rounded-lg border-outline bg-surface-container-low px-4 py-2.5"
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
                    class="w-full rounded-lg border-outline bg-surface-container-low px-4 py-2.5"
                >
            </div>

            <button
                type="submit"
                class="w-full bg-primary text-on-primary px-6 py-2.5 rounded-full font-label-sm text-label-sm hover:scale-[1.01] transition-all duration-200"
            >
                Save Changes
            </button>
        </form>
    </div>
</div>
@auth
    @if (Auth::user()->role === 'admin')
        <div
            id="postModal"
            class="fixed inset-0 z-[9999] hidden items-center justify-center bg-black/40 backdrop-blur-sm px-6"
        >
            <div
                class="absolute inset-0"
                onclick="closePostModal()"
            ></div>

            <div class="relative w-full max-w-[560px] max-h-[90vh] overflow-y-auto bg-surface rounded-2xl border border-surface-variant shadow-[0_20px_60px_rgba(0,0,0,0.25)]">
                <div class="flex items-center justify-between px-6 py-4 border-b border-surface-variant">
                    <h3 class="font-headline-md text-headline-md text-on-background">
                        Create Post
                    </h3>

                    <button
                        type="button"
                        onclick="closePostModal()"
                        class="w-10 h-10 rounded-full bg-surface-container-low text-on-surface-variant hover:text-primary transition"
                    >
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>

                <form
                    action="{{ url('/admin/photos') }}"
                    method="POST"
                    enctype="multipart/form-data"
                    class="p-6 space-y-4"
                >
                    @csrf
                    <input type="hidden" name="redirect_to" value="/my-photography">

                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-full bg-primary text-on-primary flex items-center justify-center">
                            <span class="material-symbols-outlined text-[24px]">add_a_photo</span>
                        </div>

                        <div>
                            <p class="font-semibold text-on-background">
                                Admin Post
                            </p>
                            <p class="text-sm text-on-surface-variant">
                                Publish directly to your gallery
                            </p>
                        </div>
                    </div>

                    <input
                        type="text"
                        name="title"
                        placeholder="Photo title"
                        class="w-full rounded-xl border border-surface-variant bg-surface-container-low px-4 py-3 text-on-background"
                        required
                    >

                    <textarea
                        name="description"
                        rows="4"
                        placeholder="Write a short story behind this photo..."
                        class="w-full rounded-xl border border-surface-variant bg-surface-container-low px-4 py-3 text-on-background resize-none"
                    ></textarea>

                    <select
                        name="category"
                        class="w-full rounded-xl border border-surface-variant bg-surface-container-low px-4 py-3 text-on-background"
                    >
                        @foreach ($uploadCategories as $category)
                            <option value="{{ $category }}">
                                {{ $category }}
                            </option>
                        @endforeach
                    </select>

                    <input
                        type="file"
                        name="image"
                        accept="image/*"
                        class="w-full rounded-xl border border-surface-variant bg-surface-container-low px-4 py-3"
                        required
                    >

                    <button
                        type="submit"
                        class="w-full bg-primary text-on-primary px-6 py-3 rounded-xl font-semibold hover:scale-[1.01] transition"
                    >
                        Post Photo
                    </button>
                </form>
            </div>
        </div>
    @endif
@endauth
@endauth
<script>
    // Auto-open login modal if there are validation errors (after failed login)
    @if ($errors->has('email') || $errors->has('password'))
    document.addEventListener('DOMContentLoaded', function () {
        openLoginModal();
    });
    @endif

    function openLoginModal() {
        const loginModal = document.getElementById('loginModal');
        loginModal.classList.remove('hidden');
        loginModal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closeLoginModal() {
        const loginModal = document.getElementById('loginModal');
        loginModal.classList.remove('flex');
        loginModal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    function openRegisterModal() {
        const registerModal = document.getElementById('registerModal');
        registerModal.classList.remove('hidden');
        registerModal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closeRegisterModal() {
        const registerModal = document.getElementById('registerModal');
        registerModal.classList.remove('flex');
        registerModal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    function switchToRegisterModal() {
        closeLoginModal();
        openRegisterModal();
    }

    function switchToLoginModal() {
        closeRegisterModal();
        openLoginModal();
    }

    function toggleProfileMenu() {
        const menu = document.getElementById('profileMenu');
        menu.classList.toggle('hidden');
    }

    function openEditProfileModal() {
        const menu = document.getElementById('profileMenu');
        const modal = document.getElementById('editProfileModal');

        if (menu) {
            menu.classList.add('hidden');
        }

        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closeEditProfileModal() {
        const modal = document.getElementById('editProfileModal');

        modal.classList.remove('flex');
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    setTimeout(() => {
    const successToast = document.getElementById('toastSuccess');
    const errorToast = document.getElementById('toastError');

    if (successToast) {
        successToast.classList.add('opacity-0', 'translate-x-5');
        setTimeout(() => successToast.remove(), 500);
    }

    if (errorToast) {
        errorToast.classList.add('opacity-0', 'translate-x-5');
        setTimeout(() => errorToast.remove(), 500);
    }
}, 3000);

function toggleLike(photoId) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const likeButton = document.getElementById(`likeButton-${photoId}`);
    const likeCount = document.getElementById(`likeCount-${photoId}`);

    fetch(`/my-photography/${photoId}/like`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        },
    })
    .then(response => {
        if (response.status === 401) {
            openLoginModal();
            throw new Error('Please login first.');
        }

        return response.json();
    })
    .then(data => {
        if (data.success) {
            likeCount.textContent = data.likes_count;

            if (data.liked) {
                likeButton.classList.remove('text-on-surface-variant');
                likeButton.classList.add('text-red-500');
            } else {
                likeButton.classList.remove('text-red-500');
                likeButton.classList.add('text-on-surface-variant');
            }
        }
    })
    .catch(error => {
        console.log(error.message);
    });
}
function openPostModal() {
    const modal = document.getElementById('postModal');

    if (modal) {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }
}

function closePostModal() {
    const modal = document.getElementById('postModal');

    if (modal) {
        modal.classList.remove('flex');
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
}



</script>
@endsection
