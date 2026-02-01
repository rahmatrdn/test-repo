@extends('_admin._layout.auth')

@section('title', 'Registrasi Akun')

@section('content')
    <div class="w-full max-w-md p-6 bg-white shadow-md dark:bg-neutral-900 dark:border-neutral-700 rounded-2xl">
        <div class="text-center mb-8">
            <h1 class="block text-3xl font-bold text-gray-800 dark:text-white">Daftar Akun Baru</h1>
            <p class="mt-2 text-sm text-gray-600 dark:text-neutral-400">
                Buat akun untuk mendaftarkan sekolah Anda
            </p>
        </div>

        <form id="register-form" action="{{ route('register.post') }}" method="POST">
            @csrf
            <div class="grid gap-y-4">
                @error('register_error')
                    <div class="bg-red-50 border border-red-200 text-sm text-red-600 rounded-lg p-4 mb-4 dark:bg-red-800/10 dark:border-red-900 dark:text-red-500"
                        role="alert" tabindex="-1">
                        <span class="font-bold"></span> {{ $message }}
                    </div>
                @enderror

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm mb-2 dark:text-white">Nama Lengkap</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                        class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 @error('name') border-red-500 @enderror"
                        required>
                    @error('name')
                        <p class="text-xs text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm mb-2 dark:text-white">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                        class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 @error('email') border-red-500 @enderror"
                        required>
                    @error('email')
                        <p class="text-xs text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm mb-2 dark:text-white">Password</label>
                    <input type="password" id="password" name="password"
                        class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 @error('password') border-red-500 @enderror"
                        required>
                    @error('password')
                        <p class="text-xs text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Confirmation -->
                <div>
                    <label for="password_confirmation" class="block text-sm mb-2 dark:text-white">Konfirmasi
                        Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                        required>
                </div>

                <button type="submit" id="register-btn"
                    class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-lg font-extrabold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600 cursor-pointer">
                    <span id="btn-text">D A F T A R</span>
                    <span id="btn-spinner"
                        class="animate-spin size-4 border-[3px] border-current border-t-transparent text-white rounded-full hidden"
                        role="status" aria-label="loading">
                        <span class="sr-only">Loading...</span>
                    </span>
                    <span id="btn-loading-text" class="hidden">Loading...</span>
                </button>

                <p class="text-center text-sm text-gray-600 dark:text-neutral-400 mt-2">
                    Sudah punya akun?
                    <a href="{{ route('login') }}"
                        class="text-blue-600 decoration-2 hover:underline font-medium dark:text-blue-500">
                        Login di sini
                    </a>
                </p>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('register-form').addEventListener('submit', function () {
            const btn = document.getElementById('register-btn');
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