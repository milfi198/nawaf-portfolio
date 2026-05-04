@extends('layouts.app')

@section('title', 'Photo Detail')

@push('styles')
    <link href="{{ asset('css/photography-animations.css') }}" rel="stylesheet">
@endpush

@push('head-scripts')
    <script src="{{ asset('js/photography-animations.js') }}"></script>
@endpush

@section('content')

@include('partials.navbar', ['navType' => 'show'])

<style>
    .detail-photo-toggle {
        transition:
            background-color 200ms ease,
            transform 260ms cubic-bezier(0.22, 1, 0.36, 1);
    }

    .detail-photo-toggle:hover {
        transform: translateY(-2px);
    }

    .detail-photo-toggle.is-expanded {
        transform: rotate(180deg);
    }

    .detail-photo-toggle.is-expanded:hover {
        transform: rotate(180deg) translateY(2px);
    }

    #expandIcon {
        transition: transform 260ms cubic-bezier(0.22, 1, 0.36, 1);
    }
</style>

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

    <section class="pt-4 md:pt-6 pb-12">
        <div class="max-w-[720px] mx-auto px-5 md:px-0">
            <div class="photo-detail-shell bg-surface rounded-xl border border-surface-variant shadow-sm overflow-hidden" data-photo-reveal>
                <div id="photoWrapper" class="detail-photo-frame relative h-[200px] md:h-[280px] bg-surface-container-high overflow-hidden transition-[height,box-shadow] duration-500 ease-[cubic-bezier(0.22,1,0.36,1)]">
                    <img
                        id="detailPhoto"
                        src="{{ asset('storage/' . $photo->image) }}"
                        alt="{{ $photo->title }}"
                        class="w-full h-full object-cover object-center transition-all duration-500 ease-in-out"
                    >

                    <button
                        id="expandPhotoButton"
                        type="button"
                        onclick="togglePhotoExpand()"
                        class="detail-photo-toggle absolute bottom-4 right-4 w-11 h-11 rounded-full bg-black/60 text-white flex items-center justify-center backdrop-blur-sm hover:bg-primary"
                        title="Show full photo"
                        aria-expanded="false"
                    >
                        <span id="expandIcon" class="material-symbols-outlined">
                            keyboard_arrow_down
                        </span>
                    </button>
                </div>

                <div class="p-6 md:p-10">
                    <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-6 mb-8" data-photo-reveal="left">
                        <div>
                            <p class="font-label-sm text-label-sm text-primary uppercase tracking-widest mb-3">
                                Photo Detail
                            </p>

                            <h1 class="font-headline-lg text-headline-lg text-on-background mb-4">
                                {{ $photo->title }}
                            </h1>

                            <p class="text-on-surface-variant max-w-2xl">
                                {{ $photo->description }}
                            </p>
                        </div>

                        <button
                            type="button"
                            onclick="toggleDetailLike({{ $photo->id }})"
                            id="detailLikeButton-{{ $photo->id }}"
                            class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-full font-label-sm text-label-sm hover:scale-105 transition-all duration-200
                            @auth
                                {{ $photo->isLikedBy(Auth::user()) ? 'bg-red-500 text-white' : 'bg-primary text-on-primary' }}
                            @else
                                bg-primary text-on-primary
                            @endauth"
                        >
                            <span class="material-symbols-outlined text-[20px]">
                                favorite
                            </span>

                            <span id="detailLikeText-{{ $photo->id }}">
                                @auth
                                    @if ($photo->isLikedBy(Auth::user()))
                                        Liked
                                    @else
                                        Like Photo
                                    @endif
                                @else
                                    Like Photo
                                @endauth
                            </span>
                        </button>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-10">
                        <div class="photo-stat bg-surface-container-low rounded-xl p-4" data-photo-reveal style="--photo-delay: 80ms;">
                            <p class="text-on-surface-variant text-sm">Likes</p>
                            <p id="detailLikeCount-{{ $photo->id }}" class="font-headline-md text-headline-md">
                                {{ $photo->likes()->count() }}
                            </p>
                        </div>

                        <div class="photo-stat bg-surface-container-low rounded-xl p-4" data-photo-reveal style="--photo-delay: 140ms;">
                            <p class="text-on-surface-variant text-sm">Comments</p>
                            <p id="detailCommentCount-{{ $photo->id }}" class="font-headline-md text-headline-md">
                                {{ $photo->comments()->count() }}
                            </p>
                        </div>

                        <div class="photo-stat bg-surface-container-low rounded-xl p-4" data-photo-reveal style="--photo-delay: 200ms;">
                            <p class="text-on-surface-variant text-sm">Category</p>
                            <p class="font-semibold">{{ $photo->category ?? '-' }}</p>
                        </div>

                        <div class="photo-stat bg-surface-container-low rounded-xl p-4" data-photo-reveal style="--photo-delay: 260ms;">
                            <p class="text-on-surface-variant text-sm">Uploaded</p>
                            <p class="font-semibold">{{ $photo->created_at->format('d M Y') }}</p>
                        </div>
                    </div>

                    <div class="border-t border-surface-variant pt-8" data-photo-reveal>
                        <h2 class="font-headline-md text-headline-md mb-6">
                            Comments
                        </h2>

                        <div id="commentsList" class="space-y-4 mb-8">
                            @forelse ($photo->comments()->with('user')->latest()->get() as $comment)
                                <div id="comment-{{ $comment->id }}" class="comment-card bg-surface-container-low rounded-xl p-5" data-photo-reveal>
                                    <div class="flex items-start justify-between gap-4">
                                        <div class="flex items-center gap-3 mb-3">
                                            @php
                                                $commentAnimal = explode(' ', $comment->user->display_name ?? '')[0] ?? 'User';

                                                $commentAvatars = [
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

                                                $commentAvatar = $commentAvatars[$commentAnimal] ?? '👤';
                                            @endphp

                                            <div class="w-10 h-10 rounded-full bg-primary/10 text-xl flex items-center justify-center">
                                                @if ($comment->user->role === 'admin')
                                                    <span class="material-symbols-outlined text-primary text-[22px]">admin_panel_settings</span>
                                                @else
                                                    {{ $commentAvatar }}
                                                @endif
                                            </div>

                                            <div>
                                                <p class="font-semibold">
                                                    @if ($comment->user->role === 'admin')
                                                        Admin
                                                    @else
                                                        {{ $comment->user->display_name }}
                                                    @endif
                                                </p>
                                                <p class="text-sm text-on-surface-variant">
                                                    {{ $comment->created_at->diffForHumans() }}
                                                </p>
                                            </div>
                                        </div>

                                        @auth
                                            @if ($comment->user_id === Auth::id())
                                                <button
                                                    type="button"
                                                    onclick="deleteComment({{ $comment->id }})"
                                                    class="text-red-500 hover:text-red-700 transition-all duration-200"
                                                >
                                                    <span class="material-symbols-outlined text-[20px]">delete</span>
                                                </button>
                                            @endif
                                        @endauth
                                    </div>

                                    <p class="text-on-surface-variant">
                                        {{ $comment->body }}
                                    </p>
                                </div>
                            @empty
                                <div id="noCommentsMessage" class="comment-card bg-surface-container-low rounded-xl p-5 text-center" data-photo-reveal>
                                    <p class="text-on-surface-variant">
                                        No comments yet. Be the first to comment.
                                    </p>
                                </div>
                            @endforelse
                        </div>

                        @auth
                            <form id="commentForm" class="comment-panel bg-surface-container-low rounded-xl p-5" data-photo-reveal>
                                @csrf

                                <label class="block font-semibold mb-3">
                                    Leave a comment
                                </label>

                                <textarea
                                    id="commentBody"
                                    name="body"
                                    class="w-full rounded-lg border-outline bg-surface mb-4"
                                    rows="4"
                                    placeholder="Write your comment..."
                                ></textarea>

                                <button type="submit" class="bg-primary text-on-primary px-6 py-3 rounded-full font-label-sm text-label-sm">
                                    Send Comment
                                </button>

                                <p class="text-sm text-on-surface-variant mt-3">
                                    Commenting as
                                    @if (Auth::user()->role === 'admin')
                                        Admin.
                                    @else
                                        {{ Auth::user()->display_name }}.
                                    @endif
                                </p>
                            </form>
                        @else
                            <div class="comment-panel bg-surface-container-low rounded-xl p-5" data-photo-reveal>
                                <label class="block font-semibold mb-3">
                                    Leave a comment
                                </label>

                                <textarea
                                    disabled
                                    class="w-full rounded-lg border-outline bg-surface mb-4 cursor-not-allowed opacity-70"
                                    rows="4"
                                    placeholder="Login first to write a comment..."
                                ></textarea>

                                <button
                                    type="button"
                                    onclick="openLoginModal()"
                                    class="inline-flex bg-primary text-on-primary px-6 py-3 rounded-full font-label-sm text-label-sm hover:scale-105 transition-all duration-200"
                                >Login to Comment
                                </button>

                                <p class="text-sm text-on-surface-variant mt-3">
                                    You can read comments, but you need to login before writing one.
                                </p>
                            </div>
                        @endauth
                    </div>
                </div>
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
            <input type="hidden" name="redirect_to" value="{{ request()->getRequestUri() }}">

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
            <button type="button" onclick="switchToRegisterModal()" class="text-primary font-semibold">
                Register here
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
            <input type="hidden" name="redirect_to" value="{{ request()->getRequestUri() }}">

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
@endauth
<script>
    let isPhotoExpanded = false;

    @if ($errors->any())
    document.addEventListener('DOMContentLoaded', function () {
        @if (old('name'))
            openRegisterModal();
        @else
            openLoginModal();
        @endif
    });
    @endif

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

    function togglePhotoExpand() {
        const wrapper = document.getElementById('photoWrapper');
        const photo = document.getElementById('detailPhoto');
        const button = document.getElementById('expandPhotoButton');

        if (!wrapper || !photo || !button) return;

        const setCollapsedHeight = () => {
            wrapper.style.height = window.innerWidth >= 768 ? '280px' : '200px';
        };

        if (!isPhotoExpanded) {
            wrapper.style.height = `${wrapper.offsetHeight}px`;

            photo.classList.remove('h-full', 'object-cover');
            photo.classList.add('h-auto', 'object-contain', 'mx-auto');

            requestAnimationFrame(() => {
                wrapper.style.height = `${photo.scrollHeight}px`;
            });

            wrapper.addEventListener('transitionend', function handleOpen(event) {
                if (event.propertyName !== 'height') return;

                wrapper.style.height = 'auto';
                wrapper.removeEventListener('transitionend', handleOpen);
            });

            button.classList.add('is-expanded');
            button.setAttribute('aria-expanded', 'true');
            button.setAttribute('title', 'Hide full photo');
            isPhotoExpanded = true;
        } else {
            wrapper.style.height = `${wrapper.scrollHeight}px`;

            requestAnimationFrame(setCollapsedHeight);

            photo.classList.remove('h-auto', 'object-contain', 'mx-auto');
            photo.classList.add('h-full', 'object-cover');

            wrapper.addEventListener('transitionend', function handleClose(event) {
                if (event.propertyName !== 'height') return;

                wrapper.style.height = '';
                wrapper.removeEventListener('transitionend', handleClose);
            });

            button.classList.remove('is-expanded');
            button.setAttribute('aria-expanded', 'false');
            button.setAttribute('title', 'Show full photo');
            isPhotoExpanded = false;
        }
    }


    function toggleDetailLike(photoId) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const likeButton = document.getElementById(`detailLikeButton-${photoId}`);
    const likeText = document.getElementById(`detailLikeText-${photoId}`);
    const likeCount = document.getElementById(`detailLikeCount-${photoId}`);

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
                likeButton.classList.remove('bg-primary', 'text-on-primary');
                likeButton.classList.add('bg-red-500', 'text-white');
                likeText.textContent = 'Liked';
            } else {
                likeButton.classList.remove('bg-red-500', 'text-white');
                likeButton.classList.add('bg-primary', 'text-on-primary');
                likeText.textContent = 'Like Photo';
            }
        }
    })
    .catch(error => {
        console.log(error.message);
    });
}

const commentForm = document.getElementById('commentForm');

if (commentForm) {
    commentForm.addEventListener('submit', function (event) {
        event.preventDefault();

        submitComment({{ $photo->id }});
    });
}

function submitComment(photoId) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const commentBody = document.getElementById('commentBody');
    const commentsList = document.getElementById('commentsList');
    const commentCount = document.getElementById(`detailCommentCount-${photoId}`);

    fetch(`/my-photography/${photoId}/comments`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            body: commentBody.value
        })
    })
    .then(response => {
        if (response.status === 401) {
            window.location.href = '/my-photography';
            throw new Error('Please login first.');
        }

        return response.json();
    })
    .then(data => {
        if (data.success) {
            const noCommentsMessage = document.getElementById('noCommentsMessage');

            if (noCommentsMessage) {
                noCommentsMessage.remove();
            }

            const commentHtml = `
                <div id="comment-${data.comment.id}" class="comment-card bg-surface-container-low rounded-xl p-5 is-visible" data-photo-reveal>
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 rounded-full bg-primary/10 text-xl flex items-center justify-center">
                                ${data.comment.is_admin
                                    ? '<span class="material-symbols-outlined text-primary text-[22px]">admin_panel_settings</span>'
                                    : data.comment.avatar
                                }
                            </div>

                            <div>
                                <p class="font-semibold flex items-center gap-2">
                                    ${data.comment.display_name}
                                    ${data.comment.is_admin
                                        ? '<span class="inline-flex px-2 py-0.5 rounded-full bg-primary text-on-primary text-xs font-semibold">Owner</span>'
                                        : ''
                                    }
                                </p>
                                <p class="text-sm text-on-surface-variant">
                                    ${data.comment.time}
                                </p>
                            </div>
                        </div>

                        <button
                            type="button"
                            onclick="deleteComment(${data.comment.id})"
                            class="text-red-500 hover:text-red-700 transition-all duration-200"
                        >
                            <span class="material-symbols-outlined text-[20px]">delete</span>
                        </button>
                    </div>

                    <p class="text-on-surface-variant">
                        ${escapeHtml(data.comment.body)}
                    </p>
                </div>
            `;

            commentsList.insertAdjacentHTML('afterbegin', commentHtml);
            commentCount.textContent = data.comments_count;
            commentBody.value = '';
        }
    })
    .catch(error => {
        console.log(error.message);
    });
}

function deleteComment(commentId) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const commentElement = document.getElementById(`comment-${commentId}`);
    const commentCount = document.getElementById(`detailCommentCount-{{ $photo->id }}`);

    fetch(`/comments/${commentId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (commentElement) {
                commentElement.remove();
            }

            commentCount.textContent = data.comments_count;

            const commentsList = document.getElementById('commentsList');

            if (data.comments_count === 0) {
                commentsList.innerHTML = `
                    <div id="noCommentsMessage" class="comment-card bg-surface-container-low rounded-xl p-5 text-center is-visible" data-photo-reveal>
                        <p class="text-on-surface-variant">
                            No comments yet. Be the first to comment.
                        </p>
                    </div>
                `;
            }
        }
    })
    .catch(error => {
        console.log(error.message);
    });
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function openLoginModal() {
    const loginModal = document.getElementById('loginModal');

    if (loginModal) {
        loginModal.classList.remove('hidden');
        loginModal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }
}

function closeLoginModal() {
    const loginModal = document.getElementById('loginModal');

    if (loginModal) {
        loginModal.classList.remove('flex');
        loginModal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
}

function openRegisterModal() {
    const registerModal = document.getElementById('registerModal');

    if (registerModal) {
        registerModal.classList.remove('hidden');
        registerModal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }
}

function closeRegisterModal() {
    const registerModal = document.getElementById('registerModal');

    if (registerModal) {
        registerModal.classList.remove('flex');
        registerModal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
}

function switchToRegisterModal() {
    closeLoginModal();
    openRegisterModal();
}

function switchToLoginModal() {
    closeRegisterModal();
    openLoginModal();
}

function openEditProfileModal() {
    const menu = document.getElementById('profileMenu');
    const modal = document.getElementById('editProfileModal');

    if (menu) {
        menu.classList.add('hidden');
    }

    if (modal) {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }
}

function closeEditProfileModal() {
    const modal = document.getElementById('editProfileModal');

    if (modal) {
        modal.classList.remove('flex');
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
}
</script>
@endsection
