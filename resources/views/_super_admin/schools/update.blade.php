@extends('_admin._layout.app')

@section('title', 'Edit Sekolah')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div
            class="bg-white overflow-hidden shadow-lg rounded-2xl dark:bg-neutral-800 border-2 border-gray-100 dark:border-neutral-700">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-neutral-700 flex items-center">
                <a navigate href="{{ route('superadmin.schools.index') }}"
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
                        Edit Sekolah
                    </h2>
                </div>
            </div>

            <form navigate-form action="{{ route('superadmin.schools.do_update', $id) }}" method="POST" class="p-6">
                @csrf
                <div class="space-y-4">
                    <!-- Form Group -->
                    <div>
                        <label for="school_name" class="block text-sm font-medium mb-2 dark:text-white">Nama Sekolah <span
                                class="text-red-500">*</span></label>
                        <div class="relative">
                            <input type="text" id="school_name" name="school_name"
                                value="{{ old('school_name', $data->school_name) }}"
                                class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 @error('school_name') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                                required>
                        </div>
                        @error('title')
                            <p class="text-xs text-red-600 mt-2" id="title-error">{{ $message }}</p>
                        @enderror
                    </div>


                    <div class="flex gap-4">
                        <!-- Form Group -->
                        <div class="w-1/2">
                            <label for="task_date" class="block text-sm font-medium mb-2 dark:text-white">Tanggal <span
                                    class="text-red-500">*</span></label>
                            <div class="relative">
                                <input type="date" id="mou_date" name="mou_date"
                                    value="{{ \Carbon\Carbon::parse($data->mou_date)->format('Y-m-d') }}"
                                    class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 @error('mou_date') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                                    placeholder="YYYY-MM-DD" required>
                            </div>
                            @error('mou_date')
                                <p class="text-xs text-red-600 mt-2" id="mou_date-error">{{ $message }}</p>
                            @enderror
                        </div>


                    </div>

                    <div>
                        <label for="address" class="block text-sm font-medium mb-2 dark:text-white">Alamat</label>
                        <div class="relative">
                            <textarea id="address" name="address" rows="3"
                                class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 @error('address') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror">{{ old('address', $data->address) }}</textarea>
                        </div>
                        @error('address')
                            <p class="text-xs text-red-600 mt-2" id="description-error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="no_tlp" class="block text-sm font-medium mb-2 dark:text-white">No Tlp</label>
                        <div class="relative">
                            <textarea id="no_tlp" name="no_tlp" rows="3"
                                class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 @error('no_tlp') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror">{{ old('no_tlp', $data->no_tlp) }}</textarea>
                        </div>
                        @error('no_tlp')
                            <p class="text-xs text-red-600 mt-2" id="description-error">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <div class="mt-4 flex justify-start gap-x-2">
                    <a navigate href="{{ route('superadmin.schools.index') }}"
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
@endsection
