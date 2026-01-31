@extends('_admin._layout.app')

@section('title', 'Ilustrasi')

@section('content')
    <div class="grid gap-3 md:flex md:justify-between md:items-center py-4">
        <x-page-title title="{{ $page['title'] }}" description="Buat ilustrasi dengan bantuan AI" />
        <div>
            <div class="inline-flex gap-x-2">
                <x-add-button :href="route('teacher.ai.ilustrasi.add')" label="Buat Ilustrasi" />
            </div>
        </div>


    </div>
    <div class="flex flex-col">
        <div class="overflow-x-auto">
            <div class="min-w-full inline-block align-middle">
                <div class="overflow-hidden">

                    <div class="px-2 pt-4">
                        <form action="{{ route('teacher.ai.ilustrasi.index') }}" method="GET" navigate-form
                            class="flex flex-col sm:flex-row gap-3">
                            <div class="sm:w-64">
                                <label for="keywords" class="sr-only">Search</label>
                                <div class="relative">
                                    <input type="text" name="keywords" id="keywords" value="{{ $keywords ?? '' }}"
                                        class="py-1 px-3 block w-full border-gray-200 rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900
                                        placeholder-neutral-300 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                                        placeholder="Cari Histori">
                                </div>
                            </div>

                            <div class="sm:w-64">
                                <select name="image_style_id" id="image_style_id"
                                    class="py-1 px-3 block w-full border-gray-200 rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                                    <option value="all">Semua</option>
                                    @foreach ($promptImages as $image)
                                        <option value="{{ $image->id }}"
                                            @if (isset($image_style_id) && $image_style_id == $image->id) selected @endif>
                                            {{ $image->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <button type="submit"
                                    class="py-1 px-3 inline-flex items-center gap-x-1 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600 cursor-pointer">
                                    @include('_admin._layout.icons.search')
                                    Cari
                                </button>
                                @if (!empty($keywords))
                                    <a class="py-1 px-3 inline-flex items-center gap-x-1 text-sm font-semibold rounded-lg border border-blue-600 text-blue-600 hover:border-blue-500 hover:text-blue-500 hover:bg-blue-50 disabled:opacity-50 disabled:pointer-events-none dark:border-blue-500 dark:text-blue-500 dark:hover:bg-blue-500/10 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600 cursor-pointer"
                                        href="{{ route('teacher.ai.materi_ajar.index') }}">
                                        @include('_admin._layout.icons.reset')
                                        Reset
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 my-4">
                        @forelse($data as $d)
                            <div
                                class="group flex flex-col h-full bg-white border border-gray-200 shadow-sm rounded-xl hover:shadow-md transition-shadow dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-neutral-700/70">

                                <!-- Image Container -->
                                <div
                                    class="relative h-52 flex flex-col justify-center items-center bg-gradient-to-br from-blue-50 via-purple-50 to-pink-50 rounded-t-xl overflow-hidden dark:from-neutral-800 dark:via-neutral-800 dark:to-neutral-900">
                                    @if (isset($d->output_file_path) && $d->output_file_path)
                                        <img src="{{ url($d->output_file_path) }}" alt="{{ $d->user_input }}"
                                            class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105"
                                            loading="lazy">
                                    @else
                                        <!-- Placeholder Icon -->
                                        <div
                                            class="flex flex-col items-center justify-center text-gray-400 dark:text-neutral-500">
                                            <svg class="w-20 h-20 mb-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24" stroke-width="1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                            </svg>
                                            <p class="text-sm font-medium">No Image</p>
                                        </div>
                                    @endif

                                    <!-- Style Badge -->
                                    @if ($d->image_style_name)
                                        <span
                                            class="absolute top-3 right-3 inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-white/90 text-purple-800 backdrop-blur-sm dark:bg-neutral-800/90 dark:text-purple-400">
                                            <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 6 6">
                                                <circle cx="3" cy="3" r="3" />
                                            </svg>
                                            {{ $d->image_style_name }}
                                        </span>
                                    @endif
                                </div>

                                <!-- Card Body -->
                                <div class="p-4 md:p-5 flex flex-col flex-grow">
                                    <!-- Title & Description -->
                                    <div class="flex-grow">
                                        <h3 class="text-base font-semibold text-gray-800 dark:text-white line-clamp-2 mb-2">
                                            {{ $d->user_input }}
                                        </h3>

                                        <!-- Date -->
                                        <div class="flex items-center gap-x-2 text-xs text-gray-500 dark:text-neutral-500">
                                            <svg class="flex-shrink-0 w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                            </svg>
                                            <span>{{ \Carbon\Carbon::parse($d->created_at)->format('d M Y H:i') }}</span>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="mt-5 flex gap-x-2">
                                        <a navigate href="{{ route('teacher.ai.ilustrasi.detail', $d->id) }}"
                                            class="flex-1 py-2.5 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-green-100 text-green-800 hover:bg-green-200 focus:outline-none focus:bg-green-200 transition-all dark:bg-green-800/30 dark:text-green-400 dark:hover:bg-green-800/20 dark:focus:bg-green-800/20">
                                            <svg class="flex-shrink-0 w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            
                                        </a>
                                        
                                        @if (isset($d->output_file_path) && $d->output_file_path)
                                            <a href="{{ url($d->output_file_path) }}" download
                                                class="flex-1 py-2.5 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-100 text-blue-800 hover:bg-blue-200 focus:outline-none focus:bg-blue-200 transition-all dark:bg-blue-800/30 dark:text-blue-400 dark:hover:bg-blue-800/20 dark:focus:bg-blue-800/20">
                                                <svg class="flex-shrink-0 w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                                </svg>
                                            </a>
                                        @endif

                                        <button type="button"
                                            class="py-2.5 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-red-100 text-red-800 hover:bg-red-200 focus:outline-none focus:bg-red-200 transition-all dark:bg-red-800/30 dark:text-red-500 dark:hover:bg-red-800/20 dark:focus:bg-red-800/20"
                                            data-hs-overlay="#delete-modal"
                                            onclick="setDeleteData('{{ $d->id }}', '{{ addslashes($d->user_input) }}')"
                                            aria-label="Delete image">
                                            <svg class="flex-shrink-0 w-4 h-4 text-red-600 dark:text-red-500" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full">
                                <div
                                    class="min-h-60 flex flex-col bg-white dark:bg-neutral-800 dark:border-neutral-700 justify-center items-center">
                                    <x-admin.empty-state />
                                </div>
                            </div>
                        @endforelse
                    </div>

                    @if (count($data) > 0 && $data->hasPages())
                        <div class="px-6 py-4 border-t border-gray-200 dark:border-neutral-700">
                            <div class="flex justify-end">
                                {{ $data->links() }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div id="delete-modal" class="hs-overlay hidden size-full fixed top-0 start-0 z-80 overflow-x-hidden overflow-y-auto"
        role="dialog" tabindex="-1" aria-labelledby="delete-modal-label">
        <div
            class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto">
            <div
                class="relative flex flex-col bg-white border shadow-sm rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
                <div class="absolute top-2 end-2">
                    <button type="button"
                        class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:hover:bg-neutral-600 dark:text-neutral-400 dark:focus:bg-neutral-600"
                        aria-label="Close" data-hs-overlay="#delete-modal">
                        <span class="sr-only">Close</span>
                        @include('_admin._layout.icons.close_modal')
                    </button>
                </div>

                <div class="p-4 sm:p-10 text-center overflow-y-auto">
                    <!-- Icon -->
                    <span
                        class="mb-4 inline-flex justify-center items-center size-14 rounded-full border-4 border-red-50 bg-red-100 text-red-500 dark:bg-red-700 dark:border-red-600 dark:text-red-100">
                        @include('_admin._layout.icons.warning_modal')
                    </span>
                    <!-- End Icon -->

                    <h3 id="delete-modal-label" class="mb-2 text-xl font-bold text-gray-800 dark:text-neutral-200">
                        Hapus Tugas
                    </h3>
                    <p class="text-gray-500 dark:text-neutral-500">
                        Apakah Anda yakin ingin menghapus <span id="delete-item-name"
                            class="font-semibold text-gray-800 dark:text-neutral-200"></span>?
                        <br>Tindakan ini tidak dapat dibatalkan.
                    </p>

                    <div class="mt-6 flex justify-center gap-x-4">
                        <button type="button"
                            class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:bg-gray-50 dark:bg-transparent dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800"
                            data-hs-overlay="#delete-modal">
                            Batal
                        </button>
                        <form id="delete-form" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-red-600 text-white hover:bg-red-700 focus:outline-none focus:bg-red-700 disabled:opacity-50 disabled:pointer-events-none">
                                Ya, Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function setDeleteData(id, name) {
            document.getElementById('delete-item-name').textContent = name;
            document.getElementById('delete-form').action = '{{ url('
                    admin / tasks / delete ') }}/' + id;
        }
    </script>
@endsection
