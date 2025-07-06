@extends('layouts.app')

@section('content')
    <div class="container max-w-6xl px-4 py-8 mx-auto">
        <!-- Header Section -->
        <div class="flex flex-col mb-10 md:flex-row md:items-center md:justify-between">
            <div class="flex-1 min-w-0">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-indigo-400">Celengan Kamu</h1>
                <p class="mt-2 text-gray-600 dark:text-gray-400">Kelola celengan dan raih impian finansialmu</p>
            </div>

            <div class="mt-4 md:mt-0">
                <button type="button" onclick="openModal('create')"
                    class="inline-flex items-center px-4 py-3 text-sm font-medium text-white transition-all bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:bg-indigo-700 dark:hover:bg-indigo-600 dark:focus:ring-indigo-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Tambah Celengan
                </button>
            </div>
        </div>

        <!-- Notifications -->
        <div x-data="{
            showNotification: false,
            message: '',
            isSuccess: false,
            showCongrats: false,
            congratsMessage: ''
        }" x-init="@if (session('success')) showNotification=true; message='{{ session('success') }}'; isSuccess=true; setTimeout(()=>showNotification=false, 3000); @endif
        @if (session('error')) showNotification=true; message='{{ session('error') }}'; isSuccess=false; setTimeout(()=>showNotification=false, 3000); @endif
        @if (session('congrats')) showCongrats=true; congratsMessage='{{ session('congrats') }}'; setTimeout(()=>showCongrats=false, 5000); @endif"
            class="fixed inset-x-0 z-50 flex flex-col items-center gap-4 top-4">

            <!-- Regular Notification -->
            <div x-show="showNotification" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 translate-y-2"
                :class="isSuccess ? 'bg-green-50 text-green-800 dark:bg-green-900 dark:text-green-200' :
                    'bg-red-50 text-red-800 dark:bg-red-900 dark:text-red-200'"
                class="flex items-center justify-between w-full max-w-4xl px-4 py-3 mx-4 text-sm font-medium rounded-lg shadow-sm">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            :d="isSuccess ? 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z' :
                                'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'" />
                    </svg>
                    <span x-text="message"></span>
                </div>
                <button @click="showNotification = false" class="ml-3 text-current hover:opacity-75">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            </div>

            <!-- Congrats Notification -->
            <div x-show="showCongrats" x-transition:enter="transition ease-out duration-800"
                x-transition:enter-start="opacity-0 scale-50 -translate-y-20"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                x-transition:leave-end="opacity-0 scale-95 translate-y-10" x-cloak
                class="relative w-full max-w-4xl px-6 py-4 mx-4 overflow-hidden rounded-lg shadow-lg bg-gradient-to-r from-indigo-500 to-purple-600 animate-gentle-pulse">

                <div class="relative z-10 flex items-center justify-between">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 mr-3 text-yellow-300 animate-spin-bounce"
                            fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.828 1.48 8.279-7.416-3.967-7.417 3.967 1.481-8.279-6.064-5.828 8.332-1.151z" />
                        </svg>

                        <span x-text="congratsMessage"
                            class="overflow-hidden text-xl font-bold text-white animate-typing whitespace-nowrap"></span>
                    </div>

                    <button @click="showCongrats = false"
                        class="p-1 ml-3 text-white transition-all duration-300 rounded-full hover:bg-white/20 hover:scale-110">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>

                <!-- Sparkle Effect -->
                <div class="absolute inset-0 overflow-hidden pointer-events-none">
                    <template x-for="i in 15">
                        <div class="absolute w-2 h-2 rounded-full animate-sparkle"
                            :style="`top: ${Math.random() * 100}%; left: ${Math.random() * 100}%; background-color: hsl(${Math.random() * 360}, 100%, 70%); animation-delay: ${Math.random() * 2}s; transform: scale(${Math.random() * 0.5 + 0.5});`">
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <!-- Savings List -->
        <div
            class="mb-8 overflow-hidden bg-white border border-gray-100 shadow-sm rounded-xl dark:bg-gradient-to-br dark:from-gray-800 dark:to-gray-900 dark:border-gray-700">
            @forelse($savings as $saving)
                <div
                    class="p-6 transition-colors border-b border-gray-100 hover:bg-gray-50/50 dark:border-gray-700 dark:hover:bg-gray-700/50">
                    <div class="flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
                        <!-- Savings Info -->
                        <div class="flex-1 min-w-0 space-y-3">
                            <div class="flex items-center gap-3">
                                <h3 class="text-lg font-semibold text-gray-900 truncate dark:text-white">{{ $saving->name }}
                                </h3>
                                <span
                                    class="px-2.5 py-0.5 text-xs font-medium rounded-full {{ $saving->status ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200' }}">
                                    {{ $saving->status ? 'Selesai' : 'Dalam Proses' }}
                                </span>
                            </div>

                            <!-- Progress Bar -->
                            <div class="space-y-2">
                                <div class="w-full h-2 bg-gray-100 rounded-full dark:bg-gray-700">
                                    @php
                                        $percentage = min(100, ($saving->saving / $saving->target) * 100);
                                    @endphp
                                    <div class="h-2 rounded-full bg-gradient-to-r from-indigo-500 to-indigo-300 dark:from-indigo-400 dark:to-indigo-600"
                                        style="width: {{ $percentage }}%"></div>
                                </div>
                                <div class="flex justify-between text-sm text-gray-600 dark:text-gray-300">
                                    <span>{{ number_format($percentage, 0) }}% tercapai</span>
                                    <span>Rp {{ number_format($saving->saving, 0, ',', '.') }} / Rp
                                        {{ number_format($saving->target, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600 dark:text-gray-400">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="w-4 h-4 mr-1.5 text-indigo-500 dark:text-indigo-400" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span>Target: {{ $saving->target_date }}</span>
                                </div>
                            </div>

                            @if ($saving->description)
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $saving->description }}</p>
                            @endif
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center gap-2">
                            <!-- Deposit Button -->
                            <button onclick="openDepositModal({{ $saving->id }})"
                                class="p-2 text-white transition-colors bg-indigo-500 rounded-lg hover:bg-indigo-600 dark:bg-indigo-600 dark:hover:bg-indigo-500"
                                title="Tambah Dana">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                            </button>

                            <!-- Withdrawal Button -->
                            <button onclick="openWithdrawalModal({{ $saving->id }})"
                                class="p-2 text-white transition-colors rounded-lg bg-amber-500 hover:bg-amber-600 dark:bg-amber-600 dark:hover:bg-amber-500"
                                title="Tarik Dana">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-5 h-5">
                                    <path fill-rule="evenodd"
                                        d="M4.25 12a.75.75 0 0 1 .75-.75h14a.75.75 0 0 1 0 1.5H5a.75.75 0 0 1-.75-.75Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>

                            <!-- Edit Button -->
                            <button
                                onclick="openModal('edit', {{ $saving->id }}, '{{ addslashes($saving->name) }}', {{ $saving->target }}, '{{ $saving->target_date }}', '{{ addslashes($saving->description) }}')"
                                class="p-2 text-white transition-colors bg-gray-500 rounded-lg hover:bg-gray-600 dark:bg-gray-600 dark:hover:bg-gray-500"
                                title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </button>

                            <!-- Delete Button -->
                            <form action="{{ route('savings.destroy', $saving) }}" method="POST"
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus celengan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="p-2 text-white transition-colors bg-red-500 rounded-lg hover:bg-red-600 dark:bg-red-600 dark:hover:bg-red-500"
                                    title="Hapus">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-12 text-center">
                    <div
                        class="flex items-center justify-center w-24 h-24 mx-auto mb-6 rounded-full bg-indigo-50 dark:bg-indigo-900/30">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-indigo-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Belum ada celengan</h3>
                    <p class="mt-2 text-gray-500 dark:text-gray-400">Mulai dengan membuat celengan baru untuk mencapai
                        tujuan finansial Anda.
                    </p>
                    <button type="button" onclick="openModal('create')"
                        class="inline-flex items-center px-4 py-2 mt-6 text-sm font-medium text-white transition-colors bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:bg-indigo-700 dark:hover:bg-indigo-600 dark:focus:ring-indigo-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Tambah celengan
                    </button>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if ($savings->hasPages())
            <div class="mt-8">
                {{ $savings->links() }}
            </div>
        @endif
    </div>

    <!-- Create/Edit Modal -->
    <div id="savingsModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen p-4">
            <!-- Background overlay -->
            <div class="fixed inset-0 transition-opacity bg-gray-500/75 dark:bg-gray-900/80" onclick="closeModal()"></div>

            <!-- Modal content -->
            <div class="relative w-full max-w-md mx-4 overflow-hidden bg-white shadow-2xl rounded-xl dark:bg-gray-800">
                <!-- Modal header -->
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700">
                    <h3 id="modalTitle" class="text-lg font-semibold text-gray-900 dark:text-white">Buat celengan Baru
                    </h3>
                </div>

                <!-- Modal body -->
                <form id="savingsForm" method="POST" action="{{ route('savings.store') }}" class="p-6">
                    @csrf
                    <input type="hidden" id="formMethod" name="_method" value="POST">
                    <input type="hidden" id="savingId" name="id" value="">

                    <div class="space-y-5">
                        <!-- Name -->
                        <div>
                            <label for="name"
                                class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Nama
                                celengan</label>
                            <input type="text" id="name" name="name" required
                                class="w-full px-3 py-2 text-gray-700 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:ring-indigo-500 dark:focus:border-indigo-500"
                                placeholder="Contoh: Liburan ke Bali">
                        </div>

                        <!-- Target Amount -->
                        <div>
                            <label for="target"
                                class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Target
                                Jumlah</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <span class="text-gray-500 dark:text-gray-400">Rp</span>
                                </div>
                                <input type="text" id="target" name="target" required
                                    class="block w-full py-2 pl-10 pr-3 text-gray-700 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:ring-indigo-500 dark:focus:border-indigo-500"
                                    placeholder="5.000.000">
                            </div>
                        </div>

                        <!-- Target Date -->
                        <div>
                            <label for="target_date"
                                class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Target
                                Tanggal</label>
                            <input type="date" id="target_date" name="target_date" required
                                min="{{ date('Y-m-d') }}"
                                class="w-full px-3 py-2 text-gray-700 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:ring-indigo-500 dark:focus:border-indigo-500">
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description"
                                class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Deskripsi
                                (Opsional)</label>
                            <textarea id="description" name="description" rows="3"
                                class="w-full px-3 py-2 text-gray-700 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:ring-indigo-500 dark:focus:border-indigo-500"></textarea>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="flex justify-end gap-3 pt-4 bg-gray-50 dark:bg-transparent">
                        <button type="button" onclick="closeModal()"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-gray-600 dark:text-white dark:border-gray-600 dark:hover:bg-gray-500 dark:focus:ring-indigo-400">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-indigo-700 dark:hover:bg-indigo-600 dark:focus:ring-indigo-400">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Deposit Modal -->
    <div id="depositModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen p-4">
            <!-- Background overlay -->
            <div class="fixed inset-0 transition-opacity bg-gray-500/75 dark:bg-gray-900/80"
                onclick="closeDepositModal()"></div>

            <!-- Modal content -->
            <div class="relative w-full max-w-md mx-4 overflow-hidden bg-white shadow-2xl rounded-xl dark:bg-gray-800">
                <!-- Modal header -->
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Deposit Celengan</h3>
                </div>

                <!-- Modal body -->
                <form id="depositForm" method="POST" action="" class="p-6">
                    @csrf
                    <div class="space-y-5">
                        <!-- Amount -->
                        <div>
                            <label for="amount"
                                class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Jumlah</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <span class="text-gray-500 dark:text-gray-400">Rp</span>
                                </div>
                                <input type="text" id="amount" name="amount" required
                                    class="block w-full py-2 pl-10 pr-3 text-gray-700 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:ring-indigo-500 dark:focus:border-indigo-500"
                                    placeholder="500.000">
                            </div>
                        </div>

                        <!-- Date -->
                        <div>
                            <label for="deposit_date"
                                class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal</label>
                            <input type="date" id="deposit_date" name="date" required max="{{ date('Y-m-d') }}"
                                value="{{ date('Y-m-d') }}"
                                class="w-full px-3 py-2 text-gray-700 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:ring-indigo-500 dark:focus:border-indigo-500">
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="deposit_description"
                                class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Keterangan
                                (Opsional)</label>
                            <textarea id="deposit_description" name="description" rows="2"
                                class="w-full px-3 py-2 text-gray-700 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:ring-indigo-500 dark:focus:border-indigo-500"></textarea>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="flex justify-end gap-3 pt-4 bg-gray-50 dark:bg-transparent">
                        <button type="button" onclick="closeDepositModal()"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-gray-600 dark:text-white dark:border-gray-600 dark:hover:bg-gray-500 dark:focus:ring-indigo-400">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-indigo-700 dark:hover:bg-indigo-600 dark:focus:ring-indigo-400">
                            Tambah Dana
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Withdrawal Modal -->
    <div id="withdrawalModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen p-4">
            <!-- Background overlay -->
            <div class="fixed inset-0 transition-opacity bg-gray-500/75 dark:bg-gray-900/80"
                onclick="closeWithdrawalModal()"></div>

            <!-- Modal content -->
            <div class="relative w-full max-w-md mx-4 overflow-hidden bg-white shadow-2xl rounded-xl dark:bg-gray-800">
                <!-- Modal header -->
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Tarik Dana Celengan</h3>
                </div>

                <!-- Modal body -->
                <form id="withdrawalForm" method="POST" action="" class="p-6">
                    @csrf
                    <div class="space-y-5">
                        <!-- Amount -->
                        <div>
                            <label for="withdrawal_amount"
                                class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Jumlah</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <span class="text-gray-500 dark:text-gray-400">Rp</span>
                                </div>
                                <input type="text" id="withdrawal_amount" name="amount" required
                                    class="block w-full py-2 pl-10 pr-3 text-gray-700 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:ring-indigo-500 dark:focus:border-indigo-500"
                                    placeholder="500.000">
                            </div>
                        </div>

                        <!-- Date -->
                        <div>
                            <label for="withdrawal_date"
                                class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal</label>
                            <input type="date" id="withdrawal_date" name="date" required
                                max="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}"
                                class="w-full px-3 py-2 text-gray-700 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:ring-indigo-500 dark:focus:border-indigo-500">
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="withdrawal_description"
                                class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Keterangan
                                (Opsional)</label>
                            <textarea id="withdrawal_description" name="description" rows="2"
                                class="w-full px-3 py-2 text-gray-700 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:ring-indigo-500 dark:focus:border-indigo-500"></textarea>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="flex justify-end gap-3 pt-4 bg-gray-50 dark:bg-transparent">
                        <button type="button" onclick="closeWithdrawalModal()"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-gray-600 dark:text-white dark:border-gray-600 dark:hover:bg-gray-500 dark:focus:ring-indigo-400">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white border border-transparent rounded-md shadow-sm bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 dark:bg-amber-700 dark:hover:bg-amber-600 dark:focus:ring-amber-400">
                            Tarik Dana
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Format Rupiah functions
            function formatRupiah(value, prefix = '') {
                if (!value) return '';

                // Remove all non-digit characters
                let number_string = value.toString().replace(/[^,\d]/g, '').toString();

                // Split by decimal point if any
                let split = number_string.split(',');
                let sisa = split[0].length % 3;
                let rupiah = split[0].substr(0, sisa);
                let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                // Add dots for thousand separators
                if (ribuan) {
                    let separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                // Combine with decimal part if any
                rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

                return prefix == undefined ? rupiah : (rupiah ? 'Rp ' + rupiah : '');
            }

            function parseRupiah(value) {
                return parseInt(value.replace(/[^0-9]/g, '')) || 0;
            }

            // Setup Rupiah input
            function setupRupiahInput(inputId) {
                const input = document.getElementById(inputId);
                if (input) {
                    // Format on input
                    input.addEventListener('input', function(e) {
                        this.value = formatRupiah(this.value);
                    });

                    // Format on blur (in case user pastes value)
                    input.addEventListener('blur', function(e) {
                        this.value = formatRupiah(this.value);
                    });
                }
            }

            // Modal functions
            function openModal(type, id = null, name = '', target = 0, target_date = '', description = '') {
                const modal = document.getElementById('savingsModal');
                const form = document.getElementById('savingsForm');
                const methodInput = document.getElementById('formMethod');
                const savingIdInput = document.getElementById('savingId');
                const title = document.getElementById('modalTitle');

                if (type === 'create') {
                    title.textContent = 'Buat celengan Baru';
                    form.action = "{{ route('savings.store') }}";
                    methodInput.value = 'POST';
                    savingIdInput.value = '';

                    // Reset form
                    document.getElementById('name').value = '';
                    document.getElementById('target').value = '';
                    document.getElementById('target_date').value = '';
                    document.getElementById('description').value = '';
                } else if (type === 'edit') {
                    title.textContent = 'Edit celengan';
                    form.action = `/savings/${id}`;
                    methodInput.value = 'PUT';
                    savingIdInput.value = id;

                    // Fill form with existing data
                    document.getElementById('name').value = name || '';
                    document.getElementById('target').value = formatRupiah(target);
                    document.getElementById('target_date').value = target_date;
                    document.getElementById('description').value = description || '';
                }

                modal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }

            function closeModal() {
                document.getElementById('savingsModal').classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }

            function openDepositModal(savingId) {
                const modal = document.getElementById('depositModal');
                const form = document.getElementById('depositForm');

                form.action = `/savings/${savingId}/deposit`;
                modal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }

            function closeDepositModal() {
                document.getElementById('depositModal').classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }

            function openWithdrawalModal(savingId) {
                const modal = document.getElementById('withdrawalModal');
                const form = document.getElementById('withdrawalForm');

                form.action = `/savings/${savingId}/withdraw`;
                modal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }

            function closeWithdrawalModal() {
                document.getElementById('withdrawalModal').classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }

            // Form submission handling
            function prepareFormSubmission(formId, amountFieldId) {
                const form = document.getElementById(formId);
                const amountField = document.getElementById(amountFieldId);

                if (form && amountField) {
                    form.addEventListener('submit', function(e) {
                        // Convert Rupiah formatted value back to number
                        const numericValue = parseRupiah(amountField.value);

                        // Create a hidden input with the numeric value
                        const hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.name = amountField.name;
                        hiddenInput.value = numericValue;

                        // Replace the formatted input with numeric value
                        form.appendChild(hiddenInput);
                        amountField.name = '';
                    });
                }
            }

            // Initialize when DOM is loaded
            document.addEventListener('DOMContentLoaded', function() {
                // Setup Rupiah inputs
                setupRupiahInput('target');
                setupRupiahInput('amount');
                setupRupiahInput('withdrawal_amount');

                // Prepare form submissions
                prepareFormSubmission('savingsForm', 'target');
                prepareFormSubmission('depositForm', 'amount');
                prepareFormSubmission('withdrawalForm', 'withdrawal_amount');
            });
        </script>
    @endpush
@endsection
