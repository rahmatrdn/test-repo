@extends('_admin._layout.app')

@section('title', 'Update Kelas Sekolah')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div
            class="bg-white overflow-hidden shadow-lg rounded-2xl dark:bg-neutral-800 border-2 border-gray-100 dark:border-neutral-700">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-neutral-700 flex items-center">
                <a navigate href="{{ route('admin.classrooms.index') }}"
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

            <form id="update-form" class="p-6" navigate-form action="{{ route('admin.classrooms.do_update', $data->id) }}"
                method="POST">
                @csrf

                <div class="space-y-4">
                    {{-- Name --}}
                    <div>
                        <label for="class_name" class="block text-sm font-medium mb-2 dark:text-white">Nama Kelas <span
                                class="text-red-500">*</span></label>
                        <input type="text" id="class_name" name="class_name"
                            value="{{ old('class_name', $data->class_name) }}"
                            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 placeholder-neutral-300 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 @error('class_name') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                            placeholder="Contoh: Kelas 1A" required>
                        @error('class_name')
                            <p class="text-xs text-red-600 mt-2" id="class_name-error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="entry_year" class="block text-sm font-medium mb-2 dark:text-white">Tahun Masuk <span
                                class="text-red-500">*</span></label>
                        <input type="text" id="entry_year" name="entry_year"
                            value="{{ old('entry_year', $data->entry_year) }}"
                            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 placeholder-neutral-300 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 @error('entry_year') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                            placeholder="Contoh: 2024" required>
                        @error('entry_year')
                            <p class="text-xs text-red-600 mt-2" id="entry_year-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Footer --}}
                <div class="flex justify-start gap-x-2 mt-4">
                    <a navigate href="{{ route('admin.classrooms.index') }}"
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
@endsection