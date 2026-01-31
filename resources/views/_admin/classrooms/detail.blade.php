@extends('_admin._layout.app')

@section('title', 'Detail Kelas')

@section('content')
    {{-- Header --}}
    <div class="grid gap-3 md:flex md:justify-between md:items-center py-4">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-800 dark:text-neutral-200 mb-1">
                Detail Kelas {{ $data->class_name }}
            </h1>
            <p class="text-md text-gray-400 dark:text-neutral-400">
                Tahun Masuk {{ $data->entry_year }}
            </p>
        </div>

        <div>
            <a navigate href="{{ route('admin.classrooms.index') }}"
                class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100 dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-800">
                Kembali
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="p-5 bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-neutral-800 dark:border-neutral-700">
            <div class="flex items-center gap-x-4">
                <div
                    class="size-12 flex items-center justify-center rounded-lg bg-blue-100 text-blue-600 dark:bg-blue-800/30 dark:text-blue-400">
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-neutral-400">Total Siswa</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-neutral-200">
                        {{ $students->count() }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-neutral-800 dark:border-neutral-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-neutral-700">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-neutral-200">
                Daftar Siswa
            </h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full divide-y divide-gray-200 dark:divide-neutral-700">
                <thead class="bg-gray-50 dark:bg-neutral-700">
                    <tr>
                        <th class="px-6 py-3 text-start text-xs font-semibold uppercase text-gray-600 dark:text-neutral-300">
                            #
                        </th>
                        <th class="px-6 py-3 text-start text-xs font-semibold uppercase text-gray-600 dark:text-neutral-300">
                            Nama Siswa
                        </th>
                        <th class="px-6 py-3 text-start text-xs font-semibold uppercase text-gray-600 dark:text-neutral-300">
                            Email
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                    @forelse ($students as $i => $student)
                        <tr class="hover:bg-gray-100 dark:hover:bg-neutral-700">
                            <td class="px-6 py-3 text-sm text-gray-700 dark:text-neutral-300">
                                {{ $i + 1 }}
                            </td>

                            <td class="px-6 py-3">
                                <div class="flex items-center gap-x-3">
                                    <div
                                        class="size-9 flex items-center justify-center rounded-full bg-blue-100 text-blue-700 font-semibold dark:bg-blue-800/30 dark:text-blue-400">
                                        {{ strtoupper(substr($student->name, 0, 1)) }}
                                    </div>
                                    <span class="text-sm font-semibold text-gray-800 dark:text-neutral-200">
                                        {{ $student->name }}
                                    </span>
                                </div>
                            </td>

                            <td class="px-6 py-3 text-sm text-gray-600 dark:text-neutral-400">
                                {{ $student->email }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-sm text-gray-500 dark:text-neutral-400">
                                <x-admin.empty-state message="Belum ada siswa di kelas ini" />
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
