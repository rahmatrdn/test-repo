@extends('_admin._layout.app')

@section('title', 'Buat Kuis')

@section('content')
<div class="grid gap-3 md:flex md:justify-between md:items-center py-4">
    <x-page-title title="Buat Kuis Baru" description=" Tambahkan kuis dengan input manual"/>
    <div>
        <a navigate href="{{ route('teacher.quiz.index') }}"
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

<!-- Manual Input Form -->
<div class="bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-neutral-800 dark:border-neutral-700">
    <div class="p-6 sm:p-8">
        <form action="{{ route('teacher.quiz.store') }}" method="POST">
            @csrf
            <input type="hidden" name="input_type" value="manual">

            <div class="grid sm:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="quiz_name" class="block text-sm font-medium mb-2 text-gray-800 dark:text-neutral-200">
                        Nama Kuis <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="quiz_name" name="name"
                        class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                        placeholder="Contoh: Kuis Matematika Bab 1" required>
                </div>

                <div>
                    <label for="topic" class="block text-sm font-medium mb-2 text-gray-800 dark:text-neutral-200">
                        Topik
                    </label>
                    <input type="text" id="topic" name="topic"
                        class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                        placeholder="Contoh: Aljabar">
                </div>
            </div>

            <div class="grid sm:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="duration" class="block text-sm font-medium mb-2 text-gray-800 dark:text-neutral-200">
                        Durasi Quiz <span class="text-red-500">*</span>
                    </label>
                    <input type="time" id="duration" name="duration" value="01:00:00" step="1"
                        class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                        required>
                    <p class="mt-1 text-xs text-gray-500 dark:text-neutral-500">Format: Jam:Menit:Detik (contoh: 01:30:00 untuk 1 jam 30 menit)</p>
                </div>
            </div>

            <div class="mb-6">
                <label for="description" class="block text-sm font-medium mb-2 text-gray-800 dark:text-neutral-200">
                    Deskripsi
                </label>
                <textarea id="description" name="description" rows="3"
                    class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                    placeholder="Deskripsi singkat tentang kuis ini..."></textarea>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('teacher.quiz.index') }}"
                    class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-200 dark:hover:bg-neutral-800">
                    Batal
                </a>
                <button type="submit"
                    class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-neutral-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Buat Kuis
                </button>
            </div>
        </form>
    </div>
</div>
@endsection