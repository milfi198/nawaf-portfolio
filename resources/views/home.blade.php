@extends('layouts.app')

@section('title', "Nawaf Milfi M")

@push('styles')
    <link href="{{ asset('css/home-animations.css') }}" rel="stylesheet">
@endpush

@push('head-scripts')
    <script src="{{ asset('js/home-animations.js') }}"></script>
@endpush

@section('content')

@include('partials.navbar', ['navType' => 'home'])


<main class="pt-[72px] home-animated">

    <section id="home" class="home-hero max-w-[1280px] mx-auto px-8 md:px-12 pt-10 md:pt-14 pb-16">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-10 md:gap-14 items-start">
        <div class="flex flex-col gap-8 pt-4 md:pt-8" data-animate="fade-right">
            <div>
                <p class="font-label-sm text-label-sm text-primary mb-4 uppercase tracking-widest" data-animate style="--delay: 80ms;">
                    WELCOME TO MY SITE
                </p>

                <h1 class="text-[48px] md:text-[64px] leading-[1.05] font-bold text-on-background mb-6" data-animate style="--delay: 160ms;">
                    Hi, I'm <span class="text-primary">Nawaf</span>
                </h1>

                <p class="text-[17px] md:text-[18px] leading-relaxed text-on-surface-variant max-w-xl" data-animate style="--delay: 240ms;">
                    With a background in informatics, I focus on developing skills in web development, mobile app development, and UI design. I enjoy building useful digital products and documenting moments through visual stories.
                </p>
            </div>

            <div class="flex gap-4 flex-wrap" data-animate style="--delay: 320ms;">
                <a
                    href="{{ asset('cv\CV_Nawaf_Milfi_M.pdf') }}"
                    download
                    class="kinetic-link bg-primary text-on-primary px-8 py-3 rounded-full font-label-sm text-label-sm shadow-[0_4px_20px_rgba(0,0,0,0.05)] hover:scale-105 transition-all duration-200"
                > Download CV
                </a>

                <a href="#projects" class="border border-outline text-on-background px-8 py-3 rounded-full font-label-sm text-label-sm hover:border-primary hover:text-primary hover:-translate-y-1 transition-all duration-200">
                    View Project
                </a>
            </div>

            <div class="grid grid-cols-3 gap-4 max-w-[420px]" data-animate style="--delay: 420ms;">
                <div class="stat-card border border-surface-variant bg-surface rounded-xl p-2">
                    <p class="text-2xl font-bold text-on-background">3+</p>
                    <p class="text-sm text-on-surface-variant">Projects</p>
                </div>
            </div>
        </div>

        <div class="profile-stage relative w-full max-w-[420px] mx-auto" data-animate="fade-left" style="--delay: 260ms;">
            <div class="profile-frame relative aspect-[4/5] rounded-xl overflow-hidden shadow-[0_20px_60px_rgba(0,0,0,0.10)] group bg-surface-container" data-tilt-card>
                <img
                    src="{{ asset('images\nawaf.jpg') }}"
                    alt="Nawaf Profile Photo"
                    class="w-full h-full object-cover scale-[1.02] transition-transform duration-500 group-hover:scale-[1.07]"
                >
                <div class="absolute inset-0 border border-black/5 rounded-xl pointer-events-none"></div>
            </div>

            <span class="motion-chip chip-code">
                <span class="material-symbols-outlined">code</span>
                Laravel
            </span>
            <span class="motion-chip chip-ui">
                <span class="material-symbols-outlined">palette</span>
                UI Design
            </span>
            <span class="motion-chip chip-camera">
                <span class="material-symbols-outlined">photo_camera</span>
                Photography
            </span>
        </div>
    </div>
</section>

    <section id="about" class="bg-surface-container-low py-section-padding">
        <div class="max-w-[1280px] mx-auto px-8 md:px-12">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-12">
                <div class="md:col-span-5" data-animate="fade-right">
                    <h2 class="font-headline-lg text-headline-lg text-on-background mb-stack-sm">
                        About Me
                    </h2>
                    <div class="w-12 h-1 bg-primary mb-stack-md rounded-full"></div>

                    <p class="font-body-md text-body-md text-on-surface-variant mb-4">
                        I am  currently improving my skills in web development, mobile app development, UI design, and content creation.
                    </p>

                    <p class="font-body-md text-body-md text-on-surface-variant">
                        I enjoy building useful digital products and documenting moments through photography.
                    </p>
                </div>

                <div class="md:col-span-7 grid grid-cols-1 sm:grid-cols-2 gap-gutter">
                    <div class="animated-card bg-surface p-6 rounded-xl border border-surface-variant shadow-sm" data-animate style="--delay: 80ms;">
                        <span class="material-symbols-outlined text-primary text-[32px] mb-4">code</span>
                        <h3 class="font-headline-md text-headline-md mb-2">Web Development</h3>
                        <p class="text-on-surface-variant">Building responsive and functional websites.</p>
                    </div>

                    <div class="animated-card bg-surface p-6 rounded-xl border border-surface-variant shadow-sm" data-animate style="--delay: 160ms;">
                        <span class="material-symbols-outlined text-primary text-[32px] mb-4">phone_iphone</span>
                        <h3 class="font-headline-md text-headline-md mb-2">Mobile Development</h3>
                        <p class="text-on-surface-variant">Creating mobile app, especially with Flutter.</p>
                    </div>

                    <div class="animated-card bg-surface p-6 rounded-xl border border-surface-variant shadow-sm" data-animate style="--delay: 240ms;">
                        <span class="material-symbols-outlined text-primary text-[32px] mb-4">palette</span>
                        <h3 class="font-headline-md text-headline-md mb-2">UI Design</h3>
                        <p class="text-on-surface-variant">Designing clean interfaces with attention to usability and layout.</p>
                    </div>

                    <div class="animated-card bg-surface p-6 rounded-xl border border-surface-variant shadow-sm" data-animate style="--delay: 320ms;">
                        <span class="material-symbols-outlined text-primary text-[32px] mb-4">photo_camera</span>
                        <h3 class="font-headline-md text-headline-md mb-2">Photography</h3>
                        <p class="text-on-surface-variant">Capturing moments and presenting them through a personal gallery.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="projects" class="pt-10 md:pt-12 pb-section-padding scroll-mt-[90px]">
        <div class="max-w-[1280px] mx-auto px-8 md:px-12">
            <div class="flex justify-between items-end mb-10 flex-wrap gap-6" data-animate>
                <div>
                    <p class="font-label-sm text-label-sm text-primary mb-3 uppercase tracking-widest">
                        My Work
                    </p>
                    <h2 class="font-headline-lg text-headline-lg text-on-background">
                        Selected Projects
                    </h2>
                </div>

                <a href="#contact" class="text-primary font-label-sm text-label-sm hover:underline">
                    Let's collaborate
                </a>
            </div>

            <div class="project-carousel-shell">
                <div class="project-carousel-controls" aria-label="Project carousel controls">
                    <button type="button" class="project-carousel-button" data-project-prev aria-label="Previous project">
                        <span class="material-symbols-outlined text-[28px]">chevron_left</span>
                    </button>

                    <button type="button" class="project-carousel-button" data-project-next aria-label="Next project">
                        <span class="material-symbols-outlined text-[28px]">chevron_right</span>
                    </button>
                </div>

                <div class="projects-carousel" data-project-track aria-label="Selected projects" tabindex="0">
                <article class="project-slide animated-card bg-surface rounded-xl overflow-hidden border border-surface-variant shadow-sm hover:shadow-lg transition-all duration-300" data-animate style="--delay: 80ms;">
                    <div class="h-48 bg-surface-container-high flex items-center justify-center">
                        <span class="project-icon material-symbols-outlined text-primary text-[54px]">eco</span>
                    </div>
                    <div class="p-6">
                        <h3 class="font-headline-md text-headline-md mb-3">NatureDex</h3>
                        <p class="text-on-surface-variant mb-4">
                            A Flutter mobile application for identifying flora and fauna.
                        </p>
                        <div class="flex flex-wrap gap-2">
                            <span class="px-3 py-1 bg-surface-container rounded-full text-sm">Flutter</span>
                            <span class="px-3 py-1 bg-surface-container rounded-full text-sm">API</span>
                            <span class="px-3 py-1 bg-surface-container rounded-full text-sm">Mobile</span>
                        </div>
                    </div>
                </article>

                <a
                    href="#"
                    class="project-slide animated-card block bg-surface rounded-xl overflow-hidden border border-surface-variant shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 cursor-pointer"
                    data-animate
                    style="--delay: 180ms;"
                >
                    <div class="h-48 bg-surface-container-high flex items-center justify-center">
                        <span class="project-icon material-symbols-outlined text-primary text-[54px]">language</span>
                    </div>
                    <div class="p-6">
                        <h3 class="font-headline-md text-headline-md mb-3">Portfolio Website</h3>
                        <p class="text-on-surface-variant mb-4">
                            A personal website to showcase profile, CV, projects, and photography gallery.
                        </p>
                        <div class="flex flex-wrap gap-2">
                            <span class="px-3 py-1 bg-surface-container rounded-full text-sm">Laravel</span>
                            <span class="px-3 py-1 bg-surface-container rounded-full text-sm">Blade</span>
                            <span class="px-3 py-1 bg-surface-container rounded-full text-sm">MySQL</span>
                        </div>
                    </div>
                </a>

                <a
                    href="#"
                    class="project-slide animated-card block bg-surface rounded-xl overflow-hidden border border-surface-variant shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 cursor-pointer"
                    data-animate
                    style="--delay: 280ms;"
                >
                    <div class="h-48 bg-surface-container-high flex items-center justify-center">
                        <span class="project-icon material-symbols-outlined text-primary text-[54px]">train</span>
                    </div>

                    <div class="p-6">
                        <h3 class="font-headline-md text-headline-md mb-3">SIRKKA</h3>

                        <p class="text-on-surface-variant mb-4">
                            A train reservation information system concept.
                        </p>

                        <div class="flex flex-wrap gap-2">
                            <span class="px-3 py-1 bg-surface-container rounded-full text-sm">Figma</span>
                            <span class="px-3 py-1 bg-surface-container rounded-full text-sm">Prototype</span>
                            <span class="px-3 py-1 bg-surface-container rounded-full text-sm">Concept</span>
                            <span class="px-3 py-1 bg-surface-container rounded-full text-sm">UI Design</span>
                        </div>
                    </div>
                </a>

                <a
                    href="#"
                    class="project-slide animated-card block bg-surface rounded-xl overflow-hidden border border-surface-variant shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 cursor-pointer"
                    data-animate
                    style="--delay: 380ms;"
                >
                    <div class="h-48 bg-surface-container-high flex items-center justify-center">
                        <span class="project-icon material-symbols-outlined text-primary text-[54px]">local_cafe</span>
                    </div>

                    <div class="p-6">
                        <h3 class="font-headline-md text-headline-md mb-3">Coffee Shop Web App</h3>

                        <p class="text-on-surface-variant mb-4">
                            A coffee shop website with product showcase and gallery.
                            <span class="text-primary font-semibold">(Coming Soon: cashier admin CRUD feature)</span>
                        </p>

                        <div class="flex flex-wrap gap-2">
                            <span class="px-3 py-1 bg-surface-container rounded-full text-sm">HTML</span>
                            <span class="px-3 py-1 bg-surface-container rounded-full text-sm">CSS</span>
                            <span class="px-3 py-1 bg-surface-container rounded-full text-sm">JS</span>
                        </div>
                    </div>
                </a>
                </div>
            </div>
        </div>
    </section>

    <section id="contact" class="bg-surface-container-low py-section-padding">
        <div class="max-w-[1280px] mx-auto px-8 md:px-12">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-16">
                <div data-animate="fade-right">
                    <p class="font-label-sm text-label-sm text-primary mb-3 uppercase tracking-widest">
                        Contact
                    </p>
                    <h2 class="font-headline-lg text-headline-lg text-on-background mb-6">
                        Let's Talk
                    </h2>
                    <p class="text-on-surface-variant mb-8">
                        Feel free to reach out for collaboration, project discussion, or portfolio review.
                    </p>

                    <div class="space-y-4">
                <a
                    href="mailto:milfinawaf@gmail.com"
                    class="contact-card flex items-center gap-4 bg-surface border border-surface-variant rounded-xl p-4 hover:shadow-md hover:border-primary transition-all duration-200"
                    data-animate
                    style="--delay: 90ms;"
                >
                    <div class="w-11 h-11 rounded-full bg-primary text-on-primary flex items-center justify-center">
                        <span class="material-symbols-outlined">mail</span>
                    </div>

                    <div>
                        <p class="font-semibold text-on-background">Email</p>
                        <p class="text-on-surface-variant">milfinawaf@gmail.com</p>
                    </div>
                </a>

                <a
                    href="https://wa.me/6281288637136"
                    target="_blank"
                    class="contact-card flex items-center gap-4 bg-surface border border-surface-variant rounded-xl p-4 hover:shadow-md hover:border-primary transition-all duration-200"
                    data-animate
                    style="--delay: 180ms;"
                >
                    <div class="w-11 h-11 rounded-full bg-primary text-on-primary flex items-center justify-center">
                        <span class="material-symbols-outlined">call</span>
                    </div>

                    <div>
                        <p class="font-semibold text-on-background">WhatsApp</p>
                        <p class="text-on-surface-variant">081288637136</p>
                    </div>
                </a>

                <a
                    href="https://instagram.com/nawafmilfi"
                    target="_blank"
                    class="contact-card flex items-center gap-4 bg-surface border border-surface-variant rounded-xl p-4 hover:shadow-md hover:border-primary transition-all duration-200"
                    data-animate
                    style="--delay: 270ms;"
                >
                    <div class="w-11 h-11 rounded-full bg-primary text-on-primary flex items-center justify-center">
                        <span class="material-symbols-outlined">photo_camera</span>
                    </div>

                    <div>
                        <p class="font-semibold text-on-background">Instagram</p>
                        <p class="text-on-surface-variant">@nawafmilfi</p>
                    </div>
                </a>
            </div>
                </div>

                <form action="{{ route('contact.store') }}" method="POST" class="animated-card bg-surface p-8 rounded-xl border border-surface-variant shadow-sm space-y-4" data-animate="fade-left">
                    @csrf

                    @if (session('contact_success'))
                        <div class="rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                            {{ session('contact_success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                            <ul class="list-disc ml-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <input type="text" name="website" tabindex="-1" autocomplete="off" class="hidden" aria-hidden="true">
                    <input name="name" value="{{ old('name') }}" class="w-full rounded-lg border-outline bg-surface" type="text" placeholder="Your Name" required>
                    <input name="email" value="{{ old('email') }}" class="w-full rounded-lg border-outline bg-surface" type="email" placeholder="Your Email" required>
                    <input name="subject" value="{{ old('subject') }}" class="w-full rounded-lg border-outline bg-surface" type="text" placeholder="Subject" required>
                    <textarea name="message" class="w-full rounded-lg border-outline bg-surface" rows="5" placeholder="Your Message" required>{{ old('message') }}</textarea>
                    <button class="bg-primary text-on-primary px-8 py-3 rounded-full font-label-sm text-label-sm hover:scale-[1.01] transition-all duration-200" type="submit">
                        Send Message
                    </button>
                </form>
            </div>
        </div>
    </section>

</main>

<footer class="bg-surface py-8 border-t border-surface-variant text-center text-on-surface-variant">
    &copy; {{ date('Y') }} Nawaf Portfolio. All rights reserved.
</footer>




@endsection
