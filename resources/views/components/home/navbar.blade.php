@props(['link' => [
    'beranda' => '#beranda',
    'fitur' => '#fitur',
    'materi' => '#materi',
    'testimoni' => '#testimoni',
    'galeri' => '#galeri',
    'tentang' => '#tentang',
], 'showbtn' => true, 
'linkbtn' => '#login', 
'textbtn' => 'Masuk & Belajar', 
'iconbtn' => '_home.icons.book-open-check',
'linkactive' => 'beranda', 'sectionscriptjs' => true])

<header class="navbar-element" data-section-scroll="{{ $sectionscriptjs ? 'true' : 'false' }}">
    <div class="content-nav">
    <div class="image">
        <a href="/">
            <img src={{ asset("/home/images/smart-sekolah.png") }} alt="Logo" />
        </a>
    </div>
        
    <ul>
        @foreach ($link as $name => $url)
            @if($name == $linkactive)
                <li class="link-nav active"><a href="{{ $url }}">{{ ucfirst($name) }}</a></li>
            @else
                <li class="link-nav"><a href="{{ $url }}">{{ ucfirst($name) }}</a></li>
            @endif
        @endforeach
    </ul>
        
    @if($showbtn)
        <a href="{{ $linkbtn }}" class="koleksi_btn">@include($iconbtn) {{ $textbtn }}</a>
    @endif
        
    <div class="hamburger-navbar">
        <span></span>
        <span></span>
        <span></span>
    </div>
    </div>
</header>
<div class="nav-link-mobile">
    @foreach ($link as $name => $url)
        <li class="link-nav"><a href="{{ $url }}">{{ ucfirst($name) }}</a></li>
    @endforeach

    @if($showbtn)
        <li class="flex justify-center"><a href="{{ $linkbtn }}" class="koleksi_btn">@include($iconbtn) {{ $textbtn }}</a></li>
    @endif
</div>