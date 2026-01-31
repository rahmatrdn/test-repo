@extends('_home._layout.main')

@section('title')
    Kumpulan Materi
@endsection

@section('content')
    <x-home.navbar 
    :link="[
        'beranda'   => route('landing'),
        'fitur'     => route('landing') . '#fitur',
        'materi'    => route('detail_materi'),
        'testimoni' => route('landing') . '#testimoni',
        'galeri'    => route('landing') . '#galeri',
        'tentang'   => route('landing') . '#tentang',
    ]"
    linkbtn="{{ route('login') }}" linkactive="materi" :sectionscriptjs="false" />


    <!-- MATERI SECTION -->
    <section id="materi" class="pt-30">
      <div class="flex items-center flex-col">
            <h1 class="text-2xl min-[420px]:text-3xl min-[570px]:text-3xl md:text-4xl font-fredoka font-semibold text-center">Temukan Materi Sekolah Menengah Pertama</h1>
            <p class="text-[12px] min-[420px]:text-[13px] min-[570px]:text-sm md:text-[15px] text-center mt-2">Jelajahi berbagai materi dan referensi bermanfaat sesuai minatmu, <b>mulai dari wawasan edukasi, budaya, hingga pengetahuan praktis</b> yang relevan.</p>

            <form class="searchingtext kategoripage">
                <div>
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" placeholder="Cari Materi Berdasarkan Nama...">
                </div>
                <button>Cari <span>Materi</span></button>
            </form>
        </div>

      <div id="container_card_kategori" class="grid grid-cols-1 min-[768px]:grid-cols-2 min-[1000px]:grid-cols-3 min-[1300px]:grid-cols-4 min-[1500px]:grid-cols-5 min-[1700px]:grid-cols-6 mt-10 justify-items-center gap-10">
        @forelse($subjects as $subject)
          <x-home.materi-card 
            image="home/images/penginapan/1.jpg" 
            text="{{ $subject->name }}" 
            materi_count="10" 
            kelas_count="6" 
            link="detail_materi" 
            suffix="Modul" 
          />
        @empty
          <div class="col-span-full text-center py-10">
            <p class="text-gray-500">Belum ada mata pelajaran untuk jenjang ini.</p>
          </div>
        @endforelse
      </div>
    </section>
@endsection