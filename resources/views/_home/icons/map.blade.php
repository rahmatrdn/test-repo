<li class="hs-accordion {{ request()->routeIs('admin.users.*') || request()->routeIs('admin.task_categories.*') || request()->routeIs('admin.classrooms.*') || request()->routeIs('admin.facility-categories.*') ? 'active' : '' }}"
                            id="projects-accordion">
                            <button type="button"
                                class="hs-accordion-toggle w-full text-start flex items-center gap-x-3.5  py-2.5 px-3 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 dark:bg-neutral-800 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700 dark:text-neutral-200 cursor-pointer font-semibold"
                                aria-expanded="true" aria-controls="projects-accordion-child">
                                @include('_admin._layout.icons.sidebar.data_master')
                                <span class="sidebar-text flex-1 flex items-center justify-between">
                                    Data Master
                                    <span class="flex items-center gap-x-1">
                                        @include('_admin._layout.icons.sidebar.chevron_down')
                                        @include('_admin._layout.icons.sidebar.chevron_up')
                                    </span>
                                </span>
                            </button>

                            <div id="projects-accordion-child"
                                class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300 {{ request()->routeIs('admin.users.*') || request()->routeIs('admin.classrooms.*') || request()->routeIs('admin.facility-categories.*') || request()->routeIs('admin.locations.*') ? 'block' : 'hidden' }}"
                                role="region" aria-labelledby="projects-accordion">
                                <ul class="ps-8 pt-1 space-y-1">
                                    <li>
                                        <a navigate
                                            class="flex items-center gap-x-3.5  py-2.5 px-3 text-sm rounded-lg hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700 {{ request()->routeIs('admin.facility-categories.*') ? 'bg-orange-100 text-orange-600 dark:bg-neutral-700 dark:text-orange-400' : 'text-gray-800 dark:text-neutral-200' }}"
                                            href="">
                                            <span class="sidebar-text">Jenis Sarana</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a navigate
                                            class="flex items-center gap-x-3.5  py-2.5 px-3 text-sm rounded-lg hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700 {{ request()->routeIs('admin.classrooms.*') ? 'bg-orange-100 text-orange-600 dark:bg-neutral-700 dark:text-orange-400' : 'text-gray-800 dark:text-neutral-200' }}"
                                            href="{{ route('admin.classrooms.index') }}">
                                            <span class="sidebar-text">Kelas</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a navigate
                                            class="flex items-center gap-x-3.5  py-2.5 px-3 text-sm rounded-lg hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700 {{ request()->routeIs('admin.locations.*') ? 'bg-orange-100 text-orange-600 dark:bg-neutral-700 dark:text-orange-400' : 'text-gray-800 dark:text-neutral-200' }}"
                                            href="">
                                            <span class="sidebar-text">Lokasi</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a navigate
                                            class="flex items-center gap-x-3.5  py-2.5 px-3 text-sm rounded-lg hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700 {{ request()->routeIs('admin.users.*') ? 'bg-orange-100 text-orange-600 dark:bg-neutral-700 dark:text-orange-400' : 'text-gray-800 dark:text-neutral-200' }}"
                                            href="{{ route('admin.users.index') }}">
                                            <span class="sidebar-text">Pengguna Aplikasi</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>