@extends('_admin._layout.app')

@section('title', 'Reset Password Siswa')

@section('content')
    <div class="flex flex-col gap-4">
        <!-- Header -->
        <div class="flex items-center gap-x-3">
            <a navigate href="{{ route('admin.students.index') }}"
                class="size-10 flex justify-center items-center text-sm font-semibold rounded-full border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800 cursor-pointer">
                <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="90" height="90"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path d="m12 19-7-7 7-7" />
                    <path d="M19 12H5" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-neutral-200">
                    Reset Password
                </h1>
                <p class="text-sm text-gray-500 dark:text-neutral-400">
                    Atur ulang password untuk siswa: <span
                        class="font-semibold text-gray-800 dark:text-neutral-200">{{ $data->name }}</span>
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div
                class="bg-white overflow-hidden shadow-lg rounded-2xl dark:bg-neutral-800 border-2 border-gray-100 dark:border-neutral-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-neutral-700 flex justify-between items-center">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 dark:text-neutral-200">
                            Password Baru
                        </h2>
                    </div>
                </div>

                <form id="reset-password-form" class="p-6" navigate-form
                    action="{{ route('admin.students.doResetPassword', $id) }}" method="POST">
                    @csrf

                    <div class="space-y-4">
                        <div>
                            <label for="password" class="block text-sm font-medium mb-2 dark:text-white">Password Baru <span
                                    class="text-red-500">*</span></label>
                            <input type="password" id="password" name="password"
                                class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 placeholder-neutral-300 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 @error('password') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                                placeholder="Masukkan password baru" required>
                            @error('password')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium mb-2 dark:text-white">Ulangi
                                Password Baru
                                <span class="text-red-500">*</span></label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 placeholder-neutral-300 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                                placeholder="Ulangi password baru" required>
                        </div>
                    </div>

                    <div class="mt-4 flex justify-start gap-x-2">
                        <button type="submit"
                            class="py-2.5 px-4 inline-flex items-center gap-x-2 text-sm font-semibold rounded-xl border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none transition-all shadow-md shadow-blue-500/20 active:scale-95 cursor-pointer">
                            <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="90" height="90"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="m12 19-7-7 7-7" />
                                <path d="M19 12H5" />
                            </svg>
                            Reset Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection