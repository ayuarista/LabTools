<x-layouts.app :title="__('Dashboard')">
    <div class="space-y-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

        <h1 class="text-2xl font-semibold text-zinc-800 dark:text-white break-words whitespace-normal leading-snug">
    Hai, {{ auth()->user()->name }}! 👋 Selamat datang kembali.
</h1>


        @if ($activeLoans > 0)
            <div
                class="bg-yellow-100 border-l-4 border-yellow-500 p-4 rounded text-sm text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 flex items-start gap-2">
                <i class="fas fa-exclamation-circle mt-0.5"></i>
                <span>
                    Kamu masih memiliki <strong>{{ $activeLoans }}</strong> peminjaman aktif.
                    Jangan lupa dikembalikan tepat waktu ya!
                </span>
            </div>
        @endif

        {{-- Kartu Statistik --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl p-5 shadow-sm">
                <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-1 flex items-center gap-2">
                    <i class="fas fa-book-reader text-indigo-500"></i> Total Peminjaman
                </p>
                <p class="text-2xl font-bold text-zinc-800 dark:text-white">{{ $totalLoans }}</p>
            </div>

            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl p-5 shadow-sm">
                <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-1 flex items-center gap-2">
                    <i class="fas fa-hourglass-half text-yellow-600"></i> Masih Dipinjam
                </p>
                <p class="text-2xl font-bold text-yellow-600">{{ $activeLoans }}</p>
            </div>

            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl p-5 shadow-sm">
                <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-1 flex items-center gap-2">
                    <i class="fas fa-box-open text-indigo-600"></i> Total Barang Dipinjam
                </p>
                <p class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">{{ $totalItemsBorrowed }}</p>
            </div>

            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl p-5 flex items-center justify-center shadow-sm">
                <a href="{{ route('loans.create') }}"
                    class="text-sm font-medium text-indigo-600 hover:underline dark:text-indigo-400">
                    <i class="fas fa-plus mr-1"></i> Ajukan Peminjaman Baru
                </a>
            </div>
        </div>

        {{-- Riwayat --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Riwayat Peminjaman --}}
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl p-6 shadow-sm">
                <h2 class="text-base font-semibold text-zinc-800 dark:text-white mb-4">Riwayat Peminjaman Terbaru</h2>
                <ul class="text-sm space-y-4">
                    @forelse ($recentLoans as $loan)
                        <li class="text-zinc-700 dark:text-zinc-300">
                            <i class="fas fa-calendar-day text-indigo-500 mr-2"></i>
                            <span class="font-medium">{{ $loan->loanItems->count() }} barang</span> dipinjam pada
                            <span class="text-zinc-500">{{ \Carbon\Carbon::parse($loan->loan_date)->translatedFormat('l, j F Y') }}</span>
                            <div class="font-medium">Status: {{ ucfirst($loan->status) }}</div>
                        </li>
                    @empty
                        <li class="text-zinc-500">Belum ada riwayat peminjaman.</li>
                    @endforelse
                </ul>
            </div>

            {{-- Histori Pengembalian --}}
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl p-6 shadow-sm">
                <h2 class="text-base font-semibold text-zinc-800 dark:text-white mb-4">Histori Pengembalian Barang</h2>
                <ul class="text-sm space-y-4">
                    @forelse ($returnedItems as $return)
                        <li class="text-zinc-700 dark:text-zinc-300">
                            <i class="fas fa-undo-alt text-green-500 mr-2"></i>
                            {{ $return->item->name }} —
                            <span class="text-zinc-500">
                                {{ \Carbon\Carbon::parse($return->return_date)->translatedFormat('l, j F Y') }}
                            </span>
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
