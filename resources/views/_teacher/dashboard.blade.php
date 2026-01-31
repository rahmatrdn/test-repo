@extends('_admin._layout.app')

@section('title', 'Dashboard')

@section('content')
    @if (Auth::user()->school_id)
        <div class="grid sm:grid-cols-1 lg:grid-cols-2 xl:grid-cols-2 gap-4 sm:gap-6">
            <div
                class="flex items-center gap-4 bg-white border border-gray-200 shadow-sm rounded-xl p-5 dark:bg-neutral-800 dark:border-neutral-700">
                <div class="flex shrink-0 justify-center items-center size-14 bg-orange-500 rounded-xl text-white">
                    <svg class="size-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-500 dark:text-neutral-400">Total Modul Belajar</p>
                    <h3 class="text-3xl font-bold text-orange-500">{{ number_format($stats['total_learning_modules']) }}</h3>
                </div>
            </div>

            <div
                class="flex items-center gap-4 bg-white border border-gray-200 shadow-sm rounded-xl p-5 dark:bg-neutral-800 dark:border-neutral-700">
                <div class="flex shrink-0 justify-center items-center size-14 bg-blue-500 rounded-xl text-white">
                    <svg class="size-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-500 dark:text-neutral-400">Total Pengunduh</p>
                    <h3 class="text-3xl font-bold text-blue-500">{{ number_format($stats['total_downloads']) }}</h3>
                </div>
            </div>
        </div>

        <div class="mt-6">
            <div class="bg-white border border-gray-200 shadow-2xs rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
                <div class="p-4 md:p-5">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-neutral-200 mb-4">
                        Statistik Download Modul - {{ now()->locale('id')->isoFormat('MMMM YYYY') }}
                    </h3>
                    <div id="downloadChart"></div>
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

                    const chartContainer = document.querySelector("#downloadChart");
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
                                        filename: 'statistik-download-modul',
                                        headerCategory: 'Tanggal',
                                    },
                                    svg: {
                                        filename: 'statistik-download-modul',
                                    },
                                    png: {
                                        filename: 'statistik-download-modul',
                                    }
                                }
                            },
                            background: 'transparent',
                            zoom: {
                                enabled: false
                            }
                        },
                        colors: ['#3b82f6'],
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
                            colors: ['#3b82f6'],
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
                                text: 'Jumlah Download',
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
                                    return value + ' download';
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
