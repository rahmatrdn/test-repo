@extends('_admin._layout.app')

@section('title', 'Kerjakan Kuis Baru')

@section('content')

<div class="grid gap-3 md:flex md:justify-between md:items-center py-4">
    <x-page-title title="{{$page['title'] }}" description="Riwayat hasil kuis yang telah Anda selesaikan." />

    <button type="button"
        class="py-3 px-4 inline-flex items-center justify-center gap-x-2 text-sm font-semibold rounded-xl border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-blue-700 transition-all shadow-md shadow-blue-500/20 active:scale-95 cursor-pointer"
        data-hs-overlay="#quiz-modal">
        @include('_admin._layout.icons.add')
        Gabung Kuis
    </button>
</div>

<div class="flex flex-col">
    <div class="overflow-x-auto">
        <div class="min-w-full inline-block align-middle">
            <div class="overflow-hidden">
                {{-- Form Filter --}}
                <div class="px-2 py-2 pb-4">
                    <form action="" method="GET" navigate class="flex flex-col sm:flex-row gap-3">
                        <div class="sm:w-64">
                            <input type="text" name="keywords" value="{{ $keywords ?? '' }}"
                                class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
                                placeholder="Cari Judul Kuis">
                        </div>
                        <button type="submit" class="py-2 px-3 inline-flex items-center gap-x-1 text-sm font-semibold rounded-lg bg-blue-600 text-white hover:bg-blue-700">
                            Cari
                        </button>
                    </form>
                </div>

                {{-- Daftar Riwayat Kuis --}}
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
                    @forelse ($data as $item)
                    <div class="flex flex-col bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition dark:bg-neutral-900 dark:border-neutral-700">
                        <div class="p-4">
                            <div class="flex justify-between items-start mb-2">
                                <span class="inline-flex items-center gap-1.5 py-0.5 px-2 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                                    {{ $item->subject_name }}
                                </span>
                                <span class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">
                                    {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d M Y') }}
                                </span>
                            </div>

                            <h3 class="text-sm font-semibold text-gray-800 dark:text-neutral-200 line-clamp-1">
                                {{ $item->quiz_title }}
                            </h3>

                            <div class="mt-4 grid grid-cols-3 gap-2 border-y border-gray-100 dark:border-neutral-800 py-3 my-3">
                                <div class="text-center">
                                    <p class="text-[10px] uppercase text-gray-400 font-bold">Skor</p>
                                    <p class="text-lg font-bold text-blue-600">{{ number_format($item->score, 0) }}</p>
                                </div>
                                <div class="text-center">
                                    <p class="text-[10px] uppercase text-gray-400 font-bold">Benar</p>
                                    <p class="text-lg font-bold text-green-500">{{ $item->correct_answer }}</p>
                                </div>
                                <div class="text-center">
                                    <p class="text-[10px] uppercase text-gray-400 font-bold">Salah</p>
                                    <p class="text-lg font-bold text-red-500">{{ $item->wrong_answer }}</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-2 text-xs text-gray-500">
                                <svg class="size-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>Durasi: {{ $item->working_time }}</span>
                            </div>
                        </div>

                        <div class="mt-auto flex border-t border-gray-200 dark:border-neutral-700 divide-x divide-gray-200 dark:divide-neutral-700">
                            <a href="#"
                                class="flex-1 py-2.5 text-xs font-medium text-center text-blue-600 hover:bg-blue-50 dark:text-blue-400 dark:hover:bg-neutral-800 transition">
                                Lihat Detail Pembahasan
                            </a>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full text-center py-16">
                        <x-admin.empty-state />
                        <p class="mt-2 text-sm text-gray-500">Belum ada kuis yang dikerjakan.</p>
                    </div>
                    @endforelse
                </div>

                {{-- Pagination --}}
                @if(!empty($data) && method_exists($data, 'links'))
                <div class="mt-6">
                    {{ $data->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal Gabung Kuis (Preline Style) -->
<div id="quiz-modal"
    class="hs-overlay hidden size-full fixed top-0 start-0 z-[80] overflow-x-hidden overflow-y-auto pointer-events-none"
    role="dialog" tabindex="-1" aria-labelledby="quiz-modal-label">
    <div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-sm sm:w-full m-3 sm:mx-auto">
        <div class="relative flex flex-col bg-white border shadow-sm rounded-xl pointer-events-auto dark:bg-neutral-900 dark:border-neutral-800">
            <!-- Close Button -->
            <div class="absolute top-2 end-2">
                <button type="button"
                    class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 dark:bg-neutral-700 dark:hover:bg-neutral-600 dark:text-neutral-400"
                    aria-label="Close" data-hs-overlay="#quiz-modal">
                    <span class="sr-only">Close</span>
                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 6 6 18"></path>
                        <path d="m6 6 12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Modal Content -->
            <div class="p-6 sm:p-8 text-center overflow-y-auto">
                <!-- Icon -->
                <span class="mb-4 inline-flex justify-center items-center size-[58px] rounded-full border-4 border-blue-50 bg-blue-100 text-blue-600 dark:bg-blue-900 dark:border-blue-800 dark:text-blue-500">
                    <svg class="shrink-0 size-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m10 13 2 2 4-4" />
                        <circle cx="12" cy="12" r="10" />
                    </svg>
                </span>

                <h3 id="quiz-modal-label" class="mb-2 text-xl font-bold text-gray-800 dark:text-neutral-200">
                    Gabung Kuis
                </h3>
                <p class="text-sm text-gray-500 dark:text-neutral-500 mb-6">
                    Masukkan 5 digit kode akses untuk bergabung ke kuis
                </p>

                <!-- Form -->
                <form id="quizEntryForm" method="GET" action="{{ route('student.quiz.start') }}">
                    <div class="mb-6">
                        <input type="text" name="quiz_code" id="quiz_code" required
                            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-2xl font-bold text-center tracking-[0.5em] focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-300 uppercase"
                            placeholder="- - - - -"
                            maxlength="5"
                            oninput="validateQuizCode(this)">

                        <div id="errorMessage" class="hidden mt-2 text-xs text-red-600 dark:text-red-500 font-medium">
                            Kode tidak valid
                        </div>
                    </div>

                    <div class="flex justify-center gap-x-3">
                        <button type="button"
                            class="py-2.5 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-700"
                            data-hs-overlay="#quiz-modal">
                            Batal
                        </button>
                        <button type="submit" id="submitQuizBtn" disabled
                            class="py-2.5 px-4 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:bg-blue-700">
                            Masuk Kuis
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function validateQuizCode(input) {
        // Hanya huruf dan angka
        input.value = input.value.replace(/[^a-zA-Z0-9]/g, '').toUpperCase();

        const submitBtn = document.getElementById('submitQuizBtn');
        const errorMsg = document.getElementById('errorMessage');

        // Enable submit button jika panjang kode = 5
        if (input.value.length === 5) {
            submitBtn.disabled = false;
            errorMsg.classList.add('hidden');
        } else {
            submitBtn.disabled = true;
        }
    }

    // Auto focus ke input saat modal dibuka
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('quiz-modal');
        const input = document.getElementById('quiz_code');

        // Menggunakan MutationObserver untuk detect saat modal dibuka
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.attributeName === 'class') {
                    if (!modal.classList.contains('hidden')) {
                        setTimeout(() => {
                            input.focus();
                        }, 100);
                    } else {
                        // Reset form saat modal ditutup
                        document.getElementById('quizEntryForm').reset();
                        document.getElementById('submitQuizBtn').disabled = true;
                        document.getElementById('errorMessage').classList.add('hidden');
                    }
                }
            });
        });

        observer.observe(modal, {
            attributes: true
        });
    });
</script>

@endsection