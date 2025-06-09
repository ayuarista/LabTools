<x-admin.layouts.app :title="'Daftar Pengembalian'">
    <div class="max-w-7xl mx-auto px-6 py-8 space-y-12">

        <div>
            <h2 class="text-2xl font-bold text-zinc-800 dark:text-white mb-6 tracking-tight">
                Menunggu Pengembalian
            </h2>

            @if ($waitingLoans->isEmpty())
                <div class="bg-zinc-50 dark:bg-zinc-800 p-6 text-center border border-gray-300 text-zinc-500 rounded-xl">
                    Tidak ada pengajuan pengembalian saat ini.
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    @foreach ($waitingLoans as $loan)
                        <div class="rounded-2xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 p-5 transition hover:shadow-xl">
                            <div class="mb-3">
                                <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">
                                    {{ $loan->user->name }}
                                </h3>
                                <p class="text-sm text-zinc-500 dark:text-zinc-400">
                                    Tanggal Pinjam: {{ $loan->loan_date }}
                                </p>
                            </div>

                            <p class="text-sm text-zinc-600 dark:text-zinc-300 mb-4">
                                Jumlah Barang: <span class="font-medium">{{ $loan->loanItems->count() }}</span>
                            </p>

                            <a href="{{ route('admin.return-item.create', $loan->id) }}">
                                <flux:button size="sm" variant="primary" class="hover:cursor-pointer">
                                    Proses Pengembalian
                                </flux:button>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div>
            <h2 class="text-2xl font-bold text-zinc-800 dark:text-white mb-6 tracking-tight">
                Riwayat Pengembalian
            </h2>

            @if ($returnedLoans->isEmpty())
                <div class="bg-zinc-50 dark:bg-zinc-800 p-6 text-center text-zinc-500 rounded-xl">
                    Belum ada riwayat pengembalian.
                </div>
            @else
                <div class="space-y-6">
                    @foreach ($returnedLoans as $loan)
                        <div class="bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-6">
                            <div class="mb-2">
                                <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">
                                    {{ $loan->user->name }}
                                </h3>
                                <p class="text-sm text-zinc-500 dark:text-zinc-400">
                                    Tanggal Pinjam: {{ $loan->loan_date }}
                                </p>
                            </div>

                            <ul class="mt-4 space-y-2 text-sm">
                                @foreach ($loan->returnItems as $return)
                                    <li class="flex items-start justify-between bg-zinc-100 dark:bg-zinc-800 rounded-lg px-4 py-2">
                                        <div class="text-zinc-800 dark:text-zinc-100">
                                            <span class="font-semibold">{{ $return->item->name }}</span>
                                            — kondisi:
                                            <span class="font-semibold {{ $return->conditional == 'good' ? 'text-green-600 dark:text-green-400' : ($return->conditional == 'damaged' ? 'text-yellow-500' : 'text-red-500') }}">
                                                {{ ucfirst($return->conditional) }}
                                            </span>

                                            @if ($return->penalty && $return->penalty > 0)
                                                <span class="ml-2 text-red-600 font-medium">
                                                    • Denda: Rp{{ number_format($return->penalty, 0, ',', '.') }}
                                                </span>
                                            @endif

                                            @if ($return->note)
                                                <p class="text-zinc-500 dark:text-zinc-400 mt-1 italic">
                                                    "Catatan: {{ $return->note }}"
                                                </p>
                                            @endif
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>
</x-admin.layouts.app>
