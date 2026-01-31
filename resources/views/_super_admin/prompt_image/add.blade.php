@extends('_admin._layout.app')

@section('title', 'Tambah Prompt Gambar')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div
            class="bg-white overflow-hidden shadow-lg rounded-2xl dark:bg-neutral-800 border-2 border-gray-100 dark:border-neutral-700">

        {{-- Header --}}
        <div class="px-6 py-4 border-b border-gray-200 dark:border-neutral-700 flex items-center">
            <a navigate href="{{ route('superadmin.image-prompts.index') }}"
                class="py-3 px-3 inline-flex items-center gap-x-2 text-xl rounded-xl border border-gray-200 bg-white text-gray-800 shadow-md hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700 cursor-pointer">
                <svg class="size-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2">
                    <path d="m12 19-7-7 7-7" />
                    <path d="M19 12H5" />
                </svg>
            </a>
            <div class="ms-3">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-neutral-200">
                    Tambah {{ $page['title'] }}
                </h2>
            </div>
        </div>

        {{-- Form --}}
        <form class="p-6" navigate-form method="POST"
            action="{{ route('superadmin.image-prompts.create') }}"
            enctype="multipart/form-data">
            @csrf

                <div class="space-y-4">

                    {{-- Name --}}
                    <div>
                        <label class="block text-sm font-medium mb-2 dark:text-white">
                            Jenis Gambar <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" required placeholder="Contoh: Poster Edukasi"
                            value="{{ old('name') }}" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm
                                   focus:border-blue-500 focus:ring-blue-500
                                   dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-300">
                    </div>

                    {{-- Image Upload --}}
                    <div>
                        <label class="block text-sm font-medium mb-2 dark:text-white">
                            Sampul <span class="text-red-500">*</span>
                        </label>

                        <input type="file" id="image" name="image" accept="image/*" required
                            class="
                            file:text-blue-500 hover:file:underline file:mr-3 border file:cursor-pointer
                            py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus-within:border-blue-500 focus-within:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-300">

                        <p id="image-helper" class="text-xs text-gray-500 dark:text-neutral-500 mt-1">
                            Klik, drag & drop, atau Ctrl+V untuk paste gambar (maks 5MB)
                        </p>


                        @error('image')
                            <p class="text-xs text-red-600 mt-2">{{ $message }}</p>
                        @enderror
                    </div>


                    {{-- Prompt --}}
                    <div>
                        <label class="block text-sm font-medium mb-2 dark:text-white">
                            Teks Prompt <span class="text-red-500">*</span> <span class="text-gray-500 text-xs">(Gunakan '@{{description}}' sebagai parameter untuk inputan user)</span>
                        </label>
                        <textarea name="prompt" rows="4" required placeholder="Contoh: Buat infografis dengan tema..."
                            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm
                                   focus:border-blue-500 focus:ring-blue-500
                                   dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-300">{{ old('prompt') }}</textarea>
                    </div>
                </div>

            {{-- Footer --}}
            <div class="mt-4 flex gap-2">
                <a navigate href="{{ route('superadmin.image-prompts.index') }}"
                    class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:bg-gray-50 dark:bg-transparent dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-800">
                    Batal
                </a>
                <button type="submit"
                    class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none cursor-pointer">
                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M5 12h14" />
                        <path d="M12 5v14" />
                    </svg>
                    Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>

    {{-- Script --}}
    <script>
        (function () {
            let previewUrl = null;

            function initFileInput() {
                const fileInput = document.getElementById('image');
                const helper = document.getElementById('image-helper');

                if (!fileInput || !helper) return;

                // ⛔ prevent double bind
                if (fileInput.dataset.bound === '1') return;
                fileInput.dataset.bound = '1';

                function setHelperToPreview(file) {
                    if (!file || !file.type.startsWith('image/')) return;

                    if (previewUrl) URL.revokeObjectURL(previewUrl);
                    previewUrl = URL.createObjectURL(file);

                    helper.innerHTML = `
                    <span class="text-blue-600 underline cursor-pointer hover:text-blue-800 dark:text-blue-400">
                        Lihat ${file.name}
                    </span>
                `;

                    helper.onclick = () => {
                        window.open(previewUrl, '_blank');
                    };
                }

                function resetHelper() {
                    helper.textContent =
                        'Klik, drag & drop, atau Ctrl+V untuk paste gambar (maks 5MB)';
                    helper.className =
                        'text-xs text-gray-500 dark:text-neutral-500 mt-1';
                    helper.onclick = null;
                }

                /* FILE PICK */
                fileInput.addEventListener('change', () => {
                    const file = fileInput.files[0];
                    if (!file) {
                        resetHelper();
                        return;
                    }
                    setHelperToPreview(file);
                });

                /* PASTE IMAGE */
                document.addEventListener('paste', (e) => {
                    const items = e.clipboardData?.items;
                    if (!items) return;

                    for (const item of items) {
                        if (item.type.startsWith('image/')) {
                            e.preventDefault();
                            const file = item.getAsFile();
                            const dt = new DataTransfer();
                            dt.items.add(file);
                            fileInput.files = dt.files;
                            setHelperToPreview(file);
                            break;
                        }
                    }
                });

                /* DRAG & DROP */
                fileInput.addEventListener('dragover', e => e.preventDefault());

                fileInput.addEventListener('drop', e => {
                    e.preventDefault();
                    const file = e.dataTransfer.files[0];
                    if (!file) return;

                    const dt = new DataTransfer();
                    dt.items.add(file);
                    fileInput.files = dt.files;
                    setHelperToPreview(file);
                });
            }

            // 🔥 INIT SEKARANG (penting)
            initFileInput();

            // 🔥 INIT SETIAP NAVIGATE
            document.addEventListener('navigate:complete', initFileInput);
        })();
    </script>



@endsection
