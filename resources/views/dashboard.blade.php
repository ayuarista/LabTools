<x-layouts.app :title="__('Dashboard')">
    <div class="space-y-6 max-w-7xl mx-auto p-4">

        <h1 class="text-2xl font-semibold text-zinc-800 dark:text-white">
            Hai, {{ auth()->user()->name }}! 👋 Selamat datang kembali.
        </h1>

        @if ($activeLoans > 0)
            <div
                class="bg-yellow-100 border-l-4 border-yellow-500 p-4 rounded text-sm text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                <i class="fas fa-exclamation-circle mr-2"></i> Kamu masih memiliki <strong>{{ $activeLoans }}</strong>
                peminjaman aktif. Jangan lupa dikembalikan tepat waktu ya!
            </div>
        @endif
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl p-5">
                <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-1 flex items-center gap-2">
                    <i class="fas fa-book-reader text-indigo-500"></i> Total Peminjaman
                </p>
                <p class="text-2xl font-bold text-zinc-800 dark:text-white">{{ $totalLoans }}</p>
            </div>

            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl p-5">
                <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-1 flex items-center gap-2">
                    <i class="fas fa-hourglass-half text-yellow-600"></i> Masih Dipinjam
                </p>
                <p class="text-2xl font-bold text-yellow-600">{{ $activeLoans }}</p>
            </div>

            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl p-5">
                <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-1 flex items-center gap-2">
                    <i class="fas fa-box-open text-indigo-600"></i> Total Barang Dipinjam
                </p>
                <p class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">{{ $totalItemsBorrowed }}</p>
            </div>

            <div
                class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl p-5 flex items-center justify-center">
                <a href="{{ route('loans.create') }}"
                    class="text-sm font-medium text-indigo-600 hover:underline dark:text-indigo-400">
                    <i class="fas fa-plus mr-1"></i> Ajukan Peminjaman Baru
                </a>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl p-6">
                <h2 class="text-base font-semibold text-zinc-800 dark:text-white mb-3">Riwayat Peminjaman Terbaru</h2>
                <ul class="text-sm space-y-3">
                    @forelse ($recentLoans as $loan)
                        <li class="text-zinc-700 dark:text-zinc-300">
                            <i class="fas fa-calendar-day text-indigo-500 mr-2"></i>
                            <span class="font-medium">{{ $loan->loanItems->count() }} barang</span> dipinjam pada
                            <span
                                class="text-zinc-500">{{ \Carbon\Carbon::parse($loan->loan_date)->translatedFormat('l, j F Y') }}</span>
                            <p class="font-medium">Status: {{ ucfirst($loan->status) }}</p>
                        </li>
                    @empty
                        <li class="text-zinc-500">Belum ada riwayat peminjaman.</li>
                    @endforelse
                </ul>
            </div>
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl p-6">
                <h2 class="text-base font-semibold text-zinc-800 dark:text-white mb-3">Histori Pengembalian Barang</h2>
                <ul class="text-sm space-y-3">
                    @forelse ($returnedItems as $return)
                        <li class="text-zinc-700 dark:text-zinc-300">
                            <i class="fas fa-undo-alt text-green-500 mr-2"></i>
                            {{ $return->item->name }} —
                            <span
                                class="text-zinc-500">{{ \Carbon\Carbon::parse($return->return_date)->translatedFormat('l, j F Y') }}</span>
                            (Kondisi: <span class="font-medium">{{ ucfirst($return->conditional) }}</span>
                            @if ($return->penalty > 0)
                                , Denda: Rp{{ number_format($return->penalty, 0, ',', '.') }}
                            @endif
                            @if ($return->note)
                                , Catatan: {{ $return->note }}
                            @endif)
                        </li>
                    @empty
                        <li class="text-zinc-500">Belum ada barang yang dikembalikan.</li>
                    @endforelse
                </ul>
            </div>

        </div>

    </div>
</x-layouts.app>
