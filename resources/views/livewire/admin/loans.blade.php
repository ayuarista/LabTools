<section class="w-full mt-12">
    <div class="p-4">

        @flasher_render

        {{-- Tombol Tambah & Search --}}
        <div class="flex justify-between items-center mb-6">
            <flux:input placeholder="Cari peminjaman..." class="max-w-96" wire:model.live='search' />
        </div>

        {{-- Tabel Data --}}
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr>
                        <th class="bg-neutral-800 text-white p-3 text-left text-sm">No</th>
                        <th class="bg-neutral-800 text-white p-3 text-left text-sm">Nama Peminjam</th>
                        <th class="bg-neutral-800 text-white p-3 text-left text-sm">Jam Pinjam</th>
                        <th class="bg-neutral-800 text-white p-3 text-left text-sm">Jam Kembali</th>
                        <th class="bg-neutral-800 text-white p-3 text-left text-sm">Status</th>
                        <th class="bg-neutral-800 text-white p-3 text-left text-sm"></th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-zinc-900">
                    @forelse($loans as $index => $loan)
                        <tr class="border-b border-gray-200 dark:border-zinc-700">
                            <td class="p-3 text-sm">{{ $index + 1 }}</td>
                            <td class="p-3 text-sm">{{ $loan->user->name }}</td>
                            <td class="p-3 text-sm">{{ $loan->borrowed_at ?? '-' }}</td>
                            <td class="p-3 text-sm">{{ $loan->returned_at ?? '-' }}</td>
                            <td class="p-3 text-sm capitalize">
                                <span class="@if($loan->status === 'approved') text-green-600 @elseif($loan->status === 'pending') text-yellow-600 @else text-gray-600 @endif">
                                    {{ $loan->status }}
                                </span>
                            </td>
                            <td class="p-3 text-sm space-x-2">
                                @if($loan->status === 'pending')
                                    <flux:button size="sm" variant="success" wire:click="approve({{ $loan->id }})">
                                        Approve
                                    </flux:button>
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
