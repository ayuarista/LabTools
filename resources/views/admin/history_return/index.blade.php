<x-admin.layouts.app :title="'Riwayat Pengembalian'">
    <div class="space-y-6">
        <h2 class="text-2xl font-bold text-zinc-800 dark:text-white tracking-tight">Riwayat Pengembalian</h2>

        @if ($returnedLoans->isEmpty())
            <div class="bg-zinc-50 dark:bg-zinc-800 p-6 text-center text-zinc-500 rounded-xl">
                Belum ada riwayat pengembalian.
            </div>
        @else
            <div class="overflow-x-auto rounded-lg border border-zinc-200 dark:border-zinc-700">
                <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700 text-sm">
                    <thead class="bg-zinc-800 text-zinc-100">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold whitespace-nowrap">No</th>
                            <th class="px-4 py-3 text-left font-semibold whitespace-nowrap">Nama</th>
                            <th class="px-4 py-3 text-left font-semibold whitespace-nowrap">NIS</th>
                            <th class="px-4 py-3 text-left font-semibold whitespace-nowrap">Kelas</th>
                            <th class="px-4 py-3 text-left font-semibold whitespace-nowrap">Tanggal Pinjam</th>
                            <th class="px-4 py-3 text-left font-semibold whitespace-nowrap">Barang</th>
                            <th class="px-4 py-3 text-left font-semibold whitespace-nowrap">Kondisi</th>
                            <th class="px-4 py-3 text-left font-semibold whitespace-nowrap">Denda</th>
                            <th class="px-4 py-3 text-left font-semibold whitespace-nowrap">Catatan</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-zinc-900 divide-y divide-zinc-200 dark:divide-zinc-700 text-zinc-800 dark:text-white">
                        @foreach ($returnedLoans as $index => $loan)
                            @foreach ($loan->returnItems as $return)
                                <tr>
                                    <td class="px-4 py-3 whitespace-nowrap">{{ $index + 1 }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap">{{ $loan->user->name }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap">{{ $loan->user->profile->nis ?? '-' }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap">{{ $loan->user->profile->kelas ?? '-' }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($loan->loan_date)->translatedFormat('l, j F Y') }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">{{ $return->item->name }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span class="font-semibold {{
                                            $return->conditional === 'good' ? 'text-green-600' :
                                            ($return->conditional === 'damaged' ? 'text-yellow-500' : 'text-red-500')
                                        }}">
                                            {{ ucfirst($return->conditional) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        @if ($return->penalty && $return->penalty > 0)
                                            Rp{{ number_format($return->penalty, 0, ',', '.') }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap italic">
                                        {{ $return->note ?? '-' }}
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-admin.layouts.app>