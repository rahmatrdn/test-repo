@extends('_admin._layout.app')

@section('title', 'Detail Modul Belajar')

@section('content')
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center gap-x-3 mb-4">
                <a navigate href="{{ route('teacher.learning_modules.index') }}"
                    class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-700">
                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="m12 19-7-7 7-7" />
                        <path d="M19 12H5" />
                    </svg>
                    Kembali
                </a>
                <div class="flex gap-x-2">
                    <a navigate href="{{ route('teacher.learning_modules.update', $data->id) }}"
                        class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700">
                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                        </svg>
                        Edit
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-neutral-900 dark:border-neutral-700">
            <!-- File Preview Section -->
            <div class="h-64 flex flex-col justify-center items-center bg-gradient-to-br from-blue-50 to-indigo-50 rounded-t-xl dark:from-blue-900/20 dark:to-indigo-900/20 border-b border-gray-200 dark:border-neutral-700">
                @php
                    $fileExtension = pathinfo($data->file_path, PATHINFO_EXTENSION);
                @endphp

                @if(in_array(strtolower($fileExtension), ['pdf']))
                    <svg class="size-24 text-red-600 dark:text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <path d="M9 13h6"></path>
                        <path d="M9 17h6"></path>
                        <path d="M9 9h1"></path>
                    </svg>
                    <span class="mt-3 text-lg font-semibold text-red-600 dark:text-red-400">PDF Document</span>
                @elseif(in_array(strtolower($fileExtension), ['doc', 'docx']))
                    <svg class="size-24 text-blue-600 dark:text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="16" y1="13" x2="8" y2="13"></line>
                        <line x1="16" y1="17" x2="8" y2="17"></line>
                        <polyline points="10 9 9 9 8 9"></polyline>
                    </svg>
                    <span class="mt-3 text-lg font-semibold text-blue-600 dark:text-blue-400">Word Document</span>
                @elseif(in_array(strtolower($fileExtension), ['ppt', 'pptx']))
                    <svg class="size-24 text-orange-600 dark:text-orange-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <rect x="8" y="12" width="8" height="6"></rect>
                    </svg>
                    <span class="mt-3 text-lg font-semibold text-orange-600 dark:text-orange-400">PowerPoint Presentation</span>
                @else
                    <svg class="size-24 text-gray-400 dark:text-neutral-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                    </svg>
                    <span class="mt-3 text-lg font-semibold text-gray-400 dark:text-neutral-500">File Document</span>
                @endif

                <p class="mt-2 text-sm text-gray-600 dark:text-neutral-400">{{ basename($data->file_path) }}</p>
            </div>

            <!-- Content Section -->
            <div class="p-6 sm:p-8">
                <!-- Badge Kelas -->
                <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-md text-sm font-medium bg-blue-100 text-blue-800 dark:bg-blue-800/30 dark:text-blue-500 mb-4">
                    <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z" />
                    </svg>
                    Kelas {{ $data->classroom }}
                </span>

                <!-- Title -->
                <h1 class="text-2xl font-bold text-gray-800 dark:text-neutral-200 mb-2">
                    {{ $data->title }}
                </h1>

                <!-- Metadata -->
                <div class="flex flex-wrap gap-4 text-sm text-gray-600 dark:text-neutral-400 mb-6">
                    <div class="flex items-center gap-x-2">
                        <svg class="size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"></path>
                        </svg>
                        <span>{{ $data->subject_name }}</span>
                    </div>
                    <div class="flex items-center gap-x-2">
                        <svg class="size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                        <span>{{ $data->created_by_name }}</span>
                    </div>
                    <div class="flex items-center gap-x-2">
                        <svg class="size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                        <span>{{ \Carbon\Carbon::parse($data->created_at)->format('d M Y, H:i') }}</span>
                    </div>
                </div>

                <!-- Divider -->
                <div class="border-t border-gray-200 dark:border-neutral-700 my-6"></div>

                <!-- File Info -->
                <div class="bg-gray-50 rounded-lg p-4 dark:bg-neutral-800 mb-6">
                    <h3 class="text-sm font-semibold text-gray-800 dark:text-neutral-200 mb-3">Informasi File</h3>
                    <dl class="grid grid-cols-2 gap-4">
                        <div>
                            <dt class="text-xs text-gray-500 dark:text-neutral-400 mb-1">Format File</dt>
                            <dd class="text-sm font-medium text-gray-800 dark:text-neutral-200">{{ strtoupper($fileExtension) }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-gray-500 dark:text-neutral-400 mb-1">Nama File</dt>
                            <dd class="text-sm font-medium text-gray-800 dark:text-neutral-200">{{ basename($data->file_path) }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Download Button -->
                <div class="flex gap-x-2">
                    <a href="{{ asset('storage/' . $data->file_path) }}" target="_blank"
                        class="py-2.5 px-4 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700">
                        <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                            <polyline points="7 10 12 15 17 10"></polyline>
                            <line x1="12" y1="15" x2="12" y2="3"></line>
                        </svg>
                        Download Modul
                    </a>
                    <a href="{{ asset('storage/' . $data->file_path) }}" target="_blank"
                        class="py-2.5 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-700">
                        <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                        Lihat File
                    </a>
                </div>
            </div>

            <!-- Footer Info -->
            <div class="px-6 sm:px-8 py-4 bg-gray-50 border-t border-gray-200 rounded-b-xl dark:bg-neutral-800 dark:border-neutral-700">
                <p class="text-xs text-gray-500 dark:text-neutral-400">
                    Terakhir diperbarui: {{ \Carbon\Carbon::parse($data->updated_at)->diffForHumans() }}
                </p>
            </div>
        </div>
    </div>
@endsection
