@extends('_admin._layout.app')

@section('title', 'Tambah Soal Quiz')

@section('content')
<div class="grid gap-3 md:flex md:justify-between md:items-center py-4 mb-0">
    <x-page-title title="Tambah Soal Quiz" description="Tambahkan soal-soal untuk quiz: {{ $quiz->quiz_name }}" />
    <div>
        <div class="inline-flex gap-x-2">
            <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-800/30 dark:text-blue-500">
                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                </svg>
                Kode: {{ $quiz->quiz_code }}
            </span>
            <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-800/30 dark:text-purple-500">
                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V8z" clip-rule="evenodd" />
                </svg>
                {{ count($quiz->questions ?? []) }} Soal
            </span>
        </div>
    </div>
</div>

<div class="max-w-5xl mx-auto">
    <!-- Existing Questions List -->
    @if(!empty($quiz->questions) && count($quiz->questions) > 0)
    <div class="mb-6">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-neutral-200 mb-4">Soal yang Sudah Dibuat</h3>
        <div class="space-y-4">
            @foreach($quiz->questions as $index => $question)
            <div class="bg-white dark:bg-neutral-800 border border-gray-200 dark:border-neutral-700 rounded-lg p-6 existing-question" data-question-id="{{ $question->id }}">
                <div class="flex items-start justify-between mb-3">
                    <h4 class="text-md font-semibold text-gray-800 dark:text-neutral-200">Soal {{ $index + 1 }}</h4>
                    <div class="flex gap-2">
                        <button type="button" class="edit-question py-1.5 px-3 inline-flex items-center gap-x-1 text-xs font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-200 dark:hover:bg-neutral-700">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit
                        </button>
                        <button type="button" class="delete-question py-1.5 px-3 inline-flex items-center gap-x-1 text-xs font-medium rounded-lg border border-red-200 bg-white text-red-600 shadow-sm hover:bg-red-50 dark:bg-neutral-800 dark:border-red-700 dark:text-red-400 dark:hover:bg-red-900/20">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Hapus
                        </button>
                    </div>
                </div>

                <!-- View Mode -->
                <div class="view-mode">
                    <p class="text-sm text-gray-700 dark:text-neutral-300 mb-4 question-text">{{ $question->question }}</p>

                    @if(!empty($question->options))
                    <div class="grid sm:grid-cols-2 gap-2 options-container">
                        @foreach($question->options as $optionIndex => $option)
                        <div class="flex items-center gap-2 p-2 rounded option-item {{ $option->is_correct ? 'bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800' : 'bg-gray-50 dark:bg-neutral-900' }}" data-option-id="{{ $option->id }}">
                            @if($option->is_correct)
                            <svg class="w-4 h-4 text-green-600 dark:text-green-400 correct-icon" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            @endif
                            <span class="text-sm option-text {{ $option->is_correct ? 'text-green-800 dark:text-green-300 font-medium' : 'text-gray-700 dark:text-neutral-300' }}">
                                <strong>{{ chr(65 + $optionIndex) }}.</strong> {{ $option->option_text }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>

                <!-- Edit Mode -->
                <div class="edit-mode hidden">
                    <form class="update-question-form">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2 text-gray-800 dark:text-neutral-200">Pertanyaan <span class="text-red-500">*</span></label>
                            <textarea name="question" rows="3" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400" required>{{ $question->question }}</textarea>
                        </div>

                        <div class="space-y-3 mb-4">
                            <p class="text-sm font-medium text-gray-800 dark:text-neutral-200">Pilihan Jawaban <span class="text-red-500">*</span></p>
                            @foreach($question->options as $optionIndex => $option)
                            <div class="flex items-center gap-3 p-3 border border-gray-200 dark:border-neutral-700 rounded-lg hover:bg-gray-50 dark:hover:bg-neutral-900">
                                <input type="radio" name="correct_answer" value="{{ $option->id }}" id="edit_q{{ $question->id }}_option_{{ $optionIndex }}" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500" {{ $option->is_correct ? 'checked' : '' }} required>
                                <label for="edit_q{{ $question->id }}_option_{{ $optionIndex }}" class="flex items-center gap-2 flex-1">
                                    <span class="inline-flex w-6 h-6 items-center justify-center rounded text-xs font-semibold bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">{{ chr(65 + $optionIndex) }}</span>
                                    <input type="text" name="options[{{ $option->id }}]" value="{{ $option->option_text }}" class="py-2 px-3 flex-1 border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400" required>
                                </label>
                            </div>
                            @endforeach
                        </div>

                        <div class="flex justify-end gap-2">
                            <button type="button" class="cancel-edit py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-200">Batal</button>
                            <button type="submit" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Add New Questions Form -->
    <div class="bg-white dark:bg-neutral-800 border border-gray-200 dark:border-neutral-700 rounded-xl shadow-sm p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-neutral-200">Tambah Soal Baru</h3>
            <button type="button" id="add-question"
                class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Tambah Soal
            </button>
        </div>

        <form action="{{ route('teacher.quiz.questions.store', $quiz->id) }}" method="POST">
            @csrf

            <div id="questions-container" class="space-y-6 mb-6">

            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('teacher.quiz.index') }}"
                    class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-200 dark:hover:bg-neutral-800">
                    Kembali ke Daftar
                </a>
                <button type="submit"
                    class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-neutral-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Simpan Soal
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        let questionCount = 0;

        // Toggle Edit Mode for existing questions
        $(document).on('click', '.edit-question', function() {
            const $questionDiv = $(this).closest('.existing-question');
            $questionDiv.find('.view-mode').addClass('hidden');
            $questionDiv.find('.edit-mode').removeClass('hidden');
        });

        // Cancel Edit
        $(document).on('click', '.cancel-edit', function() {
            const $questionDiv = $(this).closest('.existing-question');
            $questionDiv.find('.edit-mode').addClass('hidden');
            $questionDiv.find('.view-mode').removeClass('hidden');
        });

        // Update Question via AJAX
        $(document).on('submit', '.update-question-form', function(e) {
            e.preventDefault();

            const $form = $(this);
            const $questionDiv = $form.closest('.existing-question');
            const questionId = $questionDiv.data('question-id');
            const $submitBtn = $form.find('button[type="submit"]');

            $submitBtn.prop('disabled', true).html('<span class="animate-spin inline-block w-4 h-4 border-2 border-current border-t-transparent rounded-full"></span> Menyimpan...');

            const formData = {
                question: $form.find('textarea[name="question"]').val(),
                correct_answer: $form.find('input[name="correct_answer"]:checked').val(),
                options: {}
            };

            $form.find('input[name^="options["]').each(function() {
                const optionId = $(this).attr('name').match(/\[(\d+)\]/)[1];
                formData.options[optionId] = $(this).val();
            });

            $.ajax({
                url: `/teacher/quiz/questions/${questionId}/update`,
                type: 'POST',
                data: JSON.stringify(formData),
                contentType: 'application/json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        // Update question text
                        $questionDiv.find('.question-text').text(formData.question);

                        // Update each option display
                        $questionDiv.find('.option-item').each(function(index) {
                            const $option = $(this);
                            const optionId = $option.data('option-id');
                            const isCorrect = formData.correct_answer == optionId;
                            const letter = String.fromCharCode(65 + index);

                            // Reset classes
                            $option.removeClass('bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 bg-gray-50 dark:bg-neutral-900');
                            if (isCorrect) {
                                $option.addClass('bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800');
                            } else {
                                $option.addClass('bg-gray-50 dark:bg-neutral-900');
                            }

                            // Toggle icon
                            if (isCorrect) {
                                if ($option.find('.correct-icon').length === 0) {
                                    $option.prepend('<svg class="w-4 h-4 text-green-600 dark:text-green-400 correct-icon" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>');
                                }
                            } else {
                                $option.find('.correct-icon').remove();
                            }

                            // Update text
                            const $optionText = $option.find('.option-text');
                            $optionText.removeClass('text-green-800 dark:text-green-300 font-medium text-gray-700 dark:text-neutral-300');
                            if (isCorrect) {
                                $optionText.addClass('text-green-800 dark:text-green-300 font-medium');
                            } else {
                                $optionText.addClass('text-gray-700 dark:text-neutral-300');
                            }
                            $optionText.html(`<strong>${letter}.</strong> ${formData.options[optionId]}`);
                        });

                        // Back to view mode
                        $questionDiv.find('.edit-mode').addClass('hidden');
                        $questionDiv.find('.view-mode').removeClass('hidden');

                        showNotification('Soal berhasil diperbarui!', 'success');
                    }
                },
                error: function(xhr) {
                    let errorMsg = 'Gagal memperbarui soal.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    console.error('Update error:', xhr);
                    showNotification(errorMsg, 'error');
                },
                complete: function() {
                    $submitBtn.prop('disabled', false).html('<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg> Simpan Perubahan');
                }
            });
        });

        // Delete Question
        $(document).on('click', '.delete-question', function() {
            const $questionDiv = $(this).closest('.existing-question');
            const questionId = $questionDiv.data('question-id');

            if (!confirm('Apakah Anda yakin ingin menghapus soal ini?')) {
                return;
            }

            $.ajax({
                url: `/teacher/quiz/questions/${questionId}/delete`,
                type: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        $questionDiv.fadeOut(300, function() {
                            $(this).remove();
                            updateQuestionNumbers();
                        });
                        showNotification('Soal berhasil dihapus!', 'success');
                    }
                },
                error: function(xhr) {
                    let errorMsg = 'Gagal menghapus soal.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    console.error('Delete error:', xhr);
                    showNotification(errorMsg, 'error');
                }
            });
        });

        function updateQuestionNumbers() {
            $('.existing-question').each(function(index) {
                $(this).find('h4').first().text(`Soal ${index + 1}`);
            });
        }

        function showNotification(message, type = 'success') {
            const bgColor = type === 'success' ? 'bg-green-500' : 'bg-red-500';
            const notification = $(`
                <div class="fixed top-4 right-4 z-50 ${bgColor} text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        ${type === 'success' 
                            ? '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />'
                            : '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />'
                        }
                    </svg>
                    <span>${message}</span>
                </div>
            `);
            $('body').append(notification);
            setTimeout(() => { notification.fadeOut(300, function() { $(this).remove(); }); }, 3000);
        }
        // Add question function
        $('#add-question').on('click', function() {
            questionCount++;
            const questionHtml = `
<div class="question-item border border-gray-200 dark:border-neutral-700 rounded-lg p-6" data-question="${questionCount}">
    <div class="flex items-center justify-between mb-4">
        <h4 class="text-md font-semibold text-gray-800 dark:text-neutral-200">
            Soal ${questionCount}
        </h4>
        <button type="button" class="remove-question text-red-600 hover:text-red-800">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862
                      a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6
                      m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
        </button>
    </div>

    <div class="mb-4">
        <label class="block text-sm font-medium mb-2 text-gray-800 dark:text-neutral-200">
            Pertanyaan <span class="text-red-500">*</span>
        </label>
        <textarea name="questions[${questionCount}][question]" rows="3"
            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm
                   focus:border-blue-500 focus:ring-blue-500
                   dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
            placeholder="Tulis pertanyaan..." required></textarea>
    </div>

    <div class="space-y-3">
        <p class="text-sm font-medium text-gray-800 dark:text-neutral-200">
            Pilihan Jawaban <span class="text-red-500">*</span>
        </p>

        ${['A','B','C','D','E'].map(opt => `
        <div class="flex items-center gap-3 p-3 border border-gray-200 dark:border-neutral-700
                    rounded-lg hover:bg-gray-50 dark:hover:bg-neutral-900">
            <input type="radio"
                name="questions[${questionCount}][correct_answer]"
                value="${opt}"
                id="q${questionCount}_option_${opt.toLowerCase()}"
                class="w-4 h-4 text-blue-600 border-gray-300
                       focus:ring-blue-500 dark:focus:ring-blue-600
                       dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600"
                ${opt === 'A' || opt === 'B' ? 'required' : ''}>

            <label for="q${questionCount}_option_${opt.toLowerCase()}"
                   class="flex items-center gap-2 flex-1">
                <span class="inline-flex w-6 h-6 items-center justify-center
                             rounded text-xs font-semibold
                             ${opt === 'A' || opt === 'B'
                                ? 'bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200'
                                : 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200'}">
                    ${opt}
                </span>

                <input type="text"
                    name="questions[${questionCount}][option_${opt.toLowerCase()}]"
                    class="py-2 px-3 flex-1 border-gray-200 rounded-lg text-sm
                           focus:border-blue-500 focus:ring-blue-500
                           dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400"
                    placeholder="Tulis opsi ${opt}${opt === 'A' || opt === 'B' ? '' : ' (opsional)'}"
                    ${opt === 'A' || opt === 'B' ? 'required' : ''}>
            </label>
        </div>
        `).join('')}
    </div>
</div>
`;


            $('#questions-container').append(questionHtml);
        });

        $(document).on('click', '.remove-question', function() {
            $(this).closest('.question-item').remove();
        });

        $('#add-question').trigger('click');
    });
</script>
@endpush