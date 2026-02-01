<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang di Quiz</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc; /* Gray/Slate 50 */
        }
        .card-shadow {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.04), 0 8px 10px -6px rgba(0, 0, 0, 0.04);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6">

    <div class="max-w-xl w-full bg-white rounded-2xl card-shadow border border-slate-100 overflow-hidden">
        <!-- Banner / Header -->
        <div class="h-3 w-full bg-blue-600"></div>
        
        <div class="p-8 md:p-10">
            <!-- Title Section -->
            <div class="mb-8">
                <div class="inline-flex items-center px-3 py-1 rounded-full bg-blue-50 text-blue-600 text-xs font-bold uppercase tracking-wider mb-4">
                    Kuis Interaktif
                </div>
                <h1 id="quizName" class="text-3xl font-bold text-slate-900 leading-tight">
                    {{ $quiz->quiz_name }}
                </h1>
                <p class="text-slate-500 mt-2">Pastikan Anda telah siap sebelum menekan tombol mulai.</p>
            </div>

            <!-- Description -->
            <div class="mb-8">
                <h2 class="text-sm font-semibold text-slate-400 uppercase tracking-wide mb-3">Tentang Quiz</h2>
                <p id="quizDescription" class="text-slate-600 leading-relaxed">
                    {{ $quiz->description }}
                </p>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-3 gap-6 mb-10 border-y border-slate-50 py-8">
                <!-- Info: Time -->
                <div class="text-center">
                    <p class="text-xs text-slate-400 font-medium mb-1 uppercase tracking-tighter">Durasi</p>
                    <div class="flex items-center justify-center gap-1.5 text-slate-800">
                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="font-bold">{{ $time }}</span>
                    </div>
                </div>

                <!-- Info: Questions -->
                <div class="text-center border-x border-slate-100 px-4">
                    <p class="text-xs text-slate-400 font-medium mb-1 uppercase tracking-tighter">Soal</p>
                    <div class="flex items-center justify-center gap-1.5 text-slate-800">
                        <svg class="w-4 h-4 text-blue-500" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-scroll-text-icon lucide-scroll-text"><path d="M15 12h-5"/><path d="M15 8h-5"/><path d="M19 17V5a2 2 0 0 0-2-2H4"/><path d="M8 21h12a2 2 0 0 0 2-2v-1a1 1 0 0 0-1-1H11a1 1 0 0 0-1 1v1a2 2 0 1 1-4 0V5a2 2 0 1 0-4 0v2a1 1 0 0 0 1 1h3"/></svg>
                        <span class="font-bold">{{ $quiz->total_soal }}</span>
                    </div>
                </div>

                <!-- Info: Code -->
                <div class="text-center">
                    <p class="text-xs text-slate-400 font-medium mb-1 uppercase tracking-tighter">Kode</p>
                    <div class="flex items-center justify-center gap-1.5 text-slate-800">
                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                        <span class="font-bold  ">{{ $quiz->quiz_code }}</span>
                    </div>
                </div>
            </div>

            <!-- Footer Action -->
            <div class="space-y-4">
                <button onclick="startQuiz()" class="group w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-4 px-6 rounded-xl transition-all duration-200 flex items-center justify-center gap-2">
                    Mulai Sekarang
                    <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </button>
                <p class="text-center text-[10px] text-slate-400 uppercase tracking-widest font-bold">
                    &copy; 2024 Portal Pendidikan Indonesia
                </p>
            </div>
        </div>
    </div>

    <script>
        function startQuiz() {
            const btn = document.querySelector('button');
            const originalContent = btn.innerHTML;
            
            btn.innerHTML = `
                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>Memuat...</span>
            `;
            btn.disabled = true;
            btn.classList.add('opacity-80', 'cursor-not-allowed');

            window.location.href = "{{ route('student.quiz.quizsoal', ['code' => $quiz->quiz_code]) }}";
        }
    </script>
</body>
</html>