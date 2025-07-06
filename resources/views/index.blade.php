@extends('layouts.app')

@section('content')
    <div x-data="{
        showNotification: false,
        message: '',
        isSuccess: false
    }" x-init="@if (session('success')) showNotification = true;
            message = '{{ session('success') }}';
            isSuccess = true;
            setTimeout(() => showNotification = false, 5000); @endif
    @if (session('error')) showNotification = true;
            message = '{{ session('error') }}';
            isSuccess = false;
            setTimeout(() => showNotification = false, 5000); @endif" class="fixed inset-x-0 z-50 flex justify-center top-5">
        <div x-show="showNotification" x-transition
            class="w-full max-w-xl px-4 py-3 mx-4 text-sm font-semibold rounded-lg shadow-lg"
            :class="isSuccess ?
                'bg-green-50 border border-green-200 text-green-800 dark:bg-green-900/80 dark:backdrop-blur-sm dark:border-green-700 dark:text-green-200' :
                'bg-red-50 border border-red-200 text-red-800 dark:bg-red-900/80 dark:backdrop-blur-sm dark:border-red-700 dark:text-red-200'">
            <div class="flex items-center justify-between">
                <span x-text="message"></span>
                <button @click="showNotification = false" class="p-1 ml-4 -mr-1 rounded-full hover:bg-white/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div class="space-y-8">
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <div
                class="p-5 bg-white shadow-sm rounded-xl dark:border-gray-700 dark:bg-gradient-to-br dark:from-gray-800 dark:to-gray-900 dark:backdrop-blur-sm ring-1 ring-gray-100 dark:ring-gray-700/50">
                <div class="flex items-start justify-between">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Hutang Aktif</p>
                    <div class="p-2 text-indigo-600 bg-indigo-100 rounded-lg dark:text-indigo-300 dark:bg-indigo-900/50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H7a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-2">
                    <p class="text-3xl font-bold text-gray-800 dark:text-gray-100">
                        Rp{{ number_format($bills->where('is_paid', false)->sum('amount'), 0, ',', '.') }}
                    </p>
                    @php $unpaidBillsCount = $bills->where('is_paid', false)->count(); @endphp
                    <p
                        class="mt-1 text-xs {{ $unpaidBillsCount == 0 ? 'text-green-600 dark:text-green-400' : 'text-amber-600 dark:text-amber-400' }}">
                        {{ $unpaidBillsCount == 0 ? 'Tidak ada hutang aktif' : $unpaidBillsCount . ' tagihan belum lunas' }}
                    </p>
                </div>
            </div>

            <div
                class="p-5 bg-white shadow-sm rounded-xl dark:border-gray-700 dark:bg-gradient-to-br dark:from-gray-800 dark:to-gray-900 dark:backdrop-blur-sm ring-1 ring-gray-100 dark:ring-gray-700/50">
                <div class="flex items-start justify-between">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Tabungan</p>
                    <div class="p-2 text-green-600 bg-green-100 rounded-lg dark:text-green-300 dark:bg-green-900/50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-2">
                    <p class="text-3xl font-bold text-gray-800 dark:text-gray-100">
                        Rp{{ number_format($savings->sum('saving'), 0, ',', '.') }}
                    </p>
                    @php
                        $totalSaving = $savings->sum('saving');
                        $totalTarget = $savings->sum('target');
                        $percentage = $totalTarget > 0 ? min(100, ($totalSaving / $totalTarget) * 100) : 0;
                    @endphp
                    <div class="w-full h-2 mt-2 bg-gray-200 rounded-full dark:bg-gray-700">
                        <div class="h-2 bg-indigo-500 rounded-full" style="width: {{ $percentage }}%"></div>
                    </div>
                </div>
            </div>

            <div
                class="p-5 bg-white shadow-sm rounded-xl dark:border-gray-700 dark:bg-gradient-to-br dark:from-gray-800 dark:to-gray-900 dark:backdrop-blur-sm ring-1 ring-gray-100 dark:ring-gray-700/50">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Aksi Cepat</p>
                <div class="grid grid-cols-2 gap-3 mt-4">
                    <a href="#"
                        class="flex items-center justify-center px-3 py-4 text-sm font-semibold text-indigo-700 transition-colors bg-indigo-100 rounded-lg dark:text-indigo-300 dark:bg-indigo-900/50 hover:bg-indigo-200 dark:hover:bg-indigo-900">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Hutang
                    </a>
                    <a href="#"
                        class="flex items-center justify-center px-3 py-4 text-sm font-semibold text-green-700 transition-colors bg-green-100 rounded-lg dark:text-green-300 dark:bg-green-900/50 hover:bg-green-200 dark:hover:bg-green-900">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Tabungan
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-5">
            <div
                class="p-5 bg-white shadow-sm rounded-xl dark:border-gray-700 dark:bg-gradient-to-br dark:from-gray-800 dark:to-gray-900 dark:backdrop-blur-sm ring-1 ring-gray-100 dark:ring-gray-700/50 lg:col-span-3">
                <h3 class="text-base font-semibold text-gray-800 dark:text-gray-200">Statistik Hutang 6 Bulan Terakhir</h3>
                <div class="mt-4 h-72">
                    <canvas id="debtTrendChart"></canvas>
                </div>
            </div>
            <div
                class="p-5 bg-white shadow-sm rounded-xl dark:border-gray-700 dark:bg-gradient-to-br dark:from-gray-800 dark:to-gray-900 dark:backdrop-blur-sm ring-1 ring-gray-100 dark:ring-gray-700/50 lg:col-span-2">
                <h3 class="text-base font-semibold text-gray-800 dark:text-gray-200">Progress Tabungan</h3>
                <div class="mt-4 h-72">
                    <canvas id="savingsChart"></canvas>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <div
                class="p-5 bg-white shadow-sm rounded-xl dark:border-gray-700 dark:bg-gradient-to-br dark:from-gray-800 dark:to-gray-900 dark:backdrop-blur-sm ring-1 ring-gray-100 dark:ring-gray-700/50">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-base font-semibold text-gray-800 dark:text-gray-200">Hutang Terakhir</h3>
                    <a href="{{ route('bills') }}"
                        class="text-sm font-medium text-indigo-600 hover:underline dark:text-indigo-400">Lihat Semua</a>
                </div>
                <div class="space-y-3">
                    @forelse ($bills->take(4) as $bill)
                        <div
                            class="flex flex-col gap-2 p-3 transition-colors rounded-lg sm:flex-row sm:items-center sm:justify-between hover:bg-gray-50 dark:hover:bg-gray-700/50">
                            <div>
                                <p class="font-medium text-gray-800 truncate dark:text-gray-200">{{ $bill->item }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ \Carbon\Carbon::parse($bill->date)->translatedFormat('d F Y') }}</p>
                            </div>
                            <div class="flex items-center justify-end gap-3 sm:justify-start">
                                <p class="text-sm font-semibold text-right text-gray-700 dark:text-gray-300">
                                    Rp{{ number_format($bill->amount) }}</p>
                                <span
                                    class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-md {{ $bill->is_paid ? 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-200' : 'bg-amber-100 text-amber-700 dark:bg-amber-900 dark:text-amber-200' }}">
                                    {{ $bill->is_paid ? 'Lunas' : 'Aktif' }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div
                            class="py-12 text-center border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-10 h-10 mx-auto text-gray-400 dark:text-gray-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                            </svg>
                            <p class="mt-3 text-sm font-medium text-gray-500 dark:text-gray-400">Hore, tidak ada hutang!
                            </p>
                            <p class="mt-1 text-xs text-gray-400 dark:text-gray-500">Catat hutang baru jika ada.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <div
                class="p-5 bg-white shadow-sm rounded-xl dark:border-gray-700 dark:bg-gradient-to-br dark:from-gray-800 dark:to-gray-900 dark:backdrop-blur-sm ring-1 ring-gray-100 dark:ring-gray-700/50">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-base font-semibold text-gray-800 dark:text-gray-200">Tabungan Aktif</h3>
                    <a href="{{ route('savings') }}"
                        class="text-sm font-medium text-indigo-600 hover:underline dark:text-indigo-400">Lihat Semua</a>
                </div>
                <div class="space-y-3">
                    @forelse ($savings->where('status', false)->take(4) as $saving)
                        <a href="{{ route('savings') }}"
                            class="block p-3 transition-colors rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50">
                            <div class="flex items-center justify-between">
                                <p class="font-medium text-gray-800 dark:text-gray-200">{{ $saving->name }}</p>
                                @php $percentage = $saving->target > 0 ? ($saving->saving / $saving->target) * 100 : 0; @endphp
                                <span
                                    class="text-sm font-semibold text-gray-700 dark:text-gray-300">{{ round($percentage) }}%</span>
                            </div>
                            <div class="w-full h-2 mt-2 bg-gray-200 rounded-full dark:bg-gray-700">
                                <div class="h-2 bg-indigo-500 rounded-full" style="width: {{ $percentage }}%"></div>
                            </div>
                            <div class="flex justify-between mt-1.5 text-xs text-gray-500 dark:text-gray-400">
                                <span>Rp{{ number_format($saving->saving) }}</span>
                                <span>dari Rp{{ number_format($saving->target) }}</span>
                            </div>
                        </a>
                    @empty
                        <div
                            class="py-12 text-center border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-10 h-10 mx-auto text-gray-400 dark:text-gray-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.085a2 2 0 00-1.736 1.002L7 7m7 3h2.828a1 1 0 01.949.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a1 1 0 00-.502 1.21L17 20M7 7a2 2 0 00-2 2v6a2 2 0 002 2h2.182a1 1 0 01.949.684l1.498 4.493a1 1 0 001.996 0l1.498-4.493A1 1 0 0114.818 15H17" />
                            </svg>
                            <p class="mt-3 text-sm font-medium text-gray-500 dark:text-gray-400">Belum ada tabungan.</p>
                            <p class="mt-1 text-xs text-gray-400 dark:text-gray-500">Mulai buat target tabunganmu!</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- Skrip JavaScript tidak perlu diubah karena sudah rapi dan fungsional --}}

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // --- DATA DARI CONTROLLER ---
            const debtData = @json($debtChartData);
            const savingsData = @json($savingsChartData);


            // --- FUNGSI-FUNGSI HELPER UNTUK GRAFIK ---

            /**
             * Mengupdate warna elemen chart (teks, garis grid) berdasarkan tema.
             */
            const updateChartColors = (chart, isDark) => {
                const textColor = isDark ? 'rgba(229, 231, 235, 0.8)' : 'rgba(55, 65, 81, 0.8)';
                const gridColor = isDark ? 'rgba(55, 65, 81, 0.5)' : 'rgba(229, 231, 235, 0.5)';

                if (chart.options.plugins.legend) {
                    chart.options.plugins.legend.labels.color = textColor;
                }
                if (chart.options.scales) {
                    if (chart.options.scales.x) {
                        chart.options.scales.x.grid.color = gridColor;
                        chart.options.scales.x.ticks.color = textColor;
                    }
                    if (chart.options.scales.y) {
                        chart.options.scales.y.grid.color = gridColor;
                        chart.options.scales.y.ticks.color = textColor;
                    }
                }
                chart.update();
            };

            /**
             * Membuat dan merender grafik garis untuk tren utang.
             */
            function renderDebtChart(data) {
                const ctx = document.getElementById('debtTrendChart').getContext('2d');
                const isDark = Alpine.store('darkMode').on;
                const textColor = isDark ? 'rgba(229, 231, 235, 0.8)' : 'rgba(55, 65, 81, 0.8)';
                const gridColor = isDark ? 'rgba(55, 65, 81, 0.5)' : 'rgba(229, 231, 235, 0.5)';

                return new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            label: 'Hutang Aktif',
                            data: data.active,
                            borderColor: 'rgba(79, 70, 229, 1)',
                            backgroundColor: isDark ? 'rgba(79, 70, 229, 0.2)' :
                                'rgba(79, 70, 229, 0.05)',
                            borderWidth: 2,
                            tension: 0.3,
                            fill: true
                        }, {
                            label: 'Hutang Lunas',
                            data: data.paid,
                            borderColor: 'rgba(16, 185, 129, 1)',
                            backgroundColor: isDark ? 'rgba(16, 185, 129, 0.2)' :
                                'rgba(16, 185, 129, 0.05)',
                            borderWidth: 2,
                            tension: 0.3,
                            fill: true
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    usePointStyle: true,
                                    padding: 20,
                                    color: textColor,
                                    font: {
                                        family: "'Inter', sans-serif"
                                    }
                                }
                            },
                            tooltip: {
                                backgroundColor: isDark ? '#111827' : '#1F2937',
                                titleColor: isDark ? '#F3F4F6' : '#F9FAFB',
                                bodyColor: isDark ? '#E5E7EB' : '#F3F4F6',
                                titleFont: {
                                    family: "'Inter', sans-serif",
                                    size: 14
                                },
                                bodyFont: {
                                    family: "'Inter', sans-serif",
                                    size: 12
                                },
                                callbacks: {
                                    label: (context) =>
                                        `${context.dataset.label}: Rp${context.raw.toLocaleString('id-ID')}`
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: gridColor,
                                    drawBorder: false
                                },
                                ticks: {
                                    callback: (value) => `Rp${value.toLocaleString('id-ID')}`,
                                    color: textColor,
                                    font: {
                                        family: "'Inter', sans-serif"
                                    }
                                }
                            },
                            x: {
                                grid: {
                                    display: false,
                                    drawBorder: false
                                },
                                ticks: {
                                    color: textColor,
                                    font: {
                                        family: "'Inter', sans-serif"
                                    }
                                }
                            }
                        },
                        interaction: {
                            intersect: false,
                            mode: 'index'
                        }
                    }
                });
            }

            /**
             * Membuat dan merender grafik batang untuk progres tabungan.
             */
            function renderSavingsChart(data) {
                const ctx = document.getElementById('savingsChart').getContext('2d');
                const isDark = Alpine.store('darkMode').on;
                const textColor = isDark ? 'rgba(229, 231, 235, 0.8)' : 'rgba(55, 65, 81, 0.8)';
                const gridColor = isDark ? 'rgba(55, 65, 81, 0.5)' : 'rgba(229, 231, 235, 0.5)';

                return new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: data.map(s => s.name),
                        datasets: [{
                            label: 'Progress',
                            data: data.map(s => s.target > 0 ? Math.min(100, (s.saving / s.target) *
                                100) : 0),
                            backgroundColor: 'rgba(79, 70, 229, 0.7)',
                            borderColor: 'rgba(79, 70, 229, 1)',
                            borderWidth: 1,
                            borderRadius: 4
                        }]
                    },
                    options: {
                        indexAxis: 'y',
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: isDark ? '#111827' : '#1F2937',
                                titleColor: isDark ? '#F3F4F6' : '#F9FAFB',
                                bodyColor: isDark ? '#E5E7EB' : '#F3F4F6',
                                titleFont: {
                                    family: "'Inter', sans-serif",
                                    size: 14
                                },
                                bodyFont: {
                                    family: "'Inter', sans-serif",
                                    size: 12
                                },
                                callbacks: {
                                    label: function(context) {
                                        const saving = data[context.dataIndex];
                                        return [
                                            `Terkumpul: Rp${saving.saving.toLocaleString('id-ID')}`,
                                            `Target: Rp${saving.target.toLocaleString('id-ID')}`,
                                            `Progress: ${context.raw.toFixed(1)}%`
                                        ];
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                beginAtZero: true,
                                max: 100,
                                grid: {
                                    color: gridColor,
                                    drawBorder: false
                                },
                                ticks: {
                                    callback: (value) => `${value}%`,
                                    color: textColor,
                                    font: {
                                        family: "'Inter', sans-serif"
                                    }
                                }
                            },
                            y: {
                                grid: {
                                    display: false,
                                    drawBorder: false
                                },
                                ticks: {
                                    color: textColor,
                                    font: {
                                        family: "'Inter', sans-serif"
                                    }
                                }
                            }
                        }
                    }
                });
            }

            // --- EKSEKUSI UTAMA ---

            // 1. Render kedua chart dengan data yang sudah tersedia
            const debtChart = renderDebtChart(debtData);
            const savingsChart = renderSavingsChart(savingsData);

            // 2. Dengarkan perubahan pada dark mode untuk update warna chart
            Alpine.effect(() => {
                const isDark = Alpine.store('darkMode').on;
                if (debtChart) updateChartColors(debtChart, isDark);
                if (savingsChart) updateChartColors(savingsChart, isDark);
            });
        });
    </script>
@endpush
