@extends('_admin._layout.app')

@section('title', 'Detail Materi Ajar')

@section('content')
    <div class="grid gap-3 md:flex md:justify-between md:items-center py-4">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-800 dark:text-neutral-200 mb-1">
                Detail Materi Ajar
            </h1>
            <p class="text-md text-gray-400 dark:text-neutral-400">
                Lihat detail materi pembelajaran yang telah dibuat
            </p>
        </div>
        <div>
            <a navigate href="{{ route('teacher.ai.materi_ajar.index') }}"
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

    <!-- Info Card -->
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-neutral-800 dark:border-neutral-700 mb-6">
        <div class="p-6 sm:p-8">
            <div class="grid sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-600 dark:text-neutral-400 mb-2">
                        Tipe Materi
                    </label>
                    <p class="text-gray-800 dark:text-neutral-200 font-semibold">
                        @if($data->type == 'PPT')
                            <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-800/30 dark:text-blue-500">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 2a2 2 0 00-2 2v8a2 2 0 002 2h6a2 2 0 002-2V6.414A2 2 0 0016.414 5L14 2.586A2 2 0 0012.586 2H9z"/>
                                    <path d="M3 8a2 2 0 012-2v10h8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z"/>
                                </svg>
                                PowerPoint
                            </span>
                        @else
                            <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-800/30 dark:text-green-500">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                                </svg>
                                Modul Belajar
                            </span>
                        @endif
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 dark:text-neutral-400 mb-2">
                        Dibuat Oleh
                    </label>
                    <p class="text-gray-800 dark:text-neutral-200 font-semibold">
                        {{ $data->created_by_name }}
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 dark:text-neutral-400 mb-2">
                        Tanggal Dibuat
                    </label>
                    <p class="text-gray-800 dark:text-neutral-200">
                        {{ \Carbon\Carbon::parse($data->created_at)->format('d F Y, H:i') }} WIB
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 dark:text-neutral-400 mb-2">
                        Terakhir Update
                    </label>
                    <p class="text-gray-800 dark:text-neutral-200">
                        {{ \Carbon\Carbon::parse($data->updated_at)->format('d F Y, H:i') }} WIB
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- User Input Card -->
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-neutral-800 dark:border-neutral-700 mb-6">
        <div class="p-6 sm:p-8">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-neutral-200 mb-4">
                Deskripsi Input
            </h3>
            <div class="bg-gray-50 dark:bg-neutral-900 rounded-lg p-4 border border-gray-200 dark:border-neutral-700">
                <p class="text-gray-700 dark:text-neutral-300 whitespace-pre-wrap">{{ $data->user_input }}</p>
            </div>
        </div>
    </div>

    <!-- Result Card -->
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-neutral-800 dark:border-neutral-700">
        <div class="p-6 sm:p-8">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-neutral-200">Hasil Materi</h3>
                <div class="flex gap-2">
                    <button type="button" id="downloadBtn"
                        class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Download
                    </button>
                    <button type="button" id="copyBtn"
                        class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-300 bg-white text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                        Salin
                    </button>
                </div>
            </div>
            <div id="resultContent" class="prose prose-sm dark:prose-invert max-w-none text-gray-800 dark:text-neutral-200">
                <!-- Content akan di-render di sini oleh JavaScript -->
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>

    <script>
        $(document).ready(function() {
            const rawMarkdownContent = @json($data->output_text);

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
                        '<th class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-neutral-200 uppercase tracking-wider">');
                    
                    html = html.replace(/<tbody>/g, 
                        '<tbody class="bg-white dark:bg-neutral-900 divide-y divide-gray-100 dark:divide-neutral-800">');
                    html = html.replace(/<td>/g, 
                        '<td class="px-6 py-4 text-sm text-gray-800 dark:text-neutral-200">');
                    
                    // ===== HEADING STYLING =====
                    html = html.replace(/<h1>/g, 
                        '<h1 class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-blue-400 dark:to-indigo-400 mt-8 mb-6 pb-3 border-b-4 border-blue-500/20">');
                    
                    html = html.replace(/<h2>/g, 
                        '<h2 class="text-3xl font-bold text-gray-900 dark:text-neutral-100 mt-10 mb-5 flex items-center">' +
                        '<span class="inline-block w-1.5 h-8 bg-gradient-to-b from-blue-500 to-indigo-500 rounded-full mr-3"></span>');
                    html = html.replace(/<\/h2>/g, '</h2>');
                    
                    html = html.replace(/<h3>/g, 
                        '<h3 class="text-2xl font-semibold text-gray-800 dark:text-neutral-200 mt-8 mb-4 flex items-center">' +
                        '<svg class="w-6 h-6 mr-2 text-blue-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg><span>');
                    html = html.replace(/<\/h3>/g, '</span></h3>');
                    
                    html = html.replace(/<h4>/g, 
                        '<h4 class="text-xl font-semibold text-gray-700 dark:text-neutral-300 mt-6 mb-3">');
                    
                    // ===== LIST STYLING =====
                    html = html.replace(/<ul>/g, 
                        '<ul class="space-y-2 my-4 ml-6 list-none pl-2">');
                    
                    // Replace all <li> inside <ul> with custom styled version
                    html = html.replace(/(<ul[^>]*>)([\s\S]*?)(<\/ul>)/g, function(match, ulOpen, content, ulClose) {
                        let styledContent = content.replace(/<li>/g, 
                            '<li class="flex items-start text-gray-700 dark:text-neutral-300 leading-relaxed">' +
                            '<svg class="w-5 h-5 mr-2 mt-0.5 text-blue-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg><span>');
                        styledContent = styledContent.replace(/<\/li>/g, '</span></li>');
                        return ulOpen + styledContent + ulClose;
                    });
                    
                    html = html.replace(/<ol>/g, 
                        '<ol class="space-y-2 my-4 ml-6 list-decimal list-outside pl-2">');
                    html = html.replace(/(<ol[^>]*>)([\s\S]*?)(<\/ol>)/g, function(match, olOpen, content, olClose) {
                        let styledContent = content.replace(/<li>/g, '<li class="text-gray-700 dark:text-neutral-300 leading-relaxed pl-2">');
                        return olOpen + styledContent + olClose;
                    });
                    
                    // ===== CODE BLOCKS =====
                    html = html.replace(/<pre><code([^>]*)>/g, 
                        '<pre class="bg-gray-900 dark:bg-black rounded-lg p-5 overflow-x-auto my-5 border border-gray-700 shadow-lg"><code$1 class="text-sm text-gray-100 font-mono leading-relaxed">');
                    
                    // Inline code (yang bukan di dalam pre)
                    html = html.replace(/<code>/g, 
                        '<code class="px-2 py-1 bg-gray-100 dark:bg-neutral-800 text-red-600 dark:text-red-400 rounded text-sm font-mono border border-gray-200 dark:border-neutral-700">');
                    
                    // ===== PARAGRAF & BLOCKQUOTE =====
                    html = html.replace(/<p>/g, 
                        '<p class="text-gray-700 dark:text-neutral-300 leading-relaxed my-4">');
                    
                    html = html.replace(/<blockquote>/g, 
                        '<blockquote class="border-l-4 border-blue-500 bg-blue-50 dark:bg-blue-900/20 pl-4 py-3 my-4 italic text-gray-700 dark:text-neutral-300 rounded-r">');
                    
                    // ===== STRONG & EM =====
                    html = html.replace(/<strong>/g, 
                        '<strong class="font-bold text-gray-900 dark:text-neutral-100">');
                    
                    html = html.replace(/<em>/g, 
                        '<em class="italic text-gray-600 dark:text-neutral-400">');
                    
                    // ===== HORIZONTAL RULE =====
                    html = html.replace(/<hr>/g, 
                        '<hr class="my-8 border-t-2 border-gray-200 dark:border-neutral-700">');
                    
                    // ===== LINKS =====
                    html = html.replace(/<a href="/g, 
                        '<a target="_blank" rel="noopener noreferrer" href="');
                    html = html.replace(/<a /g, 
                        '<a class="text-blue-600 dark:text-blue-400 hover:underline font-medium" ');
                    
                    return html;
                } catch (e) {
                    console.error('Error parsing markdown:', e);
                    return `<div class="text-gray-700 dark:text-neutral-300 whitespace-pre-wrap font-mono text-sm bg-gray-50 dark:bg-neutral-900 p-4 rounded border border-gray-200 dark:border-neutral-700">${markdownContent}</div>`;
                }
            }

            // Render konten saat halaman dimuat
            const htmlContent = formatMarkdownToHTML(rawMarkdownContent);
            $('#resultContent').html(htmlContent);

            // Download button handler
            $('#downloadBtn').on('click', function() {
                if (!rawMarkdownContent) {
                    alert('⚠️ Tidak ada konten untuk diunduh.');
                    return;
                }

                const materialType = '{{ $data->type }}';
                const timestamp = new Date().toISOString().slice(0, 19).replace(/:/g, '-');
                const filename = `materi-${materialType.toLowerCase()}-${timestamp}.md`;

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

            // Copy button handler
            $('#copyBtn').on('click', function() {
                if (!rawMarkdownContent) {
                    alert('Tidak ada konten untuk disalin.');
                    return;
                }

                navigator.clipboard.writeText(rawMarkdownContent).then(function() {
                    const originalHtml = $('#copyBtn').html();
                    $('#copyBtn').html(
                        '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Tersalin!'
                    );

                    setTimeout(function() {
                        $('#copyBtn').html(originalHtml);
                    }, 2000);
                }).catch(function(err) {
                    alert('Gagal menyalin. Browser Anda mungkin tidak mendukung fitur ini.');
                    console.error('Copy failed:', err);
                });
            });

            function showSuccessNotification(message) {
                const notification = $(`
                    <div class="fixed top-4 right-4 z-50 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4 shadow-lg animate-slide-in">
                        <div class="flex items-center gap-3">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-sm font-medium text-green-800 dark:text-green-200">${message}</span>
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
        });
    </script>
@endpush
