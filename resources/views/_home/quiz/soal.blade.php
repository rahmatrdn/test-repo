<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuis Interaktif | {{ $quiz->quiz_name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #3b82f6; border-radius: 10px; }
        .option-selected { border-color: #3b82f6; background-color: #eff6ff; color: #1e40af; }
    </style>
</head>
<body class="bg-gray-50 font-sans text-gray-800 min-h-screen">
    <header class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-xl font-bold text-blue-500">{{ $quiz->quiz_name }}</h1>
            <div class="flex items-center space-x-4">
                <div id="timer" class="text-gray-600 font-mono bg-gray-100 px-3 py-1 rounded-lg border border-gray-200">
                    Sisa Waktu: 00:00
                </div>
                <button onclick="confirmFinish()" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg font-medium transition-colors shadow-sm">
                    Selesai
                </button>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 py-6">
        <div id="quiz-container" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Kolom Kiri: Soal -->
            <div class="lg:col-span-2 space-y-4">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-4 bg-gray-100 border-b border-gray-200 flex justify-between items-center">
                        <span class="font-semibold text-blue-500" id="question-label">Memuat...</span>
                        <span class="text-sm text-gray-500" id="question-count">0 dari 0</span>
                    </div>
                    <div class="p-6">
                        <div id="question-text" class="text-lg font-medium mb-8 leading-relaxed"></div>
                        <div id="options-container" class="space-y-3"></div>
                    </div>
                    <div class="p-4 bg-gray-50 border-t border-gray-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="flex space-x-2 w-full sm:w-auto">
                            <button id="prev-btn" onclick="prevQuestion()" class="flex-1 sm:flex-none flex items-center justify-center space-x-2 px-6 py-2 rounded-lg bg-white border border-gray-300 text-gray-700 hover:bg-gray-100 disabled:opacity-50">
                                <span>&larr;</span> <span>Kembali</span>
                            </button>
                            <button id="next-btn" onclick="nextQuestion()" class="flex-1 sm:flex-none flex items-center justify-center space-x-2 px-6 py-2 rounded-lg bg-blue-500 text-white hover:bg-blue-600">
                                <span>Lanjut</span> <span>&rarr;</span>
                            </button>
                        </div>
                        <label class="flex items-center space-x-3 cursor-pointer bg-amber-50 px-4 py-2 rounded-lg border border-amber-200 hover:bg-amber-100 transition">
                            <input type="checkbox" id="ragu-checkbox" onchange="toggleRagu()" class="w-5 h-5 text-amber-500 border-gray-300 rounded focus:ring-amber-500">
                            <span class="font-medium text-amber-700">Ragu-ragu</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Navigasi -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 sticky top-24">
                    <div class="p-4 bg-gray-100 border-b border-gray-200">
                        <h2 class="font-semibold text-gray-700">Navigasi Soal</h2>
                    </div>
                    <div class="p-6">
                        <div id="navigation-grid" class="grid grid-cols-5 gap-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal Selesai -->
    <div id="modal-finish" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-[100] px-4">
        <div class="bg-white p-6 rounded-xl max-w-sm w-full shadow-xl">
            <h3 class="text-xl font-bold mb-4 text-gray-800">Konfirmasi Selesai</h3>
            <p class="text-gray-600 mb-6">Apakah Anda yakin ingin mengakhiri kuis ini? Semua jawaban akan dikirimkan.</p>
            <div class="flex space-x-3">
                <button id="close-submit-btn" onclick="closeModal()" class="flex-1 py-2 rounded-lg border border-gray-300 hover:bg-gray-50 font-medium">Batal</button>
                <button id="final-submit-btn" onclick="submitExam()" class="flex-1 py-2 rounded-lg bg-blue-500 text-white hover:bg-blue-600 font-medium">Ya, Kirim</button>
            </div>
        </div>
    </div>

    <script> 
        const quizData = @json($soal);
        const TOTAL_DURATION = {{ $time }}; // 1 Jam dalam detik (Sesuaikan dengan durasi ujian Anda)
        
        let currentQuestionIndex = 0;
        let userAnswers = new Array(quizData.length).fill(null);
        let uncertainStates = new Array(quizData.length).fill(false);
        let remainingTime = TOTAL_DURATION;

        const STORAGE_KEY_ANSWERS = 'exam_user_answers';
        const STORAGE_KEY_UNCERTAIN = 'exam_uncertain_states';
        const STORAGE_KEY_TIMER = 'exam_remaining_time';

        window.onload = () => {
            loadProgress();
            renderQuestion();
            renderNavigation();
            
            const savedTime = localStorage.getItem(STORAGE_KEY_TIMER);
            remainingTime = savedTime ? parseInt(savedTime) : TOTAL_DURATION;
            console.log(remainingTime);
            console.log(TOTAL_DURATION);
            startTimer(remainingTime);
        };

        function loadProgress() {
            const savedAnswers = localStorage.getItem(STORAGE_KEY_ANSWERS);
            const savedUncertain = localStorage.getItem(STORAGE_KEY_UNCERTAIN);

            if (savedAnswers) userAnswers = JSON.parse(savedAnswers);
            if (savedUncertain) uncertainStates = JSON.parse(savedUncertain);
        }

        function renderQuestion() {
            const q = quizData[currentQuestionIndex];
            document.getElementById('question-label').innerText = `Soal Nomor ${currentQuestionIndex + 1}`;
            document.getElementById('question-count').innerText = `${currentQuestionIndex + 1} dari ${quizData.length}`;
            document.getElementById('question-text').innerText = q.question;
            document.getElementById('ragu-checkbox').checked = uncertainStates[currentQuestionIndex];

            const optionsContainer = document.getElementById('options-container');
            optionsContainer.innerHTML = '';
            
            q.options.forEach((opt, idx) => {
                const isSelected = userAnswers[currentQuestionIndex] === idx;
                const btn = document.createElement('button');
                btn.className = `w-full text-left p-4 rounded-xl border-2 transition-all flex items-center space-x-4 ${isSelected ? 'option-selected border-blue-500' : 'bg-white border-gray-100 hover:border-gray-200'}`;
                btn.onclick = () => selectOption(idx);
                btn.innerHTML = `
                    <span class="w-8 h-8 flex-shrink-0 flex items-center justify-center rounded-lg border font-bold ${isSelected ? 'bg-blue-500 text-white border-blue-500' : 'bg-gray-100 text-gray-500 border-gray-200'}">
                        ${String.fromCharCode(65 + idx)}
                    </span>
                    <span class="font-medium">${opt.option_text}</span>
                `;
                optionsContainer.appendChild(btn);
            });

            document.getElementById('prev-btn').disabled = currentQuestionIndex === 0;
            document.getElementById('next-btn').innerHTML = currentQuestionIndex === quizData.length - 1 ? 'Selesai' : 'Lanjut &rarr;';
        }

        function renderNavigation() {
            const grid = document.getElementById('navigation-grid');
            grid.innerHTML = '';
            quizData.forEach((_, idx) => {
                const isCurrent = currentQuestionIndex === idx;
                const isAnswered = userAnswers[idx] !== null;
                const isUncertain = uncertainStates[idx];
                
                let classes = "relative w-full aspect-square flex items-center justify-center rounded-lg text-sm font-bold border-2 ";
                if (isCurrent) classes += "border-blue-500 text-blue-600 ring-2 ring-blue-100";
                else if (isUncertain) classes += "bg-amber-500 border-amber-500 text-white";
                else if (isAnswered) classes += "bg-blue-500 border-blue-500 text-white";
                else classes += "bg-gray-100 border-gray-200 text-gray-400";

                const btn = document.createElement('button');
                btn.className = classes;
                btn.innerText = idx + 1;
                btn.onclick = () => { currentQuestionIndex = idx; renderQuestion(); renderNavigation(); };
                
                if (isAnswered) {
                    const badge = document.createElement('span');
                    badge.className = "absolute -top-2 -right-2 text-[10px] bg-white border border-gray-300 text-gray-800 rounded-full w-5 h-5 flex items-center justify-center shadow-sm";
                    badge.innerText = String.fromCharCode(65 + userAnswers[idx]);
                    btn.appendChild(badge);
                }
                grid.appendChild(btn);
            });
        }

        function selectOption(index) {
            userAnswers[currentQuestionIndex] = index;
            localStorage.setItem(STORAGE_KEY_ANSWERS, JSON.stringify(userAnswers));
            renderQuestion();
            renderNavigation();
        }

        function toggleRagu() {
            uncertainStates[currentQuestionIndex] = document.getElementById('ragu-checkbox').checked;
            localStorage.setItem(STORAGE_KEY_UNCERTAIN, JSON.stringify(uncertainStates));
            renderNavigation();
        }

        function nextQuestion() {
            if (currentQuestionIndex < quizData.length - 1) {
                currentQuestionIndex++;
                renderQuestion();
                renderNavigation();
            } else {
                confirmFinish();
            }
        }

        function prevQuestion() {
            if (currentQuestionIndex > 0) {
                currentQuestionIndex--;
                renderQuestion();
                renderNavigation();
            }
        }

        function confirmFinish() {
            document.getElementById('modal-finish').classList.replace('hidden', 'flex');
        }

        function closeModal() {
            document.getElementById('modal-finish').classList.replace('flex', 'hidden');
        }

        async function submitExam() {
            const finalBtn = document.getElementById('final-submit-btn');
            const closeSubmit = document.getElementById('close-submit-btn');
            if(closeSubmit) closeSubmit.remove();
            
            finalBtn.disabled = true;
            finalBtn.innerText = "Mengirim...";

            // Hitung durasi pengerjaan (Waktu Awal - Sisa Waktu)
            const timeSpentSeconds = TOTAL_DURATION - remainingTime;

            const results = quizData.map((q, index) => {
                return {
                    question_id: q.id,
                    selected_option_id: userAnswers[index] !== null ? q.options[userAnswers[index]].id : null,
                    is_uncertain: uncertainStates[index]
                };
            });

            // Hapus progress di browser
            localStorage.removeItem(STORAGE_KEY_ANSWERS);
            localStorage.removeItem(STORAGE_KEY_UNCERTAIN);
            localStorage.removeItem(STORAGE_KEY_TIMER);

            // Kirim ke server
            submitHasilQuiz(results, timeSpentSeconds);
        }

        function startTimer(duration) {
            let timer = duration;
            const display = document.getElementById('timer');
            const interval = setInterval(() => {
                let m = Math.floor(timer / 60);
                let s = timer % 60;
                display.textContent = `Sisa Waktu: ${String(m).padStart(2, '0')}:${String(s).padStart(2, '0')}`;
                
                remainingTime = timer; // Update variabel global sisa waktu
                localStorage.setItem(STORAGE_KEY_TIMER, timer);

                if (--timer < 0) {
                    clearInterval(interval);
                    remainingTime = 0;
                    submitExam();
                }
            }, 1000);
        }

        function submitHasilQuiz(results, timeSpent) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("student.quiz.hasilquiz") }}';

            const csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '_token';
            csrf.value = '{{ csrf_token() }}';
            form.appendChild(csrf);

            const quiz_id = document.createElement('input');
            quiz_id.type = 'hidden';
            quiz_id.name = 'quiz_id';
            quiz_id.value = '{{ $quiz->id }}';
            form.appendChild(quiz_id);

            const time = document.createElement('input');
            time.type = 'hidden';
            time.name = 'time';
            time.value = timeSpent;
            form.appendChild(time);

            // Kirim Jawaban
            const inputResults = document.createElement('input');
            inputResults.type = 'hidden';
            inputResults.name = 'results';
            inputResults.value = JSON.stringify(results);
            form.appendChild(inputResults);

            document.body.appendChild(form);
            form.submit();
        }
    </script>
</body>
</html>