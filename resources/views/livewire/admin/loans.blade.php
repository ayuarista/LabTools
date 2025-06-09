<section class="w-full">
    <div class="p-4">


        <div class="flex justify-between items-center mb-6">
            <flux:input placeholder="Cari berdasarkan nama pengguna..." class="max-w-96" wire:model.live='search' />
        </div>
        <h2 class="text-2xl font-bold text-zinc-800 dark:text-white mb-6 tracking-tight">
            Daftar Peminjaman
        </h2>
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr>
                        <th class="bg-neutral-800 text-white p-3 text-left text-sm">No</th>
                        <th class="bg-neutral-800 text-white p-3 text-left text-sm">Nama</th>
                        <th class="bg-neutral-800 text-white p-3 text-left text-sm">Barang</th>
                        <th class="bg-neutral-800 text-white p-3 text-left text-sm">Jam Pinjam</th>
                        <th class="bg-neutral-800 text-white p-3 text-left text-sm">Jam Mengembalikan</th>
                        <th class="bg-neutral-800 text-white p-3 text-left text-sm">Status</th>
                        <th class="bg-neutral-800 text-white p-3 text-left text-sm"></th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-zinc-900">
                    @forelse($loans as $index => $loan)
                        <tr class="border-b border-gray-200 dark:border-zinc-700">
                            <td class="p-3 text-sm">{{ $index + 1 }}</td>
                            <td class="p-3 text-sm">{{ $loan->user->name }}</td>
                            <td class="p-3 text-sm">
                                <ul class="space-y-1">
                                    @foreach ($loan->loanItems as $loanItem)
                                        <li class="flex items-center space-x-2">
                                            <span class="font-medium">{{ $loanItem->item->name }}</span>
                                            <span class="text-sm">
                                                (x{{ $loanItem->quantity }})
                                            </span>
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="p-3 text-sm">{{ \Carbon\Carbon::parse($loan->start_at)->format('H:i') ?? '-' }}
                            </td>
                            <td class="p-3 text-sm">{{ \Carbon\Carbon::parse($loan->return_at)->format('H:i') ?? '-' }}
                            </td>
                            <td class="p-3 text-sm capitalize">
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
                                <span class="px-3 py-1 rounded-md text-sm font-medium {{ $statusColor }}">
                                    {{ ucfirst($loan->status) }}
                                </span>
                            </td>

                            <td class="p-3 text-sm space-x-2">
                                @if ($loan->status === 'pending')
                                    <flux:button size="sm" variant="primary" class="hover:cursor-pointer"
                                        wire:click="approve({{ $loan->id }})">
                                        Approve
                                    </flux:button>
                                    <button
                                        class="text-red-700 bg-red-200 p-1.5 px-5 font-medium rounded-md hover:cursor-pointer hover:bg-red-300 transition-all duration-200"
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
                            <td colspan="6" class="p-4 text-center text-gray-500 dark:text-gray-400">
                                Tidak ada data peminjaman.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>
