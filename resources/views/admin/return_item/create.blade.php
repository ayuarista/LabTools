<x-admin.layouts.app :title="'Proses Pengembalian'">
    <div class="p-6 max-w-7xl mx-auto space-y-8">
        <flux:heading size="xl" class="mb-4 font-bold">Form Pengembalian</flux:heading>

        <form action="{{ route('admin.return-item.store', $loan->id) }}" method="POST" class="space-y-10">
            @csrf

            <div class="border border-zinc-300 rounded-xl p-6 shadow-sm">
                <flux:input
                    label="Tanggal Pengembalian"
                    type="date"
                    name="return_date"
                    required
                    class="text-base"
                />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach ($loan->loanItems as $index => $loanItem)
                    <div class="border border-zinc-300 rounded-xl p-6 shadow-sm space-y-5"
                         x-data="{
                            condition: 'good',
                            get showPenalty() { return this.condition === 'damaged' || this.condition === 'lost' },
                            get penaltyRequired() { return this.showPenalty }
                         }">

                        {{-- Nama Barang --}}
                        @if ($loanItem->is_late ?? false)
                            <div class="bg-yellow-100 border-l-4 border-yellow-400 text-yellow-800 text-sm p-3 rounded">
                                ⚠️ Pengembalian barang ini terlambat dari waktu yang dijadwalkan.
                            </div>
                        @endif

                        <h3 class="text-lg font-semibold text-zinc-800">
                            {{ $loanItem->item->name }}
                            <span class="text-sm font-normal text-zinc-500">({{ $loanItem->quantity }} pcs)</span>
                        </h3>

                        <div>
                            <label class="block text-sm font-medium text-zinc-700 mb-1">Kondisi Barang</label>
                            <select
                                name="items[{{ $loanItem->item->id }}][conditional]"
                                x-model="condition"
                                required
                                class="w-full border border-zinc-300 rounded-lg px-4 py-2 focus:ring-indigo-500 text-sm">
                                <option value="good">Baik</option>
                                <option value="damaged">Rusak</option>
                                <option value="lost">Hilang</option>
                            </select>
                        </div>

                        <div x-show="true" x-transition>
                            <label class="block text-sm font-medium text-zinc-700 mb-1">Denda (Rp)</label>
                            <input
                                type="number"
                                min="0"
                                :required="penaltyRequired"
                                :disabled="!showPenalty"
                                name="items[{{ $loanItem->item->id }}][penalty]"
                                placeholder="Masukkan nominal denda"
                                class="w-full border border-zinc-300 rounded-lg px-4 py-2 focus:ring-indigo-500 focus:outline-none text-sm"
                                :class="{ 'bg-zinc-100 text-zinc-400': !showPenalty }"
                            />
                        </div>

                        <flux:textarea
                            name="items[{{ $loanItem->item->id }}][note]"
                            label="Catatan (opsional)"
                            placeholder="Contoh: retak, kabel putus, hilang charger"
                            class="text-sm"
                        />
                    </div>
                @endforeach
            </div>

            <div class="text-end pt-4">
                <flux:button type="submit" variant="primary" class="hover:cursor-pointer">
                    Ajukan Pengembalian
                </flux:button>
            </div>
        </form>
    </div>
</x-admin.layouts.app>
