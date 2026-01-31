@extends('_admin._layout.app')

@section('title', 'Dashboard')

@section('content')
    @if (!Auth::user()->school_id)
        <div class="max-w-4xl mx-auto">
            <div class="bg-linear-to-r from-blue-500 to-blue-600 rounded-2xl shadow-xl p-8 text-white">
                <div class="flex items-start gap-6">
                    <div class="shrink-0">
                        <div class="flex items-center justify-center size-16 bg-white/20 rounded-xl backdrop-blur-sm">
                            <svg class="size-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1">
                        <h2 class="text-2xl font-bold mb-2">Selamat Datang di SmartSekolah!</h2>
                        <p class="text-blue-50 mb-6 text-lg">
                            Untuk dapat menggunakan semua fitur aplikasi, Anda perlu mendaftarkan sekolah terlebih dahulu.
                        </p>
                        <a href="{{ route('school.register') }}"
                            class="inline-flex items-center gap-2 px-6 py-3 bg-white text-blue-600 font-semibold rounded-lg hover:bg-blue-50 transition-all duration-200 shadow-lg hover:shadow-xl">
                            @include('_admin._layout.icons.graduation')
                            Daftarkan Sekolah Sekarang
                        </a>
                    </div>
                </div>
            </div>

        </div>
    @else
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
            <div
                class="flex items-center gap-4 bg-white border border-gray-200 shadow-sm rounded-xl p-5 dark:bg-neutral-800 dark:border-neutral-700">
                <div class="flex shrink-0 justify-center items-center size-14 bg-green-500 rounded-xl">
                    <svg class="size-7 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-500 dark:text-neutral-400">Total Guru</p>
                    <h3 class="text-3xl font-bold text-green-500">{{ number_format($stats['total_teachers']) }}</h3>
                </div>
            </div>

            <div
                class="flex items-center gap-4 bg-white border border-gray-200 shadow-sm rounded-xl p-5 dark:bg-neutral-800 dark:border-neutral-700">
                <div class="flex shrink-0 justify-center items-center size-14 bg-blue-500 rounded-xl text-white">
                    @include('_admin._layout.icons.graduation')
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-500 dark:text-neutral-400">Total Siswa</p>
                    <h3 class="text-3xl font-bold text-blue-500">{{ number_format($stats['total_students']) }}</h3>
                </div>
            </div>

            <div
                class="flex items-center gap-4 bg-white border border-gray-200 shadow-sm rounded-xl p-5 dark:bg-neutral-800 dark:border-neutral-700">
                <div class="flex shrink-0 justify-center items-center size-14 bg-purple-500 rounded-xl">
                    <svg class="size-7 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M4 6a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6ZM14 6a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2h-2a2 2 0 0 1-2-2V6ZM4 16a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-2ZM14 16a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2h-2a2 2 0 0 1-2-2v-2Z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-500 dark:text-neutral-400">Total Kelas</p>
                    <h3 class="text-3xl font-bold text-purple-500">{{ number_format($stats['total_classrooms']) }}</h3>
                </div>
            </div>

            <div
                class="flex items-center gap-4 bg-white border border-gray-200 shadow-sm rounded-xl p-5 dark:bg-neutral-800 dark:border-neutral-700">
                <div class="flex shrink-0 justify-center items-center size-14 bg-orange-500 rounded-xl">
                    <svg class="size-7 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-500 dark:text-neutral-400">Total Modul Belajar</p>
                    <h3 class="text-3xl font-bold text-orange-500">{{ number_format($stats['total_learning_modules']) }}</h3>
                </div>
            </div>
        </div>

        <div class="mt-6">
            <div class="bg-white border border-gray-200 shadow-2xs rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
                <div class="p-4 md:p-5">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-neutral-200 mb-4">
                        Statistik Registrasi Guru & Siswa - {{ now()->locale('id')->isoFormat('MMMM YYYY') }}
                    </h3>
                    <div id="schoolRegistrationChart"></div>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        (function () {
            'use strict';

            let chartInstance = null;
            let darkModeObserver = null;

            function initializeChart() {
                setTimeout(function () {
                    if (chartInstance) {
                        try {
                            chartInstance.destroy();
                        } catch (e) {
                            console.error('Error destroying chart:', e);
                        }
                        chartInstance = null;
                    }

                    if (darkModeObserver) {
                        darkModeObserver.disconnect();
                        darkModeObserver = null;
                    }

                    const chartContainer = document.querySelector("#schoolRegistrationChart");
                    if (!chartContainer) {
                        console.log('Chart container not found');
                        return;
                    }

                    const chartData = @json($chartData);

                    if (!chartData || !chartData.categories || !chartData.series) {
                        console.error('Invalid chart data');
                        return;
                    }

                    const categories = chartData.categories.map(dateStr => {
                        const date = new Date(dateStr);
                        return date.getDate().toString();
                    });

                    const isDarkMode = document.documentElement.classList.contains('dark');

                    const options = {
                        series: chartData.series,
                        chart: {
                            height: 400,
                            type: 'area',
                            fontFamily: 'inherit',
                            toolbar: {
                                show: true,
                                tools: {
                                    download: '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>',
                                    selection: false,
                                    zoom: false,
                                    zoomin: false,
                                    zoomout: false,
                                    pan: false,
                                    reset: false
                                },
                                export: {
                                    csv: {
                                        filename: 'statistik-registrasi-guru-siswa',
                                        headerCategory: 'Bulan',
                                    },
                                    svg: {
                                        filename: 'statistik-registrasi-guru-siswa',
                                    },
                                    png: {
                                        filename: 'statistik-registrasi-guru-siswa',
                                    }
                                }
                            },
                            background: 'transparent',
                            zoom: {
                                enabled: false
                            }
                        },
                        colors: ['#10b981', '#3b82f6'],
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            curve: 'smooth',
                            width: 3
                        },
                        fill: {
                            type: 'gradient',
                            gradient: {
                                shadeIntensity: 1,
                                opacityFrom: 0.5,
                                opacityTo: 0.1,
                                stops: [0, 90, 100]
                            }
                        },
                        markers: {
                            size: 0,
                            colors: ['#10b981', '#3b82f6'],
                            strokeColors: '#fff',
                            strokeWidth: 2,
                            hover: {
                                size: 7
                            }
                        },
                        xaxis: {
                            categories: categories,
                            labels: {
                                style: {
                                    colors: isDarkMode ? '#9ca3af' : '#6b7280',
                                    fontSize: '12px',
                                    fontWeight: 500
                                },
                                rotate: -45,
                                rotateAlways: false
                            },
                            axisBorder: {
                                show: true,
                                color: isDarkMode ? '#374151' : '#e5e7eb'
                            },
                            axisTicks: {
                                show: true,
                                color: isDarkMode ? '#374151' : '#e5e7eb'
                            }
                        },
                        yaxis: {
                            labels: {
                                style: {
                                    colors: isDarkMode ? '#9ca3af' : '#6b7280',
                                    fontSize: '12px',
                                    fontWeight: 500
                                },
                                formatter: function (value) {
                                    return Math.floor(value);
                                }
                            },
                            title: {
                                text: 'Jumlah Pengguna',
                                style: {
                                    color: isDarkMode ? '#9ca3af' : '#6b7280',
                                    fontSize: '13px',
                                    fontWeight: 600
                                }
                            }
                        },
                        tooltip: {
                            shared: true,
                            intersect: false,
                            theme: isDarkMode ? 'dark' : 'light',
                            y: {
                                formatter: function (value) {
                                    return value + ' pengguna';
                                }
                            },
                            marker: {
                                show: true
                            },
                            style: {
                                fontSize: '13px',
                                fontFamily: 'inherit'
                            }
                        },
                        legend: {
                            position: 'top',
                            horizontalAlign: 'left',
                            fontSize: '13px',
                            fontWeight: 500,
                            labels: {
                                colors: isDarkMode ? '#9ca3af' : '#6b7280',
                            },
                            markers: {
                                width: 12,
                                height: 12,
                                radius: 3
                            },
                            itemMargin: {
                                horizontal: 12,
                                vertical: 8
                            }
                        },
                        grid: {
                            show: true,
                            borderColor: isDarkMode ? '#374151' : '#e5e7eb',
                            strokeDashArray: 3,
                            xaxis: {
                                lines: {
                                    show: false
                                }
                            },
                            yaxis: {
                                lines: {
                                    show: true
                                }
                            },
                            padding: {
                                top: 0,
                                right: 10,
                                bottom: 0,
                                left: 10
                            }
                        }
                    };

                    try {
                        chartInstance = new ApexCharts(chartContainer, options);
                        chartInstance.render();
                        console.log('Chart rendered successfully');
                    } catch (e) {
                        console.error('Error rendering chart:', e);
                        return;
                    }

                    // Handle dark mode changes
                    darkModeObserver = new MutationObserver(function (mutations) {
                        mutations.forEach(function (mutation) {
                            if (mutation.attributeName === 'class' && chartInstance) {
                                const isDark = document.documentElement.classList.contains('dark');
                                chartInstance.updateOptions({
                                    xaxis: {
                                        labels: {
                                            style: {
                                                colors: isDark ? '#9ca3af' : '#6b7280',
                                            }
                                        },
                                        axisBorder: {
                                            color: isDark ? '#374151' : '#e5e7eb'
                                        },
                                        axisTicks: {
                                            color: isDark ? '#374151' : '#e5e7eb'
                                        }
                                    },
                                    yaxis: {
                                        labels: {
                                            style: {
                                                colors: isDark ? '#9ca3af' : '#6b7280',
                                            }
                                        },
                                        title: {
                                            style: {
                                                color: isDark ? '#9ca3af' : '#6b7280',
                                            }
                                        }
                                    },
                                    tooltip: {
                                        theme: isDark ? 'dark' : 'light'
                                    },
                                    legend: {
                                        labels: {
                                            colors: isDark ? '#9ca3af' : '#6b7280',
                                        }
                                    },
                                    grid: {
                                        borderColor: isDark ? '#374151' : '#e5e7eb',
                                    }
                                });
                            }
                        });
                    });

                    darkModeObserver.observe(document.documentElement, {
                        attributes: true
                    });
                }, 100); // Small delay to ensure DOM is ready
            }

            // Try multiple initialization strategies
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initializeChart);
            } else {
                // DOM is already loaded
                initializeChart();
            }

            // Also listen for these events in case of SPA navigation
            document.addEventListener('livewire:navigated', initializeChart);
            window.addEventListener('load', initializeChart);

            // Cleanup when leaving the page
            document.addEventListener('livewire:navigating', function () {
                if (chartInstance) {
                    try {
                        chartInstance.destroy();
                    } catch (e) {
                        console.error('Error destroying chart on navigation:', e);
                    }
                    chartInstance = null;
                }
                if (darkModeObserver) {
                    darkModeObserver.disconnect();
                    darkModeObserver = null;
                }
            });

            // Cleanup on page unload
            window.addEventListener('beforeunload', function () {
                if (chartInstance) {
                    try {
                        chartInstance.destroy();
                    } catch (e) {
                        // Ignore errors during cleanup
                    }
                }
            });
        })();
    </script>
@endpush