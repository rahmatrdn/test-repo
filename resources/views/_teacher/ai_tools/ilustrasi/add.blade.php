@extends('_admin._layout.app')

@section('title', 'AI Illustrasi')

@section('content')
<div class="grid gap-3 md:flex md:justify-between md:items-center py-4">
    <x-page-title
        title="Generator Ilustrasi"
        description="Buat ilustrasi edukatif dengan AI untuk materi pembelajaran" />
</div>

<div class="bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-neutral-800 dark:border-neutral-700">
    <div class="p-6 sm:p-8">
        <form id="illustrasiForm">
            @csrf

            <div class="mb-6">
                <label class="block text-sm font-medium mb-3 text-gray-800 dark:text-neutral-200">
                    Pilih Gaya Gambar
                </label>

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                    @foreach ($data as $item)
                    <label class="cursor-pointer group relative">
                        <input
                            type="radio"
                            name="style"
                            value="{{ $item->name }}"
                            data-id="{{ $item->id }}"
                            class="peer absolute z-10 top-2 left-2"
                            {{ $loop->first ? 'checked' : '' }}>

                        <div
                            class="border-2 border-gray-200 rounded-lg overflow-hidden
                           peer-checked:border-blue-500
                           peer-checked:ring-2
                           peer-checked:ring-blue-500
                           peer-checked:ring-offset-2
                           hover:border-gray-300
                           dark:border-neutral-700
                           dark:peer-checked:ring-offset-neutral-800
                           transition-all">

                            <div class="aspect-square bg-gradient-to-br from-purple-400 to-pink-600 relative">
                                <img
                                    src="{{ $item->preview_path }}"
                                    alt="{{ $item->name }}"
                                    class="w-full h-full object-cover">

                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent flex items-end p-2">
                                    <span class="text-white text-xs font-semibold">
                                        {{ $item->name }}
                                    </span>
                                </div>
                            </div>

                        </div>
                    </label>
                    @endforeach
                </div>
            </div>


            <div class="mb-6">
                <label for="illustration_description"
                    class="block text-sm font-medium mb-2 text-gray-800 dark:text-neutral-200">
                    Deskripsi Ilustrasi
                </label>
                <textarea id="illustration_description" name="description" rows="5"
                    class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                    placeholder="Deskripsikan ilustrasi yang ingin Anda buat. Contoh: Seorang anak sedang membaca buku di bawah pohon besar, suasana ceria dan cerah, taman yang indah dengan bunga-bunga berwarna warni..."
                    required></textarea>
                <p class="mt-2 text-xs text-gray-500 dark:text-neutral-400">
                    Jelaskan secara detail apa yang ingin divisualisasikan dalam ilustrasi
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
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    Generate
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
        <span class="ml-3 text-gray-600 dark:text-neutral-400">Sedang membuat ilustrasi...</span>
    </div>
</div>

<div id="resultArea"
    class="hidden mt-6 bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-neutral-800 dark:border-neutral-700">
    <div class="p-6 sm:p-8">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-neutral-200">Hasil Generate</h3>
            <button type="button" id="downloadBtn"
                class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-200 dark:hover:bg-neutral-800">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                </svg>
                Download
            </button>
        </div>
        <div id="resultContent" class="flex justify-center">
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        let pollInterval;
        let maxAttempts = 60;
        let currentAttempt = 0;
        let currentReferenceId = null;
        let historySaved = false;

        $('#illustrasiForm').on('submit', function(e) {
            e.preventDefault();

            const selectedStyle = $('input[name="style"]:checked');
            const styleName = selectedStyle.val();
            const styleId = selectedStyle.data('id');
            const description = $('#illustration_description').val();

            if (!styleId) {
                showError('Silakan pilih gaya gambar terlebih dahulu');
                return;
            }

            if (!description.trim()) {
                showError('Silakan masukkan deskripsi ilustrasi');
                return;
            }

            $('#loadingState').removeClass('hidden');
            $('#resultArea').addClass('hidden');
            $('#generateBtn').prop('disabled', true);
            currentAttempt = 0;
            historySaved = false;

            $.ajax({
                url: '/api/tools/ilustration',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                data: JSON.stringify({
                    description: description,
                    image_style_id: parseInt(styleId)
                }),
                success: function(response) {
                    if (response.success && response.data.reference_id) {
                        currentReferenceId = response.data.reference_id;
                        pollImageStatus(response.data.reference_id, styleName, description, styleId);
                    } else {
                        showError('Gagal memulai generate ilustrasi');
                        $('#generateBtn').prop('disabled', false);
                        $('#loadingState').addClass('hidden');
                    }
                },
                error: function(xhr) {
                    console.error('Error:', xhr);
                    let errorMsg = 'Terjadi kesalahan saat mengirim request';

                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                        errorMsg = Object.values(xhr.responseJSON.errors).flat().join(', ');
                    }

                    showError(errorMsg);
                    $('#generateBtn').prop('disabled', false);
                    $('#loadingState').addClass('hidden');
                }
            });
        });

        function pollImageStatus(referenceId, styleName, description, styleId) {
            pollInterval = setInterval(function() {
                currentAttempt++;

                $.ajax({
                    url: `/api/status/ilustration/${referenceId}`,
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json'
                    },
                    success: function(response) {
                        if (response.data.status === 'completed') {
                            clearInterval(pollInterval);
                            showResult(response.data.image_url, styleName, description, styleId, referenceId);
                            if (!historySaved) {
                                historySaved = true;
                                saveToHistory(referenceId, description, styleId, response.data.image_url);
                            }

                            $('#loadingState').addClass('hidden');
                            $('#generateBtn').prop('disabled', false);
                        } else if (response.data.status === 'failed') {
                            clearInterval(pollInterval);
                            showError('Generate ilustrasi gagal. Silakan coba lagi.');
                            $('#loadingState').addClass('hidden');
                            $('#generateBtn').prop('disabled', false);
                        } else if (currentAttempt >= maxAttempts) {
                            clearInterval(pollInterval);
                            showError('Timeout: Proses generate memakan waktu terlalu lama');
                            $('#loadingState').addClass('hidden');
                            $('#generateBtn').prop('disabled', false);
                        }
                    },
                    error: function(xhr) {
                        clearInterval(pollInterval);
                        console.error('Polling error:', xhr);
                        showError('Terjadi kesalahan saat mengecek status');
                        $('#loadingState').addClass('hidden');
                        $('#generateBtn').prop('disabled', false);
                    }
                });
            }, 1000);
        }

        function showResult(imageUrl, styleName, description, styleId, referenceId) {
            $('#resultContent').html(`
                <div class="w-full max-w-2xl">
                    <img src="${imageUrl}?t=${Date.now()}" alt="Generated illustration"
                        class="w-full rounded-lg shadow-lg border border-gray-200 dark:border-neutral-700"
                        onerror="this.onerror=null; this.src='https://via.placeholder.com/800x600?text=Image+Not+Found'; console.error('Image failed to load:', '${imageUrl}');">
                </div>
            `);

            $('#downloadBtn').off('click').on('click', function() {
                downloadImage(imageUrl);
            });

            $('#resultArea').removeClass('hidden');
        }

        function showError(message) {
            $('#loadingState').addClass('hidden');
            alert('Error: ' + message);
        }

        function downloadImage(imageUrl) {
            fetch(imageUrl)
                .then(response => response.blob())
                .then(blob => {
                    const url = window.URL.createObjectURL(blob);
                    const link = document.createElement('a');
                    link.href = url;
                    link.download = `ilustrasi-${Date.now()}.png`;
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                    window.URL.revokeObjectURL(url);
                })
                .catch(error => {
                    console.error('Download error:', error);
                    window.open(imageUrl, '_blank');
                });
        }

        function saveToHistory(referenceId, description, styleId, imageUrl) {
            $.ajax({
                url: '/teacher/api/ilustration/save-history',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                data: JSON.stringify({
                    reference_id: referenceId,
                    description: description,
                    image_style_id: parseInt(styleId),
                    image_url: imageUrl
                }),
                success: function(response) {
                    console.log('Riwayat berhasil disimpan!', response);
                },
                error: function(xhr) {
                    console.error('Failed to save history:', xhr.responseJSON || xhr);
                }
            });
        }

        $(window).on('beforeunload', function() {
            if (pollInterval) {
                clearInterval(pollInterval);
            }
        });
    });
</script>
@endpush
