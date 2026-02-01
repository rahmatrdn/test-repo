@extends('_admin._layout.app')

@section('title', 'Manajemen Guru')

@section('content')
    <div class="grid gap-3 md:flex md:justify-between md:items-center py-4">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl font-extrabold text-gray-800 dark:text-neutral-200 mb-1">{{ $page['title'] }}</h1>
            <p class="text-md text-gray-400 dark:text-neutral-400">Kelola data guru dengan mudah</p>
        </div>
        <a navigate href="{{ route('admin.teachers.add') }}"
            class="py-3 px-4 inline-flex items-center justify-center gap-x-2 text-sm font-semibold rounded-xl border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-blue-700 transition-all shadow-md shadow-blue-500/20 active:scale-95 cursor-pointer">
            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M5 12h14" />
                <path d="M12 5v14" />
            </svg>
            Tambah Guru
        </a>
    </div>

    <div class="flex flex-col">
        <div class="overflow-x-auto">
            <div class="min-w-full inline-block align-middle">
                <div class="overflow-hidden">

                    <div class="px-2 pt-0">
                        <form action="{{ route('admin.teachers.index') }}" method="GET" navigate-form
                            class="flex flex-col sm:flex-row gap-3">
                            <div class="sm:w-64">
                                <label for="keywords" class="sr-only">Search</label>
                                <div class="relative">
                                    <input type="text" name="keywords" id="keywords" value="{{ $keywords ?? '' }}"
                                        class="py-1 px-3 block w-full border-gray-200 rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900
                                            placeholder-neutral-300 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                                        placeholder="Cari Nama Guru">
                                </div>
                            </div>
                            <div>
                                <button type="submit"
                                    class="py-1 px-3 inline-flex items-center gap-x-1 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600 cursor-pointer">
                                    @include('_admin._layout.icons.search')
                                    Cari
                                </button>
                                @if (!empty($keywords))
                                    <a class="py-1 px-3 inline-flex items-center gap-x-1 text-sm font-semibold rounded-lg border border-blue-600 text-blue-600 hover:border-blue-500 hover:text-blue-500 hover:bg-blue-50 disabled:opacity-50 disabled:pointer-events-none dark:border-blue-500 dark:text-blue-500 dark:hover:bg-blue-500/10 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600 cursor-pointer"
                                        href="{{ route('admin.teachers.index') }}">
                                        @include('_admin._layout.icons.reset')
                                        Reset
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>




                    <div class="flex flex-col">
                        <div class="overflow-x-auto">
                            <div class="min-w-full inline-block align-middle">
                                <div class="overflow-hidden">
                                    <div
                                        class="mx-0 my-4 overflow-x-auto border border-gray-200 rounded-lg dark:border-neutral-700">
                                        <table class="w-full divide-y divide-gray-200 dark:divide-neutral-700">
                                            <thead class="bg-gray-50 dark:bg-neutral-700">
                                                <tr>
                                                    <th scope="col" class="px-6 py-3 text-start">
                                                        <span
                                                            class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">
                                                            No
                                                        </span>
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 text-start">
                                                        <span
                                                            class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">
                                                            Nama
                                                        </span>
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 text-start">
                                                        <span
                                                            class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">
                                                            Email
                                                        </span>
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 text-end"></th>
                                                </tr>
                                            </thead>

                                            <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                                                @forelse($data as $d)
                                                    <tr class="hover:bg-gray-100 dark:hover:bg-neutral-700">
                                                        <td class="size-px whitespace-nowrap">
                                                            <div class="px-6 py-3">
                                                                <span
                                                                    class="block text-sm text-gray-800 dark:text-neutral-200">{{ $loop->iteration + ($data instanceof \Illuminate\Pagination\LengthAwarePaginator ? $data->firstItem() - 1 : 0) }}</span>
                                                            </div>
                                                        </td>
                                                        <td class="size-px whitespace-nowrap">
                                                            <div class="px-6 py-3">
                                                                <span
                                                                    class="block text-sm font-semibold text-gray-800 dark:text-neutral-200">{{ $d->name }}</span>
                                                            </div>
                                                        </td>
                                                        <td class="size-px whitespace-nowrap">
                                                            <div class="px-6 py-3">
                                                                <span
                                                                    class="block text-sm text-gray-800 dark:text-neutral-200">{{ $d->email }}</span>
                                                            </div>
                                                        </td>
                                                        <td class="size-px whitespace-nowrap">
                                                            <div class="px-6 py-1.5 flex items-center gap-x-2 justify-end">
                                                                <button type="button"
                                                                    class="p-2 inline-flex justify-center items-center gap-x-2 text-xs font-medium rounded-lg border border-transparent bg-yellow-100 text-yellow-800 hover:bg-yellow-200 focus:outline-none focus:bg-yellow-200 disabled:opacity-50 disabled:pointer-events-none dark:text-yellow-400 dark:bg-yellow-800/30 dark:hover:bg-yellow-800/20 dark:focus:bg-yellow-800/20 cursor-pointer"
                                                                    title="Reset Password"
                                                                    data-hs-overlay="#reset-password-modal"
                                                                    onclick="setResetPasswordData('{{ $d->id }}', '{{ $d->name }}')">
                                                                    @include('_admin._layout.icons.reset')
                                                                </button>
                                                                <a navigate
                                                                    class="py-2 px-3 inline-flex justify-center items-center gap-x-2 text-xs font-medium rounded-lg border border-transparent bg-blue-100 text-blue-800 hover:bg-blue-200 focus:outline-none focus:bg-blue-200 disabled:opacity-50 disabled:pointer-events-none dark:text-blue-400 dark:bg-blue-800/30 dark:hover:bg-blue-800/20 dark:focus:bg-blue-800/20"
                                                                    href="{{ route('admin.teachers.update', $d->id) }}">
                                                                    @include('_admin._layout.icons.pencil')
                                                                </a>
                                                                <button type="button"
                                                                    class="py-2 px-3 inline-flex justify-center items-center gap-x-2 text-xs font-medium rounded-lg border border-transparent bg-red-100 text-red-800 hover:bg-red-200 focus:outline-none focus:bg-red-200 disabled:opacity-50 disabled:pointer-events-none dark:text-red-500 dark:bg-red-800/30 dark:hover:bg-red-800/20 dark:focus:bg-red-800/20 cursor-pointer"
                                                                    title="Delete" data-hs-overlay="#delete-modal"
                                                                    onclick="setDeleteData('{{ $d->id }}', '{{ $d->name }}')">
                                                                    @include('_admin._layout.icons.trash')
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5"
                                                            class="px-6 py-4 text-center text-sm text-gray-500 dark:text-neutral-500">
                                                            <x-admin.empty-state />
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>

                                    @if (count($data) > 0 && $data instanceof \Illuminate\Pagination\AbstractPaginator && $data->hasPages())
                                        <div class="px-6 py-4 border-t border-gray-200 dark:border-neutral-700">
                                            <div class="flex justify-end">
                                                {{ $data->links() }}
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Delete Confirmation Modal -->
                    <div id="delete-modal"
                        class="hs-overlay hidden size-full fixed top-0 start-0 z-80 overflow-x-hidden overflow-y-auto"
                        role="dialog" tabindex="-1" aria-labelledby="delete-modal-label">
                        <div
                            class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto">
                            <div
                                class="relative flex flex-col bg-white border shadow-sm rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
                                <div class="absolute top-2 end-2">
                                    <button type="button"
                                        class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:hover:bg-neutral-600 dark:text-neutral-400 dark:focus:bg-neutral-600"
                                        aria-label="Close" data-hs-overlay="#delete-modal">
                                        <span class="sr-only">Close</span>
                                        @include('_admin._layout.icons.close_modal')
                                    </button>
                                </div>

                                <div class="p-4 sm:p-10 text-center overflow-y-auto">
                                    <!-- Icon -->
                                    <span
                                        class="mb-4 inline-flex justify-center items-center size-14 rounded-full border-4 border-red-50 bg-red-100 text-red-500 dark:bg-red-700 dark:border-red-600 dark:text-red-100">
                                        @include('_admin._layout.icons.warning_modal')
                                    </span>
                                    <!-- End Icon -->

                                    <h3 id="delete-modal-label"
                                        class="mb-2 text-xl font-bold text-gray-800 dark:text-neutral-200">
                                        Hapus Guru
                                    </h3>
                                    <p class="text-gray-500 dark:text-neutral-500">
                                        Apakah Anda yakin ingin menghapus <span id="delete-item-name"
                                            class="font-semibold text-gray-800 dark:text-neutral-200"></span>?
                                        <br>Tindakan ini tidak dapat dibatalkan.
                                    </p>

                                    <div class="mt-6 flex justify-center gap-x-4">
                                        <button type="button"
                                            class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:bg-gray-50 dark:bg-transparent dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800"
                                            data-hs-overlay="#delete-modal">
                                            Batal
                                        </button>
                                        <form id="delete-form" method="POST" class="inline" navigate-form>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-red-600 text-white hover:bg-red-700 focus:outline-none focus:bg-red-700 disabled:opacity-50 disabled:pointer-events-none">
                                                Ya, Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Reset Password Confirmation Modal -->
                    <div id="reset-password-modal"
                        class="hs-overlay hidden size-full fixed top-0 start-0 z-80 overflow-x-hidden overflow-y-auto"
                        role="dialog" tabindex="-1" aria-labelledby="reset-password-modal-label">
                        <div
                            class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto">
                            <div
                                class="relative flex flex-col bg-white border shadow-sm rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
                                <div class="absolute top-2 end-2">
                                    <button type="button"
                                        class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:hover:bg-neutral-600 dark:text-neutral-400 dark:focus:bg-neutral-600"
                                        aria-label="Close" data-hs-overlay="#reset-password-modal">
                                        <span class="sr-only">Close</span>
                                        @include('_admin._layout.icons.close_modal')
                                    </button>
                                </div>

                                <div class="p-4 sm:p-10 text-center overflow-y-auto">
                                    <!-- Icon -->
                                    <span
                                        class="mb-4 inline-flex justify-center items-center size-14 rounded-full border-4 border-yellow-50 bg-yellow-100 text-yellow-500 dark:bg-yellow-700 dark:border-yellow-600 dark:text-yellow-100">
                                        @include('_admin._layout.icons.reset')
                                    </span>
                                    <!-- End Icon -->

                                    <h3 id="reset-password-modal-label"
                                        class="mb-2 text-xl font-bold text-gray-800 dark:text-neutral-200">
                                        Reset Password Guru
                                    </h3>
                                    <p class="text-gray-500 dark:text-neutral-500">
                                        Apakah Anda yakin ingin mereset password <span id="reset-item-name"
                                            class="font-semibold text-gray-800 dark:text-neutral-200"></span>?
                                        <br>Password akan direset menjadi default: <span
                                            class="font-bold text-blue-600">asdasd</span>
                                    </p>

                                    <div class="mt-6 flex justify-center gap-x-4">
                                        <button type="button"
                                            class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:bg-gray-50 dark:bg-transparent dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800"
                                            data-hs-overlay="#reset-password-modal">
                                            Batal
                                        </button>
                                        <form id="reset-form" method="POST" class="inline" navigate-form>
                                            @csrf
                                            <button type="submit"
                                                class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-yellow-600 text-white hover:bg-yellow-700 focus:outline-none focus:bg-yellow-700 disabled:opacity-50 disabled:pointer-events-none">
                                                Ya, Reset
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <script>
                    function setDeleteData(id, name) {
                        document.getElementById('delete-item-name').textContent = name;
                        document.getElementById('delete-form').action = '{{ url('admin/teachers/delete') }}/' + id;
                    }

                    function setResetPasswordData(id, name) {
                        document.getElementById('reset-item-name').textContent = name;
                        document.getElementById('reset-form').action = '{{ url('admin/teachers/reset-password') }}/' + id;
                    }
                </script>
@endsection