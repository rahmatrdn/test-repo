@extends('_admin._layout.app')

@section('title', 'Data Pengguna')

@php
    use App\Constants\UserConst;
@endphp

@section('content')
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between py-4 gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-800 dark:text-neutral-200 mb-1">
                Data {{ $page['title'] }}
            </h1>
            <p class="text-md text-gray-400 dark:text-neutral-400">
                Kelola data pengguna aplikasi sekolah Anda.
            </p>
        </div>
        <div class="flex flex-col sm:flex-row gap-2">
            <a navigate
                class="py-3 px-4 inline-flex items-center justify-center gap-x-2 text-sm font-semibold rounded-xl border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-blue-700 transition-all shadow-md shadow-blue-500/20 active:scale-95 cursor-pointer"
                href="{{ route('admin.users.add') }}">
                @include('_admin._layout.icons.add')
                Tambah Pengguna
            </a>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="px-2 pt-0">
        <form action="{{ route('admin.users.index') }}" method="GET" navigate-form class="flex flex-col sm:flex-row gap-3">
            <div class="sm:w-64">
                <label for="keywords" class="sr-only">Search</label>
                <div class="relative">
                    <input type="text" name="keywords" id="keywords" value="{{ $keywords ?? '' }}"
                        class="py-1 px-3 block w-full border-gray-200 rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900
                        placeholder-neutral-300 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                        placeholder="Cari Nama ">
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
                        href="{{ route('admin.users.index') }}">
                        @include('_admin._layout.icons.reset')
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Table -->
    <div
        class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden dark:bg-neutral-800 dark:border-neutral-700">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
                <thead class="bg-gray-50/50 dark:bg-neutral-800/50">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-start">
                            <span class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-neutral-400">
                                Nama & Email
                            </span>
                        </th>
                        <th scope="col" class="px-6 py-4 text-start">
                            <span class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-neutral-400">
                                Hak Akses
                            </span>
                        </th>
                        <th scope="col" class="px-6 py-4 text-end">
                            <span class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-neutral-400">
                                Aksi
                            </span>
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-neutral-700">
                    @forelse($data as $d)
                        <tr class="hover:bg-gray-50/50 dark:hover:bg-neutral-700/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-x-3">
                                    <div
                                        class="flex-shrink-0 size-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 font-bold dark:bg-blue-900/30 dark:text-blue-400">
                                        {{ strtoupper(substr($d->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <span class="block text-sm font-semibold text-gray-800 dark:text-neutral-200">
                                            {{ $d->name }}
                                        </span>
                                        <span class="block text-xs text-gray-500 dark:text-neutral-500">
                                            {{ $d->email }}
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="inline-flex items-center gap-x-1.5 py-1 px-2.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-neutral-700 dark:text-neutral-200">
                                    {{ UserConst::getAccessTypes()[$d->access_type] ?? '-' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-end">
                                <div class="inline-flex items-center gap-x-1">
                                    <button type="button"
                                        class="p-2 inline-flex justify-center items-center gap-x-2 text-xs font-medium rounded-lg border border-gray-200 bg-white text-yellow-500 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-700 cursor-pointer"
                                        title="Reset Password"
                                        data-hs-overlay="#reset-password-modal"
                                        onclick="setResetPasswordData('{{ $d->id }}', '{{ $d->name }}')">
                                        @include('_admin._layout.icons.reset', ['class' => 'size-4'])
                                    </button>
                                    <a navigate href="{{ route('admin.users.detail', $d->id) }}"
                                        class="p-2 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-700"
                                        title="Detail">
                                        @include('_admin._layout.icons.view_detail', ['class' => 'size-4'])
                                    </a>
                                    <a navigate href="{{ route('admin.users.update', $d->id) }}"
                                        class="p-2 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-blue-600 shadow-sm hover:bg-blue-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-blue-400 dark:hover:bg-blue-900/20"
                                        title="Edit">
                                        @include('_admin._layout.icons.pencil', ['class' => 'size-4'])
                                    </a>
                                    <button type="button"
                                        class="p-2 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-red-600 shadow-sm hover:bg-red-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-red-400 dark:hover:bg-red-900/20 cursor-pointer"
                                        data-hs-overlay="#delete-modal"
                                        onclick="setDeleteData('{{ $d->id }}', '{{ $d->name }}')"
                                        title="Hapus">
                                        @include('_admin._layout.icons.trash', ['class' => 'size-4'])
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-12 text-center">
                                <x-admin.empty-state message="Belum ada data pengguna." />
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if (count($data) > 0 && $data->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 dark:border-neutral-700">
                <div class="flex justify-between items-center">
                    <p class="text-sm text-gray-600 dark:text-neutral-400">
                        Menampilkan {{ $data->firstItem() }} sampai {{ $data->lastItem() }} dari {{ $data->total() }}
                        data
                    </p>
                    {{ $data->links() }}
                </div>
            </div>
        @endif
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="delete-modal" class="hs-overlay hidden size-full fixed top-0 start-0 z-80 overflow-x-hidden overflow-y-auto"
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

                    <h3 id="delete-modal-label" class="mb-2 text-xl font-bold text-gray-800 dark:text-neutral-200">
                        Hapus Pengguna
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
  <div id="reset-password-modal" class="hs-overlay hidden size-full fixed top-0 start-0 z-80 overflow-x-hidden overflow-y-auto" role="dialog" tabindex="-1" aria-labelledby="reset-password-modal-label">
        <div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto">
            <div class="relative flex flex-col bg-white border shadow-sm rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
                <div class="absolute top-2 end-2">
                    <button type="button"
                        class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:hover:bg-neutral-600 dark:text-neutral-400 dark:focus:bg-neutral-600"
                        aria-label="Close" data-hs-overlay="#reset-password-modal">
                        <span class="sr-only">Close</span>
                        @include('_admin._layout.icons.close_modal')
                    </button>
                </div>

                <div class="p-4 sm:p-10 text-center overflow-y-auto">
                    <span
                        class="mb-4 inline-flex justify-center items-center size-14 rounded-full border-4 border-yellow-50 bg-yellow-100 text-yellow-500 dark:bg-yellow-700 dark:border-yellow-600 dark:text-yellow-100">
                        @include('_admin._layout.icons.reset')
                    </span>

                    <h3 id="reset-password-modal-label" class="mb-2 text-xl font-bold text-gray-800 dark:text-neutral-200">
                        Reset Password Pengguna
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
    <script>
        function setDeleteData(id, name) {
            document.getElementById('delete-item-name').textContent = name;
            document.getElementById('delete-form').action = '{{ url('admin/users/delete') }}/' + id;
        }
        function setResetPasswordData(id, name) {
            document.getElementById('reset-item-name').textContent = name;
            document.getElementById('reset-form').action = '{{ url('admin/users/reset-password') }}/' + id;
        }
    </script>
@endsection
