<x-admin.layouts.app :title="'Riwayat Pengembalian'">
    <div class="space-y-6">
        <h2 class="text-2xl font-bold text-zinc-800 dark:text-white tracking-tight">Riwayat Pengembalian</h2>

        @if ($returnedLoans->isEmpty())
            <div class="bg-zinc-50 dark:bg-zinc-800 p-6 text-center text-zinc-500 rounded-xl">
                Belum ada riwayat pengembalian.
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700 border border-zinc-200 dark:border-zinc-700 rounded-lg overflow-hidden">
                    <thead class="bg-zinc-800 text-zinc-100 text-base rounded-t-lg">
                        <tr>
                            <th class="px-4 py-4 text-left font-semibold">Nama Siswa</th>
                            <th class="px-4 py-4 text-left font-semibold">Tanggal Pinjam</th>
                            <th class="px-4 py-4 text-left font-semibold">Barang</th>
                            <th class="px-4 py-4 text-left font-semibold">Kondisi</th>
                            <th class="px-4 py-4 text-left font-semibold">Denda</th>
                            <th class="px-4 py-4 text-left font-semibold">Catatan</th>
                        </tr>
                    </thead>
                    <tbody class="bg-zinc-50 text-zinc-800 text-sm dark:bg-zinc-900 dark:text-white divide-y divide-zinc-200 dark:divide-zinc-700 rounded-b-lg">
                        @foreach ($returnedLoans as $loan)
                            @foreach ($loan->returnItems as $return)
                                <tr>
                                    <td class="px-4 py-3 whitespace-nowrap">{{ $loan->user->name }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($loan->loan_date)->translatedFormat('l, j F Y') }}
                                    </td>
                                    <td class="px-4 py-3">{{ $return->item->name }}</td>
                                    <td class="px-4 py-3">
                                        <span class="font-semibold {{
                                            $return->conditional === 'good' ? 'text-green-600' :
                                            ($return->conditional === 'damaged' ? 'text-yellow-500' : 'text-red-500')
                                        }}">
                                            {{ ucfirst($return->conditional) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        @if ($return->penalty && $return->penalty > 0)
                                            Rp{{ number_format($return->penalty, 0, ',', '.') }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 italic text-sm">
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
