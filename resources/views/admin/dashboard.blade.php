<x-admin.layouts.app :title="'Dashboard Admin'" :page="'admin-dashboard'">
    <h1 class="text-2xl font-semibold text-zinc-800 dark:text-white mb-6">
        Hi, {{ auth()->user()->name }} 👋 Selamat datang di Dashboard Admin!
    </h1>

    <div class="flex flex-col gap-6">

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            <a href="/admin/loans" class="group flex items-center bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl p-5 transition hover:bg-zinc-50 dark:hover:bg-zinc-800">
                <div class="p-3 bg-indigo-100 dark:bg-indigo-800 rounded-full">
                    <i class="fa-solid fa-book-open text-indigo-600 dark:text-indigo-300 text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-1 group-hover:text-zinc-700 dark:group-hover:text-zinc-200">
                        Total Peminjaman
                    </p>
                    <p class="text-2xl font-bold text-zinc-800 dark:text-white">{{ $totalLoans }}</p>
                </div>
            </a>

            <a href="/admin/return-item" class="group flex items-center bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl p-5 transition hover:bg-zinc-50 dark:hover:bg-zinc-800">
                <div class="p-3 bg-yellow-100 dark:bg-yellow-800 rounded-full">
                    <i class="fa-solid fa-clock text-yellow-600 text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-1 group-hover:text-zinc-700 dark:group-hover:text-zinc-200">
                        Menunggu Pengembalian
                    </p>
                    <p class="text-[22px] font-bold text-yellow-600">{{ $pendingReturns }}</p>
                </div>
            </a>

            <a href="/admin/item" class="group flex items-center bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl p-5 transition hover:bg-zinc-50 dark:hover:bg-zinc-800">
                <div class="p-3 bg-indigo-50 dark:bg-indigo-900 rounded-full">
                    <i class="fa-solid fa-box-open text-indigo-600 dark:text-indigo-300 text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-1 group-hover:text-zinc-700 dark:group-hover:text-zinc-200">
                        Barang Terdaftar
                    </p>
                    <p class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">{{ $totalItems }}</p>
                </div>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl p-6 transition hover:bg-zinc-50 dark:hover:bg-zinc-800">
                <h2 class="flex items-center text-base font-semibold text-zinc-800 dark:text-white mb-4">
                    <i class="fa-solid fa-chart-line text-emerald-500 dark:text-zinc-300 mr-2"></i>
                    Aktivitas Terakhir
                </h2>
                <ul class="text-sm space-y-3">
                    @forelse ($recentLoans as $loan)
                        <li class="flex items-start">
                            <i class="fa-solid fa-user text-emerald-500 mt-1"></i>
                            <span class="ml-2 text-zinc-700 dark:text-zinc-300">
                                <span class="font-medium">{{ $loan->user->name }}</span>
                                meminjam <span class="font-semibold">{{ $loan->loanItems->count() }}</span> barang pada
                                <span class="text-zinc-500">{{ \Carbon\Carbon::parse($loan->loan_date)->translatedFormat('l, j F Y') }}</span>
                            </span>
                        </li>
                    @empty
                        <li class="text-zinc-500">Belum ada aktivitas terbaru.</li>
                    @endforelse
                </ul>
            </div>

            <div class="bg-white dark:bg-zinc-900 border border-red-300 dark:border-red-600 rounded-xl p-6 transition hover:bg-red-50 dark:hover:bg-red-800">
                <h2 class="flex items-center text-base font-semibold text-red-600 dark:text-red-400 mb-4">
                    <i class="fa-solid fa-exclamation-triangle mr-2"></i>
                    Peminjaman Terlambat
                </h2>
                <ul class="text-sm space-y-3 text-red-700 dark:text-red-300">
                    @forelse ($lateLoans as $loan)
                        <li class="flex items-start">
                            <i class="fa-solid fa-clock mt-1"></i>
                            <span class="ml-2">
                                <span class="font-medium">{{ $loan->user->name }}</span> terlambat mengembalikan sejak
                                <span>{{ \Carbon\Carbon::parse($loan->loan_date)->translatedFormat('l, j F Y') }}</span>
                            </span>
                        </li>
                    @empty
                        <li class="text-zinc-500">Tidak ada keterlambatan saat ini.</li>
                    @endforelse
                </ul>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl p-6 transition hover:bg-zinc-50 dark:hover:bg-zinc-800">
                <h2 class="flex items-center text-base font-semibold text-zinc-800 dark:text-white mb-4">
                    <i class="fa-solid fa-trophy text-yellow-600 mr-2"></i>
                    Leaderboard Peminjam
                </h2>
                <ol class="list-decimal list-inside space-y-2 text-sm text-zinc-700 dark:text-zinc-300">
                    @forelse ($topUsers as $user)
                        <li>
                            {{ $user->name }} — <span class="text-zinc-500">{{ $user->total_loans }}x peminjaman</span>
                        </li>
                    @empty
                        <li>Belum ada data pengguna.</li>
                    @endforelse
                </ol>
            </div>

            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl p-6 transition hover:bg-zinc-50 dark:hover:bg-zinc-800">
                <h2 class="flex items-center text-base font-semibold text-zinc-800 dark:text-white mb-4">
                    <i class="fa-solid fa-boxes text-indigo-600 mr-2"></i>
                    Barang Paling Sering Dipinjam
                </h2>
                <ol class="list-decimal list-inside space-y-2 text-sm text-zinc-700 dark:text-zinc-300">
                    @forelse ($topItems as $item)
                        <li>
                            {{ $item->name }} — <span class="text-zinc-500">{{ $item->total_borrowed }}x dipinjam</span>
                        </li>
                    @empty
                        <li>Belum ada data barang.</li>
                    @endforelse
                </ol>
            </div>
        </div>

        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl p-6 transition hover:bg-zinc-50 dark:hover:bg-zinc-800">
            <h2 class="text-base font-semibold text-zinc-800 dark:text-white mb-4">
                Peminjaman 7 Hari Terakhir
            </h2>
            <canvas id="loanChart" class="w-full h-32"></canvas>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('loanChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($loanChartLabels) !!},
                datasets: [{
                    label: 'Jumlah Peminjaman',
                    data: {!! json_encode($loanChartData) !!},
                    borderColor: '#6366F1',
                    backgroundColor: 'rgba(99, 102, 241, 0.1)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, ticks: { stepSize: 1 } }
                }
            }
        });
    </script>
</x-admin.layouts.app>
