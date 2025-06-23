@extends('layouts.app')

@section('content')
    <!-- Notifikasi dengan gradient dark mode -->
    <div x-data="{ showNotification: false, message: '', isSuccess: false }" x-init="@if (session('success')) showNotification=true; message='{{ session('success') }}'; isSuccess=true; setTimeout(()=>showNotification=false, 3000); @endif
    @if (session('error')) showNotification=true; message='{{ session('error') }}'; isSuccess=false; setTimeout(()=>showNotification=false, 3000); @endif" class="fixed inset-x-0 z-50 flex justify-center top-4">
        <div x-show="showNotification" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-2"
            :class="isSuccess ?
                'bg-green-50 border border-green-200 text-green-700 dark:bg-gradient-to-br dark:from-green-900 dark:to-green-800 dark:border-green-700 dark:text-green-100' :
                'bg-red-50 border border-red-200 text-red-700 dark:bg-gradient-to-br dark:from-red-900 dark:to-red-800 dark:border-red-700 dark:text-red-100'"
            class="w-full max-w-4xl px-4 py-2.5 mx-4 rounded-lg shadow-sm text-sm font-medium">
            <div class="flex items-center justify-between">
                <span x-text="message"></span>
                <button @click="showNotification = false" class="ml-3 text-current hover:opacity-75">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <div class="space-y-6">
        <!-- Stats Overview -->
        <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
            <!-- Total Debt Card -->
            <div
                class="p-6 bg-white border border-gray-100 shadow-xs rounded-xl dark:border-gray-700 dark:bg-gradient-to-br dark:from-gray-800 dark:to-gray-900">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Hutang</p>
                        <p class="mt-2 text-3xl font-semibold text-indigo-700 dark:text-indigo-400">
                            Rp {{ number_format($bills->sum('amount'), 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="p-3 text-indigo-600 bg-indigo-100 rounded-xl dark:text-indigo-300 dark:bg-indigo-900/50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="flex items-center mt-5">
                    <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $bills->where('is_paid', false)->isEmpty() ? 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300' : 'bg-amber-100 text-amber-800 dark:bg-amber-900/50 dark:text-amber-300' }}">
                        {{ $bills->where('is_paid', false)->isEmpty() ? 'Semua Lunas' : $bills->where('is_paid', false)->count() . ' Belum Lunas' }}
                    </span>
                </div>
            </div>

            <!-- Savings Progress Card -->
            <div
                class="p-6 bg-white border border-gray-100 shadow-xs rounded-xl dark:bg-gradient-to-br dark:from-gray-800 dark:to-gray-900 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Tabungan</p>
                        <p class="mt-2 text-3xl font-semibold text-indigo-700 dark:text-indigo-400">
                            Rp {{ number_format($savings->sum('saving'), 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="p-3 text-indigo-600 bg-indigo-100 rounded-xl dark:text-indigo-400 dark:bg-indigo-900/50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-5">
                    <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400">
                        <span>Progress Tabungan</span>
                        <span class="font-medium">
                            @php
                                $completedSavings = $savings
                                    ->filter(function ($saving) {
                                        return $saving->saving >= $saving->target && $saving->target > 0;
                                    })
                                    ->count();
                            @endphp
                            {{ $completedSavings }}/{{ $savings->count() }} Selesai
                        </span>
                    </div>
                    <div class="w-full h-2 mt-2 bg-gray-200 rounded-full dark:bg-gray-700">
                        @php
                            $totalSaving = $savings->sum('saving');
                            $totalTarget = $savings->sum('target');

                            $percentage = $totalTarget > 0 ? min(100, ($totalSaving / $totalTarget) * 100) : 0;
                        @endphp
                        <div class="h-2 transition-all duration-300 bg-indigo-600 rounded-full dark:bg-indigo-500"
                            style="width: {{ $percentage }}%"
                            title="Terkumpul: Rp{{ number_format($totalSaving, 0, ',', '.') }} dari Rp{{ number_format($totalTarget, 0, ',', '.') }}">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions Card -->
            <div
                class="p-6 bg-white border border-gray-100 shadow-xs rounded-xl dark:bg-gradient-to-br dark:from-gray-800 dark:to-gray-900 dark:border-gray-700">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Aksi Cepat</p>
                <div class="grid grid-cols-2 gap-4 mt-5">
                    <a href=""
                        class="flex flex-col items-center justify-center p-3 text-indigo-700 transition-all duration-200 rounded-lg bg-indigo-50 hover:bg-indigo-100 hover:shadow-sm dark:text-indigo-400 dark:bg-indigo-900/50 dark:hover:bg-indigo-900">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        <span class="mt-2 text-xs font-medium text-center">Tambah Hutang</span>
                    </a>
                    <a href=""
                        class="flex flex-col items-center justify-center p-3 text-indigo-700 transition-all duration-200 rounded-lg bg-indigo-50 hover:bg-indigo-100 hover:shadow-sm dark:text-indigo-400 dark:bg-indigo-900/50 dark:hover:bg-indigo-900">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        <span class="mt-2 text-xs font-medium text-center">Buat Tabungan</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <!-- Debt Chart -->
            <div
                class="p-6 bg-white border border-gray-100 shadow-xs rounded-xl dark:bg-gradient-to-br dark:from-gray-800 dark:to-gray-900 dark:border-gray-700">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Statistik Hutang</h3>
                    <div class="flex space-x-2">
                        <span
                            class="inline-flex items-center px-3 py-1 text-xs font-medium text-indigo-800 bg-indigo-100 rounded-full dark:text-indigo-300 dark:bg-indigo-900/50">Bulan
                            Ini</span>
                    </div>
                </div>
                <div class="h-72">
                    <canvas id="debtTrendChart"></canvas>
                </div>
            </div>

            <!-- Savings Chart -->
            <div
                class="p-6 bg-white border border-gray-100 shadow-xs rounded-xl dark:bg-gradient-to-br dark:from-gray-800 dark:to-gray-900 dark:border-gray-700">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Progress Tabungan</h3>
                    <div class="flex space-x-2">
                        <span
                            class="inline-flex items-center px-3 py-1 text-xs font-medium text-indigo-800 bg-indigo-100 rounded-full dark:text-indigo-300 dark:bg-indigo-900/50">Terbaru</span>
                    </div>
                </div>
                <div class="h-72">
                    <canvas id="savingsChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <!-- Recent Debts Card -->
            <div
                class="p-6 transition-shadow duration-300 bg-white border border-gray-100 shadow-sm rounded-xl hover:shadow-md dark:bg-gradient-to-br dark:from-gray-800 dark:to-gray-900 dark:border-gray-700 dark:hover:shadow-lg">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="flex items-center text-lg font-semibold text-gray-800 dark:text-gray-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2 text-indigo-600 dark:text-indigo-400"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Hutang Terakhir
                    </h3>
                    <a href="{{ route('bills') }}"
                        class="flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300">
                        Lihat Semua
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>

                <div class="space-y-3">
                    @forelse ($bills->take(3) as $bill)
                        <div
                            class="flex items-center p-4 transition-all duration-200 rounded-lg hover:bg-indigo-50 group dark:hover:bg-gray-700">
                            <div
                                class="flex-shrink-0 p-3 text-indigo-600 transition-colors bg-indigo-100 rounded-lg group-hover:bg-indigo-200 dark:text-indigo-400 dark:bg-indigo-900/50 dark:group-hover:bg-indigo-800">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0 ml-4">
                                <p class="text-sm font-medium text-gray-900 truncate dark:text-gray-200">
                                    {{ $bill->item }}</p>
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    {{ $bill->created_at->format('d M Y') }}</p>
                            </div>
                            <div class="ml-4 text-right">
                                <p
                                    class="text-sm font-semibold {{ $bill->is_paid ? 'text-green-600 dark:text-green-400' : 'text-amber-500 dark:text-amber-400' }}">
                                    Rp{{ number_format($bill->amount, 0, ',', '.') }}
                                </p>
                                <span
                                    class="inline-flex items-center px-2 py-0.5 mt-1 text-xs font-medium rounded-full {{ $bill->is_paid ? 'bg-green-50 text-green-700 dark:bg-green-900/50 dark:text-green-300' : 'bg-amber-50 text-amber-700 dark:bg-amber-900/50 dark:text-amber-300' }}">
                                    {{ $bill->is_paid ? 'Lunas' : 'Belum Lunas' }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="py-8 text-center">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-12 h-12 mx-auto text-gray-300 dark:text-gray-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                    d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="mt-3 text-sm text-gray-500 dark:text-gray-400">Tidak ada hutang terakhir</p>
                            <a href=""
                                class="inline-flex items-center mt-3 text-sm font-medium text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300">
                                Tambah Hutang Baru
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Recent Savings Card -->
            <div
                class="p-6 transition-shadow duration-300 bg-white border border-gray-100 shadow-sm rounded-xl hover:shadow-md dark:bg-gradient-to-br dark:from-gray-800 dark:to-gray-900 dark:border-gray-700 dark:hover:shadow-lg">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="flex items-center text-lg font-semibold text-gray-800 dark:text-gray-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2 text-indigo-600 dark:text-indigo-400"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Tabungan Terakhir
                    </h3>
                    <a href="{{ route('savings') }}"
                        class="flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300">
                        Lihat Semua
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>

                <div class="space-y-3">
                    @forelse ($savings->take(3) as $saving)
                        <a href="{{ route('savings') }}"
                            class="flex items-center p-4 transition-all duration-200 rounded-lg hover:bg-indigo-50 group dark:hover:bg-gray-700">
                            <div
                                class="flex-shrink-0 p-3 text-indigo-600 transition-colors bg-indigo-100 rounded-lg group-hover:bg-indigo-200 dark:text-indigo-400 dark:bg-indigo-900/50 dark:group-hover:bg-indigo-800">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0 ml-4">
                                <p class="text-sm font-medium text-gray-900 truncate dark:text-gray-200">
                                    {{ $saving->name }}</p>
                                <div class="flex items-center mt-2">
                                    <div class="w-full bg-gray-200 rounded-full h-1.5 dark:bg-gray-700">
                                        @php
                                            $percentage = min(100, ($saving->saving / ($saving->target ?: 1)) * 100);
                                        @endphp
                                        <div class="bg-indigo-600 h-1.5 rounded-full dark:bg-indigo-500"
                                            style="width: {{ $percentage }}%"></div>
                                    </div>
                                    <span
                                        class="ml-2 text-xs font-medium text-gray-500 dark:text-gray-400">{{ round($percentage) }}%</span>
                                </div>
                            </div>
                            <div class="ml-4 text-right">
                                <p class="text-sm font-semibold text-gray-900 dark:text-gray-200">
                                    Rp{{ number_format($saving->saving, 0, ',', '.') }}
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">dari
                                    Rp{{ number_format($saving->target, 0, ',', '.') }}
                                </p>
                            </div>
                        </a>
                    @empty
                        <div class="py-8 text-center">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-12 h-12 mx-auto text-gray-300 dark:text-gray-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                    d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="mt-3 text-sm text-gray-500 dark:text-gray-400">Tidak ada tabungan terakhir</p>
                            <a href=""
                                class="inline-flex items-center mt-3 text-sm font-medium text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300">
                                Buat Tabungan Baru
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Fungsi untuk mengupdate warna chart berdasarkan dark mode
            const updateChartColors = (chart, isDark) => {
                const bgColor = isDark ? 'rgba(31, 41, 55, 0.8)' : 'rgba(255, 255, 255, 0.8)';
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

            // Ambil data dari API
            fetch('/chart-data')
                .then(response => response.json())
                .then(data => {
                    const debtChart = renderDebtChart(data.debt);
                    const savingsChart = renderSavingsChart(data.savings);

                    // Listen untuk perubahan dark mode
                    Alpine.effect(() => {
                        const isDark = Alpine.store('darkMode').on;
                        if (debtChart) updateChartColors(debtChart, isDark);
                        if (savingsChart) updateChartColors(savingsChart, isDark);
                    });
                })
                .catch(error => console.error('Error fetching chart data:', error));

            function renderDebtChart(debtData) {
                const debtTrendCtx = document.getElementById('debtTrendChart').getContext('2d');
                const isDark = Alpine.store('darkMode').on;
                const textColor = isDark ? 'rgba(229, 231, 235, 0.8)' : 'rgba(55, 65, 81, 0.8)';
                const gridColor = isDark ? 'rgba(55, 65, 81, 0.5)' : 'rgba(229, 231, 235, 0.5)';

                return new Chart(debtTrendCtx, {
                    type: 'line',
                    data: {
                        labels: debtData.labels,
                        datasets: [{
                            label: 'Hutang Aktif',
                            data: debtData.active,
                            borderColor: 'rgba(79, 70, 229, 1)',
                            backgroundColor: isDark ? 'rgba(79, 70, 229, 0.2)' :
                                'rgba(79, 70, 229, 0.05)',
                            borderWidth: 2,
                            tension: 0.3,
                            fill: true
                        }, {
                            label: 'Hutang Lunas',
                            data: debtData.paid,
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
                                    label: function(context) {
                                        return context.dataset.label + ': Rp' + context.raw
                                            .toLocaleString('id-ID');
                                    }
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
                                    callback: function(value) {
                                        return 'Rp' + value.toLocaleString('id-ID');
                                    },
                                    color: textColor,
                                    font: {
                                        family: "'Inter', sans-serif"
                                    }
                                }
                            },
                            x: {
                                grid: {
                                    color: gridColor,
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

            function renderSavingsChart(savings) {
                const savingsCtx = document.getElementById('savingsChart').getContext('2d');
                const isDark = Alpine.store('darkMode').on;
                const textColor = isDark ? 'rgba(229, 231, 235, 0.8)' : 'rgba(55, 65, 81, 0.8)';
                const gridColor = isDark ? 'rgba(55, 65, 81, 0.5)' : 'rgba(229, 231, 235, 0.5)';

                return new Chart(savingsCtx, {
                    type: 'bar',
                    data: {
                        labels: savings.map(s => s.name),
                        datasets: [{
                            label: 'Progress',
                            data: savings.map(s => {
                                return s.target > 0 ? Math.min(100, (s.saving / s.target) *
                                    100) : 0;
                            }),
                            backgroundColor: isDark ? 'rgba(79, 70, 229, 0.7)' :
                                'rgba(79, 70, 229, 0.7)',
                            borderColor: isDark ? 'rgba(79, 70, 229, 1)' : 'rgba(79, 70, 229, 1)',
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
                                        const saving = savings[context.dataIndex];
                                        return [
                                            `Terkumpul: Rp${saving.saving.toLocaleString('id-ID')}`,
                                            `Target: Rp${saving.target.toLocaleString('id-ID')}`,
                                            `Progress: ${context.raw}%`
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
                                    callback: function(value) {
                                        return value + '%';
                                    },
                                    color: textColor,
                                    font: {
                                        family: "'Inter', sans-serif"
                                    }
                                }
                            },
                            y: {
                                grid: {
                                    color: gridColor,
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
        });
    </script>
@endsection
