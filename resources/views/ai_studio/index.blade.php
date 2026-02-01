@php
    use App\Constants\UserConst;
@endphp

@extends('layouts.app')

@section('content')
    <div class="flex h-screen bg-white dark:bg-neutral-900">

        <!-- LEFT SIDEBAR - History -->
        <aside class="w-64 bg-white dark:bg-neutral-900 border-r border-gray-200 dark:border-neutral-700 flex flex-col">
            <!-- Logo & Brand -->
            <div class="p-5 border-b border-gray-200 dark:border-neutral-700">
                <div class="flex items-center justify-center">
                    <div class="flex-shrink-0">
                        @include('_admin._layout.icons.sidebar.logo')
                    </div>
                </div>
            </div>

            <!-- New Generation Button -->
            <div class="p-4">
                <button type="button" id="newChatBtn"
                    class="py-2.5 px-4 w-full inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none transition-all">
                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M5 12h14" />
                        <path d="M12 5v14" />
                    </svg>
                    Percakapan Baru
                </button>
            </div>

            <!-- History List -->
            <div class="flex-1 overflow-y-auto px-3 py-4 space-y-2">
                <div class="text-xs font-semibold text-gray-500 dark:text-neutral-500 px-2 mb-2">Riwayat</div>

                <a href="#"
                    class="chat-item group flex gap-x-3 items-start p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-neutral-800 transition-all">
                    <svg class="shrink-0 size-4 text-blue-600 dark:text-blue-500 mt-0.5" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <div class="grow min-w-0">
                        <p
                            class="text-sm font-medium text-gray-800 dark:text-neutral-200 group-hover:text-blue-600 dark:group-hover:text-blue-500 truncate">
                            Testing</p>
                        <p class="text-xs text-gray-500 dark:text-neutral-500">Baru saja</p>
                    </div>
                </a>
            </div>

            <!-- Bottom Actions -->
            <div
                class="p-4 border-t border-gray-200 dark:border-neutral-700 sticky bottom-0 z-10 bg-gray-50 dark:bg-neutral-800">
                <div class="hs-dropdown relative inline-flex w-full [--placement:top-left]">
                    <button id="sidebar-bottom-dropdown" type="button"
                        class="hs-dropdown-toggle w-full group flex items-center gap-x-3.5 py-2.5 px-3 text-start text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-300"
                        aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
                        <img class="shrink-0 size-9 rounded-full"
                            src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random&length=2"
                            alt="Avatar">
                        <div class="grow">
                            <p class="text-sm font-semibold text-gray-800 dark:text-neutral-200">{{ Auth::user()->name }}
                            </p>
                            <p class="text-xs text-gray-500 dark:text-neutral-500">
                                {{ UserConst::getAccessTypes()[Auth::user()->access_type] }}
                            </p>
                        </div>
                        @include('_admin._layout.icons.sidebar.dropdown_toggle')
                    </button>

                    <div class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 hidden min-w-60 bg-white shadow-md rounded-lg mb-2 dark:bg-neutral-800 dark:border dark:border-neutral-700 dark:divide-neutral-700 after:h-4 after:absolute after:-bottom-4 after:start-0 after:w-full before:h-4 before:absolute before:-top-4 before:start-0 before:w-full"
                        role="menu" aria-orientation="vertical" aria-labelledby="sidebar-bottom-dropdown">
                        <div class="p-1.5 space-y-0.5">
                            <!-- Switch/Toggle -->
                            <div
                                class="px-3 py-2 flex items-center justify-between border-b border-gray-200 dark:border-neutral-700 mb-1">
                                <span class="text-sm text-gray-800 dark:text-neutral-200">Theme</span>
                                <div class="flex items-center gap-x-0.5">
                                    <button type="button"
                                        class="hs-dark-mode hs-dark-mode-active:hidden flex shrink-0 justify-center items-center gap-x-1 text-xs text-gray-500 hover:text-gray-800 focus:outline-hidden focus:text-gray-800 dark:text-neutral-400 dark:hover:text-neutral-200 dark:focus:text-neutral-200"
                                        data-hs-theme-click-value="dark">
                                        @include('_admin._layout.icons.sidebar.theme_dark')
                                        Dark
                                    </button>
                                    <button type="button"
                                        class="hs-dark-mode hs-dark-mode-active:flex hidden shrink-0 justify-center items-center gap-x-1 text-xs text-gray-500 hover:text-gray-800 focus:outline-hidden focus:text-gray-800 dark:text-neutral-400 dark:hover:text-neutral-200 dark:focus:text-neutral-200"
                                        data-hs-theme-click-value="light">
                                        @include('_admin._layout.icons.sidebar.theme_light')
                                        Light
                                    </button>
                                </div>
                            </div>
                            <!-- End Switch/Toggle -->
                            <a navigate
                                class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-300 dark:focus:bg-neutral-700 dark:focus:text-neutral-300"
                                href="{{ route('admin.profile.change_password') }}">
                                @include('_admin._layout.icons.sidebar.change-password')
                                Ubah Password
                            </a>
                            <form action="{{ route('logout') }}" method="POST"
                                onsubmit="return confirm('Apakah anda yakin ingin keluar?');">
                                @csrf
                                <button type="submit"
                                    class="w-full flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-red-600 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 dark:text-red-500 dark:hover:bg-neutral-700 dark:hover:text-red-500 dark:focus:bg-neutral-700 dark:focus:text-red-500">
                                    @include('_admin._layout.icons.sidebar.logout')
                                    Log out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- MAIN CONTENT AREA -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <header
                class="border-b border-gray-200 dark:border-neutral-700 px-6 py-4 bg-white dark:bg-neutral-900 shadow-sm">
                <div class="flex items-center justify-between">
                    <div class="flex flex-col">
                        <h1 class="text-lg font-semibold text-gray-800 dark:text-white">AI Idea Generation</h1>
                        <p class="text-sm text-gray-600 dark:text-neutral-400">Buat materi ajar dan gambar dengan
                            bantuan AI</p>
                        
                    </div>
                    <button type="button" id="toggleSidebarBtn"
                        class="py-2 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 dark:border-neutral-700 text-gray-700 dark:text-neutral-200 hover:bg-gray-50 dark:hover:bg-neutral-800 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:focus:ring-neutral-700 transition-all">
                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M21 3H3v18h18V3z" />
                            <path d="M15 3v18" />
                        </svg>
                    </button>
                </div>
            </header>

            <!-- Nav Tabs -->
            <nav class="border-b border-gray-200 dark:border-neutral-700 bg-white dark:bg-neutral-900">
                <div class="px-6 flex gap-x-2" role="tablist" aria-label="Tabs">
                    <button type="button"
                        class="hs-tab-active:bg-white hs-tab-active:border-b-2 hs-tab-active:border-blue-600 hs-tab-active:text-blue-600 dark:hs-tab-active:bg-neutral-900 dark:hs-tab-active:text-blue-500 py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium text-center text-gray-600 dark:text-neutral-400 hover:text-gray-800 dark:hover:text-neutral-200 focus:outline-none transition-all active"
                        id="tabs-materi" data-hs-tab="#tabs-materi-content" aria-controls="tabs-materi-content"
                        role="tab">
                        <svg class="shrink-0 size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        Materi Ajar
                    </button>
                    <button type="button"
                        class="hs-tab-active:bg-white hs-tab-active:border-b-2 hs-tab-active:border-blue-600 hs-tab-active:text-blue-600 dark:hs-tab-active:bg-neutral-900 dark:hs-tab-active:text-blue-500 py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium text-center text-gray-600 dark:text-neutral-400 hover:text-gray-800 dark:hover:text-neutral-200 focus:outline-none transition-all"
                        id="tabs-image" data-hs-tab="#tabs-image-content" aria-controls="tabs-image-content"
                        role="tab">
                        <svg class="shrink-0 size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Generate Gambar
                    </button>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="flex-1 overflow-y-auto p-6">
                <div class="max-w-5xl mx-auto">

                    <!-- Tab Content: Materi (PPT & Modul) -->
                    <div id="tabs-materi-content" role="tabpanel" aria-labelledby="tabs-materi">
                        <div class="text-center py-12">
                            <div
                                class="inline-flex items-center justify-center size-16 bg-gradient-to-br from-blue-100 to-blue-200 dark:from-blue-950 dark:to-blue-900 rounded-2xl mb-4">
                                <svg class="size-8 text-blue-600 dark:text-blue-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                            <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">Ide Materi Ajar</h2>
                            <p class="text-gray-600 dark:text-neutral-400 max-w-2xl mx-auto">
                                Buat struktur materi ajar atau poin presentasi secara instan.
                            </p>
                        </div>
                    </div>

                    <!-- Tab Content: Image -->
                    <div id="tabs-image-content" class="hidden" role="tabpanel" aria-labelledby="tabs-image">
                        <div class="mb-6">
                            <h2 class="text-sm font-semibold text-gray-800 dark:text-white mb-4">Contoh Hasil Generate -
                                Klik untuk pilih style</h2>

                            <!-- Masonry Layout for Example Images -->
                            <div class="columns-2 sm:columns-3 lg:columns-4 gap-4">

                                <!-- Example Image 1 - Realistic -->
                                <div class="example-image-card break-inside-avoid mb-4 cursor-pointer group"
                                    data-style="realistic">
                                    <div
                                        class="relative overflow-hidden rounded-xl bg-gray-100 dark:bg-neutral-800 hover:ring-2 hover:ring-blue-500 transition-all duration-200 shadow-sm hover:shadow-lg">
                                        <img src="https://images.unsplash.com/photo-1544776193-352d25ca82cd?w=400&h=600&fit=crop&q=80"
                                            alt="Realistis" class="w-full h-auto object-cover">
                                        <div
                                            class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/0 to-black/0 opacity-0 group-hover:opacity-100 transition-opacity duration-200 flex items-end justify-center pb-4">
                                            <span class="text-white text-sm font-semibold">Style Realistis</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Example Image 2 - Anime -->
                                <div class="example-image-card break-inside-avoid mb-4 cursor-pointer group"
                                    data-style="anime">
                                    <div
                                        class="relative overflow-hidden rounded-xl bg-gray-100 dark:bg-neutral-800 hover:ring-2 hover:ring-purple-500 transition-all duration-200 shadow-sm hover:shadow-lg">
                                        <img src="https://images.unsplash.com/photo-1578632767115-351597cf2477?w=400&h=500&fit=crop&q=80"
                                            alt="Anime" class="w-full h-auto object-cover">
                                        <div
                                            class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/0 to-black/0 opacity-0 group-hover:opacity-100 transition-opacity duration-200 flex items-end justify-center pb-4">
                                            <span class="text-white text-sm font-semibold">Style Anime</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Example Image 3 - Cartoon -->
                                <div class="example-image-card break-inside-avoid mb-4 cursor-pointer group"
                                    data-style="cartoon">
                                    <div
                                        class="relative overflow-hidden rounded-xl bg-gray-100 dark:bg-neutral-800 hover:ring-2 hover:ring-pink-500 transition-all duration-200 shadow-sm hover:shadow-lg">
                                        <img src="https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?w=400&h=400&fit=crop&q=80" alt="Kartun"
                                            class="w-full h-auto object-cover">
                                        <div
                                            class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/0 to-black/0 opacity-0 group-hover:opacity-100 transition-opacity duration-200 flex items-end justify-center pb-4">
                                            <span class="text-white text-sm font-semibold">Style Kartun</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Example Image 4 - Digital Art -->
                                <div class="example-image-card break-inside-avoid mb-4 cursor-pointer group"
                                    data-style="digital">
                                    <div
                                        class="relative overflow-hidden rounded-xl bg-gray-100 dark:bg-neutral-800 hover:ring-2 hover:ring-indigo-500 transition-all duration-200 shadow-sm hover:shadow-lg">
                                        <img src="https://images.unsplash.com/photo-1618172193622-ae2d025f4032?w=400&h=550&fit=crop&q=80"
                                            alt="Digital" class="w-full h-auto object-cover">
                                        <div
                                            class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/0 to-black/0 opacity-0 group-hover:opacity-100 transition-opacity duration-200 flex items-end justify-center pb-4">
                                            <span class="text-white text-sm font-semibold">Style Seni Digital</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Example Image 5 - Oil Painting -->
                                <div class="example-image-card break-inside-avoid mb-4 cursor-pointer group"
                                    data-style="oil">
                                    <div
                                        class="relative overflow-hidden rounded-xl bg-gray-100 dark:bg-neutral-800 hover:ring-2 hover:ring-amber-500 transition-all duration-200 shadow-sm hover:shadow-lg">
                                        <img src="https://images.unsplash.com/photo-1578301978693-85fa9c0320b9?w=400&h=450&fit=crop&q=80"
                                            alt="Cat Minyak" class="w-full h-auto object-cover">
                                        <div
                                            class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/0 to-black/0 opacity-0 group-hover:opacity-100 transition-opacity duration-200 flex items-end justify-center pb-4">
                                            <span class="text-white text-sm font-semibold">Style Cat Minyak</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Example Image 6 - Watercolor -->
                                <div class="example-image-card break-inside-avoid mb-4 cursor-pointer group"
                                    data-style="watercolor">
                                    <div
                                        class="relative overflow-hidden rounded-xl bg-gray-100 dark:bg-neutral-800 hover:ring-2 hover:ring-cyan-500 transition-all duration-200 shadow-sm hover:shadow-lg">
                                        <img src="https://images.unsplash.com/photo-1513364776144-60967b0f800f?w=400&h=520&fit=crop&q=80" alt="Cat Air"
                                            class="w-full h-auto object-cover">
                                        <div
                                            class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/0 to-black/0 opacity-0 group-hover:opacity-100 transition-opacity duration-200 flex items-end justify-center pb-4">
                                            <span class="text-white text-sm font-semibold">Style Cat Air</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Example Image 7 - 3D Render -->
                                <div class="example-image-card break-inside-avoid mb-4 cursor-pointer group"
                                    data-style="3d">
                                    <div
                                        class="relative overflow-hidden rounded-xl bg-gray-100 dark:bg-neutral-800 hover:ring-2 hover:ring-red-500 transition-all duration-200 shadow-sm hover:shadow-lg">
                                        <img src="https://images.unsplash.com/photo-1620641788421-7a1c342ea42e?w=400&h=480&fit=crop&q=80"
                                            alt="3D" class="w-full h-auto object-cover">
                                        <div
                                            class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/0 to-black/0 opacity-0 group-hover:opacity-100 transition-opacity duration-200 flex items-end justify-center pb-4">
                                            <span class="text-white text-sm font-semibold">Style Render 3D</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Example Image 8 - Pixel Art -->
                                <div class="example-image-card break-inside-avoid mb-4 cursor-pointer group"
                                    data-style="pixel">
                                    <div
                                        class="relative overflow-hidden rounded-xl bg-gray-100 dark:bg-neutral-800 hover:ring-2 hover:ring-green-500 transition-all duration-200 shadow-sm hover:shadow-lg">
                                        <img src="https://images.unsplash.com/photo-1614732414444-096e5f1122d5?w=400&h=400&fit=crop&q=80"
                                            alt="Pixel" class="w-full h-auto object-cover">
                                        <div
                                            class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/0 to-black/0 opacity-0 group-hover:opacity-100 transition-opacity duration-200 flex items-end justify-center pb-4">
                                            <span class="text-white text-sm font-semibold">Style Seni Pixel</span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </main>

            <!-- Input Area -->
            <footer class="border-t border-gray-200 dark:border-neutral-700 p-4 bg-white dark:bg-neutral-900 shadow-sm">
                <form class="max-w-4xl mx-auto" method="POST" action="">
                    @csrf
                    <div class="relative">
                        <textarea
                            class="py-3 px-4 pe-16 block w-full border-gray-200 rounded-xl text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-blue-600 resize-none"
                            placeholder="Tulis pesan Anda di sini..." rows="1"
                            data-hs-textarea-auto-height='{
    "defaultHeight": 52
  }'></textarea>

                        <!-- Button Group -->
                        <div class="absolute bottom-2 end-2">
                            <button type="button"
                                class="py-2 px-4 inline-flex shrink-0 justify-center items-center gap-x-2 text-sm font-semibold rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none transition-all">
                                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M22 2L11 13" />
                                    <path d="M22 2l-7 20-4-9-9-4z" />
                                </svg>
                                
                            </button>
                        </div>
                    </div>
                </form>
            </footer>
        </div>

        <!-- RIGHT SIDEBAR - Settings -->
        <aside id="rightSidebar"
            class="w-80 bg-white dark:bg-neutral-900 border-l border-gray-200 dark:border-neutral-700 overflow-y-auto transition-all duration-300">
            <div class="p-5 space-y-5">

                <!-- Materi Settings Section -->
                <div id="materi-settings-section">
                    <h3 class="text-sm font-semibold text-gray-800 dark:text-white mb-4">Pengaturan Materi</h3>

                    <!-- Jenis Materi -->
                    <div class="mb-4">
                        <label for="material_type"
                            class="block text-sm font-medium text-gray-700 dark:text-neutral-300 mb-2">Jenis Materi</label>
                                    <select
                                        id="material_type" name="material_type"
                                        data-hs-select='{
            "placeholder": "Select option...",
            "toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>",
            "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-3 ps-4 pe-9 flex gap-x-2 text-nowrap w-full cursor-pointer bg-white border border-gray-200 rounded-lg text-start text-sm focus:outline-hidden focus:ring-2 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:focus:outline-hidden dark:focus:ring-1 dark:focus:ring-neutral-600",
            "dropdownClasses": "mt-2 z-50 w-full max-h-72 p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500 dark:bg-neutral-900 dark:border-neutral-700",
            "dropdownVerticalFixedPlacement": "bottom",
            "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-hidden focus:bg-gray-100 hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 dark:bg-neutral-900 dark:hover:bg-neutral-800 dark:text-neutral-200 dark:focus:bg-neutral-800",
            "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"hidden hs-selected:block\"><svg class=\"shrink-0 size-3.5 text-blue-600 dark:text-blue-500 \" xmlns=\"http:.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"20 6 9 17 4 12\"/></svg></span></div>",
            "extraMarkup": "<div class=\"absolute top-1/2 end-3 -translate-y-1/2\"><svg class=\"shrink-0 size-3.5 text-gray-500 dark:text-neutral-500 \" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"
            }'
                                        class="hidden">
                                        <option value="">Choose</option>
                                        <option value='ppt'>Ide Presentasi (PPT)</option>
                                        <option value='modul'>Modul Belajar</option>
                                    </select>
                                </div>

                    <!-- PPT SPECIFIC SETTINGS -->
                    <div id="ppt-specific-settings">
                        <!-- Jumlah Slide -->
                        <div class="mb-4">
                            <label for="slide_count"
                                class="block text-sm font-medium text-gray-700 dark:text-neutral-300 mb-2">Jumlah
                                Slide</label>
                            <select id="slide_count" name="slide_count"
                                data-hs-select='{
                                    "placeholder": "Pilih jumlah slide...",
                                    "toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>",
                                    "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-3 ps-4 pe-9 flex gap-x-2 text-nowrap w-full cursor-pointer bg-white border border-gray-200 rounded-lg text-start text-sm focus:outline-hidden focus:ring-2 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:focus:outline-hidden dark:focus:ring-1 dark:focus:ring-neutral-600",
                                    "dropdownClasses": "mt-2 z-50 w-full max-h-72 p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500 dark:bg-neutral-900 dark:border-neutral-700",
                                    "dropdownVerticalFixedPlacement": "bottom",
                                    "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-hidden focus:bg-gray-100 hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 dark:bg-neutral-900 dark:hover:bg-neutral-800 dark:text-neutral-200 dark:focus:bg-neutral-800",
                                    "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"hidden hs-selected:block\"><svg class=\"shrink-0 size-3.5 text-blue-600 dark:text-blue-500 \" xmlns=\"http:.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"20 6 9 17 4 12\"/></svg></span></div>",
                                    "extraMarkup": "<div class=\"absolute top-1/2 end-3 -translate-y-1/2\"><svg class=\"shrink-0 size-3.5 text-gray-500 dark:text-neutral-500 \" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"
                                }'
                                class="hidden">
                                <option value="5">5 Slide</option>
                                <option value="10" selected>10 Slide</option>
                                <option value="15">15 Slide</option>
                                <option value="20">20 Slide</option>
                            </select>
                        </div>

                        <!-- Template Design -->
                        <div class="mb-4">
                            <label for="ppt_template"
                                class="block text-sm font-medium text-gray-700 dark:text-neutral-300 mb-2">Template
                                Desain</label>
                            <select id="ppt_template" name="ppt_template"
                                data-hs-select='{
                                    "placeholder": "Pilih template...",
                                    "toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>",
                                    "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-3 ps-4 pe-9 flex gap-x-2 text-nowrap w-full cursor-pointer bg-white border border-gray-200 rounded-lg text-start text-sm focus:outline-hidden focus:ring-2 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:focus:outline-hidden dark:focus:ring-1 dark:focus:ring-neutral-600",
                                    "dropdownClasses": "mt-2 z-50 w-full max-h-72 p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500 dark:bg-neutral-900 dark:border-neutral-700",
                                    "dropdownVerticalFixedPlacement": "bottom",
                                    "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-hidden focus:bg-gray-100 hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 dark:bg-neutral-900 dark:hover:bg-neutral-800 dark:text-neutral-200 dark:focus:bg-neutral-800",
                                    "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"hidden hs-selected:block\"><svg class=\"shrink-0 size-3.5 text-blue-600 dark:text-blue-500 \" xmlns=\"http:.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"20 6 9 17 4 12\"/></svg></span></div>",
                                    "extraMarkup": "<div class=\"absolute top-1/2 end-3 -translate-y-1/2\"><svg class=\"shrink-0 size-3.5 text-gray-500 dark:text-neutral-500 \" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"
                                }'
                                class="hidden">
                                <option value="modern" selected>Modern & Minimalis</option>
                                <option value="colorful">Colorful & Vibrant</option>
                                <option value="professional">Professional</option>
                                <option value="educational">Educational</option>
                                <option value="playful">Playful</option>
                            </select>
                        </div>

                        <!-- Include Images -->
                        <div class="mb-4">
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" id="ppt_include_images" name="ppt_include_images" checked
                                    class="shrink-0 border-gray-200 rounded text-blue-600 focus:ring-blue-500 dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800">
                                <span class="text-sm text-gray-800 dark:text-white ms-3">Sertakan gambar ilustrasi</span>
                            </label>
                        </div>

                        <!-- Include Notes -->
                        <div class="mb-4">
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" id="ppt_include_notes" name="ppt_include_notes" checked
                                    class="shrink-0 border-gray-200 rounded text-blue-600 focus:ring-blue-500 dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800">
                                <span class="text-sm text-gray-800 dark:text-white ms-3">Tambahkan catatan pembicara</span>
                            </label>
                        </div>
                    </div>

                    <!-- MODULE SPECIFIC SETTINGS -->
                    <div id="module-specific-settings" class="hidden">
                        <!-- Jumlah BAB -->
                        <div class="mb-4">
                            <label for="chapter_count"
                                class="block text-sm font-medium text-gray-700 dark:text-neutral-300 mb-2">Jumlah
                                BAB</label>
                            <select id="chapter_count" name="chapter_count"
                                data-hs-select='{
                                    "placeholder": "Pilih jumlah BAB...",
                                    "toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>",
                                    "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-3 ps-4 pe-9 flex gap-x-2 text-nowrap w-full cursor-pointer bg-white border border-gray-200 rounded-lg text-start text-sm focus:outline-hidden focus:ring-2 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:focus:outline-hidden dark:focus:ring-1 dark:focus:ring-neutral-600",
                                    "dropdownClasses": "mt-2 z-50 w-full max-h-72 p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500 dark:bg-neutral-900 dark:border-neutral-700",
                                    "dropdownVerticalFixedPlacement": "bottom",
                                    "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-hidden focus:bg-gray-100 hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 dark:bg-neutral-900 dark:hover:bg-neutral-800 dark:text-neutral-200 dark:focus:bg-neutral-800",
                                    "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"hidden hs-selected:block\"><svg class=\"shrink-0 size-3.5 text-blue-600 dark:text-blue-500 \" xmlns=\"http:.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"20 6 9 17 4 12\"/></svg></span></div>",
                                    "extraMarkup": "<div class=\"absolute top-1/2 end-3 -translate-y-1/2\"><svg class=\"shrink-0 size-3.5 text-gray-500 dark:text-neutral-500 \" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"
                                }'
                                class="hidden">
                                <option value="3">3 BAB</option>
                                <option value="5" selected>5 BAB</option>
                                <option value="7">7 BAB</option>
                                <option value="10">10 BAB</option>
                            </select>
                        </div>

                        <!-- Tingkat Kesulitan -->
                        <div class="mb-4">
                            <label for="module_difficulty"
                                class="block text-sm font-medium text-gray-700 dark:text-neutral-300 mb-2">Tingkat
                                Kesulitan</label>
                            <select id="module_difficulty" name="module_difficulty"
                                data-hs-select='{
                                    "placeholder": "Pilih tingkat kesulitan...",
                                    "toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>",
                                    "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-3 ps-4 pe-9 flex gap-x-2 text-nowrap w-full cursor-pointer bg-white border border-gray-200 rounded-lg text-start text-sm focus:outline-hidden focus:ring-2 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:focus:outline-hidden dark:focus:ring-1 dark:focus:ring-neutral-600",
                                    "dropdownClasses": "mt-2 z-50 w-full max-h-72 p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500 dark:bg-neutral-900 dark:border-neutral-700",
                                    "dropdownVerticalFixedPlacement": "bottom",
                                    "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-hidden focus:bg-gray-100 hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 dark:bg-neutral-900 dark:hover:bg-neutral-800 dark:text-neutral-200 dark:focus:bg-neutral-800",
                                    "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"hidden hs-selected:block\"><svg class=\"shrink-0 size-3.5 text-blue-600 dark:text-blue-500 \" xmlns=\"http:.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"20 6 9 17 4 12\"/></svg></span></div>",
                                    "extraMarkup": "<div class=\"absolute top-1/2 end-3 -translate-y-1/2\"><svg class=\"shrink-0 size-3.5 text-gray-500 dark:text-neutral-500 \" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"
                                }'
                                class="hidden">
                                <option value="beginner">Pemula</option>
                                <option value="intermediate" selected>Menengah</option>
                                <option value="advanced">Lanjutan</option>
                            </select>
                        </div>

                        <!-- Include Exercises -->
                        <div class="mb-4">
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" id="module_include_exercises" name="module_include_exercises"
                                    checked
                                    class="shrink-0 border-gray-200 rounded text-blue-600 focus:ring-blue-500 dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800">
                                <span class="text-sm text-gray-800 dark:text-white ms-3">Sertakan latihan soal</span>
                            </label>
                        </div>

                        <!-- Include Quiz -->
                        <div class="mb-4">
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" id="module_include_quiz" name="module_include_quiz" checked
                                    class="shrink-0 border-gray-200 rounded text-blue-600 focus:ring-blue-500 dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800">
                                <span class="text-sm text-gray-800 dark:text-white ms-3">Tambahkan kuis evaluasi</span>
                            </label>
                        </div>

                        <!-- Include Summary -->
                        <div class="mb-4">
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" id="module_include_summary" name="module_include_summary" checked
                                    class="shrink-0 border-gray-200 rounded text-blue-600 focus:ring-blue-500 dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800">
                                <span class="text-sm text-gray-800 dark:text-white ms-3">Rangkuman setiap BAB</span>
                            </label>
                        </div>
                    </div>

                    <!-- COMMON SETTINGS -->
                    <!-- Target Audience -->
                    <div class="mb-4">
                        <label for="target_audience"
                            class="block text-sm font-medium text-gray-700 dark:text-neutral-300 mb-2">Target
                            Audiens</label>
                        <select id="target_audience" name="target_audience"
                            data-hs-select='{
                                "placeholder": "Pilih target audiens...",
                                "toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>",
                                "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-3 ps-4 pe-9 flex gap-x-2 text-nowrap w-full cursor-pointer bg-white border border-gray-200 rounded-lg text-start text-sm focus:outline-hidden focus:ring-2 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:focus:outline-hidden dark:focus:ring-1 dark:focus:ring-neutral-600",
                                "dropdownClasses": "mt-2 z-50 w-full max-h-72 p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500 dark:bg-neutral-900 dark:border-neutral-700",
                                "dropdownVerticalFixedPlacement": "bottom",
                                "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-hidden focus:bg-gray-100 hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 dark:bg-neutral-900 dark:hover:bg-neutral-800 dark:text-neutral-200 dark:focus:bg-neutral-800",
                                "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"hidden hs-selected:block\"><svg class=\"shrink-0 size-3.5 text-blue-600 dark:text-blue-500 \" xmlns=\"http:.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"20 6 9 17 4 12\"/></svg></span></div>",
                                "extraMarkup": "<div class=\"absolute top-1/2 end-3 -translate-y-1/2\"><svg class=\"shrink-0 size-3.5 text-gray-500 dark:text-neutral-500 \" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"
                            }'
                            class="hidden">
                            <option value="elementary">SD (Sekolah Dasar)</option>
                            <option value="junior" selected>SMP (Sekolah Menengah Pertama)</option>
                            <option value="senior">SMA (Sekolah Menengah Atas)</option>
                            <option value="university">Universitas</option>
                            <option value="general">Umum</option>
                        </select>
                    </div>
                </div>

                <!-- Image Settings Section -->
                <div id="image-settings-section" class="hidden">
                    <h3 class="text-sm font-semibold text-gray-800 dark:text-white mb-4">Pengaturan Gambar</h3>

                    <!-- Aspect Ratio -->
                    <div class="mb-4">
                        <label for="aspect_ratio"
                            class="block text-sm font-medium text-gray-700 dark:text-neutral-300 mb-2">Rasio Aspek</label>
                        <select id="aspect_ratio" name="aspect_ratio"
                            data-hs-select='{
                                "placeholder": "Pilih rasio aspek...",
                                "toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>",
                                "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-3 ps-4 pe-9 flex gap-x-2 text-nowrap w-full cursor-pointer bg-white border border-gray-200 rounded-lg text-start text-sm focus:outline-hidden focus:ring-2 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:focus:outline-hidden dark:focus:ring-1 dark:focus:ring-neutral-600",
                                "dropdownClasses": "mt-2 z-50 w-full max-h-72 p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500 dark:bg-neutral-900 dark:border-neutral-700",
                                "dropdownVerticalFixedPlacement": "bottom",
                                "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-hidden focus:bg-gray-100 hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 dark:bg-neutral-900 dark:hover:bg-neutral-800 dark:text-neutral-200 dark:focus:bg-neutral-800",
                                "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"hidden hs-selected:block\"><svg class=\"shrink-0 size-3.5 text-blue-600 dark:text-blue-500 \" xmlns=\"http:.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"20 6 9 17 4 12\"/></svg></span></div>",
                                "extraMarkup": "<div class=\"absolute top-1/2 end-3 -translate-y-1/2\"><svg class=\"shrink-0 size-3.5 text-gray-500 dark:text-neutral-500 \" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"
                            }'
                            class="hidden">
                            <option selected>Otomatis</option>
                            <option value="1:1">1:1 (Persegi)</option>
                            <option value="16:9">16:9 (Landscape)</option>
                            <option value="9:16">9:16 (Portrait)</option>
                            <option value="4:3">4:3 (Klasik)</option>
                            <option value="3:2">3:2 (Foto)</option>
                        </select>
                    </div>

                    <!-- Output Format -->
                    <div class="mb-4">
                        <label for="output_format"
                            class="block text-sm font-medium text-gray-700 dark:text-neutral-300 mb-2">Format
                            Output</label>
                        <select id="output_format" name="output_format"
                            data-hs-select='{
                                "placeholder": "Pilih format output...",
                                "toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>",
                                "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-3 ps-4 pe-9 flex gap-x-2 text-nowrap w-full cursor-pointer bg-white border border-gray-200 rounded-lg text-start text-sm focus:outline-hidden focus:ring-2 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:focus:outline-hidden dark:focus:ring-1 dark:focus:ring-neutral-600",
                                "dropdownClasses": "mt-2 z-50 w-full max-h-72 p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500 dark:bg-neutral-900 dark:border-neutral-700",
                                "dropdownVerticalFixedPlacement": "bottom",
                                "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-hidden focus:bg-gray-100 hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 dark:bg-neutral-900 dark:hover:bg-neutral-800 dark:text-neutral-200 dark:focus:bg-neutral-800",
                                "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"hidden hs-selected:block\"><svg class=\"shrink-0 size-3.5 text-blue-600 dark:text-blue-500 \" xmlns=\"http:.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"20 6 9 17 4 12\"/></svg></span></div>",
                                "extraMarkup": "<div class=\"absolute top-1/2 end-3 -translate-y-1/2\"><svg class=\"shrink-0 size-3.5 text-gray-500 dark:text-neutral-500 \" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"
                            }'
                            class="hidden">
                            <option value="png" selected>PNG</option>
                            <option value="jpg">JPG</option>
                            <option value="webp">WebP</option>
                        </select>
                    </div>

                    <!-- Image Quality -->
                    <div class="mb-4">
                        <label for="quality"
                            class="block text-sm font-medium text-gray-700 dark:text-neutral-300 mb-2">Kualitas</label>
                        <select id="quality" name="quality"
                            data-hs-select='{
                                "placeholder": "Pilih kualitas...",
                                "toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>",
                                "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-3 ps-4 pe-9 flex gap-x-2 text-nowrap w-full cursor-pointer bg-white border border-gray-200 rounded-lg text-start text-sm focus:outline-hidden focus:ring-2 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:focus:outline-hidden dark:focus:ring-1 dark:focus:ring-neutral-600",
                                "dropdownClasses": "mt-2 z-50 w-full max-h-72 p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500 dark:bg-neutral-900 dark:border-neutral-700",
                                "dropdownVerticalFixedPlacement": "bottom",
                                "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-hidden focus:bg-gray-100 hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 dark:bg-neutral-900 dark:hover:bg-neutral-800 dark:text-neutral-200 dark:focus:bg-neutral-800",
                                "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"hidden hs-selected:block\"><svg class=\"shrink-0 size-3.5 text-blue-600 dark:text-blue-500 \" xmlns=\"http:.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"20 6 9 17 4 12\"/></svg></span></div>",
                                "extraMarkup": "<div class=\"absolute top-1/2 end-3 -translate-y-1/2\"><svg class=\"shrink-0 size-3.5 text-gray-500 dark:text-neutral-500 \" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"
                            }'
                            class="hidden">
                            <option value="standard">Standard</option>
                            <option value="hd" selected>HD</option>
                            <option value="ultra">Ultra HD</option>
                        </select>
                    </div>

                    <!-- Art Style Selection -->
                    <div id="art-style-section">
                        <label class="block text-sm font-semibold text-gray-800 dark:text-white mb-4">Pilih Gaya
                            Seni</label>
                        <div class="columns-2 gap-3">

                            <label class="style-card cursor-pointer block break-inside-avoid mb-3">
                                <input type="radio" name="art_style" value="realistic" class="peer sr-only" checked />
                                <div
                                    class="p-3 bg-white dark:bg-neutral-900 border-2 border-blue-600 peer-checked:border-blue-600 rounded-lg hover:bg-gray-50 dark:hover:bg-neutral-800 hover:shadow-lg transition-all">
                                    <div class="inline-flex items-center justify-center w-7 h-7 mb-2">
                                        <svg class="size-5 text-blue-600 dark:text-blue-500" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                    <p class="text-xs font-semibold text-gray-800 dark:text-white">Realistis</p>
                                    <p class="text-[10px] text-gray-500 dark:text-neutral-400">Kualitas foto</p>
                                </div>
                            </label>

                            <label class="style-card cursor-pointer block break-inside-avoid mb-3">
                                <input type="radio" name="art_style" value="anime" class="peer sr-only" />
                                <div
                                    class="p-3 bg-white dark:bg-neutral-900 border-2 border-gray-200 dark:border-neutral-700 peer-checked:border-blue-600 rounded-lg hover:bg-gray-50 dark:hover:bg-neutral-800 hover:shadow-lg transition-all">
                                    <div class="inline-flex items-center justify-center w-7 h-7 mb-2">
                                        <svg class="size-5 text-purple-600 dark:text-purple-500" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                        </svg>
                                    </div>
                                    <p class="text-xs font-semibold text-gray-800 dark:text-white">Anime</p>
                                    <p class="text-[10px] text-gray-500 dark:text-neutral-400">Gaya Jepang</p>
                                </div>
                            </label>

                            <label class="style-card cursor-pointer block break-inside-avoid mb-3">
                                <input type="radio" name="art_style" value="cartoon" class="peer sr-only" />
                                <div
                                    class="p-3 bg-white dark:bg-neutral-900 border-2 border-gray-200 dark:border-neutral-700 peer-checked:border-blue-600 rounded-lg hover:bg-gray-50 dark:hover:bg-neutral-800 hover:shadow-lg transition-all">
                                    <div class="inline-flex items-center justify-center w-7 h-7 mb-2">
                                        <svg class="size-5 text-pink-600 dark:text-pink-500" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <p class="text-xs font-semibold text-gray-800 dark:text-white">Kartun</p>
                                    <p class="text-[10px] text-gray-500 dark:text-neutral-400">Ilustrasi</p>
                                </div>
                            </label>

                            <label class="style-card cursor-pointer block break-inside-avoid mb-3">
                                <input type="radio" name="art_style" value="digital" class="peer sr-only" />
                                <div
                                    class="p-3 bg-white dark:bg-neutral-900 border-2 border-gray-200 dark:border-neutral-700 peer-checked:border-blue-600 rounded-lg hover:bg-gray-50 dark:hover:bg-neutral-800 hover:shadow-lg transition-all">
                                    <div class="inline-flex items-center justify-center w-7 h-7 mb-2">
                                        <svg class="size-5 text-indigo-600 dark:text-indigo-500" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <p class="text-xs font-semibold text-gray-800 dark:text-white">Seni Digital</p>
                                    <p class="text-[10px] text-gray-500 dark:text-neutral-400">Modern</p>
                                </div>
                            </label>

                            <label class="style-card cursor-pointer block break-inside-avoid mb-3">
                                <input type="radio" name="art_style" value="oil" class="peer sr-only" />
                                <div
                                    class="p-3 bg-white dark:bg-neutral-900 border-2 border-gray-200 dark:border-neutral-700 peer-checked:border-blue-600 rounded-lg hover:bg-gray-50 dark:hover:bg-neutral-800 hover:shadow-lg transition-all">
                                    <div class="inline-flex items-center justify-center w-7 h-7 mb-2">
                                        <svg class="size-5 text-amber-600 dark:text-amber-500" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                                        </svg>
                                    </div>
                                    <p class="text-xs font-semibold text-gray-800 dark:text-white">Cat Minyak</p>
                                    <p class="text-[10px] text-gray-500 dark:text-neutral-400">Seni klasik</p>
                                </div>
                            </label>

                            <label class="style-card cursor-pointer block break-inside-avoid mb-3">
                                <input type="radio" name="art_style" value="watercolor" class="peer sr-only" />
                                <div
                                    class="p-3 bg-white dark:bg-neutral-900 border-2 border-gray-200 dark:border-neutral-700 peer-checked:border-blue-600 rounded-lg hover:bg-gray-50 dark:hover:bg-neutral-800 hover:shadow-lg transition-all">
                                    <div class="inline-flex items-center justify-center w-7 h-7 mb-2">
                                        <svg class="size-5 text-cyan-600 dark:text-cyan-500" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                        </svg>
                                    </div>
                                    <p class="text-xs font-semibold text-gray-800 dark:text-white">Cat Air</p>
                                    <p class="text-[10px] text-gray-500 dark:text-neutral-400">Lembut & mengalir</p>
                                </div>
                            </label>

                            <label class="style-card cursor-pointer block break-inside-avoid mb-3">
                                <input type="radio" name="art_style" value="3d" class="peer sr-only" />
                                <div
                                    class="p-3 bg-white dark:bg-neutral-900 border-2 border-gray-200 dark:border-neutral-700 peer-checked:border-blue-600 rounded-lg hover:bg-gray-50 dark:hover:bg-neutral-800 hover:shadow-lg transition-all">
                                    <div class="inline-flex items-center justify-center w-7 h-7 mb-2">
                                        <svg class="size-5 text-red-600 dark:text-red-500" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5" />
                                        </svg>
                                    </div>
                                    <p class="text-xs font-semibold text-gray-800 dark:text-white">Render 3D</p>
                                    <p class="text-[10px] text-gray-500 dark:text-neutral-400">Grafis 3D</p>
                                </div>
                            </label>

                            <label class="style-card cursor-pointer block break-inside-avoid mb-3">
                                <input type="radio" name="art_style" value="pixel" class="peer sr-only" />
                                <div
                                    class="p-3 bg-white dark:bg-neutral-900 border-2 border-gray-200 dark:border-neutral-700 peer-checked:border-blue-600 rounded-lg hover:bg-gray-50 dark:hover:bg-neutral-800 hover:shadow-lg transition-all">
                                    <div class="inline-flex items-center justify-center w-7 h-7 mb-2">
                                        <svg class="size-5 text-green-600 dark:text-green-500" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 5a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4zM14 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z" />
                                        </svg>
                                    </div>
                                    <p class="text-xs font-semibold text-gray-800 dark:text-white">Seni Pixel</p>
                                    <p class="text-[10px] text-gray-500 dark:text-neutral-400">Retro gaming</p>
                                </div>
                            </label>

                        </div>
                    </div>
                </div>

            </div>
        </aside>

    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Toggle sidebar functionality
                const toggleBtn = document.getElementById('toggleSidebarBtn');
                const sidebar = document.getElementById('rightSidebar');
                let sidebarVisible = true;

                toggleBtn.addEventListener('click', function() {
                    sidebarVisible = !sidebarVisible;
                    if (sidebarVisible) {
                        sidebar.classList.remove('hidden', 'w-0');
                        sidebar.classList.add('w-80');
                    } else {
                        sidebar.classList.add('hidden', 'w-0');
                        sidebar.classList.remove('w-80');
                    }
                });

                // Tab switching - Main content and sidebar settings
                const tabs = document.querySelectorAll('[role="tab"]');
                const materiSettings = document.getElementById('materi-settings-section');
                const imageSettings = document.getElementById('image-settings-section');

                // Initially show materi settings (default tab)
                materiSettings.classList.remove('hidden');
                imageSettings.classList.add('hidden');

                // Listen to Preline tab change events
                tabs.forEach(tab => {
                    tab.addEventListener('click', function() {
                        const tabId = this.id;

                        // Hide all settings first
                        if (materiSettings) materiSettings.classList.add('hidden');
                        if (imageSettings) imageSettings.classList.add('hidden');

                        // Show relevant settings based on tab
                        if (tabId === 'tabs-materi' && materiSettings) {
                            materiSettings.classList.remove('hidden');
                        } else if (tabId === 'tabs-image' && imageSettings) {
                            imageSettings.classList.remove('hidden');
                        }
                    });
                });

                // Material type switching (PPT vs Module)
                const materialType = document.getElementById('material_type');
                const pptSpecific = document.getElementById('ppt-specific-settings');
                const moduleSpecific = document.getElementById('module-specific-settings');

                materialType.addEventListener('change', function() {
                    if (this.value === 'ppt') {
                        pptSpecific.classList.remove('hidden');
                        moduleSpecific.classList.add('hidden');
                    } else if (this.value === 'module') {
                        pptSpecific.classList.add('hidden');
                        moduleSpecific.classList.remove('hidden');
                    }
                });

                // Art style card click handling
                const styleCards = document.querySelectorAll('.style-card');
                styleCards.forEach(card => {
                    card.addEventListener('click', function() {
                        // Remove active border from all cards
                        styleCards.forEach(c => {
                            const div = c.querySelector('div');
                            div.classList.remove('border-blue-600');
                            div.classList.add('border-gray-200', 'dark:border-neutral-700');
                        });

                        // Add active border to clicked card
                        const div = this.querySelector('div');
                        div.classList.remove('border-gray-200', 'dark:border-neutral-700');
                        div.classList.add('border-blue-600');
                    });
                });

                // Example image click handling - selects art style from example
                const exampleImages = document.querySelectorAll('.example-image-card');
                exampleImages.forEach(img => {
                    img.addEventListener('click', function() {
                        const styleName = this.getAttribute('data-style');

                        // Find and check the corresponding radio button in sidebar
                        const radioButton = document.querySelector(
                            `input[name="art_style"][value="${styleName}"]`);
                        if (radioButton) {
                            radioButton.checked = true;

                            // Update visual feedback on style cards
                            styleCards.forEach(c => {
                                const div = c.querySelector('div');
                                div.classList.remove('border-blue-600');
                                div.classList.add('border-gray-200', 'dark:border-neutral-700');
                            });

                            const selectedCard = radioButton.closest('.style-card');
                            if (selectedCard) {
                                const div = selectedCard.querySelector('div');
                                div.classList.remove('border-gray-200', 'dark:border-neutral-700');
                                div.classList.add('border-blue-600');
                            }
                        }

                        exampleImages.forEach(e => {
                            e.querySelector('div').classList.remove('ring-2');
                        });
                        this.querySelector('div').classList.add('ring-2');
                    });
                });
            });
        </script>
    @endpush
@endsection
