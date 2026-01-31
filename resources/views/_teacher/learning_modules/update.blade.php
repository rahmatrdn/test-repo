@extends('_admin._layout.app')

@section('title', 'Update Modul Belajar')

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        <div
            class="bg-white overflow-hidden shadow-lg rounded-2xl dark:bg-neutral-800 border-2 border-gray-100 dark:border-neutral-700">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-neutral-700 flex items-center">
                <a navigate href="{{ route('teacher.learning_modules.index') }}"
                    class="py-3 px-3 inline-flex items-center gap-x-2 text-xl rounded-xl border border-gray-200 bg-white text-gray-800 shadow-md hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700 cursor-pointer">
                    <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="90" height="90"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="m12 19-7-7 7-7" />
                        <path d="M19 12H5" />
                    </svg>
                </a>
                <div class="ms-3">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-neutral-200">
                        Edit Modul Belajar
                    </h2>
                    <p class="text-sm text-gray-500 dark:text-neutral-400">Perbarui informasi modul belajar</p>
                </div>
            </div>

            <form navigate-form action="{{ route('teacher.learning_modules.do_update', $data->id) }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                <div class="space-y-4">
                    <!-- Judul Modul -->
                    <div>
                        <label for="title" class="block text-sm font-medium mb-2 dark:text-white">Judul Modul <span
                                class="text-red-500">*</span></label>
                        <div class="relative">
                            <input type="text" id="title" name="title" value="{{ old('title', $data->title) }}"
                                class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 @error('title') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                                placeholder="Masukkan judul modul" required>
                        </div>
                        @error('title')
                            <p class="text-xs text-red-600 mt-2" id="title-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Mata Pelajaran -->
                    <div>
                        <label for="subject_id" class="block text-sm font-medium mb-2 dark:text-white">Mata Pelajaran <span
                                class="text-red-500">*</span></label>
                        <div class="relative">
                            <select name="subject_id" id="subject_id"
                                class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 @error('subject_id') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                                required>
                                <option value="">Pilih Mata Pelajaran</option>
                                @foreach ($subjects as $subject)
                                    <option value="{{ $subject->id }}"
                                        {{ old('subject_id', $data->id) == $subject->id ? 'selected' : '' }}>
                                        {{ $subject->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('subject_id')
                            <p class="text-xs text-red-600 mt-2" id="subject_id-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kelas -->
                    <div>
                        <label for="classroom" class="block text-sm font-medium mb-2 dark:text-white">Kelas <span
                                class="text-red-500">*</span></label>
                        <div class="relative">
                            <select name="classroom" id="classroom"
                                class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 @error('classroom') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                                required>
                                <option value="">Pilih Kelas</option>
                            </select>
                        </div>
                        @error('classroom')
                            <p class="text-xs text-red-600 mt-2" id="classroom-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- File Current -->
                    <div>
                        <label class="block text-sm font-medium mb-2 dark:text-white">File Saat Ini</label>
                        <div class="flex items-center gap-x-3 p-3 bg-gray-50 rounded-lg dark:bg-neutral-900">
                            @php
                                $fileExtension = pathinfo($data->file_path, PATHINFO_EXTENSION);
                            @endphp
                            @if(in_array(strtolower($fileExtension), ['pdf']))
                                <svg class="size-8 text-red-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                    <polyline points="14 2 14 8 20 8"></polyline>
                                </svg>
                            @elseif(in_array(strtolower($fileExtension), ['doc', 'docx']))
                                <svg class="size-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                    <polyline points="14 2 14 8 20 8"></polyline>
                                </svg>
                            @else
                                <svg class="size-8 text-orange-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                    <polyline points="14 2 14 8 20 8"></polyline>
                                </svg>
                            @endif
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-800 dark:text-neutral-200">{{ basename($data->file_path) }}</p>
                                <p class="text-xs text-gray-500 dark:text-neutral-400">{{ strtoupper($fileExtension) }}</p>
                            </div>
                            <a href="{{ asset('storage/' . $data->file_path) }}" target="_blank"
                                class="py-1.5 px-3 inline-flex items-center gap-x-1 text-xs font-medium rounded-lg border border-gray-200 bg-white text-gray-800 hover:bg-gray-50 dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-300">
                                <svg class="size-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                    <polyline points="7 10 12 15 17 10"></polyline>
                                    <line x1="12" y1="15" x2="12" y2="3"></line>
                                </svg>
                                Download
                            </a>
                        </div>
                    </div>

                    <!-- File Upload New -->
                    <div>
                        <label for="file" class="block text-sm font-medium mb-2 dark:text-white">Ganti File (Opsional)</label>
                        <div class="relative">
                            <input type="file" id="file" name="file"
                                class="block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 file:bg-gray-50 file:border-0 file:me-4 file:py-3 file:px-4 dark:file:bg-neutral-700 dark:file:text-neutral-400 @error('file') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror">
                        </div>
                        <p class="text-xs text-gray-500 mt-2">Kosongkan jika tidak ingin mengubah file. Format: PDF, DOC, DOCX, PPT, PPTX, JPG, PNG, JPEG, WEBP. Maksimal 20MB</p>
                        @error('file')
                            <p class="text-xs text-red-600 mt-2" id="file-error">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <div class="mt-6 flex justify-start gap-x-2">
                    <a navigate href="{{ route('teacher.learning_modules.index') }}"
                        class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:bg-gray-50 dark:bg-transparent dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-800">
                        Batal
                    </a>
                    <button type="submit"
                        class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none cursor-pointer">
                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                            <polyline points="17 21 17 13 7 13 7 21" />
                            <polyline points="7 3 7 8 15 8" />
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>




        </div>
    </div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        const classOptions = {
            'SD': ['1', '2', '3', '4', '5', '6'],
            'MI': ['1', '2', '3', '4', '5', '6'],
            'SMP': ['7', '8', '9'],
            'MTS': ['7', '8', '9'],
            'SMA': ['10', '11', '12'],
            'SMK': ['10', '11', '12'],
            'MA': ['10', '11', '12']
        };

        const savedClassroom = '{{ old("classroom", $data->classroom ?? "") }}';
        const schoolGrade = '{{ $schoolGrade ?? "" }}';

        // Auto-populate classroom based on school grade
        function populateClassroom() {
            const classSelect = $('#classroom');
            
            // Clear existing options
            classSelect.empty().append('<option value="">Pilih Kelas</option>');
            
            if (schoolGrade && classOptions[schoolGrade]) {
                classSelect.prop('disabled', false);
                classOptions[schoolGrade].forEach(function(classNum) {
                    const selected = classNum === savedClassroom ? 'selected' : '';
                    classSelect.append(`<option value="${classNum}" ${selected}>${classNum}</option>`);
                });
            } else {
                classSelect.prop('disabled', true);
            }
        }

        // Populate on page load
        populateClassroom();
    });
</script>
@endpush
