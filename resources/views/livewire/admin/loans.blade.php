<section class="w-full">
    <div class="p-4 space-y-6">

        <h2 class="text-2xl font-bold text-zinc-800 dark:text-white tracking-tight">
            Daftar Peminjaman
        </h2>

        <div class="overflow-x-auto rounded-t-lg border border-zinc-200 dark:border-zinc-700">
            <table class="min-w-full text-sm border-collapse divide-y divide-zinc-200 dark:divide-zinc-700">
                <thead class="bg-neutral-800 text-white">
                    <tr>
                        <th class="p-3 text-left">No</th>
                        <th class="p-3 text-left">Nama</th>
                        <th class="p-3 text-left">NIS</th>
                        <th class="p-3 text-left">Kelas</th>
                        <th class="p-3 text-left">Jurusan</th>
                        <th class="p-3 text-left">Barang</th>
                        <th class="p-3 text-left">Jam Pinjam</th>
                        <th class="p-3 text-left">Jam Mengembalikan</th>
                        <th class="p-3 text-left">Status</th>
                        <th class="p-3 text-left"></th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-zinc-900 divide-y divide-zinc-200 dark:divide-zinc-700">
                    @forelse($loans as $index => $loan)
                        <tr>
                            <td class="p-3">{{ $index + 1 }}</td>
                            <td class="p-3 font-semibold">{{ $loan->user->name }}</td>
                            <td class="p-3">{{ $loan->user->profile?->nis ?? '-' }}</td>
                            <td class="p-3">{{ $loan->user->profile?->kelas ?? '-' }}</td>
                            <td class="p-3">{{ $loan->user->profile?->jurusan ?? '-' }}</td>
                            <td class="p-3">
                                <ul class="space-y-1">
                                    @foreach ($loan->loanItems as $loanItem)
                                        <li class="flex items-center gap-2">
                                            <span class="font-medium">{{ $loanItem->item->name }}</span>
                                            <span class="text-sm">(x{{ $loanItem->quantity }})</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="p-3">
                                {{ \Carbon\Carbon::parse($loan->start_at)->format('H:i') ?? '-' }}
                            </td>
                            <td class="p-3">
                                {{ \Carbon\Carbon::parse($loan->return_at)->format('H:i') ?? '-' }}
                            </td>
                            <td class="p-3 capitalize">
                                @php
                                    $statusColor = match ($loan->status) {
                                        'approved' => 'bg-green-100 text-green-800',
                                        'returned' => 'bg-yellow-100 text-yellow-700',
                                        'rejected' => 'bg-red-100 text-red-800',
                                        'canceled' => 'bg-red-100 text-red-800',
                                        'request return' => 'bg-sky-100 text-sky-700',
                                        default => 'bg-gray-200 text-gray-600',
                                    };
                                @endphp
                                <span class="px-3 py-1 rounded-md font-medium {{ $statusColor }}">
                                    {{ ucfirst($loan->status) }}
                                </span>
                            </td>
                            <td class="p-3 space-y-2 sm:space-x-2 sm:space-y-0 sm:flex sm:items-center">
                                @if ($loan->status === 'pending')
                                    <flux:button size="sm" variant="primary" class="hover:cursor-pointer"
                                        wire:click="approve({{ $loan->id }})">
                                        Approve
                                    </flux:button>
                                    <button
                                        class="text-red-700 bg-red-200 p-1.5 px-5 font-medium rounded-md hover:bg-red-300 transition"
                                        wire:click="reject({{ $loan->id }})">
                                        Reject
                                    </button>
                                @else
                                    <span class="text-gray-400 text-sm">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="p-4 text-center text-gray-500 dark:text-gray-400">
                                Tidak ada data peminjaman.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>