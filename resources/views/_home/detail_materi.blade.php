@extends('_home._layout.main')

@section('title')
    Kumpulan Materi
@endsection

@section('content')
    <x-home.navbar 
    :link="[
        'beranda'   => route('landing'),
        'fitur'     => route('landing') . '#fitur',
        'materi'    => route('kumpulan_materi'),
        'testimoni' => route('landing') . '#testimoni',
        'galeri'    => route('landing') . '#galeri',
        'tentang'   => route('landing') . '#tentang',
    ]"
    linkbtn="{{ route('login') }}" linkactive="materi" :sectionscriptjs="false" />


    <!-- MATERI SECTION -->
    <section id="materi" class="pt-30">
      <div class="flex items-center flex-col">
            <h1 class="text-2xl -mb-2 min-[420px]:text-3xl min-[570px]:text-3xl md:text-4xl font-fredoka font-semibold text-center">Materi Matematika</h1>

            <form class="searchingtext kategoripage">
                <div>
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" placeholder="Cari Modul Berdasarkan Nama...">
                </div>
                <button>Cari <span>Modul</span></button>
            </form>

            <div class="flex flex-wrap justify-center gap-6 mt-6">
                <div class="badge-sort-class active">Kelas 7</div>
                <div class="badge-sort-class">Kelas 8</div>
                <div class="badge-sort-class">Kelas 9</div>
            </div>
        </div>

      <div id="container_card_kategori" class="grid grid-cols-1 min-[768px]:grid-cols-2 min-[1000px]:grid-cols-3 min-[1300px]:grid-cols-4 min-[1500px]:grid-cols-5 min-[1700px]:grid-cols-6 mt-10 justify-items-center gap-10">
        <x-home.modul-card image="home/images/penginapan/1.jpg" text="Matematika" materi_count="10" kelas_count="6" link="kumpulan_materi" />
        <x-home.modul-card image="home/images/penginapan/1.jpg" text="Ilmu Pengetahuan Alam" materi_count="10" kelas_count="6" link="kumpulan_materi" />
        <x-home.modul-card image="home/images/penginapan/1.jpg" text="Ilmu Pengetahuan Sosial" materi_count="10" kelas_count="6" link="kumpulan_materi" />
        <x-home.modul-card image="home/images/penginapan/1.jpg" text="Bahasa Indonesia" materi_count="10" kelas_count="6" link="kumpulan_materi" />
        <x-home.modul-card image="home/images/penginapan/1.jpg" text="Bahasa Inggris" materi_count="10" kelas_count="6" link="kumpulan_materi" />
        <x-home.modul-card image="home/images/penginapan/1.jpg" text="Pendidikan Pancasila & Kewarganegaraan" materi_count="10" kelas_count="6" link="kumpulan_materi" />
        <x-home.modul-card image="home/images/penginapan/1.jpg" text="Pendidikan Agama" materi_count="10" kelas_count="6" link="kumpulan_materi" />
        <x-home.modul-card image="home/images/penginapan/1.jpg" text="Seni Budaya & Prakarya" materi_count="10" kelas_count="6" link="kumpulan_materi" />
      </div>
    </section>

    <!-- Overlay -->
    <div class="bgblur"></div>
    <!-- Modal -->
    <div id="detail_modul_modal" class="fixed top-1/2 left-1/2 -translate-1/2 z-[100] w-[90%] max-w-4xl h-[600px] bg-white rounded-xl shadow-2xl overflow-auto transition duration-500 scale-0">

        <!-- Header -->
        <div class="flex items-center justify-between px-5 py-4 border-b">
            <h3 class="text-lg font-semibold text-gray-800">
                Contoh Modul
            </h3>

            <!-- Close Button -->
            <button class="text-gray-500 hover:text-gray-800 text-xl font-bold cursor-pointer" id="close_detail_modul_modal">
                ✕
            </button>
        </div>

        <!-- Content -->
        <div class="grid grid-cols-1 md:grid-cols-3">

            <!-- Preview Dokumen -->
            <div class="md:col-span-2 px-4 pt-4">
                <iframe
                src="https://docs.google.com/gview?url=https://pusdapol.ummat.ac.id/id/eprint/193/1/LAPORAN%20PKL%20RISKA.pdf&embedded=true"
                class="w-full h-[500px] rounded-lg border">
                </iframe>
            </div>

            <!-- Sidebar Info -->
            <div class="p-4 border-l bg-gray-50 flex flex-col">
                <h4 class="text-md font-semibold mb-2 text-gray-800">
                Ringkasan Materi
                </h4>

                <p class="text-sm text-gray-600 mb-4 leading-relaxed">hahahaha
                </p>

                <!-- Action -->
                <a 
                href="https://pusdapol.ummat.ac.id/id/eprint/193/1/LAPORAN%20PKL%20RISKA.pdf"
                target="_blank"
                class="mt-4 inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg bg-blue-600 text-white text-sm font-medium hover:bg-blue-700 transition">
                ⬇ Download Modul
                </a>
            </div>

        </div>

    </div>

    <script>
        const modul_card = document.querySelectorAll('#modul_card');
        const bgblur = document.querySelector('.bgblur');
        const close_detail_modul_modal = document.querySelector('#close_detail_modul_modal');
        const detail_modul_modal = document.querySelector('#detail_modul_modal');

        modul_card.forEach(card => {
            card.addEventListener('click', () => {
                detail_modul_modal.classList.remove('scale-0');
                bgblur.classList.add('active');
            });
        });

        close_detail_modul_modal.addEventListener('click', () => {
            detail_modul_modal.classList.add('scale-0');
            bgblur.classList.remove('active');
        });
    </script>

@endsection