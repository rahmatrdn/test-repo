@extends('_admin._layout.app')

@section('title', 'Edit Siswa')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div
            class="bg-white overflow-hidden shadow-lg rounded-2xl dark:bg-neutral-800 border-2 border-gray-100 dark:border-neutral-700">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-neutral-700 flex items-center">
                <a navigate href="{{ route('admin.students.index') }}"
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

            <form navigate-form action="{{ route('admin.students.do_update', $data->id) }}" method="POST" class="p-6">
                @csrf
                <div class="space-y-4">
                    {{-- Name --}}
                    <div>
                        <label for="name" class="block text-sm font-medium mb-2 dark:text-white">Nama Siswa <span
                                class="text-red-500">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name', $data->name) }}"
                            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 placeholder-neutral-300 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 @error('name') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                            placeholder="Contoh: Ahmad" required>
                        @error('name')
                            <p class="text-xs text-red-600 mt-2" id="name-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Form Group -->
                    <div>
                        <label for="email" class="block text-sm font-medium mb-2 dark:text-white">Email <span
                                class="text-red-500">*</span></label>
                        <div class="relative">
                            <input type="email" id="email" name="email" value="{{ old('email', $data->email) }}"
                                class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 @error('email') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                                placeholder="Masukkan email siswa" required>
                        </div>
                        @error('email')
                            <p class="text-xs text-red-600 mt-2" id="email-error">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- End Form Group -->

                    {{-- Class --}}
                    <div>
                        <label for="classroom_id" class="block text-sm font-medium mb-2 dark:text-white">Kelas <span
                                class="text-red-500">*</span></label>
                        <select name="classroom_id" id="classroom_id"
                            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 @error('classroom_id') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                            required>
                            <option value="">Pilih Kelas</option>
                            @foreach ($classrooms as $class)
                                <option value="{{ $class->id }}" {{ old('classroom_id', $data->classroom_id) == $class->id ? 'selected' : '' }}>
                                    {{ $class->class_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('classroom_id')
                            <p class="text-xs text-red-600 mt-2" id="classroom_id-error">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <div class="mt-4 flex justify-start gap-x-2">
                    <a navigate href="{{ route('admin.students.index') }}"
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