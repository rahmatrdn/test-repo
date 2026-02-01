<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Kuis - {{ $quiz->quiz_name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #fcfcfd;
            color: #1a1a1a;
        }

        .premium-gradient {
            background: linear-gradient(135deg, #0b1d3a 0%, #1e3a8a 100%);
        }


        .stat-card {
            transition: transform 0.2s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
        }

        /* Glassmorphism effect for subtle elements */
        .glass-effect {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
    </style>
</head>
<body class="min-h-screen mt-10 flex items-center justify-center">

    <main class="w-full mx-auto px-10">
        <!-- Section Judul -->
        <div class="mb-10 flex justify-between items-center">
            <div>
                <span class="inline-block px-3 py-1 bg-blue-50 text-blue-600 text-[10px] font-bold rounded-full uppercase tracking-widest mb-3">Hasil Evaluasi</span>
                <h1 class="text-4xl font-extrabold text-slate-900 tracking-tight">{{ $quiz->quiz_name }}</h1>
                <p class="text-slate-500 mt-2 flex items-center gap-4">
                    <span class="flex items-center gap-1.5"><i class="far fa-calendar-alt opacity-60"></i> {{ $quiz->created_at }}</span>
                </p>
            </div>
            <a href="{{ route('landing') }}"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-xl
                        bg-blue-500 text-white
                        hover:bg-blue-600
                        active:scale-95
                        transition-all duration-200">
                    
                    <!-- Lucide Arrow Left -->
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-4 h-4"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M19 12H5M12 19l-7-7 7-7"/>
                    </svg>

                    <span>Kembali Ke Beranda</span>
                </a>


        </div>

        <!-- Grid Utama -->
        <div class="grid grid-cols-1 gap-6 mb-12">
            
            <!-- Card Skor Utama -->
            <div class="lg:col-span-2 relative overflow-hidden premium-gradient rounded-[2rem] p-10 text-white shadow-2xl shadow-slate-200">
                <div class="relative z-10 flex flex-col justify-between h-full">
                    <div>
                        <h3 class="text-lg font-medium opacity-70 mb-1">Skor Akhir Anda</h3>
                        <div class="flex items-baseline gap-3">
                            <span class="text-8xl font-black tracking-tighter">{{ $data['nilai'] }}</span>
                            <span class="text-2xl opacity-40 font-bold">/ 100</span>
                        </div>
                    </div>
                    
                    <div class="mt-8 flex items-center gap-4">
                        <div class="px-4 py-2 bg-white/10 backdrop-blur-md rounded-xl border border-white/10">
                            <p class="text-[10px] uppercase font-bold opacity-60 tracking-wider">Jumlah Soal</p>
                            <p class="text-sm font-bold text-green-400">{{ $data['total'] }}</p>
                        </div>
                        <div class="px-4 py-2 bg-white/10 backdrop-blur-md rounded-xl border border-white/10">
                            <p class="text-[10px] uppercase font-bold opacity-60 tracking-wider">Durasi</p>
                            <p class="text-sm font-bold text-blue-300">{{ $quiz->quiz_time }}</p>
                        </div>
                        <div class="px-4 py-2 bg-white/10 backdrop-blur-md rounded-xl border border-white/10">
                            <p class="text-[10px] uppercase font-bold opacity-60 tracking-wider">Kode</p>
                            <p class="text-sm font-bold text-blue-300">{{ $quiz->quiz_code }}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Ornamen Dekoratif -->
                <div class="absolute -right-10 -bottom-10 opacity-10">
                    <i class="fas fa-award text-[15rem] rotate-12"></i>
                </div>
            </div>

            <!-- Statistik Kanan -->
            <div class="grid grid-cols-3 gap-4">
                <div class="stat-card bg-white p-6 rounded-[1.5rem] border border-slate-100 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Waktu</p>
                        <p class="text-2xl font-black text-slate-800">{{ $time }}</p>
                    </div>
                    <div class="w-12 h-12 bg-orange-50 rounded-2xl flex items-center justify-center">
                        <i class="fas fa-stopwatch text-orange-500"></i>
                    </div>
                </div>
                <div class="stat-card bg-white p-6 rounded-[1.5rem] border border-slate-100 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Benar</p>
                        <p class="text-2xl font-black text-emerald-600">{{ $data['benar'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-emerald-50 rounded-2xl flex items-center justify-center">
                        <i class="fas fa-check text-emerald-600"></i>
                    </div>
                </div>
                <div class="stat-card bg-white p-6 rounded-[1.5rem] border border-slate-100 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Salah</p>
                        <p class="text-2xl font-black text-rose-500">{{ $data['salah'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-rose-50 rounded-2xl flex items-center justify-center">
                        <i class="fas fa-times text-rose-500"></i>
                    </div>
                </div>
            </div>
        </div>

    </main>
</body>
</html>