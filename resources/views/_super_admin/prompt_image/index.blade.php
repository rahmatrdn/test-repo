@extends('_admin._layout.app')

@section('title', 'Prompt Gambar')

@section('content')
    <div class="grid gap-3 md:flex md:justify-between md:items-center py-4">
        <x-page-title title="Data {{ $page['title'] }}" description="Kelola Gaya Gambar untuk Tools Generator Ilustrasi" />
        <div class="inline-flex gap-x-2">
            <x-add-button :href="route('superadmin.image-prompts.add')" label="Tambah Data" />
        </div>
    </div>
    <div class="flex flex-col">
        <div class="overflow-x-auto">
            <div class="min-w-full inline-block align-middle">
                <div class="overflow-hidden">

                    <div class="px-2 pt-4">
                        <form action="{{ route('superadmin.image-prompts.index') }}" method="GET" navigate-form
                            class="flex flex-col sm:flex-row gap-3">
                            <div class="sm:w-64">
                                <label for="keywords" class="sr-only">Search</label>
                                <div class="relative">
                                    <input type="text" name="keywords" id="keywords" value="{{ $keywords ?? '' }}"
                                        class="py-1 px-3 block w-full border-gray-200 rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900
                                        placeholder-neutral-300 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                                        placeholder="Cari Nama Gaya Gambar">
                                </div>
                            </div>
                            <div>
                                <button type="submit"
                                    class="py-1 px-3 inline-flex items-center gap-x-1 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600 cursor-pointer">
                                    @include('_admin._layout.icons.search')
                                    Cari
                                </button>
                                @if (!empty($keywords))
                                    <a class="py-1 px-3 inline-flex items-center gap-x-1 text-sm font-semibold rounded-lg border border-blue-600 text-blue-600 hover:border-blue-500 hover:text-blue-500 hover:bg-blue-50 disabled:opacity-50 disabled:pointer-events-none dark:border-blue-500 dark:text-blue-500 dark:hover:bg-blue-500/10 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600 cursor-pointer"
                                        href="{{ route('superadmin.image-prompts.index') }}">
                                        @include('_admin._layout.icons.reset')
                                        Reset
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 my-4">
                        @forelse($data as $d)
                            <!-- Card -->
                            <div
                                class="group flex flex-col h-full bg-white border border-gray-200 shadow-sm rounded-xl hover:shadow-md transition-shadow dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-neutral-700/70">

                                <!-- Image Container -->
                                <div
                                    class="relative h-52 flex flex-col justify-center items-center bg-gradient-to-br from-blue-50 via-purple-50 to-pink-50 rounded-t-xl overflow-hidden dark:from-neutral-800 dark:via-neutral-800 dark:to-neutral-900">
                                    <img src="{{ $d->preview_path }}" alt="{{ $d->name }}"
                                        class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105"
                                        loading="lazy">
                                </div>

                                <!-- Card Body -->
                                <div class="p-4 md:p-5 flex flex-col flex-grow">
                                    <!-- Title -->
                                    <div class="flex-grow flex items-center justify-center">
                                        <h3 class="text-base font-semibold text-gray-800 dark:text-white text-center">
                                            {{ $d->name }}
                                        </h3>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="mt-5 flex gap-x-2">
                                        <a navigate href="{{ route('superadmin.image-prompts.update', $d->id) }}"
                                            class="flex-1 py-2.5 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-100 text-blue-800 hover:bg-blue-200 focus:outline-none focus:bg-blue-200 transition-all dark:bg-blue-800/30 dark:text-blue-400 dark:hover:bg-blue-800/20 dark:focus:bg-blue-800/20">
                                            <svg class="flex-shrink-0 w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                            </svg>
                                            Edit
                                        </a>

                                        <button type="button"
                                            class="py-2.5 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-red-100 text-red-800 hover:bg-red-200 focus:outline-none focus:bg-red-200 transition-all dark:bg-red-800/30 dark:text-red-500 dark:hover:bg-red-800/20 dark:focus:bg-red-800/20"
                                            data-hs-overlay="#delete-modal"
                                            onclick="setDeleteData('{{ $d->id }}', '{{ addslashes($d->name) }}')"
                                            aria-label="Delete prompt">
                                            <svg class="flex-shrink-0 w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                            </svg>
                                            Hapus
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full">
                                <div
                                    class="min-h-60 flex flex-col bg-white  dark:bg-neutral-800 dark:border-neutral-700 justify-center items-center">
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

    <!-- Delete Confirmation Modal -->
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
                        Hapus Gaya Gambar
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
                        <form id="delete-form" method="POST" class="inline" navigate-form>
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
            const deleteUrl = "{{ route('superadmin.image-prompts.delete', ':id') }}";
            document.getElementById('delete-form').action = deleteUrl.replace(':id', id);
        }
    </script>
@endsection
