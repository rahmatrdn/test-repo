@extends('_admin._layout.app')

@section('title', 'Detail Ilustrasi')

@section('content')
    <div class="grid gap-3 md:flex md:justify-between md:items-center py-4">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-800 dark:text-neutral-200 mb-1">
                Detail Ilustrasi
            </h1>
            <p class="text-md text-gray-400 dark:text-neutral-400">
                Lihat detail ilustrasi yang telah dibuat
            </p>
        </div>
        <div>
            <a navigate href="{{ route('teacher.ai.ilustrasi.index') }}"
                class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-700">
                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path d="m12 19-7-7 7-7" />
                    <path d="M19 12H5" />
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <!-- Info Card -->
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-neutral-800 dark:border-neutral-700 mb-6">
        <div class="p-6 sm:p-8">
            <div class="grid sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-600 dark:text-neutral-400 mb-2">
                        Style Gambar
                    </label>
                    <p class="text-gray-800 dark:text-neutral-200 font-semibold">
                        @if($data->image_style_name)
                            <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-800/30 dark:text-purple-500">
                                <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 6 6">
                                    <circle cx="3" cy="3" r="3" />
                                </svg>
                                {{ $data->image_style_name }}
                            </span>
                        @else
                            <span class="text-gray-500 dark:text-neutral-500 text-sm">-</span>
                        @endif
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 dark:text-neutral-400 mb-2">
                        Dibuat Oleh
                    </label>
                    <p class="text-gray-800 dark:text-neutral-200 font-semibold">
                        {{ $data->created_by_name }}
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 dark:text-neutral-400 mb-2">
                        Tanggal Dibuat
                    </label>
                    <p class="text-gray-800 dark:text-neutral-200">
                        {{ \Carbon\Carbon::parse($data->created_at)->format('d F Y, H:i') }} WIB
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 dark:text-neutral-400 mb-2">
                        Terakhir Update
                    </label>
                    <p class="text-gray-800 dark:text-neutral-200">
                        {{ \Carbon\Carbon::parse($data->updated_at)->format('d F Y, H:i') }} WIB
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- User Input Card -->
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-neutral-800 dark:border-neutral-700 mb-6">
        <div class="p-6 sm:p-8">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-neutral-200 mb-4">
                Deskripsi Prompt
            </h3>
            <div class="bg-gray-50 dark:bg-neutral-900 rounded-lg p-4 border border-gray-200 dark:border-neutral-700">
                <p class="text-gray-700 dark:text-neutral-300 whitespace-pre-wrap">{{ $data->user_input }}</p>
            </div>
        </div>
    </div>

    <!-- Result Card -->
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-neutral-800 dark:border-neutral-700">
        <div class="p-6 sm:p-8">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-neutral-200">Hasil Ilustrasi</h3>
                @if(isset($data->output_file_path) && $data->output_file_path)
                    <a href="{{ url($data->output_file_path) }}" download
                        class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Download
                    </a>
                @endif
            </div>
            
            <div class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-neutral-900 dark:to-neutral-800 rounded-lg p-8 border border-gray-200 dark:border-neutral-700">
                @if(isset($data->output_file_path) && $data->output_file_path)
                    <div class="flex justify-center">
                        <img src="{{ url($data->output_file_path) }}" 
                             alt="{{ $data->user_input }}"
                             class="max-w-full h-auto rounded-lg shadow-lg border border-gray-300 dark:border-neutral-600"
                             loading="lazy">
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center py-12 text-gray-400 dark:text-neutral-500">
                        <svg class="w-24 h-24 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                        </svg>
                        <p class="text-lg font-medium">Tidak ada gambar</p>
                        <p class="text-sm mt-1">Ilustrasi belum tersedia</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
