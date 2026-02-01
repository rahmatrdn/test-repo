@extends('_admin._layout.app')

@section('title', 'AI Quiz Generator')

@section('content')
<div class="grid gap-3 md:flex md:justify-between md:items-center py-4">
    <x-page-title
        title="Pembuat Kuis"
        description="Buat soal quiz pilihan ganda dengan AI untuk siswa Anda" />
    <div>
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

<div class="bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-neutral-800 dark:border-neutral-700">
    <div class="p-6 sm:p-8">
        <form id="quizForm">
            @csrf

            <div class="grid sm:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="quiz_name" class="block text-sm font-medium mb-2 text-gray-800 dark:text-neutral-200">
                        Nama Kuis
                    </label>
                    <input type="text" id="quiz_name" name="quiz_name"
                        class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
                        placeholder="Contoh: Ulangan Harian Tata Surya" required>
                </div>

                <div>
                    <label for="timer" class="block text-sm font-medium mb-2 text-gray-800 dark:text-neutral-200">
                        Durasi (Jam : Menit)
                    </label>
                    <input type="time" id="timer" name="timer" value="00:00" step="60"
                        class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
                        required>
                </div>
            </div>

            <div class="grid sm:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="question_count"
                        class="block text-sm font-medium mb-2 text-gray-800 dark:text-neutral-200">
                        Jumlah Soal
                    </label>
                    <input type="number" id="total_questions" name="question_count" min="1" max="50" value="10"
                        class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                        placeholder="Masukkan jumlah soal" required>
                    <p class="mt-2 text-xs text-gray-500 dark:text-neutral-400">
                        Maksimal 50 soal per quiz
                    </p>
                </div>

                <div>
                    <label for="options_count" class="block text-sm font-medium mb-2 text-gray-800 dark:text-neutral-200">
                        Opsi Jawaban
                    </label>
                    <select id="options_count" name="options_count" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400" required>
                        <option value="2">2 Opsi (A-B)</option>
                        <option value="3">3 Opsi (A-C)</option>
                        <option value="4" selected>4 Opsi (A-D)</option>
                        <option value="5">5 Opsi (A-E)</option>
                    </select>
                </div>

                <div>
                    <label for="education_level" class="block text-sm font-medium mb-2 text-gray-800 dark:text-neutral-200">
                        Jenjang & Kelas
                    </label>
                    <div class="flex gap-2">
                        <select id="education_level" name="education_level" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400" required>
                            <option value="">Pilih</option>
                            <option value="SD">SD</option>
                            <option value="SMP">SMP</option>
                            <option value="SMA">SMA</option>
                            <option value="SMK">SMK</option>
                        </select>
                        <select id="class_select" name="class" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400" required disabled>
                            <option value="">Kelas</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="grid gap-6 mb-6">
                <div>
                    <label for="description" class="block text-sm font-medium mb-2 text-gray-800 dark:text-neutral-200">
                        Deskripsi Kuis
                    </label>
                    <textarea id="description" name="description" rows="2"
                        class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
                        placeholder="Instruksi pengerjaan..."></textarea>
                </div>

                <div>
                    <label for="topic" class="block text-sm font-medium mb-2 text-gray-800 dark:text-neutral-200">
                        Topik / Materi (AI Prompt)
                    </label>
                    <textarea id="topic" name="topic" rows="4"
                        class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
                        placeholder="Contoh: Sistem Tata Surya, fokus pada planet-planet dan orbitnya..."
                        required></textarea>
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <button type="reset" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 hover:bg-gray-50 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-200">
                    Reset
                </button>
                <button type="submit" id="generateBtn" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    Generate Quiz
                </button>
            </div>
        </form>
    </div>
</div>

<div id="loadingState" class="hidden mt-6 bg-white border border-gray-200 rounded-xl shadow-sm p-6 dark:bg-neutral-800 dark:border-neutral-700">
    <div class="flex items-center justify-center">
        <div class="animate-spin inline-block w-6 h-6 border-[3px] border-current border-t-transparent text-blue-600 rounded-full" role="status"></div>
        <span class="ml-3 text-gray-600 dark:text-neutral-400">AI sedang memproses soal...</span>
    </div>
</div>

<div id="resultArea" class="hidden mt-6 bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-neutral-800 dark:border-neutral-700">
    <div class="p-6 sm:p-8">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-neutral-200">Hasil Generate</h3>
            <div class="flex gap-2">
                <button type="button" id="downloadBtn" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-200">Download</button>
                <button type="button" id="copyBtn" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-200">Copy</button>
            </div>
        </div>
        <div id="resultContent" class="prose prose-sm dark:prose-invert max-w-none text-gray-800 dark:text-neutral-200"></div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
<script>
    $(document).ready(function() {
        let rawMarkdownContent = '';
        let pollingInterval = null;

        // Mapping Kelas
        const classMapping = {
            'SD': ['1', '2', '3', '4', '5', '6'],
            'SMP': ['7', '8', '9'],
            'SMA': ['10', '11', '12'],
            'SMK': ['10', '11', '12']
        };

        $('#education_level').on('change', function() {
            const level = $(this).val();
            const $classSelect = $('#class_select');
            $classSelect.empty().append('<option value="">Kelas</option>');
            if (level && classMapping[level]) {
                $classSelect.prop('disabled', false);
                classMapping[level].forEach(c => $classSelect.append(`<option value="${c}">${c}</option>`));
            } else {
                $classSelect.prop('disabled', true);
            }
        });

        // Markdown Parser & Formatter (Simplified for brevity but effective)
        function renderMarkdown(content) {
            return marked.parse(content);
        }

        function pollStatus(url) {
            $.get(url, function(res) {
                if (res.data.status === 'completed') {
                    clearInterval(pollingInterval);
                    
                    // Parse JSON content to make it readable
                    try {
                        const questions = JSON.parse(res.data.content);
                        let markdownOutput = `# ${$('#quiz_name').val()}\n\n`;
                        markdownOutput += `**Jenjang:** ${$('#education_level').val()} Kelas ${$('#class_select').val()}\n\n`;
                        markdownOutput += `**Jumlah Soal:** ${questions.length}\n\n`;
                        markdownOutput += `---\n\n`;
                        
                        questions.forEach((q, idx) => {
                            markdownOutput += `## Soal ${idx + 1}\n\n`;
                            markdownOutput += `**${q.question}**\n\n`;
                            q.options.forEach((opt, optIdx) => {
                                const letter = String.fromCharCode(65 + optIdx);
                                const isCorrect = opt === q.correct_answer ? ' ✅' : '';
                                markdownOutput += `${letter}. ${opt}${isCorrect}\n\n`;
                            });
                            markdownOutput += `**Jawaban:** ${q.correct_answer}\n\n`;
                            markdownOutput += `---\n\n`;
                        });
                        
                        rawMarkdownContent = markdownOutput;
                    } catch (e) {
                        rawMarkdownContent = res.data.content;
                    }
                    
                    $('#resultContent').html(renderMarkdown(rawMarkdownContent));
                    $('#loadingState').addClass('hidden');
                    $('#resultArea').removeClass('hidden');
                    $('#generateBtn').prop('disabled', false);
                } else if (res.data.status === 'failed') {
                    clearInterval(pollingInterval);
                    const errorMsg = res.data.error || 'Gagal membuat kuis.';
                    alert('Error: ' + errorMsg);
                    $('#loadingState').addClass('hidden');
                    $('#generateBtn').prop('disabled', false);
                }
            }).fail(function() {
                clearInterval(pollingInterval);
                alert('Terjadi kesalahan saat mengecek status.');
                $('#loadingState').addClass('hidden');
                $('#generateBtn').prop('disabled', false);
            });
        }

        $('#quizForm').on('submit', function(e) {
            e.preventDefault();

            // Object Body sesuai permintaan
            const requestBody = {
                "quiz_name": $('#quiz_name').val(),
                "timer": $('#timer').val(),
                "description": $('#description').val(),
                "topic": $('#topic').val(),
                "total_questions": parseInt($('#total_questions').val()),
                "education_level": $('#education_level').val(),
                "class": $('#class_select').val(),
                "options_count": parseInt($('#options_count').val()),
                "categories": "QUIZ"
            };

            $('#loadingState').removeClass('hidden');
            $('#resultArea').addClass('hidden');
            $('#generateBtn').prop('disabled', true);

            $.ajax({
                url: '{{ route('teacher.ai.quiz_generator.do_create') }}', 
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(requestBody),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success && response.data.status_url) {
                        // Mulai polling status hasil AI
                        pollingInterval = setInterval(() => pollStatus(response.data.status_url), 2000);
                    } else {
                        alert('Gagal inisialisasi kuis.');
                        $('#loadingState').addClass('hidden');
                        $('#generateBtn').prop('disabled', false);
                    }
                },
                error: function() {
                    alert('Terjadi kesalahan koneksi.');
                    $('#loadingState').addClass('hidden');
                    $('#generateBtn').prop('disabled', false);
                }
            });
        });

        // Action Buttons
        $('#copyBtn').click(function() {
            navigator.clipboard.writeText(rawMarkdownContent);
            alert('Tersalin ke clipboard!');
        });

        $('#downloadBtn').click(function() {
            const blob = new Blob([rawMarkdownContent], {
                type: 'text/markdown'
            });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `quiz-${Date.now()}.md`;
            a.click();
        });

        $('button[type="reset"]').click(function() {
            $('#class_select').prop('disabled', true).empty().append('<option value="">Kelas</option>');
            $('#resultArea').addClass('hidden');
            clearInterval(pollingInterval);
        });
    });
</script>
@endpush