@extends('_admin._layout.app')

@section('title', 'Detail Kuis')

@section('content')
<div class="grid gap-3 md:flex md:justify-between md:items-center py-4">
    <x-page-title title="Detail Kuis" description=" Informasi lengkap tentang kuis"/>
    <div>
        <a navigate href="{{ route('teacher.quiz.index') }}"
            class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-700">
            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                linejoin="round">
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
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-600 dark:text-neutral-400 mb-2">
                    Nama Kuis
                </label>
                <p class="text-gray-800 dark:text-neutral-200 font-semibold">
                    {{ $data->quiz_name ?? 'N/A' }}
                </p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-600 dark:text-neutral-400 mb-2">
                    Kode Quiz
                </label>
                <p class="text-gray-800 dark:text-neutral-200">
                    <span class="inline-flex items-center gap-x-1.5 py-1 px-2 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-800/30 dark:text-blue-500">
                        {{ $data->quiz_code ?? 'N/A' }}
                    </span>
                </p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-600 dark:text-neutral-400 mb-2">
                    Durasi
                </label>
                <p class="text-gray-800 dark:text-neutral-200">
                    {{ $data->quiz_time ?? '00:00:00' }}
                </p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-600 dark:text-neutral-400 mb-2">
                    Jumlah Soal
                </label>
                <p class="text-gray-800 dark:text-neutral-200 font-semibold">
                    <span class="inline-flex items-center gap-x-1.5 py-1 px-2 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-800/30 dark:text-purple-500">
                        {{ count($data->questions ?? []) }} Soal
                    </span>
                </p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-600 dark:text-neutral-400 mb-2">
                    Dibuat Oleh
                </label>
                <p class="text-gray-800 dark:text-neutral-200">
                    {{ $data->created_by_name ?? 'N/A' }}
                </p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-600 dark:text-neutral-400 mb-2">
                    Tanggal Dibuat
                </label>
                <p class="text-gray-800 dark:text-neutral-200">
                    {{ \Carbon\Carbon::parse($data->created_at)->format('d M Y, H:i') }}
                </p>
            </div>

            <div class="sm:col-span-2 lg:col-span-3">
                <label class="block text-sm font-medium text-gray-600 dark:text-neutral-400 mb-2">
                    Deskripsi
                </label>
                <p class="text-gray-800 dark:text-neutral-200">
                    {{ $data->description ?? '-' }}
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Questions List -->
<div class="bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-neutral-800 dark:border-neutral-700">
    <div class="p-6 sm:p-8">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-neutral-200 mb-6">Daftar Soal</h3>

        @if(isset($data->questions) && count($data->questions) > 0)
        <div class="space-y-4">
            @foreach($data->questions as $index => $question)
            <div class="bg-white dark:bg-neutral-800 border border-gray-200 dark:border-neutral-700 rounded-lg p-6">
                <div class="flex items-start justify-between mb-3">
                    <h4 class="text-md font-semibold text-gray-800 dark:text-neutral-200">Soal {{ $index + 1 }}</h4>
                </div>
                <p class="text-sm text-gray-700 dark:text-neutral-300 mb-4">{{ $question->question ?? 'N/A' }}</p>

                @if(!empty($question->options))
                <div class="grid sm:grid-cols-2 gap-2">
                    @foreach($question->options as $optionIndex => $option)
                    <div class="flex items-center gap-2 p-2 rounded {{ $option->is_correct ? 'bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800' : 'bg-gray-50 dark:bg-neutral-900' }}">
                        @if($option->is_correct)
                        <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        @endif
                        <span class="text-sm {{ $option->is_correct ? 'text-green-800 dark:text-green-300 font-medium' : 'text-gray-700 dark:text-neutral-300' }}">
                            <strong>{{ chr(65 + $optionIndex) }}.</strong> {{ $option->option_text }}
                        </span>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-4">
                    <p class="text-sm text-gray-500 dark:text-neutral-400">Belum ada opsi jawaban</p>
                </div>
                @endif
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <p class="mt-2 text-sm text-gray-500 dark:text-neutral-400">Belum ada soal</p>
        </div>
        @endif
    </div>
</div>
@endsection