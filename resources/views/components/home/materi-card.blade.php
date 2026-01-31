@props(['text' => 'Sekolah Dasar', 'image' => 'home/images/wisata/2.jpg', 'materi_count' => 27, 'sekolah_count' => 6, 'link' => 'kumpulan_materi', 'suffix' => 'Materi'])

<div class="group cardkategoriberanda" onclick="window.location = '{{ route($link) }}'">
    <img src="{{ asset($image) }}"  alt="Materi Image" class="w-full h-full object-cover absolute z-1"/>
    <div class="absolute bottom-0 left-0 w-full h-full bg-linear-to-t from-black to-transparent z-2 transition-all duration-500 group-hover:bg-black/70"></div>
    <h3 class="text-white text-[15px] text-nowrap translate-y-50 group-hover:translate-y-0 transition duration-300 absolute top-1/2 left-1/2 -translate-1/2 flex items-center z-4 gap-x-2">
        @include('_home/icons/move-right-up') <p class="text-nowrap">Klik Untuk Info Lebih Lanjut</p>
    </h3>
    <div class="bottom-0 left-0 p-5 pb-6 z-3 absolute text-white">
        <p class="text-sm font-medium">{{ $materi_count }}+ {{ $suffix }}</p>
        <h3 class="font-semibold text-xl my-1">{{ mb_strimwidth($text, 0, 18, '...') }}</h3>
        <h6 class="font-fredoka">{{ $sekolah_count }} Sekolah</h6>
    </div>
</div>