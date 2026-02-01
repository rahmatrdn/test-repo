@extends('_admin._layout.app')

@section('title', 'Nilai Kuis')

@section('content')
<div class="grid gap-3 md:flex md:justify-between md:items-center py-4">
    <div>
        <h1 class="text-2xl font-extrabold text-gray-800 dark:text-neutral-200 mb-1">
            Nilai Kuis
        </h1>
        <p class="text-md text-gray-400 dark:text-neutral-400">
            {{ $quiz->name ?? 'N/A' }} - {{ $quiz->topic ?? '' }}
        </p>
    </div>
    <div class="inline-flex gap-x-2">
        <button type="button"
            class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-200 dark:hover:bg-neutral-700">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
            </svg>
            Export Excel
        </button>
        <a navigate href="{{ route('teacher.ai.quiz_generator.index') }}"
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

<!-- Statistics Cards -->
<div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-5 dark:bg-neutral-800 dark:border-neutral-700">
        <div class="flex items-center gap-x-3">
            <div class="flex-shrink-0">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-500 dark:text-neutral-400">Total Siswa</p>
                <h3 class="text-xl font-bold text-gray-800 dark:text-neutral-200">{{ $scores->total() ?? 0 }}</h3>
            </div>
        </div>
    </div>

    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-5 dark:bg-neutral-800 dark:border-neutral-700">
        <div class="flex items-center gap-x-3">
            <div class="flex-shrink-0">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-500 dark:text-neutral-400">Rata-rata Nilai</p>
                <h3 class="text-xl font-bold text-gray-800 dark:text-neutral-200">
                    {{ $scores->avg('score') ? number_format($scores->avg('score'), 1) : '0' }}
                </h3>
            </div>
        </div>
    </div>

    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-5 dark:bg-neutral-800 dark:border-neutral-700">
        <div class="flex items-center gap-x-3">
            <div class="flex-shrink-0">
                <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-500 dark:text-neutral-400">Nilai Tertinggi</p>
                <h3 class="text-xl font-bold text-gray-800 dark:text-neutral-200">
                    {{ $scores->max('score') ?? '0' }}
                </h3>
            </div>
        </div>
    </div>

    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-5 dark:bg-neutral-800 dark:border-neutral-700">
        <div class="flex items-center gap-x-3">
            <div class="flex-shrink-0">
                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" />
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-500 dark:text-neutral-400">Nilai Terendah</p>
                <h3 class="text-xl font-bold text-gray-800 dark:text-neutral-200">
                    {{ $scores->min('score') ?? '0' }}
                </h3>
            </div>
        </div>
    </div>
</div>

<!-- Scores Table -->
<div class="flex flex-col">
    <div class="overflow-x-auto">
        <div class="min-w-full inline-block align-middle">
            <div class="overflow-hidden">
                <div class="mx-0 my-0 overflow-x-auto border border-gray-200 rounded-lg dark:border-neutral-700">
                    <table class="w-full divide-y divide-gray-200 dark:divide-neutral-700">
                        <thead class="bg-gray-50 dark:bg-neutral-700">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-start">
                                    <span class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">
                                        No
                                    </span>
                                </th>
                                <th scope="col" class="px-6 py-3 text-start">
                                    <span class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">
                                        Nama Siswa
                                    </span>
                                </th>
                                <th scope="col" class="px-6 py-3 text-start">
                                    <span class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">
                                        NISN
                                    </span>
                                </th>
                                <th scope="col" class="px-6 py-3 text-start">
                                    <span class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">
                                        Jawaban Benar
                                    </span>
                                </th>
                                <th scope="col" class="px-6 py-3 text-start">
                                    <span class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">
                                        Nilai
                                    </span>
                                </th>
                                <th scope="col" class="px-6 py-3 text-start">
                                    <span class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">
                                        Waktu Selesai
                                    </span>
                                </th>
                                <th scope="col" class="px-2 py-3 text-end">
                                    <span class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">
                                        Status
                                    </span>
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                            @forelse($scores as $index => $score)
                            <tr class="hover:bg-gray-100 dark:hover:bg-neutral-700">
                                <td class="size-px whitespace-nowrap px-6 py-3">
                                    <span class="text-sm text-gray-800 dark:text-neutral-200">
                                        {{ ($scores->currentPage() - 1) * $scores->perPage() + $index + 1 }}
                                    </span>
                                </td>
                                <td class="size-px whitespace-nowrap px-6 py-3">
                                    <span class="block text-sm font-semibold text-gray-800 dark:text-neutral-200">
                                        {{ $score->student_name }}
                                    </span>
                                </td>
                                <td class="size-px whitespace-nowrap px-6 py-3">
                                    <span class="text-sm text-gray-600 dark:text-neutral-400">
                                        {{ $score->student_nisn }}
                                    </span>
                                </td>
                                <td class="size-px whitespace-nowrap px-6 py-3">
                                    <span class="text-sm text-gray-800 dark:text-neutral-200">
                                        {{ $score->correct_answers }}/{{ $score->total_questions }}
                                    </span>
                                </td>
                                <td class="size-px whitespace-nowrap px-6 py-3">
                                    <span class="inline-flex items-center gap-x-1 py-1 px-2 rounded-full text-xs font-medium
                                                @if($score->score >= 80) bg-green-100 text-green-800 dark:bg-green-800/30 dark:text-green-500
                                                @elseif($score->score >= 60) bg-yellow-100 text-yellow-800 dark:bg-yellow-800/30 dark:text-yellow-500
                                                @else bg-red-100 text-red-800 dark:bg-red-800/30 dark:text-red-500
                                                @endif">
                                        {{ $score->score }}
                                    </span>
                                </td>
                                <td class="size-px whitespace-nowrap px-6 py-3">
                                    <span class="text-sm text-gray-600 dark:text-neutral-400">
                                        {{ \Carbon\Carbon::parse($score->completed_at)->format('d M Y, H:i') }}
                                    </span>
                                </td>
                                <td class="size-px whitespace-nowrap px-6 py-3">
                                    <div class="flex items-center justify-end">
                                        @if($score->score >= 75)
                                        <span class="inline-flex items-center gap-x-1 py-1 px-2 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-800/30 dark:text-green-500">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                            </svg>
                                            Lulus
                                        </span>
                                        @else
                                        <span class="inline-flex items-center gap-x-1 py-1 px-2 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-800/30 dark:text-red-500">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                            </svg>
                                            Tidak Lulus
                                        </span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-neutral-500">
                                    <x-admin.empty-state />
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if (count($scores) > 0 && $scores->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 dark:border-neutral-700">
                    <div class="flex justify-end">
                        {{ $scores->links() }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection