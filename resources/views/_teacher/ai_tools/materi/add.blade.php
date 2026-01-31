@extends('_admin._layout.app')

@section('title', 'AI Materi Ajar')

@section('content')
    <div class="grid gap-3 md:flex md:justify-between md:items-center py-4">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-800 dark:text-neutral-200 mb-1">
                Generator Materi Ajar
            </h1>
            <p class="text-md text-gray-400 dark:text-neutral-400">
                Buat materi pembelajaran dengan AI untuk siswa Anda
            </p>
        </div>
    </div>

    <div class="bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-neutral-800 dark:border-neutral-700">
        <div class="p-6 sm:p-8">
            <form id="materiForm">
                @csrf

                <div class="mb-6">
                    <label class="block text-sm font-medium mb-3 text-gray-800 dark:text-neutral-200">
                        Tipe Materi
                    </label>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <label
                            class="flex p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 dark:border-neutral-700 dark:hover:bg-neutral-700 transition-colors">
                            <input type="radio" name="material_type" value="ppt"
                                class="shrink-0 mt-0.5 border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-neutral-800"
                                checked>
                            <span class="ml-3">
                                <span class="block text-sm font-semibold text-gray-800 dark:text-neutral-200">
                                    <svg class="w-5 h-5 inline-block mr-1 text-orange-500" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    Materi PPT
                                </span>
                                <span class="block text-sm text-gray-500 dark:text-neutral-400 mt-1">
                                    Presentasi PowerPoint untuk kelas
                                </span>
                            </span>
                        </label>

                        <label
                            class="flex p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 dark:border-neutral-700 dark:hover:bg-neutral-700 transition-colors">
                            <input type="radio" name="material_type" value="modul"
                                class="shrink-0 mt-0.5 border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-neutral-800">
                            <span class="ml-3">
                                <span class="block text-sm font-semibold text-gray-800 dark:text-neutral-200">
                                    <svg class="w-5 h-5 inline-block mr-1 text-blue-500" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                        </path>
                                    </svg>
                                    Modul Belajar
                                </span>
                                <span class="block text-sm text-gray-500 dark:text-neutral-400 mt-1">
                                    Modul lengkap untuk pembelajaran mandiri
                                </span>
                            </span>
                        </label>
                    </div>
                </div>


                <div class="mb-6">
                    <label for="material_description"
                        class="block text-sm font-medium mb-2 text-gray-800 dark:text-neutral-200">
                        Deskripsi Materi
                    </label>
                    <textarea id="material_description" name="description" rows="6"
                        class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                        placeholder="Jelaskan topik, sub-topik, tingkat kelas, dan detail materi yang ingin Anda buat. Contoh: Materi tentang fotosintesis untuk kelas 5 SD, mencakup pengertian, proses, dan faktor-faktor yang mempengaruhi fotosintesis..."
                        required></textarea>
                    <p class="mt-2 text-xs text-gray-500 dark:text-neutral-400">
                        Berikan deskripsi yang jelas dan detail untuk hasil yang lebih baik
                    </p>
                </div>

                <div class="flex justify-end gap-3">
                    <button type="reset"
                        class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-200 dark:hover:bg-neutral-800">
                        Reset
                    </button>
                    <button type="submit" id="generateBtn"
                        class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-neutral-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Generate Materi
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div id="loadingState"
        class="hidden mt-6 bg-white border border-gray-200 rounded-xl shadow-sm p-6 dark:bg-neutral-800 dark:border-neutral-700">
        <div class="flex items-center justify-center">
            <div class="animate-spin inline-block w-6 h-6 border-[3px] border-current border-t-transparent text-blue-600 rounded-full dark:text-blue-500"
                role="status" aria-label="loading">
                <span class="sr-only">Loading...</span>
            </div>
            <span class="ml-3 text-gray-600 dark:text-neutral-400">Sedang membuat materi...</span>
        </div>
    </div>

    <div id="resultArea"
        class="hidden mt-6 bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-neutral-800 dark:border-neutral-700">
        <div class="p-6 sm:p-8">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-neutral-200">Hasil Generate</h3>
                <div class="flex gap-2">
                    <button type="button" id="downloadBtn"
                        class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-200 dark:hover:bg-neutral-800">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        Download
                    </button>
                    <button type="button" id="copyBtn"
                        class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-200 dark:hover:bg-neutral-800">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z">
                            </path>
                        </svg>
                        Copy
                    </button>
                </div>
            </div>
            <div id="resultContent" class="prose prose-sm dark:prose-invert max-w-none text-gray-800 dark:text-neutral-200">
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>

    <script>
        $(document).ready(function() {
            let pollingInterval = null;
            let pollingAttempts = 0;
            let rawMarkdownContent = '';
            let historySaved = false;
            let currentReferenceId = null;
            const MAX_POLLING_ATTEMPTS = 120;

            marked.setOptions({
                breaks: true,
                gfm: true,
                headerIds: true,
                mangle: false,
                pedantic: false,
                smartLists: true,
                smartypants: true
            });

            /**
             * 🎨 ENHANCED MARKDOWN TO HTML PARSER
             * Parsing markdown dengan styling premium & responsive
             */
            function formatMarkdownToHTML(markdownContent) {
                try {
                    let html = marked.parse(markdownContent);
                    
                    // ===== TABEL STYLING =====
                    html = html.replace(/<table>/g, 
                        '<div class="overflow-x-auto my-6 rounded-lg border border-gray-200 dark:border-neutral-700 shadow-sm">' +
                        '<table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">');
                    html = html.replace(/<\/table>/g, '</table></div>');
                    
                    html = html.replace(/<thead>/g, 
                        '<thead class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-neutral-800 dark:to-neutral-900">');
                    html = html.replace(/<th>/g, 
                        '<th class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-neutral-300 uppercase tracking-wider border-b-2 border-gray-300 dark:border-neutral-600">');
                    
                    html = html.replace(/<tbody>/g, 
                        '<tbody class="bg-white dark:bg-neutral-900 divide-y divide-gray-100 dark:divide-neutral-800">');
                    html = html.replace(/<td>/g, 
                        '<td class="px-6 py-4 text-sm text-gray-700 dark:text-neutral-300 border-b border-gray-100 dark:border-neutral-800">');
                    
                    // ===== HEADING STYLING =====
                    html = html.replace(/<h1>/g, 
                        '<h1 class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-blue-400 dark:to-indigo-400 mb-6 mt-8 pb-2 border-b-4 border-blue-500 dark:border-blue-600">');
                    
                    html = html.replace(/<h2>/g, 
                        '<h2 class="text-3xl font-bold text-gray-800 dark:text-neutral-100 mb-5 mt-8 pb-3 border-b-2 border-gray-300 dark:border-neutral-700 flex items-center">' +
                        '<span class="inline-block w-1.5 h-8 bg-gradient-to-b from-blue-500 to-indigo-500 rounded-full mr-3"></span>');
                    html = html.replace(/<\/h2>/g, '</h2>');
                    
                    html = html.replace(/<h3>/g, 
                        '<h3 class="text-2xl font-semibold text-gray-700 dark:text-neutral-200 mb-4 mt-6 flex items-center">' +
                        '<svg class="w-6 h-6 mr-2 text-blue-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg><span>');
                    html = html.replace(/<\/h3>/g, '</span></h3>');
                    
                    html = html.replace(/<h4>/g, 
                        '<h4 class="text-xl font-semibold text-gray-600 dark:text-neutral-300 mb-3 mt-4">');
                    
                    // ===== LIST STYLING =====
                    html = html.replace(/<ul>/g, 
                        '<ul class="space-y-2 my-4 ml-1">');
                    
                    // Replace all <li> inside <ul> with custom styled version
                    html = html.replace(/(<ul[^>]*>)([\s\S]*?)(<\/ul>)/g, function(match, ulOpen, content, ulClose) {
                        let styledContent = content.replace(/<li>/g, 
                            '<li class="flex items-start pl-0">' +
                            '<svg class="w-5 h-5 text-blue-500 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="3"/></svg>' +
                            '<span class="text-gray-700 dark:text-neutral-300">');
                        styledContent = styledContent.replace(/<\/li>/g, '</span></li>');
                        return ulOpen + styledContent + ulClose;
                    });
                    
                    html = html.replace(/<ol>/g, 
                        '<ol class="space-y-2 my-4 ml-6 list-decimal list-outside pl-2">');
                    html = html.replace(/(<ol[^>]*>)([\s\S]*?)(<\/ol>)/g, function(match, olOpen, content, olClose) {
                        let styledContent = content.replace(/<li>/g, 
                            '<li class="text-gray-700 dark:text-neutral-300 pl-2 ml-0">');
                        return olOpen + styledContent + olClose;
                    });
                    
                    // ===== CODE BLOCKS =====
                    html = html.replace(/<pre><code([^>]*)>/g, 
                        '<pre class="bg-gradient-to-br from-gray-900 to-gray-800 dark:from-neutral-950 dark:to-neutral-900 p-5 rounded-xl overflow-x-auto my-5 shadow-lg border border-gray-700">' +
                        '<code$1 class="text-sm font-mono text-green-400 dark:text-green-300 leading-relaxed">');
                    
                    // Inline code (yang bukan di dalam pre)
                    html = html.replace(/<code>/g, 
                        '<code class="px-2 py-1 bg-gray-100 dark:bg-neutral-800 text-red-600 dark:text-red-400 rounded font-mono text-sm border border-gray-200 dark:border-neutral-700">');
                    
                    // ===== PARAGRAF & BLOCKQUOTE =====
                    html = html.replace(/<p>/g, 
                        '<p class="text-gray-700 dark:text-neutral-300 leading-relaxed my-4 text-base">');
                    
                    html = html.replace(/<blockquote>/g, 
                        '<blockquote class="border-l-4 border-blue-500 bg-blue-50 dark:bg-blue-900/20 pl-5 py-3 my-5 italic text-gray-700 dark:text-neutral-300 rounded-r">');
                    
                    // ===== STRONG & EM =====
                    html = html.replace(/<strong>/g, 
                        '<strong class="font-bold text-gray-900 dark:text-neutral-100">');
                    
                    html = html.replace(/<em>/g, 
                        '<em class="italic text-gray-600 dark:text-neutral-400">');
                    
                    // ===== HORIZONTAL RULE =====
                    html = html.replace(/<hr>/g, 
                        '<hr class="my-8 border-t-2 border-gray-300 dark:border-neutral-700">');
                    
                    // ===== LINKS =====
                    html = html.replace(/<a href="/g, 
                        '<a target="_blank" rel="noopener noreferrer" href="');
                    html = html.replace(/<a /g, 
                        '<a class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 underline font-medium transition-colors" ');
                    
                    return html;
                } catch (e) {
                    console.error('Error parsing markdown:', e);
                    return `<div class="text-gray-700 dark:text-neutral-300 whitespace-pre-wrap font-mono text-sm bg-gray-50 dark:bg-neutral-900 p-4 rounded border border-gray-200 dark:border-neutral-700">${markdownContent}</div>`;
                }
            }

            function pollStatus(statusUrl) {
                pollingAttempts++;

                const dots = '.'.repeat((pollingAttempts % 4) + 1);
                const loadingTexts = [
                    'Sedang menyusun materi',
                    'AI sedang berpikir',
                    'Membuat konten berkualitas',
                    'Hampir selesai'
                ];
                const loadingText = loadingTexts[Math.floor(pollingAttempts / 10) % loadingTexts.length];
                
                $('#loadingState span').html(
                    `${loadingText}${dots} <span class="text-xs text-gray-500">(${pollingAttempts}s)</span>`
                );

                if (pollingAttempts >= MAX_POLLING_ATTEMPTS) {
                    clearInterval(pollingInterval);
                    showError('⏱️ Request timeout. Server mungkin sedang sibuk. Silakan coba lagi nanti.');
                    return;
                }

                $.ajax({
                    url: statusUrl,
                    type: 'GET',
                    success: function(response) {
                        if (response.data.status === 'completed') {
                            clearInterval(pollingInterval);

                            $('#loadingState').addClass('hidden');
                            $('#resultArea').removeClass('hidden');

                            rawMarkdownContent = response.data.content;

                            const formattedContent = formatMarkdownToHTML(response.data.content);
                            $('#resultContent').html(formattedContent);

                            if (!historySaved && currentReferenceId) {
                                historySaved = true;
                                saveTextHistory(currentReferenceId);
                            }

                            showSuccessNotification(
                                `Materi berhasil dibuat dalam ${pollingAttempts} detik`
                            );

                            // Enable button kembali
                            $('#generateBtn').prop('disabled', false);

                        } else if (response.data.status === 'failed') {
                            clearInterval(pollingInterval);
                            showError('❌ Pembuatan materi gagal. Silakan coba lagi.');

                        } else if (response.data.status === 'queued' || response.data.status === 'processing') {
                            console.log('🔄 Status:', response.data.status, '| Attempt:', pollingAttempts);
                        }
                    },
                    error: function(xhr, status, error) {
                        clearInterval(pollingInterval);
                        showError('⚠️ Terjadi kesalahan saat mengecek status. Silakan coba lagi.');
                        console.error('❌ Polling error:', error);
                    }
                });
            }

            function showError(message) {
                $('#loadingState').addClass('hidden');
                $('#resultArea').removeClass('hidden');
                $('#generateBtn').prop('disabled', false);

                $('#resultContent').html(`
                    <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4 shadow-sm">
                        <div class="flex">
                            <svg class="w-5 h-5 text-red-600 dark:text-red-400 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800 dark:text-red-300">${message}</h3>
                            </div>
                        </div>
                    </div>
                `);
            }

            function showSuccessNotification(message) {
                const notification = $(`
                    <div class="fixed top-4 right-4 z-50 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4 shadow-lg animate-slide-in">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-600 dark:text-green-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="ml-3 text-sm font-medium text-green-800 dark:text-green-300">${message}</span>
                        </div>
                    </div>
                `);

                $('body').append(notification);

                setTimeout(() => {
                    notification.fadeOut(300, function() {
                        $(this).remove();
                    });
                }, 3000);
            }

            function saveTextHistory(referenceId) {
                $.ajax({
                    url: '/teacher/api/text-generation/save-history',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    data: JSON.stringify({
                        reference_id: referenceId
                    }),
                    success: function(response) {
                        console.log('✅ Riwayat text generation berhasil disimpan!', response);
                    },
                    error: function(xhr) {
                        console.error('❌ Failed to save text history:', xhr.responseJSON || xhr);
                    }
                });
            }

            $('#materiForm').on('submit', function(e) {
                e.preventDefault();

                const materialType = $('input[name="material_type"]:checked').val();
                const description = $('#material_description').val();

                if (!description.trim()) {
                    alert('Mohon isi deskripsi materi terlebih dahulu.');
                    return;
                }

                pollingAttempts = 0;
                historySaved = false;
                currentReferenceId = null;
                if (pollingInterval) {
                    clearInterval(pollingInterval);
                }

                $('#loadingState').removeClass('hidden');
                $('#resultArea').addClass('hidden');
                $('#generateBtn').prop('disabled', true);

                const categoryMap = {
                    'ppt': 'PPT',
                    'modul': 'MODULBELAJAR'
                };

                const requestData = {
                    description: description,
                    categories: categoryMap[materialType] || 'PPT'
                };


                $.ajax({
                    url: '/api/tools/materi',
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify(requestData),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success && response.data.status_url) {
                            currentReferenceId = response.data.reference_id;
                            console.log('✅ Job queued! Reference ID:', currentReferenceId);

                            pollingInterval = setInterval(function() {
                                pollStatus(response.data.status_url);
                            }, 1000);

                        } else {
                            showError('⚠️ Response dari API tidak sesuai format. Mohon periksa backend.');
                            $('#generateBtn').prop('disabled', false);
                        }
                    },
                    error: function(xhr, status, error) {
                        let errorMessage = '❌ Terjadi kesalahan. ';

                        if (xhr.status === 401) {
                            errorMessage += 'Anda belum login. Silakan login terlebih dahulu.';
                        } else if (xhr.status === 422) {
                            errorMessage += 'Data yang dikirim tidak valid. Mohon periksa kembali.';
                        } else if (xhr.status === 500) {
                            errorMessage += 'Terjadi kesalahan pada server. Silakan coba lagi nanti.';
                        } else if (xhr.status === 0) {
                            errorMessage += 'Tidak dapat terhubung ke server. Periksa koneksi internet Anda.';
                        } else {
                            errorMessage += `Error: ${error}`;
                        }

                        showError(errorMessage);

                        console.error('Error details:', {
                            status: xhr.status,
                            response: xhr.responseJSON,
                            error: error
                        });
                    }
                });
            });

            $('#downloadBtn').on('click', function() {
                if (!rawMarkdownContent) {
                    alert('⚠️ Tidak ada konten untuk diunduh.');
                    return;
                }

                const materialType = $('input[name="material_type"]:checked').val();
                const timestamp = new Date().toISOString().slice(0, 19).replace(/:/g, '-');
                const filename = `materi-${materialType}-${timestamp}.md`;

                const blob = new Blob([rawMarkdownContent], { type: 'text/markdown;charset=utf-8' });
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = filename;
                document.body.appendChild(a);
                a.click();
                window.URL.revokeObjectURL(url);
                document.body.removeChild(a);

                showSuccessNotification('📥 File berhasil diunduh!');
            });

            $('#copyBtn').on('click', function() {
                const content = rawMarkdownContent || $('#resultContent').text();

                if (!content) {
                    alert('Tidak ada konten untuk disalin.');
                    return;
                }

                navigator.clipboard.writeText(content).then(function() {
                    const originalHtml = $('#copyBtn').html();
                    $('#copyBtn').html(
                        '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Tersalin!'
                    );

                    setTimeout(function() {
                        $('#copyBtn').html(originalHtml);
                    }, 2000);
                }).catch(function(err) {
                    alert('Gagal menyalin. Browser Anda mungkin tidak mendukung fitur ini.');
                    console.error('Copy failed:', err);
                });
            });

            $('button[type="reset"]').on('click', function() {
                $('#resultArea').addClass('hidden');
                $('#material_description').val('');
                $('input[name="material_type"][value="ppt"]').prop('checked', true);
                rawMarkdownContent = '';

                if (pollingInterval) {
                    clearInterval(pollingInterval);
                    pollingInterval = null;
                }

                $('#generateBtn').prop('disabled', false);
            });

            $(window).on('beforeunload', function() {
                if (pollingInterval) {
                    clearInterval(pollingInterval);
                }
            });
        });
    </script>
@endpush
