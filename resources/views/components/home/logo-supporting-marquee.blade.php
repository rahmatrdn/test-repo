@php
    $logoSupporting = [
        "/home/images/supporting/hotel1.png",
        "/home/images/supporting/hotel2.png",
        "/home/images/supporting/hotel3.png",
        "/home/images/supporting/hotel4.png",
        "/home/images/supporting/hotel5.png",
        "/home/images/supporting/hotel6.png",
    ]
@endphp

@foreach (array_merge($logoSupporting, $logoSupporting) as $logo)
    <div class="marquee-item px-6 min-[990px]:px-10 flex items-center justify-center">
        <x-home.logo-supporting :img="$logo"></x-home.logo-supporting>
    </div>
@endforeach