@props(['img' => '', 'name' => '', 'role' => '', 'message' => ''])

<div class="card-testimoni-home">
    <div class="images-card-testimoni-home">
        <img src="{{ asset($img) }}" alt="">
    </div>

    <div class="text-card-testimoni-home">
        <h4>{{ $name }}</h4>
        <h6>{{ $role }}</h6>
        <p>{{ $message }}</p>
    </div>
</div>