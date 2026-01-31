@extends('_admin._layout.app');

@section('title', 'Kuis Interaktif')

@section('content')
<div class="grid gap-3 md:flex md:justify-between md:items-center py-4">
    <x-page-title title="Daftar {{$page['title'] }}" description="Daftar kuis yang telah Anda kerjakan." />
    <x-add-button :href="route('admin.students.add')" label="Gabung Kuis" />
</div>

<div class="flex flex-col">
    <div class="overflow-x-auto">
        <div class="min-w-full inline-block align-middle">
            <div class="overflow-hidden">

                <div class="px-2 py-2 pb-4">
                    <form action="{{ route('student.quiz.index') }}" method="GET" navigate
                        class="flex flex-col sm:flex-row gap-3">
                        <div class="sm:w-64">
                            <label for="keywords" class="sr-only">Search</label>
                            <div class="relative">
                                <input type="text" name="keywords" id="keywords" value="{{ $keywords ?? '' }}"
                                    class="py-1 px-3 block w-full border-gray-200 rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900
                                        placeholder-neutral-300 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                                    placeholder="Cari Judul Modul">
                            </div>
                        </div>
                        <div class="sm:w-64">
                            <select name="subject_id"
                                class="py-1 px-3 block w-full border-gray-200 rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                                <option value="all">Semua Mata Pelajaran</option>
                                @foreach ($subjects as $subject)
                                <option value="{{ $subject->id }}"
                                    {{ ($subject_id ?? '') == $subject->id ? 'selected' : '' }}>
                                    {{ $subject->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <button type="submit"
                                class="py-1 px-3 inline-flex items-center gap-x-1 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600 cursor-pointer">
                                <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="11" cy="11" r="8" />
                                    <path d="m21 21-4.3-4.3" />
                                </svg>
                                Cari
                            </button>
                            @if (!empty($keywords))
                            <a class="py-1 px-3 inline-flex items-center gap-x-1 text-sm font-semibold rounded-lg border border-blue-600 text-blue-600 hover:border-blue-500 hover:text-blue-500 hover:bg-blue-50 disabled:opacity-50 disabled:pointer-events-none dark:border-blue-500 dark:text-blue-500 dark:hover:bg-blue-500/10 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600 cursor-pointer"
                                href="{{ route('student.learning_modules.index') }}">
                                <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M3 6h18" />
                                    <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                                    <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                                    <line x1="10" x2="10" y1="11" y2="17" />
                                    <line x1="14" x2="14" y1="11" y2="17" />
                                </svg>
                                Reset
                            </a>
                            @endif
                        </div>
                    </form>
                </div>

                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
                    @forelse ($data as $item)
                    @php
                    $ext = strtolower(pathinfo($item->file_path, PATHINFO_EXTENSION));
                    $icon = match ($ext) {
                    'pdf' => 'text-red-500',
                    'doc', 'docx' => 'text-blue-500',
                    'ppt', 'pptx' => 'text-orange-500',
                    'jpg', 'png' => 'text-gray-700',
                    default => 'text-gray-400',
                    };
                    @endphp

                    <div
                        class="flex flex-col bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition dark:bg-neutral-900 dark:border-neutral-700">
                        <div class="p-4 flex items-start gap-3">
                            <div class="{{ $icon }}">
                                @if ($ext === 'pdf')
                                @include('_admin._layout.icons.filetype.pdf')
                                @elseif (in_array($ext, ['doc', 'docx', 'ppt', 'pptx', 'png', 'jpg']))
                                @include('_admin._layout.icons.filetype.' . $ext)
                                @else
                                <svg class="size-8 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                    <path d="M14 2v6h6" />
                                </svg>
                                @endif
                            </div>

                            <div class="flex-1">
                                <h3 class="text-sm font-semibold text-gray-800 dark:text-neutral-200 line-clamp-2">
                                    {{ $item->title }}
                                </h3>
                                <p class="mt-1 text-xs text-gray-500 dark:text-neutral-400">
                                    {{ $item->subject_name }} • Kelas {{ $item->classroom }}
                                </p>
                            </div>
                        </div>

                        <div
                            class="mt-auto flex border-t border-gray-200 dark:border-neutral-700 divide-x divide-gray-200 dark:divide-neutral-700">
                            <a class="flex-1 py-2 text-xs font-medium text-center cursor-pointer text-gray-600 hover:bg-gray-50 dark:text-neutral-300 dark:hover:bg-neutral-800"
                                onclick='setPreviewData(@json($item->title), @json($item->file_path), @json($item->summary ?? ''))'
                                data-hs-overlay="#preview-modal">
                                Preview
                            </a>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full text-center py-16 text-sm text-gray-500 dark:text-neutral-400">
                        <x-admin.empty-state />
                    </div>
                    @endforelse
                </div>

                <!-- Preview Modal -->
                <div id="preview-modal"
                    class="hs-overlay hs-overlay-open:opacity-100 hs-overlay-open:duration-500 hidden size-full fixed top-0 start-0 z-[80] opacity-0 overflow-x-hidden transition-all overflow-y-auto pointer-events-none"
                    role="dialog" tabindex="-1" aria-labelledby="preview-modal-label">
                    <div class="sm:max-w-4xl sm:w-full m-3 sm:mx-auto">
                        <div
                            class="flex flex-col bg-white border border-gray-200 shadow-2xl rounded-xl pointer-events-auto dark:bg-neutral-800 dark:border-neutral-700">

                            <div
                                class="flex justify-between items-center py-3 px-4 border-b border-gray-200 dark:border-neutral-700">
                                <h3 id="preview-modal-label" class="font-bold text-gray-800 dark:text-white">
                                    Preview Modul
                                </h3>
                                <button type="button"
                                    class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:hover:bg-neutral-600 dark:text-neutral-400 dark:focus:bg-neutral-600"
                                    aria-label="Close" data-hs-overlay="#preview-modal">
                                    <span class="sr-only">Close</span>
                                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M18 6 6 18"></path>
                                        <path d="m6 6 12 12"></path>
                                    </svg>
                                </button>
                            </div>

                            <div class="p-4 overflow-y-auto max-h-[70vh]">
                                <div id="preview-container" class="mb-4"></div>
                                <div id="summary-container"></div>
                            </div>

                            <div
                                class="flex justify-between items-center gap-x-2 py-3 px-4 border-t border-gray-200 dark:border-neutral-700">
                                <a id="download-btn" href="#" download
                                    class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 transition">
                                    <svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    Download
                                </a>
                                <button type="button"
                                    class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700"
                                    data-hs-overlay="#preview-modal">
                                    Tutup
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    function setPreviewData(title, filePath, summary) {
                        document.getElementById('preview-modal-label').textContent = title;

                        const ext = filePath.split('.').pop().toLowerCase();
                        const previewContainer = document.getElementById('preview-container');
                        const downloadBtn = document.getElementById('download-btn');

                        downloadBtn.href = '/storage/' + filePath;
                        downloadBtn.download = title;

                        previewContainer.innerHTML = '';

                        const imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'bmp'];
                        const fileUrl = `${window.location.origin}/storage/${filePath}`;

                        if (ext === 'pdf') {
                            previewContainer.innerHTML = `
                                    <div class="border border-gray-200 dark:border-neutral-700 rounded-lg overflow-hidden bg-gray-50 dark:bg-neutral-900">
                                        <iframe src="https://docs.google.com/gview?url=${encodeURIComponent(fileUrl)}&embedded=true" class="w-full h-96" frameborder="0"></iframe>
                                    </div>
                                `;
                        } else if (imageExtensions.includes(ext)) {
                            previewContainer.innerHTML = `
                                    <div class="border border-gray-200 dark:border-neutral-700 rounded-lg overflow-hidden bg-gray-50 dark:bg-neutral-900 p-4">
                                        <img src="/storage/${filePath}" alt="${title}" class="w-full h-auto rounded-lg object-contain max-h-96">
                                    </div>
                                `;
                        } else if (['doc', 'docx', 'ppt', 'pptx'].includes(ext)) {
                            previewContainer.innerHTML = `
                                    <div class="border border-gray-200 dark:border-neutral-700 rounded-lg overflow-hidden bg-gray-50 dark:bg-neutral-900">
                                        <iframe src="https://docs.google.com/gview?url=${encodeURIComponent(fileUrl)}&embedded=true" class="w-full h-96" frameborder="0"></iframe>
                                    </div>
                                `;
                        } else {
                            previewContainer.innerHTML = `
                                    <div class="p-6 bg-gray-50 dark:bg-neutral-900 rounded-lg border border-gray-200 dark:border-neutral-700 text-center">
                                        <svg class="mx-auto size-16 text-gray-400 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 2v6h6"/>
                                        </svg>
                                        <p class="text-sm text-gray-600 dark:text-neutral-400">
                                            Preview tidak tersedia untuk tipe file ini
                                        </p>
                                    </div>
                                `;
                        }

                        const summaryContainer = document.getElementById('summary-container');

                        if (summary && summary.trim() !== '') {
                            summaryContainer.innerHTML = `
                                    <div class="space-y-2 p-4 bg-blue-50 dark:bg-blue-900/10 rounded-lg border border-blue-100 dark:border-blue-900/30">
                                        <div class="flex items-center gap-2">
                                            <svg class="size-5 text-blue-600 dark:text-blue-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            <h4 class="font-semibold text-gray-800 dark:text-white text-sm">Ringkasan Materi</h4>
                                        </div>
                                        <p class="text-sm text-gray-700 dark:text-neutral-300 leading-relaxed pl-7">
                                            ${summary}
                                        </p>
                                    </div>
                                `;
                        } else {
                            summaryContainer.innerHTML = `
                                    <div class="p-4 bg-gray-50 dark:bg-neutral-900 rounded-lg border border-gray-200 dark:border-neutral-700 text-center">
                                        <p class="text-sm text-gray-500 dark:text-neutral-500 italic">
                                            Tidak ada ringkasan untuk modul ini
                                        </p>
                                    </div>
                                `;
                        }
                    }
                </script>

            </div>
        </div>
    </div>
</div>
@endsection
