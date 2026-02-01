<div class="inline-flex gap-x-2">
    <a navigate
        class="py-3 px-4 inline-flex items-center justify-center gap-x-2 text-sm font-semibold rounded-xl border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-blue-700 transition-all shadow-md shadow-blue-500/20 active:scale-95 cursor-pointer"
        href="{{ $href }}">
        @include('_admin._layout.icons.add')
        {{ $slot ?? '' }}
        {{ $label }}
    </a>
</div>
