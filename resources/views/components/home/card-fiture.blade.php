@props(
['img' => '',
'title' => '',
'text' => '',
'href' => '',
'hrefText' => ''])

<div class="card-fiture-landingpage group">
    <div class="img-fiture-card">
        <img src="{{ asset($img) }}" alt="" srcset="">
    </div>
    <div class="content-card-fiture">
        <h2>{{ $title }}</h2>
        <p>{{ $text }}</p>
        <a href="{{ $href }}">{{ $hrefText }}</a>
    </div>
</div>