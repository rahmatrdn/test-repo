@extends('_home._layout.main')

@section('title')
    Beranda
@endsection

@section('content')
    <x-home.navbar linkbtn="{{ route('login') }}"></x-home.navbar>
          
    <!-- HERO SECTION -->
    <section id="beranda" class="pt-30 overflow-hidden relative">
      <div class="h-full w-full absolute top-0 left-0 -z-1">
        <svg class="-rotate-180 top-0 absolute" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
          <path class="fill-gray-100" fill-opacity="1" d="M0,128L60,112C120,96,240,64,360,74.7C480,85,600,139,720,149.3C840,160,960,128,1080,144C1200,160,1320,224,1380,256L1440,288L1440,320L1380,320C1320,320,1200,320,1080,320C960,320,840,320,720,320C600,320,480,320,360,320C240,320,120,320,60,320L0,320Z"></path>
        </svg>
        <div class="bg-transparent size-20 absolute top-100 left-50 rounded-full border-5 border-blue-500/20"></div>
        <div class="bg-transparent size-10 absolute bottom-70 left-150 rounded-full border-5 border-blue-500/20"></div>
        <div class="bg-transparent size-15 absolute bottom-20 left-50 rounded-full border-5 border-blue-500/20"></div>
      </div>
      <div class="flex flex-col-reverse min-[990px]:flex-row items-center justify-between gap-x-20 overflow-hidden px-5 min-[450px]:px-10 min-[700px]:px-20">
        <div class="flex-1 mt-15 min-[990px]:mt-0">
          <p class="px-5 inline-block text-[12px] min-[750px]:text-[13px] min-[1040px]:text-[14px] py-2 bg-gray-200 text-blue-500 font-semibold rounded-full">Ayo Belajar Bersama</p>
          <h1 class="font-fredoka text-[30px] min-[475px]:text-[35px] min-[670px]:text-[30px] min-[750px]:text-[35px] min-[1120px]:text-[43px] min-[1250px]:text-[50px] min-[1270px]:text-[55px] 2xl:text-7xl font-semibold leading-15 min-[1120px]:leading-20 2xl:leading-24 min-[1120px]:mt-2 mb-3 flex items-start min-[670px]:items-center min-[990px]:items-start flex-col min-[670px]:flex-row min-[990px]:flex-col">
            <div>
              Platform Pembelajaran Digital untuk 
              <span class="slidetexthero">
                  <span class="wrapper">
                      <span>Membangun</span>
                      <span>Mencetak</span>
                      <span>Mewujudkan</span>
                  </span>
              </span>
            </div>
          Kompetensi Nyata</h1>
        <p class="text-sm min-[1120px]:text-[15px] min-[1270px]:text-[16px]">Platform pembelajaran digital yang membantu kamu membangun kompetensi nyata melalui materi terstruktur, berbasis praktik, dan sesuai kebutuhan industri.</p>
        <div class="flex flex-col gap-y-5 min-[510px]:gap-y-0 min-[510px]:flex-row gap-x-8 items-center mt-8">
          <a href="#terdekat" class="linkhoveranimation text-[13px] min-[1030px]:text-sm min-[1120px]:text-[15px] filled">@include('_home.icons.rocket') Mulai Pembelajaran</a>
          <a href="#populer" class="linkhoveranimation text-[13px] min-[1030px]:text-sm min-[1120px]:text-[15px]">Eksplore Program @include('_home.icons.book-search')</a>
        </div>
        <div class="grid grid-cols-2 min-[560px]:grid-cols-4 mt-10 min-[1040px]:mt-15 gap-x-20 gap-y-10 min-[560px]:gap-y-0">
            <div class="statistikhero">
                <h1>1,2K+</h1>
                <p>Pengguna Terdaftar</p>
            </div>
            <div class="statistikhero">
              <h1>12+</h1>
              <p>Partner Sekolah</p>
            </div>
            <div class="statistikhero">
              <h1>100+</h1>
              <p>Modul Interaktif</p>
            </div>
            <div class="statistikhero">
              <h1>5+</h1>
              <p>Tahun Bergerak</p>
            </div>
        </div>
        </div>
        <div class="w-[300px] min-[480px]:w-[350px] min-[540px]:w-[400px] min-[590px]:w-[450px] min-[990px]:w-[320px] min-[1040px]:w-[350px] min-[1090px]:w-[400px] min-[1170px]:w-[450px] 2xl:w-[700px] relative font-fredoka">
          <div class="absolute top-1/2 -left-10 size-30 bg-blue-500/20 z-1"></div>
          <div class="absolute top-1/3 -right-10 size-30 bg-blue-500/10 z-1"></div>
          <x-home.floating-mini-card text="Profesional" class="right-[40%] top-14">
            @include('_home.icons.star')
          </x-home.floating-mini-card>
          <x-home.floating-mini-card text="Berkualitas" class="left-[20%] top-[40%]">
            @include('_home.icons.badge-check')
          </x-home.floating-mini-card>
          <x-home.floating-mini-card text="Bersertifikat" class="right-[40%] min-[1040px]:right-[30%] bottom-[30%]">
            @include('_home.icons.trophy')
          </x-home.floating-mini-card>
          <img src={{ asset("/home/images/gambar_home/hero_section.png") }} class="w-[700px] relative top-0 z-5" alt="Hero Section Image" />
        </div>
      </div>
    </section>
    {{-- <div class="md:my-0 my-10 relative px-5 min-[450px]:px-10 min-[700px]:px-20">
        <div class="pointer-events-none absolute left-0 top-0 h-full w-5 min-[990px]:w-10 bg-linear-to-r from-gray-50 via-gray-50/80 to-transparent z-10"></div>
        <div class="pointer-events-none absolute right-0 top-0 h-full w-5 min-[990px]:w-10 bg-linear-to-l from-gray-50 via-gray-50/80 to-transparent z-10"></div>
        
        <div class="w-full overflow-hidden relative h-52">
          <div class="supportinglogomarqueehero">
            @include('components.home.logo-supporting-marquee')
          </div>
        </div>
    </div> --}}
        
    <!-- FITUR SECTION -->
    <section id="fitur" class="pt-30">
      <div class="titleSectionHome">
        <div>
            <h4 class="font-latin subtitle">Fitur Terbaik Belajar</h4>
            <h2 class="font-fredoka title">Eksplorasi Fitur Membantu Belajar</h2>
        </div>
        {{-- <a class="link linkhoveranimation text-[15px]" href='/wisata.html'>Terus Jelajahi <i class="fa-solid fa-arrow-right"></i></a> --}}
      </div>

      <div class="grid grid-cols-1 min-[900px]:grid-cols-2 min-[1260px]:grid-cols-3 justify-items-center 2xl:grid-cols-4 mt-30 gap-y-40">
        <x-home.card-fiture
            img="home/images/gambar_home/management-guru.jpeg"
            title="Management Data Guru"
            text="Kelola data guru secara terstruktur, mulai dari profil, jadwal mengajar, hingga riwayat aktivitas untuk mendukung proses administrasi sekolah."
            href="/"
            hrefText="Selengkapnya"
        />

        <x-home.card-fiture
            img="home/images/gambar_home/management-siswa.jpeg"
            title="Management Data Siswa"
            text="Atur dan pantau data siswa dengan mudah, mencakup identitas, kelas, perkembangan belajar, serta riwayat akademik secara terpusat."
            href="/"
            hrefText="Selengkapnya"
        />

        <x-home.card-fiture
            img="home/images/gambar_home/management-materi.jpeg"
            title="Kelola Materi Belajar"
            text="Kelola dan susun materi pembelajaran secara rapi, mulai dari modul, video, hingga dokumen pendukung untuk proses belajar."
            href="/"
            hrefText="Selengkapnya"
        />

        <x-home.card-fiture
            img="home/images/penginapan/1.jpg"
            title="Generate Gambar & Materi"
            text="Buat gambar dan materi pembelajaran secara otomatis menggunakan teknologi AI untuk mendukung kreativitas guru dan siswa."
            href="/"
            hrefText="Selengkapnya"
        />

        <x-home.card-fiture
            img="home/images/penginapan/1.jpg"
            title="Akses Materi Belajar"
            text="Akses berbagai materi belajar kapan saja dan di mana saja untuk mendukung proses pembelajaran yang fleksibel dan efektif."
            href="/"
            hrefText="Selengkapnya"
        />

        <x-home.card-fiture
            img="home/images/penginapan/1.jpg"
            title="AI Summary"
            text="Ringkas materi pembelajaran secara cepat dan akurat menggunakan AI agar lebih mudah dipahami dan dipelajari oleh siswa."
            href="/"
            hrefText="Selengkapnya"
        />
      </div>
    </section> 

    <!-- MATERI SECTION -->
    <section id="materi" class="pt-30">
      <div class="titleSectionHome">
        <div>
            <h4 class="font-latin subtitle">Kumpulan Materi Belajar</h4>
            <h2 class="font-fredoka title">Materi Belajar Dari Guru</h2>
        </div>
        {{-- <a class="link linkhoveranimation text-[15px]" href='/wisata.html'>Terus Jelajahi <i class="fa-solid fa-arrow-right"></i></a> --}}
      </div>

      <div id="container_card_kategori" class="grid grid-cols-1 min-[768px]:grid-cols-2 min-[1000px]:grid-cols-3 min-[1300px]:grid-cols-4 min-[1500px]:grid-cols-5 min-[1700px]:grid-cols-6 mt-10 justify-items-center gap-10">
        @php
          use App\Constants\GradeConst;
          $grades = GradeConst::getGrades();
          $gradeImages = [
            GradeConst::SD => 'home/images/gambar_home/sekolah_dasar.jpg',
            GradeConst::SMP => 'home/images/gambar_home/sekolah_menengah_pertama.jpg',
            GradeConst::SMK => 'home/images/gambar_home/sekolah_menengah_kejuruan.jpg',
          ];
        @endphp
        
        @foreach($grades as $gradeId => $gradeName)
          <x-home.materi-card 
            image="{{ $gradeImages[$gradeId] ?? 'home/images/gambar_home/umum.jpg' }}" 
            text="{{ $gradeName }}" 
            materi_count="10" 
            sekolah_count="{{ $gradeData[$gradeId]['count'] ?? 0 }}" 
            link="kumpulan_materi" 
          />
        @endforeach
      </div>
    </section> 

    <!-- TESTIMONI SECTION -->
    <section id="testimoni" class="pt-30">
      <div class="flex flex-col items-center">
        <h5 class="text-center font-latin text-[20px] min-[475px]:text-xl min-[550px]:text-2xl text-blue-500 font-semibold">Testimoni Pengguna</h5>
        <h3 class="text-center font-extrabold text-2xl min-[475px]:text-3xl min-[550px]:text-4xl font-fredoka tracking-widest -mt-1">APA KATA MEREKA ?</h3>
        <p class="text-center text-[13px] min-[475px]:text-sm min-[550px]:text-[15px] mb-10 mt-3 w-full min-[750px]:w-[700px]">Platform ini membantu mempermudah proses belajar dan pengelolaan data sekolah. Fitur yang lengkap dan mudah digunakan membuat aktivitas belajar mengajar menjadi lebih efektif dan terorganisir.</p>
      </div>

      @php
        $testimonials = [
          [
            'img' => '/home/images/avatar/1.png',
            'name' => 'Fahmy Bima Az Zukhruf',
            'role' => 'Siswa SMKN 8 JEMBER',
            'message' => 'Platform Smart Sekolah sangat membantu saya dalam mengakses materi pembelajaran dengan mudah. Fitur-fiturnya lengkap dan mudah dipahami, membuat belajar jadi lebih menyenangkan.'
          ],
          [
            'img' => '/home/images/avatar/2.png',
            'name' => 'Siti Nurhaliza',
            'role' => 'Guru SMP Negeri 5 Jember',
            'message' => 'Dengan Smart Sekolah, mengelola materi dan tugas siswa menjadi jauh lebih efisien. Sistem yang terintegrasi memudahkan saya dalam memantau perkembangan belajar siswa.'
          ],
          [
            'img' => '/home/images/avatar/3.png',
            'name' => 'Ahmad Zainudin',
            'role' => 'Kepala Sekolah SD Negeri 3 Jember',
            'message' => 'Smart Sekolah memberikan solusi terbaik untuk digitalisasi sekolah kami. Administrasi menjadi lebih rapi dan proses pembelajaran lebih terstruktur.'
          ],
          [
            'img' => '/home/images/avatar/4.png',
            'name' => 'Dewi Kartika',
            'role' => 'Siswa SMA Negeri 2 Jember',
            'message' => 'Saya sangat terbantu dengan adanya fitur AI Summary yang bisa merangkum materi panjang menjadi lebih singkat. Sangat cocok untuk persiapan ujian!'
          ],
          [
            'img' => '/home/images/avatar/5.png',
            'name' => 'Bambang Sutrisno',
            'role' => 'Guru SMK Negeri 1 Jember',
            'message' => 'Fitur generate gambar dan materi dengan AI sangat inovatif. Membantu saya membuat konten pembelajaran yang lebih menarik dan interaktif untuk siswa.'
          ],
          [
            'img' => '/home/images/avatar/6.png',
            'name' => 'Rina Agustina',
            'role' => 'Orang Tua Siswa',
            'message' => 'Sebagai orang tua, saya merasa lebih tenang karena bisa memantau perkembangan belajar anak melalui platform ini. Sistemnya transparan dan mudah digunakan.'
          ]
        ];
      @endphp

      <div class="grid grid-cols-1 min-[875px]:grid-cols-2 min-[1250px]:grid-cols-3 gap-5">
        @foreach($testimonials as $testimonial)
          <x-home.card-testimoni 
            img="{{ $testimonial['img'] }}" 
            name="{{ $testimonial['name'] }}" 
            role="{{ $testimonial['role'] }}" 
            message="{{ $testimonial['message'] }}" 
          />
        @endforeach
      </div>
    </section>

    <!-- GALERI SECTION -->
    <section id="galeri" class="pt-30">
      <div class="titleSectionHome">
        <div>
            <h4 class="font-latin subtitle">Galeri Smart Sekolah</h4>
            <h2 class="font-fredoka title">Dokumentasi Perjalanan Kami</h2>
        </div>
        {{-- <a class="link linkhoveranimation text-[15px]" href='/wisata.html'>Terus Jelajahi <i class="fa-solid fa-arrow-right"></i></a> --}}
      </div>

      <div class="grid grid-cols-1 min-[780px]:grid-cols-2 min-[1090px]:grid-cols-3 min-[1390px]:grid-cols-4 min-[1700px]:grid-cols-4 gap-5 mt-10 justify-items-center">
        <x-home.card-gallery
            img="home/images/gallery/gallery1.jpg"
            title="Promosi Smart Sekolah"
            date="13 Agustus 2025"
            deskripsi="Kegiatan promosi Smart Sekolah untuk memperkenalkan platform pembelajaran digital kepada siswa dan tenaga pendidik."
        />

        <x-home.card-gallery
            img="home/images/gallery/gallery2.jpg"
            title="MOU Oleh RPL SMKN 8 JEMBER"
            date="13 Agustus 2025"
            deskripsi="Penandatanganan nota kesepahaman sebagai bentuk kerja sama pengembangan pembelajaran digital berbasis industri."
        />

        <x-home.card-gallery
            img="home/images/gallery/gallery3.jpg"
            title="Demonstrasi Smart Sekolah"
            date="22 Oktober 2025"
            deskripsi="Sesi demonstrasi penggunaan platform Smart Sekolah untuk menunjukkan fitur dan manfaat sistem pembelajaran."
        />

        <x-home.card-gallery
            img="home/images/gallery/gallery4.jpg"
            title="Tim Developer Smart Sekolah"
            date="20 November 2025"
            deskripsi="Dokumentasi tim developer Smart Sekolah yang berperan dalam pengembangan dan inovasi platform."
        />

        <x-home.card-gallery
            img="home/images/gallery/gallery5.jpg"
            title="Demonstrasi Smart Sekolah"
            date="11 Desember 2025"
            deskripsi="Demonstrasi lanjutan platform Smart Sekolah dalam mendukung proses belajar mengajar yang lebih interaktif."
        />

        <x-home.card-gallery
            img="home/images/gallery/gallery6.jpg"
            title="Smart Sekolah Recruitment Magang"
            date="01 Januari 2026"
            deskripsi="Kegiatan rekrutmen program magang Smart Sekolah untuk menjaring talenta muda di bidang teknologi pendidikan."
        />

      </div>
    </section>

    <!-- Overlay -->
    <div class="bgblur"></div>
    <!-- Modal -->
    <div id="detail_gallery_modal" class="fixed top-1/2 left-1/2 -translate-1/2 z-[100] w-[90%] max-w-4xl h-[600px] bg-white rounded-xl shadow-2xl overflow-auto transition duration-500 scale-0">

        <!-- Header -->
        <div class="flex items-center justify-between px-5 py-4 border-b">
            <h3 id="title_gallery_modal" class="text-lg font-semibold text-gray-800">
                Judul Gambar
            </h3>

            <!-- Close Button -->
            <button class="text-gray-500 hover:text-gray-800 text-xl font-bold cursor-pointer" id="close_detail_gallery_modal">
                ✕
            </button>
        </div>

        <!-- Content -->
        <div class="grid grid-cols-1 md:grid-cols-3">

            <!-- Preview Dokumen -->
            <div class="md:col-span-2 px-4 pt-4">
                <div class="w-full h-[500px] rounded-lg border flex justify-center items-center overflow-hidden">
                    <img id="image_gallery_modal" src="{{ asset('/home/images/gambar_home/sekolah_dasar.jpg') }}" alt="Preview Dokumen" class="max-w-full max-h-[500px] h-auto"/>
                </div>
            </div>

            <!-- Sidebar Info -->
            <div class="p-4 border-l bg-gray-50 flex flex-col">
                <h4 class="text-md font-semibold mb-2 text-gray-800">
                  Deskripsi
                </h4>

                <p id="deskripsi_gallery_modal" class="text-sm text-gray-600 mb-4 leading-relaxed">hahahaha
                </p>

                <!-- Action -->
                <button id="download-image" 
                class="mt-4 inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg bg-blue-600 text-white text-sm font-medium hover:bg-blue-700 transition">
                ⬇ Download Gambar
                </button>
            </div>

        </div>

    </div>

    <!-- TENTANG KAMI SECTION -->
    <section id="tentang" class="pt-30">
      <div class="flex flex-col min-[901px]:flex-row justify-between gap-7 min-[950px]:gap-15 2xl:gap-25 items-center">
        <div class="grid grid-cols-2 gap-2 min-[370px]:h-[250px] h-[300px] min-[485px]:h-[350px] min-[600px]:h-[450px] min-[901px]:h-[350px] min-[1060px]:h-[450px] 2xl:h-[550px] items-center justify-items-center">
          <div>
            <div class="w-[150px] h-[200px] min-[370px]:h-[230px] min-[404px]:w-[180px] min-[404px]:h-[250px] min-[485px]:w-[200px] min-[485px]:h-[300px] min-[600px]:w-[250px] min-[600px]:h-[360px] min-[901px]:w-[200px] min-[901px]:h-[300px] min-[1060px]:w-[250px] min-[1060px]:h-[360px] 2xl:w-[300px] 2xl:h-[400px] rounded-2xl shadow-xl overflow-hidden">
              <img src="{{ asset('/home/images/gambar_home/about1.jpg') }}"  alt="Image About 1" class="w-full h-full object-cover"/>
            </div>
          </div>
          <div class="flex flex-col gap-5 justify-center">
            <div class="w-[120px] h-[100px] min-[370px]:w-[135px] min-[370px]:h-[120px] min-[404px]:w-[150px] min-[404px]:h-[130px] min-[485px]:w-[180px] min-[485px]:h-[180px] min-[600px]:w-[230px] min-[600px]:h-[230px] min-[901px]:w-[180px] min-[901px]:h-[180px] min-[1060px]:w-[230px] min-[1060px]:h-[230px] 2xl:w-[350px] 2xl:h-[250px] rounded-2xl shadow-xl overflow-hidden">
              <img src="{{ asset('/home/images/gambar_home/about2.jpg') }}"  alt="Image About 2" class="w-full h-full object-cover"/>
            </div>
            <div class="w-[90px] h-20 min-[370px]:w-[100px] min-[370px]:h-[90px] min-[404px]:w-[120px] min-[404px]:h-[90px] min-[485px]:w-[180px] min-[485px]:h-[150px] 2xl:w-[280px] 2xl:h-60 rounded-2xl shadow-xl overflow-hidden">
              <img src="{{ asset('/home/images/gambar_home/about3.jpg') }}"  alt="Image About 3" class="w-full h-full object-cover"/>
            </div>
          </div>
        </div>
        <div class="flex-1">
          <h3 class="font-latin text-blue-500 text-[20px] xl:text-2xl 2xl:text-3xl -mb-3">
            Jelajahi Potensi Belajarmu
          </h3>
          <h1 class="font-fredoka text-2xl xl:text-3xl 2xl:text-4xl font-semibold">
            Inspirasi untuk Belajar Lebih Baik
          </h1>
          <p class="mt-5 text-sm xl:text-[15px] 2xl:text-[16px]">Smart Sekolah adalah platform pembelajaran digital yang membantu kamu membangun kompetensi nyata melalui materi yang terstruktur, berbasis praktik, dan dirancang sesuai dengan kebutuhan industri. Kami berkomitmen menghadirkan pengalaman belajar yang lebih mudah, relevan, dan efektif melalui akses materi, latihan, serta panduan pembelajaran yang kamu butuhkan.</p>
          <p class="mt-3 text-sm xl:text-[15px] 2xl:text-[16px]">Didirikan oleh Tim Smartlogy pada tahun 2026, platform ini dibangun untuk mendukung transformasi pendidikan dengan menghadirkan konten berkualitas, teknologi modern, serta tampilan yang ramah pengguna.</p>
          
          <div class="visimisiswapperabout hidden xl:block">
            <div class="button-container">
              <button id="visibtn">VISI</button>
              <button id="misibtn">MISI</button>
              <div id="visimisiindicator"></div>
            </div>
            <div class="content-text">
              <div id="contentBoxVisiMisi">
                <p id="visicontent">
                  Menjadi platform pembelajaran digital unggulan yang membantu menciptakan generasi
                  kompeten, adaptif, dan siap menghadapi kebutuhan dunia industri melalui teknologi
                  pendidikan yang inovatif.
                </p>
                <ol id="misicontent">
                  <li>Materi pembelajaran terstruktur, relevan, dan berbasis praktik.</li>
                  <li>Mendukung peningkatan kompetensi siswa dan tenaga pendidik sesuai kebutuhan industri.</li>
                  <li>Menghadirkan pengalaman belajar digital yang mudah diakses, modern, dan menyenangkan.</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="visimisiswapperabout block xl:hidden">
        <div class="button-container">
          <button id="visibtn">VISI</button>
          <button id="misibtn">MISI</button>
          <div id="visimisiindicator"></div>
        </div>
        <div class="content-text">
          <div id="contentBoxVisiMisi">
            <p id="visicontent">Menjadi platform informasi wisata terdepan di Indonesia yang menginspirasi jutaan traveler untuk menjelajahi keindahan negeri, memperkenalkan pesona budaya lokal, serta mendukung pertumbuhan pariwisata berkelanjutan di seluruh nusantara.</p>
            <ol id="misicontent">
              <li>Menyediakan informasi destinasi dan penginapan yang akurat, menarik, dan mudah diakses.</li>
              <li>Mendukung pariwisata lokal dengan menampilkan potensi terbaik dari setiap daerah.</li>
              <li>Menghadirkan pengalaman digital yang modern dan menyenangkan bagi setiap pengguna.</li>
            </ol>
          </div>
        </div>
      </div>

      <div>
        <h2 class="font-bold font-fredoka text-[22px] min-[475px]:text-2xl my-10 text-center">KONTRIBUTOR</h2>
        <div class="grid grid-cols-1 min-[575px]:grid-cols-2 min-[875px]:grid-cols-3 min-[1600px]:grid-cols-4 min-[1600px]:grid-cols-6 gap-5 justify-items-center">
          <x-home.card-kontributor linkinstagram="#" linklinkedin="#" linkgithub="#" nama="Fahmy Bima Az Zukhruf" role="Frontend Developer" profileimage="/home/images/avatar/1.png" />
          <x-home.card-kontributor linkinstagram="#" linklinkedin="#" linkgithub="#" nama="Fahmy Bima Az Zukhruf" role="Frontend Developer" profileimage="/home/images/avatar/2.png" />
          <x-home.card-kontributor linkinstagram="#" linklinkedin="#" linkgithub="#" nama="Fahmy Bima Az Zukhruf" role="Frontend Developer" profileimage="/home/images/avatar/3.png" />
          <x-home.card-kontributor linkinstagram="#" linklinkedin="#" linkgithub="#" nama="Fahmy Bima Az Zukhruf" role="Frontend Developer" profileimage="/home/images/avatar/4.png" />
          <x-home.card-kontributor linkinstagram="#" linklinkedin="#" linkgithub="#" nama="Fahmy Bima Az Zukhruf" role="Frontend Developer" profileimage="/home/images/avatar/5.png" />
          <x-home.card-kontributor linkinstagram="#" linklinkedin="#" linkgithub="#" nama="Fahmy Bima Az Zukhruf" role="Frontend Developer" profileimage="/home/images/avatar/6.png" />
        </div>
      </div>
    </section>

    <script>
        const card_gallery = document.querySelectorAll('.card-gallery-home');
        const bgblur = document.querySelector('.bgblur');
        const close_detail_gallery_modal = document.querySelector('#close_detail_gallery_modal');
        const detail_gallery_modal = document.querySelector('#detail_gallery_modal');
        const title_gallery_modal = document.querySelector('#title_gallery_modal');
        const image_gallery_modal = document.querySelector('#image_gallery_modal');
        const deskripsi_gallery_modal = document.querySelector('#deskripsi_gallery_modal');

        card_gallery.forEach(card => {
            card.querySelector('#maximize-gallery-card').addEventListener('click', () => {
              const title = card.dataset.title;
              const image = card.dataset.src;
              const deskripsi = card.dataset.deskripsi;

              title_gallery_modal.textContent = title;
              image_gallery_modal.src = image;
              deskripsi_gallery_modal.textContent = deskripsi;

              detail_gallery_modal.classList.remove('scale-0');
              bgblur.classList.add('active');
            });
        });

        close_detail_gallery_modal.addEventListener('click', () => {
            detail_gallery_modal.classList.add('scale-0');
            bgblur.classList.remove('active');
        });

        document.querySelector('#download-image').addEventListener('click', async () => {
          alert(1)
            const imageUrl = document.querySelector('#image_gallery_modal').src;

            const response = await fetch(imageUrl);
            const blob = await response.blob();

            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');

            a.href = url;
            a.download = 'gambar-gallery.jpg';

            document.body.appendChild(a);
            a.click();

            document.body.removeChild(a);
            window.URL.revokeObjectURL(url);
        });

    </script>
@endsection