@extends('_admin._layout.app')

@section('title', 'Beranda')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

    <div class="bg-white dark:bg-neutral-900 border border-slate-200 dark:border-neutral-800 rounded-xl">
        <div class="p-6 md:p-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                
                <div class="space-y-4">
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-blue-600 text-white uppercase tracking-wider">
                            Siswa Aktif
                        </span>
                        <span class="text-[10px] font-bold text-slate-400 dark:text-neutral-500 uppercase tracking-widest">
                            ID: #{{ Auth::user()->id }}
                        </span>
                    </div>

                    <div class="space-y-1">
                        <h1 class="text-2xl md:text-3xl font-bold text-slate-900 dark:text-white tracking-tight">
                            {{ $profile->name ?? 'Nama Siswa' }}
                        </h1>
                        <div class="flex flex-wrap items-center gap-y-1 gap-x-4 text-slate-500 dark:text-neutral-400">
                            <span class="flex items-center gap-1.5 text-sm">
                                <svg class="size-4 opacity-60" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                {{ $profile->email ?? '-' }}
                            </span>
                            <span class="hidden md:block size-1 bg-slate-300 dark:bg-neutral-700 rounded-full"></span>
                            <span class="flex items-center gap-1.5 text-sm font-medium text-slate-700 dark:text-neutral-300">
                                <svg class="size-4 opacity-60" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                Kelas {{ $profile->display_class ?? '-' }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="flex md:flex-col items-center md:items-end gap-2 border-t md:border-t-0 md:border-l border-slate-100 dark:border-neutral-800 pt-4 md:pt-0 md:pl-8">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Tahun Angkatan</span>
                    <span class="text-xl font-bold text-slate-800 dark:text-white">{{ $profile->entry_year ?? '-' }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white dark:bg-neutral-900 border border-slate-200 dark:border-neutral-800 rounded-xl p-6">
                <h2 class="text-sm font-bold text-slate-800 dark:text-neutral-200 mb-6 flex items-center gap-2">
                    <div class="size-1.5 bg-blue-600 rounded-full"></div>
                    Detail Institusi
                </h2>

                <div class="grid sm:grid-cols-2 gap-6">
                    <div>
                        <span class="text-[10px] font-bold text-slate-400 dark:text-neutral-500 uppercase tracking-widest block mb-1">Sekolah</span>
                        <p class="text-sm font-semibold text-slate-700 dark:text-neutral-200">{{ $profile->school_name ?? '-' }}</p>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold text-slate-400 dark:text-neutral-500 uppercase tracking-widest block mb-1">Telepon</span>
                        <p class="text-sm font-semibold text-slate-700 dark:text-neutral-200">{{ $profile->school_phone ?? '-' }}</p>
                    </div>
                    <div class="sm:col-span-2 pt-4 border-t border-slate-50 dark:border-neutral-800">
                        <span class="text-[10px] font-bold text-slate-400 dark:text-neutral-500 uppercase tracking-widest block mb-1">Alamat</span>
                        <p class="text-sm text-slate-600 dark:text-neutral-400 font-medium">{{ $profile->school_address ?? 'Belum diatur' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-neutral-900 border border-slate-200 dark:border-neutral-800 rounded-xl p-6">
            <h2 class="text-sm font-bold text-slate-800 dark:text-neutral-200 mb-6 flex items-center gap-2">
                <div class="size-1.5 bg-blue-600 rounded-full"></div>
                Status Akademik
            </h2>
            <div class="space-y-1">
                <div class="flex justify-between py-2 text-sm">
                    <span class="text-slate-500">Kurikulum</span>
                    <span class="font-bold text-slate-800 dark:text-white">Merdeka</span>
                </div>
                <div class="flex justify-between py-2 text-sm border-t border-slate-50 dark:border-neutral-800">
                    <span class="text-slate-500">Semester</span>
                    <span class="font-bold text-slate-800 dark:text-white">Ganjil</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection