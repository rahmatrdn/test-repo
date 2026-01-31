<footer class="footer-element">
    <div class="container-footer">
        <div class="content-utama">
            <div class="logo-desk">
                <img src={{ asset("/home/images/smart-sekolah.png") }} alt="Logo">
                <p>Smart Sekolah adalah platform pembelajaran digital yang membantu kamu membangun kompetensi nyata melalui materi yang terstruktur, berbasis praktik, dan dirancang sesuai dengan kebutuhan industri.</p>
            </div>
            <div class="link-cepat">
                <h3>Link Cepat</h3>
                <a href="{{ route('landing') }}">Beranda</a>
                <a href="{{ route('kumpulan_materi') }}">Materi</a>
                <a href="{{ route('login') }}">Login</a>
            </div>
            <div class="kategori-populer">
                <h3>Materi</h3>
                <a href="{{ route('kumpulan_materi') }}">Sekolah Dasar</a>
                <a href="{{ route('kumpulan_materi') }}">Sekolah Menengah Pertama</a>
                <a href="{{ route('kumpulan_materi') }}">Sekolah Menengah Atas</a>
            </div>
            <div class="medsos-content">
                <h3>Sosial Media</h3>
                <div>
                    <a href="https://www.youtube.com/@fktech.nology" target="_blank">@include('_home.icons.instagram')</a>
                    <a href="https://www.tiktok.com/@fk_clippers" target="_blank">@include('_home.icons.linkedin')</a>
                    <a href="https://x.com/Fahmy_4you" target="_blank">@include('_home.icons.github')</a>
                </div>
            </div>
        </div>
        <div class="container-contact">
            <a>
                <div>@include('_home.icons.map')</div>
                <h5>Umbulsari Jember Jawa Timur</h5>
            </a>
            <a>
                <div>@include('_home.icons.phone')</div>
                <h5>(0036) 444 112</h5>
            </a>
            <a>
                <div>@include('_home.icons.mail')</div>
                <h5>smartsekolah@gmail.com</h5>
            </a>
            <a>
                <div>@include('_home.icons.whatsapp')</div>
                <h5>+62 881 0368 43274</h5>
            </a>
        </div>
        <div class="bg-vector">
            <img src="{{ asset('/home/images/vektor.png') }}" alt="Vektor Footer">
        </div>
    </div>
    <div class="copyright-content">
        <h5>&copy; Smart Sekolah - Platform Belajar Online</h5>
    </div>
</footer>