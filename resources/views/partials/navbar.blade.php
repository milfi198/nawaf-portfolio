{{--
    Shared Navbar Partial
    Usage: @include('partials.navbar', ['navType' => 'home'])
    $navType options: 'home' | 'photography' | 'show'
--}}
@php $navType = $navType ?? 'photography'; @endphp

<nav class="fixed top-0 left-0 w-full h-[72px] z-50 bg-surface/80 backdrop-blur-lg border-b border-surface-variant shadow-[0_4px_20px_rgba(0,0,0,0.05)]">
    <div class="flex justify-between items-center px-8 md:px-12 max-w-[1280px] mx-auto w-full h-full">

        {{-- Logo --}}
        @if ($navType === 'home')
            <div class="font-headline-md text-headline-md font-bold tracking-tighter text-on-background">
                Portfolio
            </div>
        @elseif ($navType === 'show')
            <a href="{{ url('/my-photography') }}" class="inline-flex items-center gap-2 text-primary font-label-sm text-label-sm">
                <span class="material-symbols-outlined text-[20px]">arrow_back</span>
                Back to Gallery
            </a>
        @else
            <a href="{{ url('/') }}" class="font-headline-md text-headline-md font-bold tracking-tighter text-on-background">
                Nawaf Milfi
            </a>
        @endif

        {{-- Desktop Nav Links --}}
        <div class="hidden md:flex gap-8 items-center font-label-sm text-label-sm font-medium tracking-wide">
            @if ($navType === 'home')
                <a class="nav-link text-primary border-b-2 border-primary pb-1 hover:text-primary transition-all duration-200 cursor-pointer" href="#home">Home</a>
                <a class="nav-link text-on-surface-variant border-b-2 border-transparent pb-1 hover:text-primary transition-all duration-200 cursor-pointer" href="#about">About</a>
                <a class="nav-link text-on-surface-variant border-b-2 border-transparent pb-1 hover:text-primary transition-all duration-200 cursor-pointer" href="#projects">Project</a>
                <a class="nav-link text-on-surface-variant border-b-2 border-transparent pb-1 hover:text-primary transition-all duration-200 cursor-pointer" href="#contact">Contact</a>
                <a class="text-on-surface-variant border-b-2 border-transparent pb-1 hover:text-primary transition-all duration-200 cursor-pointer" href="{{ url('/my-photography') }}">My Photography</a>
            @else
                <a class="text-on-surface-variant hover:text-primary transition-all duration-200 cursor-pointer" href="{{ url('/#home') }}">Home</a>
                <a class="text-on-surface-variant hover:text-primary transition-all duration-200 cursor-pointer" href="{{ url('/#about') }}">About</a>
                <a class="text-on-surface-variant hover:text-primary transition-all duration-200 cursor-pointer" href="{{ url('/#projects') }}">Project</a>
                <a class="text-on-surface-variant hover:text-primary transition-all duration-200 cursor-pointer" href="{{ url('/#contact') }}">Contact</a>
                <a class="text-primary border-b-2 border-primary pb-1 transition-all duration-200 cursor-pointer" href="{{ url('/my-photography') }}">My Photography</a>
            @endif
        </div>

        {{-- Right Side: Contact Button (home) or Auth Section (photography/show) --}}
        @if ($navType === 'home')
            <a href="#contact" class="hidden md:block bg-primary text-on-primary px-6 py-2 rounded-full font-label-sm text-label-sm hover:scale-105 transition-all duration-200 shadow-[0_4px_20px_rgba(0,0,0,0.05)]">
                Hit Me Up!
            </a>
        @else
            @auth
                @php
                    $animal = explode(' ', Auth::user()->display_name)[0] ?? 'User';
                    $avatars = [
                        'Kucing' => '🐱', 'Panda' => '🐼', 'Koala' => '🐨',
                        'Rubah' => '🦊', 'Elang' => '🦅', 'Kelinci' => '🐰',
                        'Harimau' => '🐯', 'Serigala' => '🐺', 'Burung' => '🐦',
                        'Kura-kura' => '🐢',
                    ];
                    $avatar = $avatars[$animal] ?? '👤';
                @endphp

                <div class="relative hidden md:block">
                    <button
                        type="button"
                        onclick="toggleProfileMenu()"
                        class="flex items-center gap-3 bg-primary text-on-primary px-4 py-2 rounded-full font-label-sm text-label-sm hover:scale-105 transition-all duration-200 shadow-[0_4px_20px_rgba(0,0,0,0.05)]"
                    >
                        <span class="w-8 h-8 rounded-full bg-white text-xl flex items-center justify-center">
                            @if (Auth::user()->role === 'admin')
                                <span class="material-symbols-outlined text-primary text-[20px]">admin_panel_settings</span>
                            @else
                                {{ $avatar }}
                            @endif
                        </span>
                        <span>
                            @if (Auth::user()->role === 'admin') Admin @else {{ Auth::user()->display_name }} @endif
                        </span>
                        <span class="material-symbols-outlined text-[18px]">expand_more</span>
                    </button>

                    <div id="profileMenu" class="hidden absolute right-0 mt-3 w-56 bg-surface border border-surface-variant rounded-xl shadow-[0_20px_60px_rgba(0,0,0,0.18)] overflow-hidden z-[999]">
                        @if (Auth::user()->role === 'admin')
                            <a href="{{ url('/admin/dashboard') }}" class="flex items-center gap-2 px-5 py-3 hover:bg-surface-container-low transition-all duration-200">
                                <span class="material-symbols-outlined text-[20px]">dashboard</span>
                                Dashboard
                            </a>
                        @else
                            <button type="button" onclick="openEditProfileModal()" class="w-full text-left px-5 py-3 hover:bg-surface-container-low transition-all duration-200">
                                Edit Profile
                            </button>
                        @endif

                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-2 px-5 py-3 text-red-600 hover:bg-red-50 transition-all duration-200">
                                <span class="material-symbols-outlined text-[20px]">logout</span>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <button
                    type="button"
                    onclick="openLoginModal()"
                    class="hidden md:block bg-primary text-on-primary px-6 py-2 rounded-full font-label-sm text-label-sm hover:scale-105 transition-all duration-200 shadow-[0_4px_20px_rgba(0,0,0,0.05)]"
                >
                    Login
                </button>
            @endauth
        @endif

        {{-- Hamburger Button --}}
        <button type="button" onclick="toggleMobileMenu()" class="md:hidden text-on-background">
            <span id="mobileMenuIcon" class="material-symbols-outlined">menu</span>
        </button>

    </div>
</nav>

{{-- Mobile Menu Dropdown --}}
<div id="mobileMenu" class="fixed top-[84px] right-4 w-[280px] max-h-[calc(100vh-100px)] overflow-y-auto z-50 hidden bg-surface border border-surface-variant rounded-2xl shadow-2xl md:hidden">
    <div class="flex flex-col px-6 py-6 gap-2 font-label-sm text-label-sm font-medium">

        @if ($navType === 'home')
            <a href="#home" onclick="toggleMobileMenu()" class="px-4 py-3 rounded-xl text-on-surface-variant hover:bg-surface-container-low hover:text-primary transition-all">Home</a>
            <a href="#about" onclick="toggleMobileMenu()" class="px-4 py-3 rounded-xl text-on-surface-variant hover:bg-surface-container-low hover:text-primary transition-all">About</a>
            <a href="#projects" onclick="toggleMobileMenu()" class="px-4 py-3 rounded-xl text-on-surface-variant hover:bg-surface-container-low hover:text-primary transition-all">Project</a>
            <a href="#contact" onclick="toggleMobileMenu()" class="px-4 py-3 rounded-xl text-on-surface-variant hover:bg-surface-container-low hover:text-primary transition-all">Contact</a>
            <a href="{{ url('/my-photography') }}" class="px-4 py-3 rounded-xl text-primary font-semibold hover:bg-surface-container-low transition-all">My Photography</a>

            <div class="pt-4 mt-2 border-t border-surface-variant">
                <a href="#contact" onclick="toggleMobileMenu()" class="block w-full bg-primary text-on-primary px-5 py-3 rounded-xl font-semibold text-center hover:scale-[1.02] transition-all shadow-[0_4px_20px_rgba(0,0,0,0.05)]">
                    Contact Me
                </a>
            </div>
        @else
            <a href="{{ url('/#home') }}" class="px-4 py-3 rounded-xl text-on-surface-variant hover:bg-surface-container-low hover:text-primary transition-all">Home</a>
            <a href="{{ url('/#about') }}" class="px-4 py-3 rounded-xl text-on-surface-variant hover:bg-surface-container-low hover:text-primary transition-all">About</a>
            <a href="{{ url('/#projects') }}" class="px-4 py-3 rounded-xl text-on-surface-variant hover:bg-surface-container-low hover:text-primary transition-all">Project</a>
            <a href="{{ url('/#contact') }}" class="px-4 py-3 rounded-xl text-on-surface-variant hover:bg-surface-container-low hover:text-primary transition-all">Contact</a>
            <a href="{{ url('/my-photography') }}" class="px-4 py-3 rounded-xl text-primary font-semibold hover:bg-surface-container-low transition-all">My Photography</a>

            <div class="pt-4 mt-2 border-t border-surface-variant">
                @auth
                    @php
                        $animal = explode(' ', Auth::user()->display_name)[0] ?? 'User';
                        $avatars = [
                            'Kucing' => '🐱', 'Panda' => '🐼', 'Koala' => '🐨',
                            'Rubah' => '🦊', 'Elang' => '🦅', 'Kelinci' => '🐰',
                            'Harimau' => '🐯', 'Serigala' => '🐺', 'Burung' => '🐦',
                            'Kura-kura' => '🐢',
                        ];
                        $avatar = $avatars[$animal] ?? '👤';
                    @endphp

                    <div class="flex items-center gap-4 px-4 py-3 mb-2 bg-surface-container-low rounded-xl">
                        <div class="w-12 h-12 rounded-full bg-white text-2xl flex items-center justify-center shadow-sm">
                            @if (Auth::user()->role === 'admin')
                                <span class="material-symbols-outlined text-primary text-[24px]">admin_panel_settings</span>
                            @else
                                {{ $avatar }}
                            @endif
                        </div>
                        <div class="flex flex-col">
                            <span class="font-semibold text-on-background text-base">
                                @if (Auth::user()->role === 'admin') Admin @else {{ Auth::user()->display_name }} @endif
                            </span>
                            <span class="text-xs text-on-surface-variant">My Account</span>
                        </div>
                    </div>

                    @if (Auth::user()->role === 'admin')
                        <a href="{{ url('/admin/dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-on-surface-variant hover:bg-surface-container-low hover:text-primary transition-all">
                            <span class="material-symbols-outlined text-[20px]">dashboard</span>
                            Dashboard
                        </a>
                    @else
                        <button type="button" onclick="openEditProfileModal(); toggleMobileMenu();" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-on-surface-variant hover:bg-surface-container-low hover:text-primary transition-all text-left">
                            <span class="material-symbols-outlined text-[20px]">manage_accounts</span>
                            Edit Profile
                        </button>
                    @endif

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-red-600 hover:bg-red-50 transition-all text-left font-semibold">
                            <span class="material-symbols-outlined text-[20px]">logout</span>
                            Logout
                        </button>
                    </form>
                @else
                    <button type="button" onclick="openLoginModal(); toggleMobileMenu();" class="w-full bg-primary text-on-primary px-5 py-3 rounded-xl font-semibold hover:scale-[1.02] transition-all shadow-[0_4px_20px_rgba(0,0,0,0.05)]">
                        Login
                    </button>
                @endauth
            </div>
        @endif

    </div>
</div>

<script>
    function toggleMobileMenu() {
        const menu = document.getElementById('mobileMenu');
        const icon = document.getElementById('mobileMenuIcon');
        if (!menu) return;
        menu.classList.toggle('hidden');
        if (icon) {
            icon.textContent = menu.classList.contains('hidden') ? 'menu' : 'close';
        }
    }

    function toggleProfileMenu() {
        const menu = document.getElementById('profileMenu');
        if (menu) menu.classList.toggle('hidden');
    }

    @if ($navType === 'home')
    const navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
        link.addEventListener('click', function () {
            navLinks.forEach(item => {
                item.classList.remove('text-primary', 'border-primary');
                item.classList.add('text-on-surface-variant', 'border-transparent');
            });
            this.classList.remove('text-on-surface-variant', 'border-transparent');
            this.classList.add('text-primary', 'border-primary');
        });
    });
    @endif
</script>
