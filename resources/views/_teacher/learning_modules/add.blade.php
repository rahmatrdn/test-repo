@extends('_admin._layout.app')

@section('title', 'Tambah Modul Belajar')

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
                        Tambah Modul Belajar
                    </h2>
                    <p class="text-sm text-gray-500 dark:text-neutral-400">Lengkapi form untuk menambah modul belajar</p>
                </div>
            </div>

            <form navigate-form action="{{ route('teacher.learning_modules.create') }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                <div class="space-y-4">
                    <!-- Judul Modul -->
                    <div>
                        <label for="title" class="block text-sm font-medium mb-2 dark:text-white">Judul<span
                                class="text-red-500">*</span></label>
                        <div class="relative">
                            <input type="text" id="title" name="title" value="{{ old('title') }}"
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
                                        {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
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

                    <!-- File Upload -->
                    <div>
                        <label for="file" class="block text-sm font-medium mb-2 dark:text-white">File Modul <span
                                class="text-red-500">*</span></label>
                        <div class="relative">
                            <input type="file" id="file" name="file"
                                class="block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 file:bg-gray-50 file:border-0 file:me-4 file:py-3 file:px-4 dark:file:bg-neutral-700 dark:file:text-neutral-400 @error('file') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                                required>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">Format: PDF, DOC, DOCX, PPT, PPTX, JPG, PNG, JPEG, WEBP. Maksimal 20MB</p>
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
                            <path d="M5 12h14" />
                            <path d="M12 5v14" />
                        </svg>
                        Simpan Modul
                    </button>
                </div>
            </form>
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

        const savedClassroom = '{{ old("classroom") }}';
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
