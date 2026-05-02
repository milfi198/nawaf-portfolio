<!-- Mobile Header -->
<div class="md:hidden fixed top-0 left-0 w-full h-[72px] bg-surface/90 backdrop-blur-lg border-b border-surface-variant z-40 flex items-center justify-between px-6 shadow-sm">
    <div class="flex items-center gap-4">
        <button onclick="toggleAdminSidebar()" class="text-on-background flex items-center justify-center p-2 -ml-2 rounded-lg hover:bg-surface-container-low transition-colors">
            <span class="material-symbols-outlined">menu</span>
        </button>
        <span class="font-headline-md font-bold text-on-background tracking-tight">Admin Panel</span>
    </div>
</div>

<!-- Sidebar Overlay -->
<div id="adminSidebarOverlay" onclick="toggleAdminSidebar()" class="md:hidden fixed inset-0 bg-black/50 z-40 hidden backdrop-blur-sm transition-opacity"></div>

<!-- Sidebar -->
<aside id="adminSidebar" class="fixed md:sticky top-0 left-0 h-screen w-[280px] bg-surface border-r border-surface-variant z-50 transform -translate-x-full md:translate-x-0 transition-transform duration-300 flex flex-col overflow-y-auto">

    <div class="p-8 border-b border-surface-variant">
        <p class="font-label-sm text-label-sm text-primary uppercase tracking-widest mb-3">
            Admin Panel
        </p>

        <h1 class="font-headline-md text-headline-md font-bold text-on-background">
            Photography Manager
        </h1>

        <p class="text-on-surface-variant mt-2">
            Manage your gallery.
        </p>
    </div>

    <nav class="flex-1 p-5 space-y-2">
        <a href="{{ url('/admin/dashboard') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold transition
           {{ request()->is('admin/dashboard') ? 'bg-primary text-on-primary' : 'text-on-surface-variant hover:bg-surface-container-low hover:text-primary' }}">
            <span class="material-symbols-outlined">dashboard</span>
            Dashboard
        </a>

        <a href="{{ url('/admin/photos') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold transition
           {{ request()->is('admin/photos*') ? 'bg-primary text-on-primary' : 'text-on-surface-variant hover:bg-surface-container-low hover:text-primary' }}">
            <span class="material-symbols-outlined">photo_library</span>
            Photo Management
        </a>

        <a href="{{ url('/admin/users') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold transition
           {{ request()->is('admin/users') ? 'bg-primary text-on-primary' : 'text-on-surface-variant hover:bg-surface-container-low hover:text-primary' }}">
            <span class="material-symbols-outlined">group</span>
            Users
        </a>

        <a href="{{ url('/admin/comments') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold transition
           {{ request()->is('admin/comments') ? 'bg-primary text-on-primary' : 'text-on-surface-variant hover:bg-surface-container-low hover:text-primary' }}">
            <span class="material-symbols-outlined">chat_bubble</span>
            Comments
        </a>

        <a href="{{ url('/admin/settings') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold transition
           {{ request()->is('admin/settings') ? 'bg-primary text-on-primary' : 'text-on-surface-variant hover:bg-surface-container-low hover:text-primary' }}">
            <span class="material-symbols-outlined">settings</span>
            Settings
        </a>

        <a href="{{ url('/my-photography') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-on-surface-variant hover:bg-surface-container-low hover:text-primary transition">
            <span class="material-symbols-outlined">visibility</span>
            View Gallery
        </a>
    </nav>

    <div class="p-5 border-t border-surface-variant">
        <form action="{{ route('logout') }}" method="POST">
            @csrf

            <button type="submit"
                class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-red-600 hover:bg-red-50 transition">
                <span class="material-symbols-outlined">logout</span>
                Logout
            </button>
        </form>
    </div>
</aside>

<style>
    /* Add padding to the main container on mobile to account for the fixed header */
    @media (max-width: 767px) {
        main {
            padding-top: 72px;
        }
    }
</style>

<script>
    function toggleAdminSidebar() {
        const sidebar = document.getElementById('adminSidebar');
        const overlay = document.getElementById('adminSidebarOverlay');

        sidebar.classList.toggle('-translate-x-full');
        overlay.classList.toggle('hidden');

        // Prevent body scroll when sidebar is open
        if (!sidebar.classList.contains('-translate-x-full')) {
            document.body.style.overflow = 'hidden';
        } else {
            document.body.style.overflow = '';
        }
    }
</script>
