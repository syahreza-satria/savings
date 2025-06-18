@extends('layouts.app')

@section('content')
    <div class="space-y-4">
        <!-- Daftar Hutang Section -->
        <section class="p-4 bg-white border border-gray-100 shadow-sm rounded-xl">
            <div class="flex items-center justify-between mb-3">
                <div class="flex flex-col">
                    <h1 class="text-lg font-semibold text-gray-800">Daftar Hutang</h1>
                    @if ($bills->where('is_paid', false)->isNotEmpty())
                        <p class="text-xs">Total: <span
                                class="text-indigo-500">{{ number_format($bills->sum('amount'), '0', ',', '.') }}</span>
                        </p>
                    @endif
                </div>
                <a href="{{ route('bills') }}"
                    class="flex items-center text-sm text-blue-500 transition-colors hover:text-blue-600 {{ $bills->empty() ? 'block' : 'hidden' }}">
                    Lihat Semua
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
            <hr>

            <div class="divide-y divide-gray-100">
                @forelse ($bills as $bill)
                    <div class="flex items-center justify-between py-3 transition-colors group hover:bg-gray-50/50">
                        <div class="flex-grow pr-2">
                            <h3 class="text-sm font-medium text-gray-800">{{ $bill->item }}</h3>
                            <p class="mt-1 text-xs text-gray-500">{{ $bill->created_at->format('d M Y') }}</p>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="flex items-center gap-1 transition-opacity opacity-0 group-hover:opacity-100">
                                <button
                                    class="p-1.5 rounded-full hover:bg-gray-100 text-gray-500 hover:text-yellow-500 transition-colors">
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
                                        class="p-1.5 rounded-full hover:bg-gray-100 text-gray-500 hover:text-green-500 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M10.125 2.25h-4.5c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125v-9M10.125 2.25h.375a9 9 0 0 1 9 9v.375M10.125 2.25A3.375 3.375 0 0 1 13.5 5.625v1.5c0 .621.504 1.125 1.125 1.125h1.5a3.375 3.375 0 0 1 3.375 3.375M9 15l2.25 2.25L15 12" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                            <span class="text-sm font-medium text-indigo-600 whitespace-nowrap">
                                Rp {{ number_format($bill->amount, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="py-4 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="mx-auto leading-relaxed text-indigo-500 size-16">
                            <path fill-rule="evenodd"
                                d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-2.625 6c-.54 0-.828.419-.936.634a1.96 1.96 0 0 0-.189.866c0 .298.059.605.189.866.108.215.395.634.936.634.54 0 .828-.419.936-.634.13-.26.189-.568.189-.866 0-.298-.059-.605-.189-.866-.108-.215-.395-.634-.936-.634Zm4.314.634c.108-.215.395-.634.936-.634.54 0 .828.419.936.634.13.26.189.568.189.866 0 .298-.059.605-.189.866-.108.215-.395.634-.936.634-.54 0-.828-.419-.936-.634a1.96 1.96 0 0 1-.189-.866c0-.298.059-.605.189-.866Zm2.023 6.828a.75.75 0 1 0-1.06-1.06 3.75 3.75 0 0 1-5.304 0 .75.75 0 0 0-1.06 1.06 5.25 5.25 0 0 0 7.424 0Z"
                                clip-rule="evenodd" />
                        </svg>
                        <p class="mt-2 text-sm text-gray-500">Yeay, Kamu tidak memiliki hutang apapun!</p>
                    </div>
                @endforelse
            </div>
        </section>

        <!-- Tabungan Section -->
        <section class="p-4 bg-white border border-gray-100 shadow-sm rounded-xl">
            <div class="flex items-center justify-between">
                <h1 class="mb-3 text-lg font-semibold text-gray-800">Tabungan Kamu</h1>
                <a href="{{ route('savings') }}"
                    class="flex items-center text-sm transition duration-300 text-sky-500 hover:text-sky-700">
                    Lihat Semua
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

            <div class="space-y-3">
                @forelse($savings as $saving)
                    <a href="#"
                        class="flex items-center justify-between p-3 transition-colors rounded-lg hover:bg-gray-50/50">
                        <div class="flex items-center gap-3">
                            <div class="flex items-center justify-center w-10 h-10 bg-blue-100 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-800">{{ $saving->name }}</h3>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-xs text-gray-500">Tercapai: Rp
                                        {{ number_format($saving->saving, 0, ',', '.') }}</span>
                                    <span class="text-xs text-gray-400">•</span>
                                    <span class="text-xs text-gray-500">Target: Rp
                                        {{ number_format($saving->target, 0, ',', '.') }}</span>
                                </div>
                                <div class="w-full mt-1 bg-gray-200 rounded-full h-1.5">
                                    @php
                                        $percentage = min(100, ($saving->saving / $saving->target) * 100);
                                    @endphp
                                    <div class="bg-blue-600 h-1.5 rounded-full" style="width: {{ $percentage }}%"></div>
                                </div>
                            </div>
                        </div>
                        <span
                            class="text-sm font-medium {{ $saving->status == 'completed' ? 'text-green-600' : 'text-blue-600' }} whitespace-nowrap">
                            {{ $saving->status == 'completed' ? 'Selesai' : round($percentage) }}%
                        </span>
                    </a>
                @empty
                    <div class="py-4 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="mx-auto leading-relaxed size-16 text-emerald-500">
                            <path d="M12 7.5a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5Z" />
                            <path fill-rule="evenodd"
                                d="M1.5 4.875C1.5 3.839 2.34 3 3.375 3h17.25c1.035 0 1.875.84 1.875 1.875v9.75c0 1.036-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 0 1 1.5 14.625v-9.75ZM8.25 9.75a3.75 3.75 0 1 1 7.5 0 3.75 3.75 0 0 1-7.5 0ZM18.75 9a.75.75 0 0 0-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 0 0 .75-.75V9.75a.75.75 0 0 0-.75-.75h-.008ZM4.5 9.75A.75.75 0 0 1 5.25 9h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H5.25a.75.75 0 0 1-.75-.75V9.75Z"
                                clip-rule="evenodd" />
                            <path
                                d="M2.25 18a.75.75 0 0 0 0 1.5c5.4 0 10.63.722 15.6 2.075 1.19.324 2.4-.558 2.4-1.82V18.75a.75.75 0 0 0-.75-.75H2.25Z" />
                        </svg>
                        <p class="mt-2 text-sm text-gray-500">Kamu belum memulai celengan apapun</p>
                    </div>
                @endforelse
            </div>
        </section>
    </div>
@endsection
