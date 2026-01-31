@extends('_admin._layout.app')

@section('title', 'Manajemen Kuis')

@section('content')
<div class="grid gap-3 md:flex md:justify-between md:items-center py-4 mb-0">
    <x-page-title title="{{ $page['title'] }}" description="Kelola kuis untuk siswa Anda" />
    <div>
        <div class="inline-flex gap-x-2">
            <x-add-button :href="route('teacher.quiz.add')" label="Buat Kuis"></x-add-button>
        </div>
    </div>
</div>

<div class="flex flex-col">
    <div class="overflow-x-auto">
        <div class="min-w-full inline-block align-middle">
            <div class="overflow-hidden">

                <div class="px-2 pt-4">
                    <form action="{{ route('teacher.quiz.index') }}" method="GET" navigate-form
                        class="flex flex-col sm:flex-row gap-3">
                        <div class="sm:w-64">
                            <label for="keywords" class="sr-only">Search</label>
                            <div class="relative">
                                <input type="text" name="keywords" id="keywords" value="{{ $keywords ?? '' }}"
                                    class="py-1 px-3 block w-full border-gray-200 rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900
                                        placeholder-neutral-300 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                                    placeholder="Cari Kuis">
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
                                href="{{ route('teacher.quiz.index') }}">
                                @include('_admin._layout.icons.reset')
                                Reset
                            </a>
                            @endif
                        </div>
                    </form>
                </div>

                <div class="mx-0 my-4 overflow-x-auto border border-gray-200 rounded-lg dark:border-neutral-700">
                    <table class="w-full divide-y divide-gray-200 dark:divide-neutral-700">
                        <thead class="bg-gray-50 dark:bg-neutral-700">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-start">
                                    <div class="flex items-center gap-x-2">
                                        <span
                                            class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">
                                            Nama Kuis
                                        </span>
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-3 text-start">
                                    <div class="flex items-center gap-x-2">
                                        <span
                                            class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">
                                            Topik
                                        </span>
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-3 text-start">
                                    <div class="flex items-center gap-x-2">
                                        <span
                                            class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">
                                            Jumlah Soal
                                        </span>
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-3 text-start">
                                    <div class="flex items-center gap-x-2">
                                        <span
                                            class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">
                                            Durasi Kuis
                                        </span>
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-3 text-start">
                                    <div class="flex items-center gap-x-2">
                                        <span
                                            class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">
                                            Jumlah Partisipan
                                        </span>
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-3 text-start">
                                    <div class="flex items-center gap-x-2">
                                        <span
                                            class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">
                                            Kode
                                        </span>
                                    </div>
                                </th>
                                <th scope="col" class="px-2 py-3 text-end">
                                    <div class="text-center">
                                        <span
                                            class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">
                                            Aksi
                                        </span>
                                    </div>
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                            @forelse($data as $d)
                            <tr class="hover:bg-gray-100 dark:hover:bg-neutral-700">
                                <td class="size-px whitespace-nowrap">
                                    <div class="px-6 py-3">
                                        <span
                                            class="block text-sm font-semibold text-gray-800 dark:text-neutral-200">{{ $d->quiz_name }}</span>
                                    </div>
                                </td>
                                <td class="size-px whitespace-nowrap">
                                    <div class="px-6 py-3">
                                        <span class="block text-sm text-gray-800 dark:text-neutral-200">
                                            {{ Str::limit($d->description, 20, '...') }}
                                        </span>
                                    </div>
                                </td>
                                <td class="size-px whitespace-nowrap">
                                    <div class="px-6 py-3">
                                        <span
                                            class="inline-flex items-center gap-x-1.5 py-1 px-2 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-800/30 dark:text-blue-500">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V8z" clip-rule="evenodd" />
                                            </svg>
                                            {{ $d->question_count }} Soal
                                        </span>
                                    </div>
                                </td>
                                <td class="size-px whitespace-nowrap">
                                    <div class="px-6 py-3">
                                        <span
                                            class="inline-flex items-center gap-x-1.5 py-1 px-2 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-800/30 dark:text-green-500">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                            </svg>
                                            {{ $d->quiz_time }}
                                        </span>
                                    </div>
                                </td>
                                <td class="size-px whitespace-nowrap">
                                    <div class="px-6 py-3">
                                        <span
                                            class="inline-flex items-center gap-x-1.5 py-1 px-2 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-800/30 dark:text-green-500">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                                            </svg>
                                            {{ $d->participants_count }} Siswa
                                        </span>
                                    </div>
                                </td>
                                <td class="size-px whitespace-nowrap">
                                    <div class="px-6 py-3">
                                        <span
                                            class="inline-flex items-center gap-x-1.5 py-1 px-2 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-800/30 dark:text-green-500">
                                            {{ $d->quiz_code }}
                                        </span>
                                    </div>
                                </td>


                                <td class="size-px whitespace-nowrap">
                                    <div class="px-6 py-1.5 flex items-center gap-x-2 justify-end">
                                        <a href="{{ route('teacher.quiz.detail', $d->id) }}"
                                            class="py-2 px-3 inline-flex justify-center items-center gap-x-2 text-xs font-medium rounded-lg border border-transparent bg-blue-100 text-blue-800 hover:bg-blue-200 focus:outline-none focus:bg-blue-200 disabled:opacity-50 disabled:pointer-events-none dark:text-blue-400 dark:bg-blue-800/30 dark:hover:bg-blue-800/20 dark:focus:bg-blue-800/20 cursor-pointer"
                                            title="Lihat Detail">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('teacher.quiz.questions.add', $d->id) }}"
                                            class="py-2 px-3 inline-flex justify-center items-center gap-x-2 text-xs font-medium rounded-lg border border-transparent bg-purple-100 text-purple-800 hover:bg-purple-200 focus:outline-none focus:bg-purple-200 disabled:opacity-50 disabled:pointer-events-none dark:text-purple-400 dark:bg-purple-800/30 dark:hover:bg-purple-800/20 dark:focus:bg-purple-800/20 cursor-pointer"
                                            title="Tambah Soal">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('teacher.quiz.scores', $d->id) }}"
                                            class="py-2 px-3 inline-flex justify-center items-center gap-x-2 text-xs font-medium rounded-lg border border-transparent bg-green-100 text-green-800 hover:bg-green-200 focus:outline-none focus:bg-green-200 disabled:opacity-50 disabled:pointer-events-none dark:text-green-400 dark:bg-green-800/30 dark:hover:bg-green-800/20 dark:focus:bg-green-800/20 cursor-pointer"
                                            title="Lihat Nilai">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                            </svg>
                                        </a>
                                        <button type="button"
                                            class="py-2 px-3 inline-flex justify-center items-center gap-x-2 text-xs font-medium rounded-lg border border-transparent bg-red-100 text-red-800 hover:bg-red-200 focus:outline-none focus:bg-red-200 disabled:opacity-50 disabled:pointer-events-none dark:text-red-500 dark:bg-red-800/30 dark:hover:bg-red-800/20 dark:focus:bg-red-800/20 cursor-pointer"
                                            title="Delete" data-hs-overlay="#delete-modal"
                                            onclick="setDeleteData('{{ $d->id }}', '{{ $d->quiz_name }}')">
                                            @include('_admin._layout.icons.trash')
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6"
                                    class="px-6 py-4 text-center text-sm text-gray-500 dark:text-neutral-500">
                                    <x-admin.empty-state />
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
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
                <span
                    class="mb-4 inline-flex justify-center items-center size-14 rounded-full border-4 border-red-50 bg-red-100 text-red-500 dark:bg-red-700 dark:border-red-600 dark:text-red-100">
                    @include('_admin._layout.icons.warning_modal')
                </span>

                <h3 id="delete-modal-label" class="mb-2 text-xl font-bold text-gray-800 dark:text-neutral-200">
                    Hapus Kuis
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
        const deleteUrl = '{{ route('teacher.quiz.delete', ':id') }}';
        document.getElementById('delete-form').action = deleteUrl.replace(':id', id);
    }
</script>
@endsection