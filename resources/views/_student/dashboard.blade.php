@extends('_admin._layout.app')

@section('title', 'Beranda')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

    <div class="bg-gray-50 dark:bg-neutral-800 border border-slate-200 dark:border-neutral-700 rounded-2xl">
        <div class="p-6 md:p-8">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">

                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-bold bg-blue-100 text-blue-600 dark:bg-neutral-700 dark:text-blue-400 uppercase tracking-wider">
                            Siswa Aktif
                        </span>
                        <span class="text-[10px] font-bold text-gray-400 dark:text-neutral-500 uppercase tracking-widest">
                            ID: #{{ Auth::user()->id }}
                        </span>
                    </div>

                    <div class="space-y-1">
                        <h1 class="text-2xl font-bold text-gray-800 dark:text-white tracking-tight">
                            {{ $profile->name ?? 'Nama Siswa' }}
                        </h1>
                        <div class="flex flex-wrap items-center gap-y-1 gap-x-4 text-gray-500 dark:text-neutral-400">
                            <span class="flex items-center gap-1.5 text-sm">
                                <svg class="size-4 opacity-70" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                {{ $profile->email ?? '-' }}
                            </span>
                            <span class="hidden md:block size-1 bg-gray-300 dark:bg-neutral-700 rounded-full"></span>
                            <span class="flex items-center gap-1.5 text-sm font-medium">
                                <svg class="size-4 opacity-70" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                Kelas {{ $profile->display_class ?? '-' }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="flex md:flex-col items-center md:items-end gap-1 md:gap-0 pt-4 md:pt-0 border-t md:border-t-0 md:border-l border-gray-200 dark:border-neutral-700 md:pl-10">
                    <span class="text-[10px] font-bold text-gray-400 dark:text-neutral-500 uppercase tracking-widest">Angkatan</span>
                    <span class="text-xl font-extrabold text-gray-700 dark:text-neutral-200">{{ $profile->entry_year ?? '-' }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white dark:bg-neutral-800 border border-slate-200 dark:border-neutral-700 rounded-2xl p-6 md:p-8">
                <h2 class="text-xs font-bold text-gray-400 dark:text-neutral-500 uppercase tracking-[0.2em] mb-8 flex items-center gap-2">
                    <div class="size-2 bg-blue-500/50 rounded-full"></div>
                    Detail Institusi
                </h2>

                <div class="grid sm:grid-cols-2 gap-y-8 gap-x-12">
                    <div>
                        <span class="text-[10px] font-bold text-gray-400 dark:text-neutral-500 uppercase tracking-widest block mb-1">Sekolah</span>
                        <p class="text-sm font-semibold text-gray-700 dark:text-neutral-200">{{ $profile->school_name ?? '-' }}</p>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold text-gray-400 dark:text-neutral-500 uppercase tracking-widest block mb-1">Telepon</span>
                        <p class="text-sm font-semibold text-gray-700 dark:text-neutral-200">{{ $profile->school_phone ?? '-' }}</p>
                    </div>
                    <div class="sm:col-span-2 pt-6 border-t border-gray-100 dark:border-neutral-700/50">
                        <span class="text-[10px] font-bold text-gray-400 dark:text-neutral-500 uppercase tracking-widest block mb-1">Alamat</span>
                        <p class="text-sm text-gray-500 dark:text-neutral-400 leading-relaxed font-medium">
                            {{ $profile->school_address ?? 'Belum diatur' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-neutral-800 border border-slate-200 dark:border-neutral-700 rounded-2xl p-6">
            <h2 class="text-xs font-bold text-gray-400 dark:text-neutral-500 uppercase tracking-[0.2em] mb-6">Status Akademik</h2>
            <div class="space-y-1">
                <div class="flex items-center justify-between py-3">
                    <span class="text-xs font-medium text-gray-500 dark:text-neutral-500">Kurikulum</span>
                    <span class="text-xs font-bold text-gray-700 dark:text-neutral-200 uppercase tracking-wider">Merdeka</span>
                </div>
                <div class="flex items-center justify-between py-3 border-t border-gray-50 dark:border-neutral-700/50">
                    <span class="text-xs font-medium text-gray-500 dark:text-neutral-500">Semester</span>
                    <span class="text-xs font-bold text-gray-700 dark:text-neutral-200 uppercase tracking-wider">Ganjil</span>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection