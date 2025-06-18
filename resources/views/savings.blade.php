@extends('layouts.app')

@section('content')
    <div class="container">
        <!-- Header Section -->
        <div class="flex flex-col gap-3 mb-8 md:flex-row md:items-center md:justify-between">
            <div class="flex-1 min-w-0">
                <h1 class="text-2xl font-bold text-gray-900 sm:text-3xl">Celengan Kamu</h1>
                <p class="mt-1 text-sm text-gray-500 sm:mt-2 sm:text-base">Kelola celengan dan raih impian finansialmu</p>
            </div>

            <div class="flex-shrink-0">
                <button type="button" onclick="openModal('create')"
                    class="flex items-center justify-center w-full px-4 py-2.5 text-sm font-medium text-white transition-all bg-blue-600 rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 sm:w-auto sm:text-base">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2 -ml-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Tambah Celengan
                </button>
            </div>
        </div>

        <!-- Notifikasi -->
        <div x-data="{ showNotification: false, message: '', isSuccess: false }" x-init="@if (session('success')) showNotification=true; message='{{ session('success') }}'; isSuccess=true; setTimeout(()=>showNotification=false, 3000); @endif
        @if (session('error')) showNotification=true; message='{{ session('error') }}'; isSuccess=false; setTimeout(()=>showNotification=false, 3000); @endif" class="fixed inset-x-0 z-50 flex justify-center top-4">
            <div x-show="showNotification" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 translate-y-2"
                :class="isSuccess ? 'bg-green-50 border border-green-200 text-green-700' :
                    'bg-red-50 border border-red-200 text-red-700'"
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

        <!-- Savings List -->
        <div class="mb-8 overflow-hidden bg-white border border-gray-200 shadow-sm rounded-xl">
            @forelse($savings as $saving)
                <div class="p-5 transition-colors border-b border-gray-200 hover:bg-gray-50">
                    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                        <!-- Savings Info -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-3 mb-2">
                                <h3 class="text-lg font-semibold text-gray-800 truncate">{{ $saving->name }}</h3>
                                <span
                                    class="px-2.5 py-0.5 text-xs font-medium rounded-full {{ $saving->status == 'completed' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                    {{ $saving->status == 'completed' ? 'Selesai' : 'Dalam Proses' }}
                                </span>
                            </div>

                            <!-- Progress Bar -->
                            <div class="w-full bg-gray-200 rounded-full h-2.5 mb-3">
                                @php
                                    $percentage = min(100, ($saving->saving / $saving->target) * 100);
                                @endphp
                                <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $percentage }}%"></div>
                            </div>

                            <div class="flex flex-wrap items-center text-sm text-gray-600 gap-x-4 gap-y-2">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>Tercapai: Rp {{ number_format($saving->saving, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                    </svg>
                                    <span>Target: Rp {{ number_format($saving->target, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span>Target: {{ $saving->target_date }}</span>
                                </div>
                            </div>

                            @if ($saving->description)
                                <p class="mt-3 text-sm text-gray-600">{{ $saving->description }}</p>
                            @endif
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center gap-2">
                            <!-- Deposit Button -->
                            <button onclick="openDepositModal({{ $saving->id }})"
                                class="p-2 text-green-600 transition-colors rounded-lg bg-green-50 hover:bg-green-100"
                                title="Tambah Dana">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                            </button>

                            <!-- Withdrawal Button -->
                            <button onclick="openWithdrawalModal({{ $saving->id }})"
                                class="p-2 text-yellow-600 transition-colors rounded-lg bg-yellow-50 hover:bg-yellow-100"
                                title="Tarik Dana">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="size-5">
                                    <path fill-rule="evenodd"
                                        d="M4.25 12a.75.75 0 0 1 .75-.75h14a.75.75 0 0 1 0 1.5H5a.75.75 0 0 1-.75-.75Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>

                            <!-- Edit Button -->
                            <button
                                onclick="openModal('edit', {{ $saving->id }}, '{{ addslashes($saving->name) }}', {{ $saving->target }}, '{{ $saving->target_date }}', '{{ addslashes($saving->description) }}')"
                                class="p-2 text-blue-600 transition-colors rounded-lg bg-blue-50 hover:bg-blue-100"
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
                                    class="p-2 text-red-600 transition-colors rounded-lg bg-red-50 hover:bg-red-100"
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
                <div class="p-8 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 mx-auto text-gray-400" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">Belum ada celengan</h3>
                    <p class="mt-1 text-gray-500">Mulai dengan membuat celengan baru untuk mencapai tujuan finansial Anda.
                    </p>
                    <button type="button" onclick="openModal('create')"
                        class="inline-flex items-center px-4 py-2 mt-4 text-white transition-colors bg-blue-600 rounded-lg shadow-sm hover:bg-blue-700">
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
            <div class="mt-6">
                {{ $savings->links() }}
            </div>
        @endif
    </div>

    <!-- Create/Edit Modal -->
    <div id="savingsModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen p-4">
            <!-- Background overlay -->
            <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" onclick="closeModal()"></div>

            <!-- Modal content -->
            <div class="relative w-full max-w-md mx-4 bg-white rounded-lg shadow-xl">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 border-b">
                    <h3 id="modalTitle" class="text-lg font-semibold text-gray-900">Buat celengan Baru</h3>
                    <button type="button" onclick="closeModal()" class="text-gray-400 hover:text-gray-500">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Modal body -->
                <form id="savingsForm" method="POST" action="{{ route('savings.store') }}" class="p-4">
                    @csrf
                    <input type="hidden" id="formMethod" name="_method" value="POST">
                    <input type="hidden" id="savingId" name="id" value="">

                    <div class="space-y-4">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block mb-1 text-sm font-medium text-gray-700">Nama
                                celengan</label>
                            <input type="text" id="name" name="name" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Contoh: Liburan ke Bali">
                        </div>

                        <!-- Target Amount -->
                        <div>
                            <label for="target" class="block mb-1 text-sm font-medium text-gray-700">Target
                                Jumlah</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <span class="text-gray-500">Rp</span>
                                </div>
                                <input type="text" id="target" name="target" required
                                    class="block w-full py-2 pl-10 pr-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="5.000.000">
                            </div>
                        </div>

                        <!-- Target Date -->
                        <div>
                            <label for="target_date" class="block mb-1 text-sm font-medium text-gray-700">Target
                                Tanggal</label>
                            <input type="date" id="target_date" name="target_date" required
                                min="{{ date('Y-m-d') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block mb-1 text-sm font-medium text-gray-700">Deskripsi
                                (Opsional)</label>
                            <textarea id="description" name="description" rows="3"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="flex justify-end gap-3 mt-6">
                        <button type="button" onclick="closeModal()"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
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
            <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" onclick="closeDepositModal()"></div>

            <!-- Modal content -->
            <div class="relative w-full max-w-md mx-4 bg-white rounded-lg shadow-xl">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 border-b">
                    <h3 class="text-lg font-semibold text-gray-900">Deposit Celengan</h3>
                    <button type="button" onclick="closeDepositModal()" class="text-gray-400 hover:text-gray-500">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Modal body -->
                <form id="depositForm" method="POST" action="" class="p-4">
                    @csrf
                    <div class="space-y-4">
                        <!-- Amount -->
                        <div>
                            <label for="amount" class="block mb-1 text-sm font-medium text-gray-700">Jumlah</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <span class="text-gray-500">Rp</span>
                                </div>
                                <input type="text" id="amount" name="amount" required
                                    class="block w-full py-2 pl-10 pr-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="500.000">
                            </div>
                        </div>

                        <!-- Date -->
                        <div>
                            <label for="deposit_date" class="block mb-1 text-sm font-medium text-gray-700">Tanggal</label>
                            <input type="date" id="deposit_date" name="date" required max="{{ date('Y-m-d') }}"
                                value="{{ date('Y-m-d') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="deposit_description"
                                class="block mb-1 text-sm font-medium text-gray-700">Keterangan (Opsional)</label>
                            <textarea id="deposit_description" name="description" rows="2"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="flex justify-end gap-3 mt-6">
                        <button type="button" onclick="closeDepositModal()"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
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
            <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" onclick="closeWithdrawalModal()">
            </div>

            <!-- Modal content -->
            <div class="relative w-full max-w-md mx-4 bg-white rounded-lg shadow-xl">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 border-b">
                    <h3 class="text-lg font-semibold text-gray-900">Tarik Dana Celengan</h3>
                    <button type="button" onclick="closeWithdrawalModal()" class="text-gray-400 hover:text-gray-500">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Modal body -->
                <form id="withdrawalForm" method="POST" action="" class="p-4">
                    @csrf
                    <div class="space-y-4">
                        <!-- Amount -->
                        <div>
                            <label for="withdrawal_amount"
                                class="block mb-1 text-sm font-medium text-gray-700">Jumlah</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <span class="text-gray-500">Rp</span>
                                </div>
                                <input type="text" id="withdrawal_amount" name="amount" required
                                    class="block w-full py-2 pl-10 pr-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="500.000">
                            </div>
                        </div>

                        <!-- Date -->
                        <div>
                            <label for="withdrawal_date"
                                class="block mb-1 text-sm font-medium text-gray-700">Tanggal</label>
                            <input type="date" id="withdrawal_date" name="date" required
                                max="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="withdrawal_description"
                                class="block mb-1 text-sm font-medium text-gray-700">Keterangan (Opsional)</label>
                            <textarea id="withdrawal_description" name="description" rows="2"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="flex justify-end gap-3 mt-6">
                        <button type="button" onclick="closeWithdrawalModal()"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-yellow-600 border border-transparent rounded-md shadow-sm hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                            Tarik Dana
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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
@endsection
