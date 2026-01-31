@extends('_admin._layout.app')

@section('title', 'Registrasi Sekolah')

@section('content')
    <div class="max-w-3xl mx-auto">
        <div
            class="bg-white overflow-hidden shadow-lg rounded-2xl dark:bg-neutral-800 border-2 border-gray-100 dark:border-neutral-700">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-neutral-700">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-neutral-200">
                    Registrasi Sekolah
                </h2>
                <p class="text-sm text-gray-600 dark:text-neutral-400 mt-1">
                    Lengkapi data sekolah Anda untuk melanjutkan
                </p>
            </div>

            <form id="school-form" class="p-6" action="{{ route('school.register.post') }}" method="POST" navigate-form>
                @csrf

                <div class="space-y-4">
                    <div>
                        <label for="school_name" class="block text-sm font-medium mb-2 dark:text-white">
                            Nama Sekolah <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="school_name" name="school_name" value="{{ old('school_name') }}"
                            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 placeholder-neutral-300 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 @error('school_name') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                            placeholder="Contoh: SMA Negeri 1 Jakarta" required>
                        @error('school_name')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="grade" class="block text-sm font-medium mb-2 dark:text-white">
                            Tingkat Sekolah <span class="text-red-500">*</span>
                        </label>
                        <select id="grade" name="grade"
                            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 @error('grade') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                            required>
                            <option value="" selected disabled>Pilih Tingkat Sekolah</option>
                            @foreach (\App\Constants\GradeConst::getGrades() as $value => $label)
                                <option value="{{ $value }}" {{ old('grade') == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('grade')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="address" class="block text-sm font-medium mb-2 dark:text-white">
                            Alamat Sekolah <span class="text-gray-400">(Opsional)</span>
                        </label>
                        <textarea id="address" name="address" rows="3"
                            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 placeholder-neutral-300 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 @error('address') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                            placeholder="Contoh: Jl. Sudirman No. 123, Jakarta Pusat">{{ old('address') }}</textarea>
                        @error('address')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="no_tlp" class="block text-sm font-medium mb-2 dark:text-white">
                            No. Telepon <span class="text-gray-400">(Opsional)</span>
                        </label>
                        <input type="text" id="no_tlp" name="no_tlp" value="{{ old('no_tlp') }}"
                            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 placeholder-neutral-300 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 @error('no_tlp') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                            placeholder="Contoh: 021-1234567">
                        @error('no_tlp')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-x-2">
                    <button type="submit" id="submit-btn"
                        class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none cursor-pointer">
                        <span id="btn-text">Daftar Sekolah</span>
                        <span id="btn-spinner"
                            class="animate-spin size-4 border-[3px] border-current border-t-transparent text-white rounded-full hidden"
                            role="status" aria-label="loading">
                            <span class="sr-only">Loading...</span>
                        </span>
                        <span id="btn-loading-text" class="hidden">Menyimpan...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('school-form').addEventListener('submit', function () {
            const btn = document.getElementById('submit-btn');
            const btnText = document.getElementById('btn-text');
            const btnSpinner = document.getElementById('btn-spinner');
            const btnLoadingText = document.getElementById('btn-loading-text');

            btn.disabled = true;
            btnText.classList.add('hidden');
            btnSpinner.classList.remove('hidden');
            btnSpinner.classList.add('inline-block');
            btnLoadingText.classList.remove('hidden');
        });
    </script>
@endsection