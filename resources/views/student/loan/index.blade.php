<x-layouts.app :title="'Peminjaman Saya'">
    <div class="max-w-7xl mx-auto p-6 space-y-6">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl font-bold text-zinc-800 dark:text-white">Peminjaman Saya</h1>
            <a href="{{ route('loans.create') }}">
                <flux:button variant="primary" class="hover:cursor-pointer">+ Ajukan Peminjaman</flux:button>
            </a>
        </div>

        <div class="flex items-center gap-3 bg-blue-100 text-blue-800 p-3 rounded-md text-sm leading-6">
            <i class="fa-solid fa-circle-exclamation"></i>
            <p>
                Kamu tidak dapat mengajukan peminjaman apabila memiliki lebih dari <strong>2</strong> peminjaman dengan
                status <strong>pending</strong>.
            </p>
        </div>

        @if ($loans->count())
            <div class="overflow-x-auto rounded-t-lg border border-zinc-200 dark:border-zinc-700">
                <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700 text-sm">
                    <thead class="bg-zinc-800 text-left text-zinc-100">
                        <tr>
                            <th class="px-4 py-3 font-semibold">No</th>
                            <th class="px-4 py-3 font-semibold">Tanggal</th>
                            <th class="px-4 py-3 font-semibold">Waktu</th>
                            <th class="px-4 py-3 font-semibold">Barang</th>
                            <th class="px-4 py-3 font-semibold">Status</th>
                            <th class="px-4 py-3 font-semibold text-end"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                        @foreach ($loans as $index => $loan)
                            <tr class="bg-white dark:bg-zinc-900 text-zinc-800 dark:text-zinc-200">
                                <td class="px-4 py-3">
                                    {{ $index + 1 }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($loan->loan_date)->translatedFormat('l, j F Y') }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($loan->start_at)->format('H:i') }} -
                                    {{ \Carbon\Carbon::parse($loan->return_at)->format('H:i') }}
                                </td>
                                <td class="px-4 py-3 space-y-1">
                                    @foreach ($loan->loanItems as $item)
                                        <div>
                                            <span class="font-semibold">{{ $item->item->name }}</span> -
                                            {{ $item->quantity }} pcs
                                            <span
                                                class="italic text-zinc-500">{{ $item->note ? '(' . $item->note . ')' : '' }}</span>
                                        </div>
                                    @endforeach
                                </td>
                                <td class="px-4 py-3">
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
                                    <span
                                        class="inline-block px-3 py-1 rounded-full font-medium text-[13px] {{ $statusColor }}">
                                        {{ ucfirst($loan->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-end whitespace-nowrap space-x-2">
                                    @if ($loan->status === 'approved')
                                        <form action="{{ route('loans.return.request', $loan->id) }}" method="POST" class="inline">
                                            @csrf
                                            <flux:button variant="primary" size="sm" type="submit" class="hover:cursor-pointer">
                                                Kembalikan
                                            </flux:button>
                                        </form>
                                    @endif

                                    @if ($loan->status === 'pending')
                                        <form action="{{ route('loans.edit', $loan->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="bg-amber-100 text-amber-700 rounded-md px-3 py-1 text-sm font-medium">
                                                Edit
                                            </button>
                                        </form>
                                        <form action="{{ route('loans.cancel', $loan->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="bg-red-100 text-red-700 rounded-md px-3 py-1 text-sm font-medium">
                                                Batalkan
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $loans->links() }}
            </div>
        @else
            <div class="text-center text-zinc-500 italic mt-20">
                Belum ada riwayat peminjaman.
            </div>
        @endif
    </div>
</x-layouts.app>
