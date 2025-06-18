@extends('layouts.app')

@section('content')
    <!-- Notifikasi -->
    <div x-data="{ showNotification: false, message: '', isSuccess: false }" x-init="@if (session('success')) showNotification=true; message='{{ session('success') }}'; isSuccess=true; setTimeout(()=>showNotification=false, 3000); @endif
    @if (session('error')) showNotification=true; message='{{ session('error') }}'; isSuccess=false; setTimeout(()=>showNotification=false, 3000); @endif" class="fixed inset-x-0 z-50 flex justify-center top-4">
        <div x-show="showNotification" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-2"
            :class="isSuccess ? 'bg-green-50 border border-green-200 text-green-700' :
                'bg-red-50 border border-red-200 text-red-700'"
            class="w-full max-w-md px-4 py-2.5 mx-4 rounded-lg shadow-sm text-sm font-medium">
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

    <div class="mb-8 space-y-6 md:space-y-0 md:grid md:grid-cols-2 md:gap-6">
        <!-- Hutang Belum Lunas -->
        <div class="space-y-3">
            <section class="flex flex-col gap-2 overflow-hidden bg-white border border-gray-100 rounded-lg shadow">
                <div class="flex items-center justify-between px-4 py-3 bg-white border-b">
                    <div>
                        <h1 class="text-lg font-semibold leading-tight text-gray-800">
                            Daftar Hutang
                        </h1>
                        <p class="text-xs font-light">Total: Rp
                            {{ number_format($bills->sum('amount'), '0', ',', '.') }}</p>
                    </div>
                    <button type="button" onclick="openModal('store')"
                        class="px-3 py-1.5 text-xs font-medium text-white bg-blue-500 rounded-md hover:bg-blue-600 transition-colors flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-3.5 h-3.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        <span>Tambah</span>
                    </button>
                </div>

                <div class="divide-y divide-gray-100">
                    @forelse ($bills as $bill)
                        <div class="flex items-center justify-between p-3 transition-colors hover:bg-gray-50/50">
                            <div class="flex-1 min-w-0 pr-2">
                                <div class="flex items-center gap-2">
                                    <h2 class="text-sm font-medium text-gray-800 truncate">{{ $bill->item }}</h2>
                                    <span class="text-xs px-1.5 py-0.5 rounded bg-red-100 text-red-800">Belum Lunas</span>
                                </div>
                                <p class="mt-1 text-xs text-gray-500">{{ $bill->created_at->format('d M Y') }}</p>
                                @if ($bill->description)
                                    <p class="mt-1 text-xs text-gray-600 line-clamp-2">{{ $bill->description }}</p>
                                @endif
                            </div>
                            <div class="flex items-center gap-1.5">
                                <p class="text-sm font-semibold text-indigo-600 whitespace-nowrap">Rp
                                    {{ number_format($bill->amount, 0, ',', '.') }}</p>
                                <div class="flex items-center gap-1">
                                    <button type="button"
                                        onclick="openModal('edit', {{ $bill->id }}, `{{ addslashes($bill->item) }}`, {{ $bill->amount }}, `{{ addslashes($bill->description) }}`)"
                                        class="p-1.5 rounded-full hover:bg-gray-100 text-gray-500 hover:text-yellow-600 transition-colors"
                                        title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                        </svg>
                                    </button>

                                    <form action="{{ route('bills.paid', $bill) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            class="p-1.5 rounded-full hover:bg-gray-100 text-gray-500 hover:text-green-600 transition-colors"
                                            title="Tandai Lunas" {{ $bill->is_paid ? 'disabled' : '' }}>
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M10.125 2.25h-4.5c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125v-9M10.125 2.25h.375a9 9 0 0 1 9 9v.375M10.125 2.25A3.375 3.375 0 0 1 13.5 5.625v1.5c0 .621.504 1.125 1.125 1.125h1.5a3.375 3.375 0 0 1 3.375 3.375M9 15l2.25 2.25L15 12" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="px-4 py-6 text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1"
                                stroke="currentColor" class="w-10 h-10 mx-auto text-gray-400">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                            </svg>
                            <p class="mt-3 text-sm text-gray-500">Tidak ada hutang yang tercatat</p>
                        </div>
                    @endforelse
                </div>

                @if ($bills->hasPages())
                    <div class="px-4 py-3 border-t bg-gray-50">
                        {{ $bills->links('pagination::tailwind') }}
                    </div>
                @endif
            </section>
        </div>

        <!-- Hutang Lunas -->
        <div class="space-y-3">
            <section class="flex flex-col gap-2 overflow-hidden bg-white border border-gray-100 rounded-lg shadow">
                <div class="flex items-center justify-between px-4 py-3 bg-white border-b">
                    <div class="flex flex-col ">
                        <h1 class="text-lg font-semibold leading-tight text-gray-800">Telah Terbayar</h1>
                        <p class="text-xs font-light">Rp {{ number_format($paids->sum('amount'), '0', ',', '.') }}</p>
                    </div>
                </div>

                <div class="divide-y divide-gray-100">
                    @forelse ($paids as $paid)
                        <div class="flex items-center justify-between p-3 transition-colors hover:bg-gray-50/50">
                            <div class="flex-1 min-w-0 pr-2">
                                <div class="flex items-center gap-2">
                                    <h2 class="text-sm font-medium text-gray-800 truncate">{{ $paid->item }}</h2>
                                    <span class="text-xs px-1.5 py-0.5 rounded bg-green-100 text-green-800">Lunas</span>
                                </div>
                                <p class="mt-1 text-xs text-gray-500">Lunas pada {{ $paid->updated_at->format('d M Y') }}
                                </p>
                                @if ($paid->description)
                                    <p class="mt-1 text-xs text-gray-600 line-clamp-2">{{ $paid->description }}</p>
                                @endif
                            </div>
                            <div class="flex items-center gap-1.5">
                                <p class="text-sm font-semibold text-indigo-600 whitespace-nowrap">Rp
                                    {{ number_format($paid->amount, 0, ',', '.') }}</p>
                                <button type="button"
                                    onclick="openModal('edit', {{ $paid->id }}, `{{ addslashes($paid->item) }}`, {{ $paid->amount }}, `{{ addslashes($paid->description) }}`)"
                                    class="p-1.5 rounded-full hover:bg-gray-100 text-gray-500 hover:text-yellow-600 transition-colors"
                                    title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="px-4 py-6 text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1"
                                stroke="currentColor" class="w-10 h-10 mx-auto text-gray-400">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                            </svg>
                            <p class="mt-3 text-sm text-gray-500">Belum ada riwayat dosamu lunas</p>
                        </div>
                    @endforelse
                </div>
                @if ($paids->hasPages())
                    <div class="px-4 py-3 border-t bg-gray-50">
                        {{ $paids->links('pagination::tailwind') }}
                    </div>
                @endif
            </section>
        </div>
    </div>

    <!-- Modal Tambah Hutang -->
    <div id="storeModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div
                class="inline-block w-full max-w-md p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl sm:align-middle sm:max-w-lg">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Tambah Hutang Baru</h3>
                    <button onclick="closeModal()" class="text-gray-400 hover:text-gray-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                    </button>
                </div>
                <form id="storeForm" method="POST" action="{{ route('bills.store') }}">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label for="store_item" class="block text-sm font-medium text-gray-700">Item</label>
                            <input type="text" id="store_item" name="item" required
                                class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                placeholder="Nasi Ayam Goreng">
                        </div>
                        <div>
                            <label for="store_amount" class="block text-sm font-medium text-gray-700">Jumlah</label>
                            <input type="text" id="store_amount" name="amount" required
                                class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                placeholder="Rp 18.000">
                        </div>
                        <div>
                            <label for="store_description" class="block text-sm font-medium text-gray-700">Deskripsi
                                (Opsional)</label>
                            <input type="text" id="store_description" name="description"
                                class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>
                    </div>
                    <div class="flex justify-end mt-6 space-x-3">
                        <button type="button" onclick="closeModal()"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Batal</button>
                        <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Hutang -->
    <div id="editModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div
                class="inline-block w-full max-w-md p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl sm:align-middle sm:max-w-lg">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Edit Hutang</h3>
                    <button onclick="closeModal()" class="text-gray-400 hover:text-gray-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="space-y-4">
                        <div>
                            <label for="edit_item" class="block text-sm font-medium text-gray-700">Item</label>
                            <input type="text" id="edit_item" name="item" required
                                class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>
                        <div>
                            <label for="edit_amount" class="block text-sm font-medium text-gray-700">Jumlah</label>
                            <input type="text" id="edit_amount" name="amount" required
                                class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>
                        <div>
                            <label for="edit_description" class="block text-sm font-medium text-gray-700">Deskripsi
                                (Opsional)</label>
                            <input type="text" id="edit_description" name="description"
                                class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>
                    </div>
                    <div class="flex justify-end mt-6 space-x-3">
                        <button type="button" onclick="closeModal()"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Batal</button>
                        <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Fungsi untuk membuka modal
        function openModal(type, id = null, item = null, amount = null, description = null) {
            if (type === 'store') {
                document.getElementById('storeModal').classList.remove('hidden');
                document.getElementById('store_item').value = '';
                document.getElementById('store_amount').value = '';
                document.getElementById('store_description').value = '';
            } else if (type === 'edit') {
                document.getElementById('editModal').classList.remove('hidden');
                document.getElementById('edit_item').value = item;
                document.getElementById('edit_amount').value = formatRupiah(amount);
                document.getElementById('edit_description').value = description || '';
                document.getElementById('editForm').action = `/bills/${id}`;
            }
            document.body.classList.add('overflow-hidden');
        }

        // Fungsi untuk menutup modal
        function closeModal() {
            document.getElementById('storeModal').classList.add('hidden');
            document.getElementById('editModal').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const storeModal = document.getElementById('storeModal');
            const editModal = document.getElementById('editModal');
            if (event.target === storeModal || event.target === editModal) {
                closeModal();
            }
        }

        // Format Rupiah untuk input amount
        function setupRupiahInput(inputId) {
            const input = document.getElementById(inputId);
            if (input) {
                input.addEventListener('input', function(e) {
                    let value = this.value.replace(/[^0-9]/g, '');
                    if (value.length > 0) {
                        value = parseInt(value, 10);
                        this.value = formatRupiah(value);
                    } else {
                        this.value = '';
                    }
                });
            }
        }

        // Format angka ke Rupiah
        function formatRupiah(angka) {
            if (!angka) return '';
            let number_string = angka.toString();
            let sisa = number_string.length % 3;
            let rupiah = number_string.substr(0, sisa);
            let ribuan = number_string.substr(sisa).match(/\d{3}/g);

            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }
            return 'Rp ' + rupiah;
        }

        // Konversi Rupiah ke numerik sebelum submit
        function setupFormSubmission(formId, amountInputId) {
            const form = document.getElementById(formId);
            if (form) {
                form.addEventListener('submit', function(e) {
                    const amountInput = document.getElementById(amountInputId);
                    const numericValue = amountInput.value.replace(/[^0-9]/g, '');

                    // Buat input sementara untuk nilai numerik
                    const tempInput = document.createElement('input');
                    tempInput.type = 'hidden';
                    tempInput.name = 'amount';
                    tempInput.value = numericValue;
                    this.appendChild(tempInput);

                    // Set nilai asli ke format numerik
                    amountInput.value = numericValue;
                });
            }
        }

        // Inisialisasi saat DOM siap
        document.addEventListener('DOMContentLoaded', function() {
            setupRupiahInput('store_amount');
            setupRupiahInput('edit_amount');
            setupFormSubmission('storeForm', 'store_amount');
            setupFormSubmission('editForm', 'edit_amount');
        });
    </script>
@endsection
