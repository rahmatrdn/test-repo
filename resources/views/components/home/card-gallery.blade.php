@props(['img' => '', 'title' => '', 'date' => '', 'deskripsi' => ''])

<div class="card-gallery-home" data-deskripsi="{{ $deskripsi }}" data-src="{{ asset($img) }}" data-title="{{ $title }}" data-date="{{ $date }}">
    <img src="{{ asset($img) }}" alt="Galeri Image"/>
    <div class="content-card-gallery-home">
    <div class="text-card-gallery-home">
        <h3>{{ mb_strimwidth($title, 0, 15, '...') }}</h3>
        <p>{{ $date }}</p>
    </div>

    <div id="maximize-gallery-card" class="group">@include('_home.icons.maximize')</div>
    </div>

</div>