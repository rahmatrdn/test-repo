<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Sekolah | @yield('title', 'Beranda')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/_home/home-custom.css'])
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&family=Lexend:wght@100..900&family=Poppins:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">
</head>

<body class="bg-lightBg dark:bg-darkBg text-slate-800 dark:text-slate-100 transition-colors duration-300">

    <!-- Navbar -->
    <nav class="fixed w-full z-50 top-0 glass border-0 border-b border-slate-200 dark:border-slate-800">
        <div class="max-w-7xl mx-auto px-10 min-[1000px]:px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <img src="{{ asset('home/images/smart-sekolah.png') }}" alt="Logo" class="w-60">
            </div>

            <div class="hidden min-[1000px]:flex items-center gap-8 text-sm font-medium">
                <a href="#beranda" class="nav-link transition-colors">Beranda</a>
                <a href="#tentang" class="nav-link transition-colors">Tentang</a>
                <a href="#fitur" class="nav-link transition-colors">Fitur</a>
                <a href="#materi" class="nav-link transition-colors">Materi</a>
                <button onclick="toggleDarkMode()"
                    class="p-2 rounded-full hover:bg-slate-200 dark:hover:bg-slate-800 transition-all">
                    <div class="w-5 h-5 hidden dark:block">
                        @include('_home.icons.moon')
                    </div>
                    <div class="w-5 h-5 block dark:hidden">
                        @include('_home.icons.sun')
                    </div>
                </button>
                <a href="{{ route('login') }}"
                    class="bg-primary text-white px-6 py-2.5 rounded-full hover:bg-secondary transition-all shadow-lg shadow-indigo-500/20">Mulai
                    Sekarang</a>
            </div>

            <div class="hamburger-navbar">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </nav>

    <div id="mobile-menu" class="glass">
        <a href="#beranda" class="nav-link">Beranda</a>
        <a href="#tentang" class="nav-link">Tentang</a>
        <a href="#fitur" class="nav-link">Fitur</a>
        <a href="#materi" class="nav-link">Materi</a>
        <div class="flex items-center gap-4 pt-4">
            <button onclick="toggleDarkMode()" class="p-4 rounded-full bg-slate-100 dark:bg-slate-800 transition-all">
                <div class="w-5 h-5 hidden dark:block">
                    @include('_home.icons.moon')
                </div>
                <div class="w-5 h-5 block dark:hidden">
                    @include('_home.icons.sun')
                </div>
            </button>
            <a href="{{ route('login') }}" class="bg-primary text-white px-8 py-3 rounded-full">Mulai Sekarang</a>
        </div>
    </div>

    <!-- Hero Banner -->
    <section id="beranda" class="pt-32 pb-20 px-6">
        <div class="max-w-7xl mx-auto flex flex-col min-[1000px]:flex-row items-center justify-between gap-12">
            <div class="space-y-8 w-full min-[1000px]:w-[55%]">
                <div
                    class="inline-flex items-center gap-2 bg-indigo-50 dark:bg-indigo-900/30 text-primary px-4 py-2 rounded-full text-xs font-semibold tracking-wider uppercase">
                    <span class="relative flex h-2 w-2">
                        <span
                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-primary"></span>
                    </span>
                    Revolusi Digital Pendidikan
                </div>
                <h1 class="text-5xl min-[1120px]:text-[68px] font-bold leading-tight">
                    Belajar Lebih <span class="text-primary">Cerdas</span>, Mengajar Lebih Efisien.
                </h1>
                <p class="text-slate-500 dark:text-slate-400 text-base max-w-lg">
                    Platform ekosistem pendidikan terpadu untuk menghubungkan guru, murid, dan orang tua dalam satu
                    harmoni digital yang modern.
                </p>
                <div class="flex flex-col min-[500px]:flex-row gap-4">
                    <a href="{{ route('login') }}"
                        class="bg-primary text-white justify-center text-sm min-[1090px]:text-base px-4 min-[1090px]:px-8 py-2 min-[1090px]:py-4 rounded-2xl font-bold hover:bg-secondary transition-all flex items-center gap-2">
                        @include('_home.icons.rocket') Mulai Sekarang
                    </a>
                    <a
                        class="flex items-center gap-2 border px-4 justify-center text-sm min-[1090px]:text-base min-[1090px]:px-8 py-2 min-[1090px]:py-4 border-slate-300 dark:border-slate-700 rounded-2xl font-bold hover:bg-slate-100 dark:hover:bg-slate-800 transition-all">
                        Eksplore Program @include('_home.icons.book-search')
                    </a>
                </div>
            </div>
            <div class="relative w-full min-[500px]:w-[80%] min-[750px]:w-[60%] min-[1000px]:w-[45%]">
                <div class="absolute -top-10 -left-10 w-64 h-64 bg-primary/20 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-10 -right-10 w-64 h-64 bg-blue-500/20 rounded-full blur-3xl"></div>
                <img src="{{ asset('home/images/hero_section.png') }}" alt="Students learning"
                    class="z-10 w-full object-cover">
                <div
                    class="absolute bottom-0 -left-6 bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-xl z-20 hidden md:block border border-slate-100 dark:border-slate-700">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-green-100 dark:bg-green-900/30 rounded-full">
                            @include('_home.icons.circle-check')
                        </div>
                        <div>
                            <p class="text-xs text-slate-400">Aktif Digunakan</p>
                            <p class="font-bold">500+ Sekolah</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tentang SmartSekolah -->
    <section id="tentang" class="py-24 bg-white dark:bg-slate-900/50 transition-colors">
        <div class="max-w-7xl mx-auto px-6 md:px-16">
            <div class="grid md:grid-cols-2 gap-12 lg:gap-20 items-center">

                <div class="order-2 md:order-1 grid grid-cols-2 gap-3">
                    <img src="{{ asset('home/images/learn1.jpg') }}"
                        class="w-full aspect-[3/4] object-cover rounded-2xl shadow-sm hover:scale-105 transition-transform duration-500 mt-6"
                        alt="Learning 1">

                    <img src="{{ asset('home/images/learn2.jpg') }}"
                        class="w-full aspect-[3/4] object-cover rounded-2xl shadow-sm hover:scale-105 transition-transform duration-500"
                        alt="Learning 2">
                </div>

                <div class="space-y-8 order-1 md:order-2">
                    <div class="space-y-3">
                        <h2 class="text-xs font-bold text-primary tracking-widest uppercase italic italic">Tentang Kami
                        </h2>
                        <h3 class="text-4xl font-extrabold leading-tight dark:text-white">
                            Membangun Masa Depan Pendidikan yang <span class="text-primary">Inklusif</span>
                        </h3>
                        <p class="text-slate-600 dark:text-slate-400">
                            <strong>SmartSekolah</strong> hadir untuk memutus rantai krisis pembelajaran. Kami fokus
                            menyederhanakan materi kompleks dan menghapus batasan geografis demi kesetaraan kualitas
                            pendidikan di seluruh Indonesia.
                        </p>
                    </div>

                    <div class="grid gap-6">
                        <div class="flex gap-4">
                            <div
                                class="shrink-0 w-12 h-12 bg-primary/10 rounded-2xl flex items-center justify-center text-primary">
                                @include('_home.icons.sparkles')
                            </div>
                            <div>
                                <h4 class="font-bold dark:text-white">Penyederhanaan Konsep</h4>
                                <p class="text-xs text-slate-500 dark:text-slate-400">Materi akademik berat kini lebih
                                    visual dan interaktif.</p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div
                                class="shrink-0 w-12 h-12 bg-primary/10 rounded-2xl flex items-center justify-center text-primary">
                                @include('_home.icons.users')
                            </div>
                            <div>
                                <h4 class="font-bold dark:text-white">Kesetaraan Akses</h4>
                                <p class="text-xs text-slate-500 dark:text-slate-400">Menghubungkan pelosok dengan
                                    standar pendidikan nasional.</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Fitur -->
    <section id="fitur" class="py-24 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="text-center max-w-2xl mx-auto mb-16 space-y-4">
                <h2 class="text-4xl font-bold">Kenapa Memilih Kami?</h2>
                <p class="text-slate-500">Fitur yang dirancang khusus untuk memenuhi kebutuhan ekosistem pendidikan
                    Indonesia.</p>
            </div>
            <div class="min-[965px]:grid min-[965px]:grid-cols-3 flex flex-row justify-center flex-wrap gap-8">
                <!-- Fitur 1 -->
                <div
                    class="p-8 w-[300px] min-[965px]:w-full rounded-[2rem] border border-slate-200 dark:border-slate-800 bg-white/50 dark:bg-slate-800/50 hover:border-primary transition-all group">
                    <div
                        class="w-14 h-14 bg-blue-100 dark:bg-blue-900/30 text-blue-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        @include('_home.icons.bot')
                    </div>
                    <h4 class="text-xl font-bold mb-4">AI Creator Studio</h4>
                    <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed">
                        merancang struktur materi, mencari referensi pendukung, hingga menyusun strategi penyampaian
                        materi yang sesuai dengan tingkat kognitif siswa.
                    </p>

                </div>
                <!-- Fitur 2 -->
                <div
                    class="p-8 w-[300px] min-[965px]:w-full rounded-[2rem] border border-slate-200 dark:border-slate-800 bg-white/50 dark:bg-slate-800/50 hover:border-primary transition-all group">
                    <div
                        class="w-14 h-14 bg-purple-100 dark:bg-purple-900/30 text-purple-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        @include('_home.icons.layout-list')
                    </div>
                    <h4 class="text-xl font-bold mb-4">AI Auto Summary</h4>
                    <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed">
                        AI akan mengekstraksi poin-poin esensial dari materi pembelajaran dan menyusunnya menjadi
                        ringkasan terstruktur yang mudah dicerna dan dipahami.
                    </p>

                </div>
                <!-- Fitur 3-->
                <div
                    class="p-8 w-[300px] min-[965px]:w-full rounded-[2rem] border border-slate-200 dark:border-slate-800 bg-white/50 dark:bg-slate-800/50 hover:border-primary transition-all group">
                    <div
                        class="w-14 h-14 bg-amber-100 dark:bg-amber-900/30 text-amber-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        @include('_home.icons.puzzle')
                    </div>
                    <h4 class="text-xl font-bold mb-4">Kuis Interaktif</h4>
                    <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed">
                        Kuis interaktif yang dirancang untuk menguji pemahaman siswa secara aktif dan menyenangkan.
                    </p>


                </div>
            </div>
        </div>
    </section>

    <!-- Materi Ajar Section -->
    <section id="materi" class="py-24 bg-slate-100 dark:bg-slate-900/80">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-6">
                <div class="space-y-4">
                    <h2 class="text-4xl font-bold tracking-tight">Eksplorasi Materi Ajar</h2>
                    <p class="text-slate-500">Temukan ribuan materi berkualitas yang disusun oleh ahli di bidangnya.
                    </p>
                </div>
            </div>

            <!-- Filter Controls -->
            <div
                class="bg-white dark:bg-slate-800 p-6 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-700 mb-10">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    <!-- Searchable Select: Jenjang -->
                    <div class="custom-select-wrapper" id="select-jenjang">
                        <label class="block text-xs font-bold uppercase text-slate-400 mb-2">Pilih Jenjang</label>
                        <div class="relative">
                            <!-- Trigger Button -->
                            <button
                                class="select-trigger w-full flex items-center justify-between bg-slate-50 dark:bg-slate-900 border-2 border-transparent hover:border-blue-400 rounded-xl px-4 py-3 outline-none transition-all">
                                <span class="selected-text text-slate-700 dark:text-slate-200">Sekolah Dasar
                                    (SD)</span>
                                <svg class="w-4 h-4 text-slate-400 transition-transform arrow-icon" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <!-- Dropdown Content -->
                            <div
                                class="dropdown-menu absolute z-50 w-full mt-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-xl overflow-hidden">
                                <div class="p-2 border-b border-slate-100 dark:border-slate-700">
                                    <input type="text"
                                        class="search-input w-full bg-slate-50 dark:bg-slate-900 text-sm border-none rounded-lg px-3 py-2 focus:ring-1 focus:ring-blue-500 outline-none text-slate-700 dark:text-slate-200"
                                        placeholder="Cari jenjang...">
                                </div>
                                <ul id="opsi-jenjang"
                                    class="option-list max-h-60 overflow-y-auto custom-scrollbar py-1">

                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Searchable Select: Kelas -->
                    <div class="custom-select-wrapper" id="select-kelas">
                        <label class="block text-xs font-bold uppercase text-slate-400 mb-2">Pilih Kelas</label>
                        <div class="relative">
                            <button id="button-kelas-opsi"
                                class="select-trigger w-full flex items-center justify-between bg-slate-50 dark:bg-slate-900 border-2 border-transparent hover:border-blue-400 rounded-xl px-4 py-3 outline-none transition-all">
                                <span class="selected-text text-slate-700 dark:text-slate-200">1</span>
                                <svg class="w-4 h-4 text-slate-400 transition-transform arrow-icon" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div
                                class="dropdown-menu absolute z-50 w-full mt-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-xl overflow-hidden">
                                <div class="p-2 border-b border-slate-100 dark:border-slate-700">
                                    <input type="text"
                                        class="search-input w-full bg-slate-50 dark:bg-slate-900 text-sm border-none rounded-lg px-3 py-2 focus:ring-1 focus:ring-blue-500 outline-none text-slate-700 dark:text-slate-200"
                                        placeholder="Cari kelas...">
                                </div>
                                <ul id="opsi-kelas"
                                    class="option-list max-h-60 overflow-y-auto custom-scrollbar py-1">

                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Searchable Select: Mata Pelajaran -->
                    <div class="custom-select-wrapper" id="select-mapel">
                        <label class="block text-xs font-bold uppercase text-slate-400 mb-2">Mata Pelajaran</label>
                        <div class="relative">
                            <button
                                class="select-trigger w-full flex items-center justify-between bg-slate-50 dark:bg-slate-900 border-2 border-transparent hover:border-blue-400 rounded-xl px-4 py-3 outline-none transition-all">
                                <span class="selected-text text-slate-700 dark:text-slate-200">Semua Mata
                                    Pelajaran</span>
                                <svg class="w-4 h-4 text-slate-400 transition-transform arrow-icon" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div
                                class="dropdown-menu absolute z-50 w-full mt-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-xl overflow-hidden">
                                <div class="p-2 border-b border-slate-100 dark:border-slate-700">
                                    <input type="text"
                                        class="search-input w-full bg-slate-50 dark:bg-slate-900 text-sm border-none rounded-lg px-3 py-2 focus:ring-1 focus:ring-blue-500 outline-none text-slate-700 dark:text-slate-200"
                                        placeholder="Cari mata pelajaran...">
                                </div>
                                <ul id="opsi-mapel"
                                    class="option-list max-h-60 overflow-y-auto custom-scrollbar py-1">
                                    <li class="option px-4 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-blue-50 dark:hover:bg-slate-700 cursor-pointer transition-colors"
                                        data-value="semua">Semua Mata Pelajaran</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <h1 id="materi_error_text" class="text-center font-semibold mt-8 text-lg hidden">Materi Tidak Ditemukan
            </h1>
            <div id="materi_error_loading" class="mt-8 flex flex-col items-center hidden">
                <span class="text-lg font-semibold text-slate-800 tracking-tight">Menyiapkan Data Materi</span>
                <div class="flex space-x-1 mt-2">
                    <div class="w-1.5 h-1.5 bg-blue-600 rounded-full animate-bounce" style="animation-delay: 0.1s">
                    </div>
                    <div class="w-1.5 h-1.5 bg-blue-600 rounded-full animate-bounce" style="animation-delay: 0.2s">
                    </div>
                    <div class="w-1.5 h-1.5 bg-blue-600 rounded-full animate-bounce" style="animation-delay: 0.3s">
                    </div>
                </div>
            </div>
            <div id="materi_card_container"
                class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">


            </div>
        </div>
    </section>

    <!-- Gabung Section -->
    <section id="gabung" class="py-24 px-6 overflow-hidden">
        <div class="max-w-5xl mx-auto relative">
            <div
                class="bg-primary rounded-[3rem] px-8 py-16 md:p-20 text-center text-white relative z-10 overflow-hidden shadow-2xl">
                <div
                    class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2">
                </div>
                <div
                    class="absolute bottom-0 left-0 w-48 h-48 bg-black/10 rounded-full translate-y-1/2 -translate-x-1/2">
                </div>

                <h2 class="text-4xl md:text-5xl font-bold mb-6">Siap Memulai Transformasi?</h2>
                <p class="text-indigo-100 text-lg mb-10 max-w-xl mx-auto">
                    Bergabunglah dengan ribuan pengajar dan siswa yang telah merasakan kemudahan belajar di ekosistem
                    SmartSekolah.
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{ route('register') }}"
                        class="bg-white text-primary px-10 py-4 rounded-2xl font-bold hover:bg-indigo-50 transition-all shadow-xl">
                        Daftarkan Sekolah Anda
                    </a>
                    <a href="https://wa.me/6285648793646"
                        class="bg-primary border-2 border-white/30 text-white px-10 py-4 rounded-2xl font-bold hover:bg-white/10 transition-all">
                        Hubungi Sales
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-16 bg-white dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800 px-6">
        <div class="max-w-7xl mx-auto grid md:grid-cols-4 gap-12">
            <div class="space-y-6">
                <div class="flex items-center gap-2">
                    <img src="{{ asset('home/images/smart-sekolah.png') }}" alt="Logo" class="w-60">
                </div>
                <p class="text-slate-500 text-sm">Tuntaskan kesenjangan pendidikan bersama SmartSekolah, platform
                    pembelajaran modern berbasis AI</p>
                <div class="flex gap-4">
                    <a href="#" class="text-slate-400 hover:text-primary transition-colors"><i
                            data-lucide="instagram"></i></a>
                    <a href="#" class="text-slate-400 hover:text-primary transition-colors"><i
                            data-lucide="twitter"></i></a>
                    <a href="#" class="text-slate-400 hover:text-primary transition-colors"><i
                            data-lucide="linkedin"></i></a>
                </div>
            </div>
            <div>
                <h5 class="font-bold mb-6">Beranda Link</h5>
                <ul class="space-y-4 text-slate-500 text-sm">
                    <li><a href="#" class="hover:text-primary"
                            href="{{ route('landing') }}#beranda">Beranda</a></li>
                    <li><a href="#" class="hover:text-primary"
                            href="{{ route('landing') }}#tentang">Tentang</a></li>
                    <li><a href="#" class="hover:text-primary" href="{{ route('landing') }}#fitur">Fitur</a>
                    </li>
                    <li><a href="#" class="hover:text-primary" href="{{ route('landing') }}#materi">Materi</a>
                    </li>
                </ul>
            </div>
            <div>
                <h5 class="font-bold mb-6">Link Cepat</h5>
                <ul class="space-y-4 text-slate-500 text-sm">
                    <li><a href="#" class="hover:text-primary">Tentang Kami</a></li>
                    <li><a href="#" class="hover:text-primary">Karir</a></li>
                    <li><a href="#" class="hover:text-primary">Blog Pendidikan</a></li>
                    <li><a href="#" class="hover:text-primary">Kebijakan Privasi</a></li>
                </ul>
            </div>
            <div>
                <h5 class="font-bold mb-6">Kontak</h5>
                <ul class="space-y-4 text-slate-500 text-sm">
                    <li class="flex items-center gap-3">
                        @include('_home.icons.mail') smartsekolah@gmail.id
                    </li>
                    <li class="flex items-center gap-3">
                        @include('_home.icons.phone') +62 (21) 4567 890
                    </li>
                    <li class="flex items-start gap-3">
                        @include('_home.icons.map-pin') Jakarta, Indonesia
                    </li>
                </ul>
            </div>
        </div>
        <div
            class="max-w-7xl mx-auto mt-16 pt-8 border-t border-slate-100 dark:border-slate-800 text-center text-slate-400 text-xs">
            <p>&copy; 2026 SmartSekolah. Seluruh hak cipta dilindungi.</p>
        </div>
    </footer>
    <script>
        const materi_error_text = document.querySelector('#materi_error_text');
        const materi_card_container = document.querySelector('#materi_card_container');
        const materi_error_loading = document.querySelector('#materi_error_loading');

        // Inisialisasi
        let opsiMateri = {
            jenjang: 1,
            kelas: 1,
            mapel: 'semua'
        }

        let mapel = @json($mapel);
        mapel = mapel['data'];
        mapel.forEach((item) => {
            document.querySelector('#opsi-mapel').innerHTML +=
                `<li class="option px-4 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-blue-50 dark:hover:bg-slate-700 cursor-pointer transition-colors" data-type="mapel" data-value="${item.id}">${item.name}</li>`;
        })

        let jenjang = [{
                id: 1,
                jenjang: 'Sekolah Dasar (SD)'
            },
            {
                id: 2,
                jenjang: 'Madrasah Ibtidaiyah (MI)'
            },
            {
                id: 3,
                jenjang: 'Sekolah Menengah Pertama (SMP)'
            },
            {
                id: 4,
                jenjang: 'Madrasah Tsanawiyah (MTS)'
            },
            {
                id: 5,
                jenjang: 'Sekolah Menengah Atas (SMA)'
            },
            {
                id: 6,
                jenjang: 'Madrasah Aliyah (MA)'
            },
            {
                id: 7,
                jenjang: 'Sekolah Menengah Kejuruan (SMK)'
            },
        ];
        jenjang.forEach((item) => {
            document.querySelector('#opsi-jenjang').innerHTML +=
                `<li class="option px-4 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-blue-50 dark:hover:bg-slate-700 cursor-pointer transition-colors" data-type="jenjang" data-value="${item.id}">${item.jenjang}</li>`;
        })

        let kelas = [{
                id: 1,
                kelas: '1'
            },
            {
                id: 2,
                kelas: '2'
            },
            {
                id: 3,
                kelas: '3'
            },
            {
                id: 4,
                kelas: '4'
            },
            {
                id: 5,
                kelas: '5'
            },
            {
                id: 6,
                kelas: '6'
            },
            {
                id: 7,
                kelas: '7'
            },
            {
                id: 8,
                kelas: '8'
            },
            {
                id: 9,
                kelas: '9'
            },
            {
                id: 10,
                kelas: '10'
            },
            {
                id: 11,
                kelas: '11'
            },
            {
                id: 12,
                kelas: '12'
            },
        ];
        kelas.forEach((item) => {
            document.querySelector('#opsi-kelas').innerHTML +=
                `<li class="option px-4 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-blue-50 dark:hover:bg-slate-700 cursor-pointer transition-colors" data-type="kelas" data-value="${item.id}">${item.kelas}</li>`;
        })


        // Dark Mode Toggle
        function toggleDarkMode() {
            document.documentElement.classList.toggle('dark');
        }

        const hamburger = document.querySelector('.hamburger-navbar');
        hamburger.addEventListener('click', () => {
            hamburger.classList.toggle('active');
            document.querySelector('#mobile-menu').classList.toggle('active');
        })

        // Fungsi untuk menginisialisasi Searchable Select kustom
        function initSearchableSelect(wrapperId) {
            const wrapper = document.getElementById(wrapperId);
            const trigger = wrapper.querySelector('.select-trigger');
            const dropdown = wrapper.querySelector('.dropdown-menu');
            const searchInput = wrapper.querySelector('.search-input');
            const options = wrapper.querySelectorAll('.option');
            const selectedText = wrapper.querySelector('.selected-text');
            const arrowIcon = wrapper.querySelector('.arrow-icon');

            // 1. Toggle Dropdown
            trigger.addEventListener('click', (e) => {
                e.stopPropagation();
                // Tutup dropdown lain yang mungkin sedang terbuka
                document.querySelectorAll('.dropdown-menu').forEach(menu => {
                    if (menu !== dropdown) menu.classList.remove('active');
                });
                document.querySelectorAll('.arrow-icon').forEach(icon => {
                    if (icon !== arrowIcon) icon.style.transform = 'rotate(0deg)';
                });

                // Toggle menu ini
                const isActive = dropdown.classList.toggle('active');
                arrowIcon.style.transform = isActive ? 'rotate(180deg)' : 'rotate(0deg)';

                if (isActive) {
                    searchInput.value = '';
                    filterOptions('');
                    setTimeout(() => searchInput.focus(), 100);
                }
            });

            // 2. Fungsi Pencarian (Filtering)
            function filterOptions(term) {
                const lowerTerm = term.toLowerCase();
                let hasResults = false;

                options.forEach(option => {
                    const text = option.textContent.toLowerCase();
                    if (text.includes(lowerTerm)) {
                        option.style.display = 'block';
                        hasResults = true;
                    } else {
                        option.style.display = 'none';
                    }
                });

                // Opsional: tampilkan pesan "tidak ditemukan"
                const noResultMsg = wrapper.querySelector('.no-result');
                if (!hasResults) {
                    if (!noResultMsg) {
                        const li = document.createElement('li');
                        li.className = 'no-result px-4 py-2 text-sm text-slate-400 italic';
                        li.textContent = 'Tidak ditemukan';
                        wrapper.querySelector('.option-list').appendChild(li);
                    }
                } else if (noResultMsg) {
                    noResultMsg.remove();
                }
            }

            searchInput.addEventListener('input', (e) => {
                filterOptions(e.target.value);
            });

            // 3. Memilih Opsi
            wrapper.querySelector('.option-list').addEventListener('click', (e) => {
                const option = e.target.closest('.option');
                if (!option) return;

                selectedText.textContent = option.textContent;
                const value = option.dataset.value;

                console.log(`Selected in ${wrapperId}:`, value);

                if (wrapperId === "select-jenjang") {
                    opsiMateri.jenjang = value;

                    const opsiKelas = document.querySelector('#opsi-kelas');
                    const btn_opsi = document.querySelector('#button-kelas-opsi span');
                    opsiKelas.innerHTML = '';

                    let kelas = [];

                    if (value == 1 || value == 2) {
                        btn_opsi.innerHTML = 1;
                        opsiMateri.kelas = 1;
                        kelas = [{
                                id: 1,
                                kelas: '1'
                            },
                            {
                                id: 2,
                                kelas: '2'
                            },
                            {
                                id: 3,
                                kelas: '3'
                            },
                            {
                                id: 4,
                                kelas: '4'
                            },
                            {
                                id: 5,
                                kelas: '5'
                            },
                            {
                                id: 6,
                                kelas: '6'
                            },
                        ];
                    } else if (value == 3 || value == 4) {
                        btn_opsi.innerHTML = 7;
                        opsiMateri.kelas = 7;
                        kelas = [{
                                id: 7,
                                kelas: '7'
                            },
                            {
                                id: 8,
                                kelas: '8'
                            },
                            {
                                id: 9,
                                kelas: '9'
                            },
                        ];
                    } else {
                        btn_opsi.innerHTML = 10;
                        opsiMateri.kelas = 10;
                        kelas = [{
                                id: 10,
                                kelas: '10'
                            },
                            {
                                id: 11,
                                kelas: '11'
                            },
                            {
                                id: 12,
                                kelas: '12'
                            },
                        ];
                    }

                    kelas.forEach(item => {
                        opsiKelas.insertAdjacentHTML(
                            'beforeend',
                            `<li class="option px-4 py-2 text-sm cursor-pointer" data-value="${item.id}">
                                ${item.kelas}
                            </li>`
                        );
                    });

                } else if (wrapperId === "select-kelas") {
                    opsiMateri.kelas = value;
                } else if (wrapperId === "select-mapel") {
                    opsiMateri.mapel = value;
                }

                getMateri(opsiMateri.jenjang, opsiMateri.kelas, opsiMateri.mapel);

                dropdown.classList.remove('active');
                arrowIcon.style.transform = 'rotate(0deg)';
            });


            // Mencegah klik di dalam search input menutup dropdown
            searchInput.addEventListener('click', (e) => e.stopPropagation());
        }

        // Jalankan inisialisasi saat DOM siap
        document.addEventListener('DOMContentLoaded', () => {
            initSearchableSelect('select-jenjang');
            initSearchableSelect('select-kelas');
            initSearchableSelect('select-mapel');

            // Tutup semua dropdown jika klik di luar area
            document.addEventListener('click', () => {
                document.querySelectorAll('.dropdown-menu').forEach(menu => menu.classList.remove(
                'active'));
                document.querySelectorAll('.arrow-icon').forEach(icon => icon.style.transform =
                    'rotate(0deg)');
            });
        });

        const materiRoute =
            "{{ route('get_materi', ['jenjang' => '__JENJANG__', 'kelas' => '__KELAS__', 'mapel' => '__MAPEL__']) }}";
        const downloadRoute = "{{ route('materi_download', ['id' => '__ID__']) }}"

        function getMateri(jenjang, kelas, mapel) {
            materi_card_container.innerHTML = ``;
            materi_error_loading.classList.remove('hidden');
            materi_error_text.classList.add('hidden');

            const url = materiRoute
                .replace('__JENJANG__', jenjang)
                .replace('__KELAS__', kelas)
                .replace('__MAPEL__', encodeURIComponent(mapel));


            fetch(url)
                .then(res => res.json())
                .then(data => {
                    const items = data.data.data;
                    console.log(Array.isArray(items) && items.length > 0);
                    if (Array.isArray(items) && items.length > 0) {
                        items.forEach(item => {
                            const urlDownload = downloadRoute.replace('__ID__', item.id);

                            const extension = item.file_path.split('.').pop().toLowerCase();
                            console.log(item);
                            let icon =
                                '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" width="30" height="30" fill="gray"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2026 Fonticons, Inc.--><path d="M192 64C156.7 64 128 92.7 128 128L128 512C128 547.3 156.7 576 192 576L448 576C483.3 576 512 547.3 512 512L512 234.5C512 217.5 505.3 201.2 493.3 189.2L386.7 82.7C374.7 70.7 358.5 64 341.5 64L192 64zM453.5 240L360 240C346.7 240 336 229.3 336 216L336 122.5L453.5 240z"/></svg>';

                            if (extension == 'pdf') {
                                icon =
                                    '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" width="30" height="30" fill="red"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2026 Fonticons, Inc.--><path d="M128 64C92.7 64 64 92.7 64 128L64 512C64 547.3 92.7 576 128 576L208 576L208 464C208 428.7 236.7 400 272 400L448 400L448 234.5C448 217.5 441.3 201.2 429.3 189.2L322.7 82.7C310.7 70.7 294.5 64 277.5 64L128 64zM389.5 240L296 240C282.7 240 272 229.3 272 216L272 122.5L389.5 240zM272 444C261 444 252 453 252 464L252 592C252 603 261 612 272 612C283 612 292 603 292 592L292 564L304 564C337.1 564 364 537.1 364 504C364 470.9 337.1 444 304 444L272 444zM304 524L292 524L292 484L304 484C315 484 324 493 324 504C324 515 315 524 304 524zM400 444C389 444 380 453 380 464L380 592C380 603 389 612 400 612L432 612C460.7 612 484 588.7 484 560L484 496C484 467.3 460.7 444 432 444L400 444zM420 572L420 484L432 484C438.6 484 444 489.4 444 496L444 560C444 566.6 438.6 572 432 572L420 572zM508 464L508 592C508 603 517 612 528 612C539 612 548 603 548 592L548 548L576 548C587 548 596 539 596 528C596 517 587 508 576 508L548 508L548 484L576 484C587 484 596 475 596 464C596 453 587 444 576 444L528 444C517 444 508 453 508 464z"/></svg>'
                            } else if (extension == 'word') {
                                icon =
                                    '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" width="30" height="30" fill="blue"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2026 Fonticons, Inc.--><path d="M128 128C128 92.7 156.7 64 192 64L341.5 64C358.5 64 374.8 70.7 386.8 82.7L493.3 189.3C505.3 201.3 512 217.6 512 234.6L512 512C512 547.3 483.3 576 448 576L192 576C156.7 576 128 547.3 128 512L128 128zM336 122.5L336 216C336 229.3 346.7 240 360 240L453.5 240L336 122.5zM263.4 338.8C260.5 325.9 247.7 317.7 234.8 320.6C221.9 323.5 213.7 336.3 216.6 349.2L248.6 493.2C250.9 503.7 260 511.4 270.8 512C281.6 512.6 291.4 505.9 294.8 495.6L320 419.9L345.2 495.6C348.6 505.8 358.4 512.5 369.2 512C380 511.5 389.1 503.8 391.4 493.2L423.4 349.2C426.3 336.3 418.1 323.4 405.2 320.6C392.3 317.8 379.4 325.9 376.6 338.8L363.4 398.2L342.8 336.4C339.5 326.6 330.4 320 320 320C309.6 320 300.5 326.6 297.2 336.4L276.6 398.2L263.4 338.8z"/></svg>'
                            } else if (extension == 'docx') {
                                icon =
                                    '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" width="30" height="30" fill="blue"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2026 Fonticons, Inc.--><path d="M128 128C128 92.7 156.7 64 192 64L341.5 64C358.5 64 374.8 70.7 386.8 82.7L493.3 189.3C505.3 201.3 512 217.6 512 234.6L512 512C512 547.3 483.3 576 448 576L192 576C156.7 576 128 547.3 128 512L128 128zM336 122.5L336 216C336 229.3 346.7 240 360 240L453.5 240L336 122.5zM263.4 338.8C260.5 325.9 247.7 317.7 234.8 320.6C221.9 323.5 213.7 336.3 216.6 349.2L248.6 493.2C250.9 503.7 260 511.4 270.8 512C281.6 512.6 291.4 505.9 294.8 495.6L320 419.9L345.2 495.6C348.6 505.8 358.4 512.5 369.2 512C380 511.5 389.1 503.8 391.4 493.2L423.4 349.2C426.3 336.3 418.1 323.4 405.2 320.6C392.3 317.8 379.4 325.9 376.6 338.8L363.4 398.2L342.8 336.4C339.5 326.6 330.4 320 320 320C309.6 320 300.5 326.6 297.2 336.4L276.6 398.2L263.4 338.8z"/></svg>'
                            } else if (extension == 'jpg' || extension == 'png' || extension == 'jpeg' ||
                                extension == 'gif') {
                                icon =
                                    '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" width="30" height="30" fill="orange"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2026 Fonticons, Inc.--><path d="M128 128C128 92.7 156.7 64 192 64L341.5 64C358.5 64 374.8 70.7 386.8 82.7L493.3 189.3C505.3 201.3 512 217.6 512 234.6L512 512C512 547.3 483.3 576 448 576L192 576C156.7 576 128 547.3 128 512L128 128zM336 122.5L336 216C336 229.3 346.7 240 360 240L453.5 240L336 122.5zM256 320C256 302.3 241.7 288 224 288C206.3 288 192 302.3 192 320C192 337.7 206.3 352 224 352C241.7 352 256 337.7 256 320zM220.6 512L419.4 512C435.2 512 448 499.2 448 483.4C448 476.1 445.2 469 440.1 463.7L343.3 361.9C337.3 355.6 328.9 352 320.1 352L319.8 352C311 352 302.7 355.6 296.6 361.9L199.9 463.7C194.8 469 192 476.1 192 483.4C192 499.2 204.8 512 220.6 512z"/></svg>'
                            } else {
                                icon =
                                    '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" width="30" height="30" fill="gray"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2026 Fonticons, Inc.--><path d="M192 64C156.7 64 128 92.7 128 128L128 512C128 547.3 156.7 576 192 576L448 576C483.3 576 512 547.3 512 512L512 234.5C512 217.5 505.3 201.2 493.3 189.2L386.7 82.7C374.7 70.7 358.5 64 341.5 64L192 64zM453.5 240L360 240C346.7 240 336 229.3 336 216L336 122.5L453.5 240z"/></svg>'
                            }

                            const grade = item.grade;
                            let jenjangText = 'SD';

                            if (grade == 1) {
                                jenjangText = 'SD'
                            } else if (grade == 2) {
                                jenjangText = 'MI'
                            } else if (grade == 3) {
                                jenjangText = 'SMP'
                            } else if (grade == 4) {
                                jenjangText = 'MTS'
                            } else if (grade == 5) {
                                jenjangText = 'SMA'
                            } else if (grade == 6) {
                                jenjangText = 'MA'
                            } else if (grade == 7) {
                                jenjangText = 'SMK'
                            }

                            materi_card_container.innerHTML += `<div class="flex flex-col bg-white dark:bg-slate-800/50 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden group">
                                <div class="p-5 flex flex-col flex-grow">
                                    <!-- Header Kartu: Ikon & Badge -->
                                    <div class="flex justify-between items-start mb-4">
                                        <div class="w-12 h-12 flex items-center justify-center bg-red-50 dark:bg-red-900/20 rounded-xl text-red-500 text-2xl group-hover:scale-110 transition-transform duration-300">
                                            ${icon}
                                        </div>
                                        <div class="flex flex-col items-end gap-1">
                                            <span class="text-[10px] font-bold px-2 py-0.5 bg-blue-100 dark:bg-blue-900/40 text-blue-700 dark:text-blue-300 rounded-full uppercase tracking-wider">${jenjangText}</span>
                                            <span class="text-[11px] text-slate-400 dark:text-slate-500 font-medium">${item.total_download} Unduhan</span>
                                        </div>
                                    </div>
                                    
                                    <!-- Judul & Sekolah -->
                                    <div class="mb-3">
                                        <h3 class="font-bold text-slate-900 dark:text-slate-100 leading-tight mb-1 line-clamp-2 min-h-[2.5rem]">
                                            ${item.name}
                                        </h3>
                                        <p class="text-xs text-indigo-600 dark:text-indigo-400 font-semibold flex items-center gap-1">
                                            <i class="fa-solid fa-school text-[10px]"></i>
                                            ${item.school_name}
                                        </p>
                                    </div>

                                    <!-- Deskripsi -->
                                    <p class="text-xs text-slate-500 dark:text-slate-400 line-clamp-3 mb-4 leading-relaxed">
                                        ${item.summary}
                                    </p>
                                    
                                    <div class="mt-auto pt-4 border-t border-slate-100 dark:border-slate-700/50 flex items-center justify-between">
                                        <span class="text-xs text-slate-400 dark:text-slate-500 font-medium">Kelas ${item.classroom}</span>
                                        <span class="text-[10px] font-bold text-slate-300 dark:text-slate-600 uppercase tracking-widest">${extension}</span>
                                    </div>
                                </div>

                                <!-- Tombol Action -->
                                <div class="p-4 bg-slate-50 dark:bg-slate-900/50 border-t border-slate-100 dark:border-slate-700/50">
                                    <a href="${urlDownload}" class="w-full flex items-center justify-center gap-2 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-all font-semibold text-sm shadow-sm active:scale-95">
                                        <i class="fa-solid fa-download"></i>
                                        <span>Download Materi</span>
                                    </a>
                                </div>
                            </div>`;
                        })
                    } else {
                        materi_error_text.classList.remove('hidden');
                        materi_error_text.innerHTML = 'Data Materi Tidak Ditemukan';
                    }
                    materi_error_loading.classList.add('hidden');
                })
                .catch(err => {
                    materi_error_text.classList.remove('hidden');
                    materi_error_text.innerHTML = 'Terjadi Kesalahan Saat Mengambil Data';
                    materi_error_loading.classList.add('hidden');
                    console.error(err)
                });
        }
        getMateri(1, 1, 'semua');
    </script>
</body>

</html>
