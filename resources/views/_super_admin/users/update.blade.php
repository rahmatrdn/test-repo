@extends('_admin._layout.app')

@section('title', 'Update Pengguna')

@php
    use App\Constants\UserConst;
@endphp

@section('content')
    <div class="max-w-4xl">
        <!-- Breadcrumb & Title -->
        <div class="mb-6">
            <div class="flex items-center gap-x-3 mb-2">
                <a navigate href="{{ route('superadmin.users.index') }}"
                    class="size-10 flex items-center justify-center rounded-full bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 transition-colors shadow-sm dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400">
                    <svg class="size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m15 18-6-6 6-6" />
                    </svg>
                </a>
                <h1 class="text-2xl font-extrabold text-gray-800 dark:text-neutral-200">
                    Update Pengguna
                </h1>
            </div>
            <p class="text-sm text-gray-500 dark:text-neutral-500 ml-13">
                Ubah data pengguna sistem aplikasi.
            </p>
        </div>

        <div
            class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8 dark:bg-neutral-800 dark:border-neutral-700">
            <form action="{{ route('superadmin.users.doUpdate', $userId) }}" method="POST" navigate-form>
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nama Lengkap -->
                    <div class="space-y-2">
                        <label for="name" class="inline-block text-sm font-semibold text-gray-800 dark:text-neutral-200">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name', $data->name) }}"
                            class="py-3 px-4 block w-full border-gray-200 rounded-xl text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
                            placeholder="Contoh: Ahmad Fauzi" required>
                        @error('name')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="space-y-2">
                        <label for="email" class="inline-block text-sm font-semibold text-gray-800 dark:text-neutral-200">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" name="email" id="email" value="{{ old('email', $data->email) }}"
                            class="py-3 px-4 block w-full border-gray-200 rounded-xl text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
                            placeholder="contoh@email.com" required>
                        @error('email')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Role / Hak Akses -->
                    <div class="space-y-2">
                        <label for="access_type"
                            class="inline-block text-sm font-semibold text-gray-800 dark:text-neutral-200">
                            Hak Akses <span class="text-red-500">*</span>
                        </label>
                        <select name="access_type" id="access_type" onchange="toggleSchoolField()"
                            class="py-3 px-4 block w-full border-gray-200 rounded-xl text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
                            required>
                            <option value="">Pilih Hak Akses</option>
                            @foreach (UserConst::getAccessTypes() as $key => $value)
                                <option value="{{ $key }}" {{ old('access_type', $data->access_type) == $key ? 'selected' : '' }}>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                        @error('access_type')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Sekolah Selection (Conditional) -->
                    <div class="space-y-2" id="school_field" style="display: none;">
                        <label for="school_id"
                            class="inline-block text-sm font-semibold text-gray-800 dark:text-neutral-200">
                            Pilih Sekolah <span class="text-red-500">*</span>
                        </label>
                        <select name="school_id" id="school_id"
                            class="py-3 px-4 block w-full border-gray-200 rounded-xl text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                            <option value="">Pilih Sekolah</option>
                            @foreach ($schools as $school)
                                <option value="{{ $school->id }}" {{ old('school_id', $data->school_id) == $school->id ? 'selected' : '' }}>
                                    {{ $school->school_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('school_id')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-8 flex justify-end gap-x-3">
                    <button type="button" onclick="history.back()"
                        class="py-3 px-6 inline-flex justify-center items-center gap-2 rounded-xl border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200 transition-all dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-700">
                        Batal
                    </button>
                    <button type="submit"
                        class="py-3 px-8 inline-flex justify-center items-center gap-2 rounded-xl border border-transparent bg-blue-600 text-white font-semibold hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all shadow-md shadow-blue-500/20 active:scale-95">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleSchoolField() {
            const accessType = document.getElementById('access_type').value;
            const schoolField = document.getElementById('school_field');
            const schoolSelect = document.getElementById('school_id');

            // Show school field if not Super Admin (1)
            if (accessType && accessType != '1') {
                schoolField.style.display = 'block';
                schoolSelect.setAttribute('required', 'required');
            } else {
                schoolField.style.display = 'none';
                schoolSelect.removeAttribute('required');
                schoolSelect.value = '';
            }
        }

        // Run on page load
        document.addEventListener('DOMContentLoaded', toggleSchoolField);
    </script>
@endsection