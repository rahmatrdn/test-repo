@extends('_admin._layout.app')

@section('title', 'Dashboard')

@section('content')
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
        <div
            class="flex items-center gap-4 bg-white border border-gray-200 shadow-sm rounded-xl p-5 dark:bg-neutral-800 dark:border-neutral-700">
            <div class="flex shrink-0 justify-center items-center size-14 bg-amber-500 rounded-xl text-white">
                @include('_admin._layout.icons.school')
            </div>
            <div class="flex-1">
                <p class="text-sm font-medium text-gray-500 dark:text-neutral-400">Total Sekolah</p>
                <h3 class="text-3xl font-bold text-amber-500">{{ number_format($stats['total_schools']) }}</h3>
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
    </div>

    <div class="mt-6">
        <div class="bg-white border border-gray-200 shadow-2xs rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
            <div class="p-4 md:p-5">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-neutral-200 mb-4">
                    Statistik Registrasi Pengguna - {{ now()->locale('id')->isoFormat('MMMM YYYY') }}
                </h3>
                <div id="userRegistrationChart"></div>
            </div>
        </div>
    </div>
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

                    const chartContainer = document.querySelector("#userRegistrationChart");
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
                                        filename: 'statistik-registrasi-pengguna',
                                        headerCategory: 'Bulan',
                                    },
                                    svg: {
                                        filename: 'statistik-registrasi-pengguna',
                                    },
                                    png: {
                                        filename: 'statistik-registrasi-pengguna',
                                    }
                                }
                            },
                            background: 'transparent',
                            zoom: {
                                enabled: false
                            }
                        },
                        colors: ['#3b82f6', '#10b981', '#f59e0b'],
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
                            colors: ['#3b82f6', '#10b981', '#f59e0b'],
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
                            x: {
                                show: true,
                                formatter: function (value, { dataPointIndex }) {
                                    return categories[dataPointIndex];
                                }
                            },
                            y: {
                                formatter: function (value, { seriesIndex, dataPointIndex, w }) {
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
                }, 100);
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initializeChart);
            } else {
                initializeChart();
            }

            document.addEventListener('livewire:navigated', initializeChart);
            window.addEventListener('load', initializeChart);

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