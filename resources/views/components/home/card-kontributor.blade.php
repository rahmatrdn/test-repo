@props([
    'linkinstagram' => '#', 
    'linklinkedin' => '#', 
    'linkgithub' => '#',
    'nama' => 'Fahmy Bima Az Zukhruf',
    'role' => 'Frontend Developer',
    'profileimage' => '/home/images/avatar/1.png'])

<div class="card-kontributor">
    <img src="{{ asset($profileimage) }}" alt="">
    <h3>{{ $nama }}</h3>
    <h6>{{ $role }}</h6>
    <div class="sosmed">
        <a href="{{ $linkinstagram }}">@include('_home.icons.instagram')</a>
        <a href="{{ $linklinkedin }}">@include('_home.icons.linkedin')</a>
        <a href="{{ $linkgithub }}">@include('_home.icons.github')</a>
    </div>
</div>