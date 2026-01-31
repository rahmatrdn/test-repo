@extends('_admin._layout.app')

@section('title', 'Update Gaya Gambar')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div
            class="bg-white overflow-hidden shadow-lg rounded-2xl dark:bg-neutral-800 border-2 border-gray-100 dark:border-neutral-700">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-neutral-700 flex items-center">
                <a navigate href="{{ route('superadmin.image-prompts.index') }}"
                    class="py-3 px-3 inline-flex items-center gap-x-2 text-xl rounded-xl border border-gray-200 bg-white text-gray-800 shadow-md hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700 cursor-pointer">
                    <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="90" height="90"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="m12 19-7-7 7-7" />
                        <path d="M19 12H5" />
                    </svg>
                </a>
                <div class="ms-3">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-neutral-200">
                        Edit {{ $page['title'] }}
                    </h2>
                </div>
            </div>

            <form id="update-form" class="p-6" navigate-form
                action="{{ route('superadmin.image-prompts.do_update', $id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf

                <div class="space-y-4">
                    {{-- Name --}}
                    <div>
                        <label for="name" class="block text-sm font-medium mb-2 dark:text-white">Nama Gaya Gambar <span
                                class="text-red-500">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name', $data->name) }}"
                            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 placeholder-neutral-300 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 @error('name') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                            placeholder="Contoh: 3D Kartun" required>
                        @error('name')
                            <p class="text-xs text-red-600 mt-2" id="name-error">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Prompt --}}
                    <div>
                        <label for="prompt" class="block text-sm font-medium mb-2 dark:text-white">Teks Prompt<span class="text-red-500">*</span> <span class="text-gray-500 text-xs">(Gunakan '@{{description}}' sebagai parameter untuk inputan user)</span></label>
                        <textarea id="prompt" name="prompt" rows="4"
                            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 placeholder-neutral-300 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 @error('prompt') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                            placeholder="Masukkan prompt untuk generate gambar" required>{{ old('prompt', $data->prompt) }}</textarea>
                        @error('prompt')
                            <p class="text-xs text-red-600 mt-2" id="prompt-error">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Image Upload --}}
                    <div>
                        <label for="image" class="block text-sm font-medium mb-2 dark:text-white">
                            Sampul
                            <span class="text-gray-500 text-xs">(Kosongkan jika tidak ingin mengubah)</span>
                        </label>

                        <input type="file" id="image" name="image"
                            accept="image/jpeg,image/jpg,image/png,image/webp"
                            class="
                        file:text-blue-500 hover:file:underline file:mr-3 border file:cursor-pointer
                        py-3 px-4 block w-full border-gray-200 rounded-lg text-sm
                        focus-within:border-blue-500 focus-within:ring-blue-500
                        dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-300
                        @error('image') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror
                    ">

                        <p id="image-helper" class="text-xs text-gray-500 dark:text-neutral-500 mt-1"
                            data-existing-url="{{ $data->preview_path ?? '' }}">
                            @if (isset($data->preview_path))
                                <span class="text-blue-600 underline cursor-pointer hover:text-blue-800 dark:text-blue-400">
                                    Lihat gambar saat ini
                                </span>
                            @else
                                Klik, drag & drop, atau Ctrl+V untuk paste gambar (maks 5MB)
                            @endif
                        </p>

                        @error('image')
                            <p class="text-xs text-red-600 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <div class="flex justify-start gap-x-2 mt-4">
                    <a navigate href="{{ route('superadmin.image-prompts.index') }}"
                        class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:bg-gray-50 dark:bg-transparent dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-800">
                        Batal
                    </a>
                    <button type="submit"
                        class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none cursor-pointer">
                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                            <polyline points="17 21 17 13 7 13 7 21" />
                            <polyline points="7 3 7 8 15 8" />
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        (function() {
            let previewUrl = null;

            function initImageHelper() {
                const fileInput = document.getElementById('image');
                const helper = document.getElementById('image-helper');

                if (!fileInput || !helper) return;

                // prevent double bind (navigate-form)
                if (fileInput.dataset.bound === '1') return;
                fileInput.dataset.bound = '1';

                const existingUrl = helper.dataset.existingUrl;

                function setLink(text, url) {
                    helper.innerHTML = `
                            <span class="text-blue-600 underline cursor-pointer hover:text-blue-800 dark:text-blue-400">
                                ${text}
                            </span>
                        `;
                    helper.onclick = () => window.open(url, '_blank');
                }

                function resetHelper() {
                    if (existingUrl) {
                        setLink('Lihat gambar saat ini', existingUrl);
                    } else {
                        helper.textContent =
                            'Klik, drag & drop, atau Ctrl+V untuk paste gambar (maks 5MB)';
                        helper.onclick = null;
                    }
                }

                function handleFile(file) {
                    if (!file || !file.type.startsWith('image/')) return;

                    if (previewUrl) URL.revokeObjectURL(previewUrl);
                    previewUrl = URL.createObjectURL(file);

                    setLink(`Lihat ${file.name}`, previewUrl);
                }

                /* FILE PICK */
                fileInput.addEventListener('change', () => {
                    const file = fileInput.files[0];
                    if (!file) {
                        resetHelper();
                        return;
                    }
                    handleFile(file);
                });

                /* PASTE */
                document.addEventListener('paste', e => {
                    const items = e.clipboardData?.items;
                    if (!items) return;

                    for (const item of items) {
                        if (item.type.startsWith('image/')) {
                            e.preventDefault();
                            const file = item.getAsFile();
                            const dt = new DataTransfer();
                            dt.items.add(file);
                            fileInput.files = dt.files;
                            handleFile(file);
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
                    handleFile(file);
                });

                // init default state
                resetHelper();
            }

            initImageHelper();
            document.addEventListener('navigate:complete', initImageHelper);
        })();
    </script>

@endsection
