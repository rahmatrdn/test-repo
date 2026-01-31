@php
use App\Constants\UserConst;
@endphp

<!-- Sidebar -->
<div id="hs-application-sidebar" class="hs-overlay  [--auto-close:lg]
  hs-overlay-open:translate-x-0
  -translate-x-full transition-all duration-300 transform
  w-65 h-full
  hidden
  fixed inset-y-0 start-0 z-60
   rounded-r-2xl
  lg:block lg:translate-x-0 lg:end-auto lg:bottom-0
  dark:bg-neutral-800 dark:border-neutral-700
  bg-gray-50" role="dialog" tabindex="-1" aria-label="Sidebar">
    <div class="relative flex flex-col h-full max-h-full">
        <div class="px-6 pt-4 flex items-center">
            <!-- Logo -->
            <a class="flex-none rounded-xl text-xl inline-block font-semibold focus:outline-hidden focus:opacity-80"
                href="#" aria-label="SmartSekolah">
                @include('_admin._layout.icons.sidebar.logo')
            </a>
            <!-- End Logo -->
        </div>

        <!-- Content -->
        <div
            class="flex-1 overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500 mt-4">
            <nav class="hs-accordion-group p-3 w-full flex flex-col flex-wrap" data-hs-accordion-always-open>
                <ul class="flex flex-col space-y-1">

                    {{-- MENU DASHBOARD/BERANDA (Semua Role) --}}
                    <li>
                        @php
                        $dashboardRoute = match (Auth::user()->access_type) {
                        UserConst::SUPER_ADMIN => 'superadmin.dashboard',
                        UserConst::ADMIN_SEKOLAH => 'admin.dashboard',
                        UserConst::GURU => 'teacher.dashboard',
                        default => 'admin.dashboard',
                        };
                        @endphp
                        <a navigate
                            class="flex items-center gap-x-3.5 py-2.5 px-3 {{ request()->routeIs($dashboardRoute) ? 'bg-blue-100 text-blue-600 dark:bg-neutral-700 dark:text-blue-400' : 'text-gray-800 dark:text-white' }} text-sm rounded-lg hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700 font-semibold"
                            href="{{ route($dashboardRoute) }}">
                            @include('_admin._layout.icons.sidebar.dashboard')
                            {{ Auth::user()->access_type == UserConst::SUPER_ADMIN ? 'Dashboard' : 'Beranda' }}
                        </a>
                    </li>

                    {{-- MENU DATA SEKOLAH (SUPER ADMIN ONLY) --}}
                    @if(Auth::user()->access_type == UserConst::SUPER_ADMIN)
                    <li>
                        <a navigate
                            class="flex items-center gap-x-3.5 py-2.5 px-3 {{ request()->routeIs('superadmin.schools.*') ? 'bg-blue-100 text-blue-600 dark:bg-neutral-700 dark:text-blue-400' : 'text-gray-800 dark:text-white' }} text-sm rounded-lg hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700 font-semibold"
                            href="{{ route('superadmin.schools.index') }}">
                            @include('_admin._layout.icons.sidebar.school')
                            Data Sekolah
                        </a>
                    </li>
                    @endif

                    {{-- MENU GURU (ADMIN SEKOLAH) --}}
                    @if(Auth::user()->access_type == UserConst::ADMIN_SEKOLAH && Auth::user()->school_id)
                    <li>
                        <a navigate
                            class="flex items-center gap-x-3.5 py-2.5 px-3 {{ request()->routeIs('admin.teachers.*') ? 'bg-blue-100 text-blue-600 dark:bg-neutral-700 dark:text-blue-400' : 'text-gray-800 dark:text-white' }} text-sm rounded-lg hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700 font-semibold"
                            href="{{ route('admin.teachers.index') }}">
                            @include('_admin._layout.icons.sidebar.teacher')
                            Guru
                        </a>
                    </li>
                    @endif

                    {{-- MENU SISWA (ADMIN SEKOLAH) --}}
                    @if(Auth::user()->access_type == UserConst::ADMIN_SEKOLAH && Auth::user()->school_id)
                    <li>
                        <a navigate
                            class="flex items-center gap-x-3.5 py-2.5 px-3 {{ request()->routeIs('admin.students.*') ? 'bg-blue-100 text-blue-600 dark:bg-neutral-700 dark:text-blue-400' : 'text-gray-800 dark:text-white' }} text-sm rounded-lg hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700 font-semibold"
                            href="{{ route('admin.students.index') }}">
                            @include('_admin._layout.icons.sidebar.student')
                            Siswa
                        </a>
                    </li>
                    @endif

                    {{-- MENU MODUL BELAJAR (GURU & SISWA) --}}
                    @if(Auth::user()->access_type == UserConst::GURU)
                    <li>
                        <a navigate
                            class="flex items-center gap-x-3.5 py-2.5 px-3 {{ request()->routeIs('teacher.learning_modules*') ? 'bg-blue-100 text-blue-600 dark:bg-neutral-700 dark:text-blue-400' : 'text-gray-800 dark:text-white' }} text-sm rounded-lg hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700 font-semibold"
                            href="{{ route('teacher.learning_modules.index') }}">
                            @include('_admin._layout.icons.sidebar.swatch_book')
                            Modul Belajar
                        </a>
                    </li>
                    <li>
                        <a navigate
                            class="flex items-center gap-x-3.5 py-2.5 px-3 {{ request()->routeIs('teacher.quiz*') ? 'bg-blue-100 text-blue-600 dark:bg-neutral-700 dark:text-blue-400' : 'text-gray-800 dark:text-white' }} text-sm rounded-lg hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700 font-semibold"
                            href="{{ route('teacher.quiz.index') }}">
                            @include('_admin._layout.icons.sidebar.bolt')
                            Kuis Interaktif
                        </a>
                    </li>
                    @endif

                    @if(Auth::user()->access_type == UserConst::SISWA)
                    <li>
                        <a navigate
                            class="flex items-center gap-x-3.5 py-2.5 px-3 {{ request()->routeIs('student.learning_modules*') ? 'bg-blue-100 text-blue-600 dark:bg-neutral-700 dark:text-blue-400' : 'text-gray-800 dark:text-white' }} text-sm rounded-lg hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700 font-semibold"
                            href="{{ route('student.learning_modules.index') }}">
                            @include('_admin._layout.icons.sidebar.swatch_book')
                            Modul Belajar
                        </a>
                    </li>
                    <li>
                        <a navigate
                            class="flex items-center gap-x-3.5 py-2.5 px-3 {{ request()->routeIs('student.quiz*') ? 'bg-blue-100 text-blue-600 dark:bg-neutral-700 dark:text-blue-400' : 'text-gray-800 dark:text-white' }} text-sm rounded-lg hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700 font-semibold"
                            href="{{ route('student.quiz.index') }}">
                            @include('_admin._layout.icons.sidebar.bolt')
                            Kuis Interaktif
                        </a>
                    </li>
                    @endif

                    {{-- MENU ALAT AI (GURU) --}}
                    @if(Auth::user()->access_type == UserConst::GURU)
                    <li class="hs-accordion {{ request()->routeIs('teacher.ai.*') ? 'active' : '' }}"
                        id="projects-accordion">
                        <button type="button"
                            class="hs-accordion-toggle w-full text-start flex items-center gap-x-3.5  py-2.5 px-3 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 dark:bg-neutral-800 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700 dark:text-neutral-200 cursor-pointer font-semibold"
                            aria-expanded="true" aria-controls="projects-accordion-child">
                            @include('_admin._layout.icons.sidebar.spark')
                            Alat AI

                            @include('_admin._layout.icons.sidebar.chevron_down')
                            @include('_admin._layout.icons.sidebar.chevron_up')
                        </button>

                        <div id="projects-accordion-child"
                            class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300 {{ request()->routeIs('teacher.ai.*') ? 'block' : 'hidden' }}"
                            role="region" aria-labelledby="projects-accordion">
                            <ul class="ps-8 pt-1 space-y-1">
                                <li>
                                    <a navigate
                                        class="flex items-center gap-x-3.5  py-2.5 px-3 text-sm rounded-lg hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700 {{ request()->routeIs('teacher.ai.ilustrasi.*') ? 'bg-blue-100 text-blue-600 dark:bg-neutral-700 dark:text-blue-400' : 'text-gray-800 dark:text-neutral-200' }}"
                                        href="{{ route('teacher.ai.ilustrasi.index') }}">
                                        Ilustrasi
                                    </a>
                                </li>
                                <li>
                                    <a navigate
                                        class="flex items-center gap-x-3.5  py-2.5 px-3 text-sm rounded-lg hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700 {{ request()->routeIs('teacher.ai.materi_ajar.*') ? 'bg-blue-100 text-blue-600 dark:bg-neutral-700 dark:text-blue-400' : 'text-gray-800 dark:text-neutral-200' }}"
                                        href="{{ route('teacher.ai.materi_ajar.index') }}">
                                        Materi Ajar
                                    </a>
                                </li>
                                <li>
                                    <a navigate
                                        class="flex items-center gap-x-3.5  py-2.5 px-3 text-sm rounded-lg hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700 {{ request()->routeIs('teacher.ai.quiz_generator.*') ? 'bg-blue-100 text-blue-600 dark:bg-neutral-700 dark:text-blue-400' : 'text-gray-800 dark:text-neutral-200' }}"
                                        href="{{ route('teacher.ai.quiz_generator.index') }}">
                                        Pembuat Kuis
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    @endif

                    {{-- MENU DATA MASTER (SUPER ADMIN & ADMIN SEKOLAH) --}}
                    @if(Auth::user()->access_type == UserConst::SUPER_ADMIN || (Auth::user()->access_type == UserConst::ADMIN_SEKOLAH && Auth::user()->school_id))
                    <li class="hs-accordion {{ request()->routeIs('admin.users.*') || request()->routeIs('superadmin.users.*') || request()->routeIs('admin.classrooms.*') || request()->routeIs('superadmin.image-prompts.*') || request()->routeIs('superadmin.subjects.*') ? 'active' : '' }}"
                        id="data-master-accordion">
                        <button type="button"
                            class="hs-accordion-toggle w-full text-start flex items-center gap-x-3.5  py-2.5 px-3 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 dark:bg-neutral-800 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700 dark:text-neutral-200 cursor-pointer font-semibold"
                            aria-expanded="true" aria-controls="data-master-accordion-child">
                            @include('_admin._layout.icons.sidebar.data_master')
                            Data Master

                            @include('_admin._layout.icons.sidebar.chevron_down')
                            @include('_admin._layout.icons.sidebar.chevron_up')
                        </button>

                        <div id="data-master-accordion-child"
                            class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300 {{ request()->routeIs('admin.users.*') || request()->routeIs('superadmin.users.*') || request()->routeIs('admin.classrooms.*') || request()->routeIs('superadmin.image-prompts.*') || request()->routeIs('superadmin.subjects.*') ? 'block' : 'hidden' }}"
                            role="region" aria-labelledby="data-master-accordion">
                            <ul class="ps-8 pt-1 space-y-1">
                                {{-- Menu untuk Super Admin --}}
                                @if(Auth::user()->access_type == UserConst::SUPER_ADMIN)
                                <li>
                                    <a navigate
                                        class="flex items-center gap-x-3.5  py-2.5 px-3 text-sm rounded-lg hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700 {{ request()->routeIs('superadmin.subjects.*') ? 'bg-blue-100 text-blue-600 dark:bg-neutral-700 dark:text-blue-400' : 'text-gray-800 dark:text-neutral-200' }}"
                                        href="{{ route('superadmin.subjects.index') }}">
                                        Mata Pelajaran
                                    </a>
                                </li>
                                <li>
                                    <a navigate
                                        class="flex items-center gap-x-3.5  py-2.5 px-3 text-sm rounded-lg hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700 {{ request()->routeIs('superadmin.users.*') ? 'bg-blue-100 text-blue-600 dark:bg-neutral-700 dark:text-blue-400' : 'text-gray-800 dark:text-neutral-200' }}"
                                        href="{{ route('superadmin.users.index') }}">
                                        Pengguna Aplikasi
                                    </a>
                                </li>
                                <li>
                                    <a navigate
                                        class="flex items-center gap-x-3.5  py-2.5 px-3 text-sm rounded-lg hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700 {{ request()->routeIs('superadmin.image-prompts.*') ? 'bg-blue-100 text-blue-600 dark:bg-neutral-700 dark:text-blue-400' : 'text-gray-800 dark:text-neutral-200' }}"
                                        href="{{ route('superadmin.image-prompts.index') }}">
                                        Gaya Gambar
                                    </a>
                                </li>
                                @endif

                                {{-- Menu untuk Admin Sekolah --}}
                                @if(Auth::user()->access_type == UserConst::ADMIN_SEKOLAH)
                                <li>
                                    <a navigate
                                        class="flex items-center gap-x-3.5  py-2.5 px-3 text-sm rounded-lg hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700 {{ request()->routeIs('admin.classrooms.*') ? 'bg-blue-100 text-blue-600 dark:bg-neutral-700 dark:text-blue-400' : 'text-gray-800 dark:text-neutral-200' }}"
                                        href="{{ route('admin.classrooms.index') }}">
                                        Kelas
                                    </a>
                                </li>
                                <li>
                                    <a navigate
                                        class="flex items-center gap-x-3.5  py-2.5 px-3 text-sm rounded-lg hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700 {{ request()->routeIs('admin.users.*') ? 'bg-blue-100 text-blue-600 dark:bg-neutral-700 dark:text-blue-400' : 'text-gray-800 dark:text-neutral-200' }}"
                                        href="{{ route('admin.users.index') }}">
                                        Pengguna Aplikasi
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                    @endif

                    {{-- MENU REGISTRASI SEKOLAH (Admin Sekolah tanpa school_id, bukan Super Admin) --}}
                    @if(Auth::user()->access_type == UserConst::ADMIN_SEKOLAH && !Auth::user()->school_id)
                    <li>
                        <a navigate
                            class="flex items-center gap-x-3.5 py-2.5 px-3 {{ request()->routeIs('school.register') ? 'bg-blue-100 text-blue-600 dark:bg-neutral-700 dark:text-blue-400' : 'text-gray-800 dark:text-white' }} text-sm rounded-lg hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700 font-semibold"
                            href="{{ route('school.register') }}">
                            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 10v6M2 10l10-5 10 5-10 5z" />
                                <path d="M6 12v5c3 3 9 3 12 0v-5" />
                            </svg>
                            Registrasi Sekolah
                        </a>
                    </li>
                    @endif

                </ul>
            </nav>
        </div>

        <div
            class="p-4 border-t border-gray-200 dark:border-neutral-700 sticky bottom-0 z-10 bg-gray-50 dark:bg-neutral-800">
            <div class="hs-dropdown relative inline-flex w-full [--placement:top-left]">
                <button id="sidebar-bottom-dropdown" type="button"
                    class="hs-dropdown-toggle w-full group flex items-center gap-x-3.5  py-2.5 px-3 text-start text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-300"
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
        <!-- End Content -->
    </div>
</div>
<!-- End Sidebar -->