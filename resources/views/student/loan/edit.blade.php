<x-layouts.app :title="'Edit Peminjaman'">
    <form action="{{ route('loans.update', $loan->id) }}" method="POST" class="space-y-6 mx-auto px-4">
        @csrf
        @method('PATCH')

        <h2 class="text-2xl font-semibold text-zinc-800 dark:text-white">Formulir Edit Peminjaman</h2>

        {{-- Tanggal --}}
        <div>
            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                <span class="text-red-500">*</span> Tanggal Peminjaman
            </label>
            <input type="date" name="loan_date" value="{{ $loan->loan_date }}"
                   class="w-full border rounded px-4 py-2 focus:ring focus:ring-indigo-300" required>
        </div>

        {{-- Jam Mulai dan Jam Kembali --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="start_at" class="block text-sm font-medium text-zinc-700 mb-1">Jam Mulai
                    Meminjam<span class="text-red-500">*</span></label>
                <input type="time" name="start_at" id="start_at" value="{{ $loan->start_at }}"
                    class="w-full border border-zinc-300 rounded-lg px-4 py-2 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
                    required>
            </div>

            <div>
                <label for="return_at" class="block text-sm font-medium text-zinc-700 mb-1">Jam Mengembalikan<span
                        class="text-red-500">*</span></label>
                <input type="time" name="return_at" id="return_at" value="{{ $loan->return_at }}"
                    class="w-full border border-zinc-300 rounded-lg px-4 py-2 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
                    required>
            </div>
        </div>

        <div class="bg-yellow-100 text-yellow-800 text-sm p-3 rounded flex items-start gap-2">
            <i class="fas fa-info-circle mt-0.5"></i>
            <p>Kamu bisa memilih 1–2 jenis barang, dan setiap barang boleh dipinjam 1–2 pcs.</p>
        </div>

        {{-- Barang --}}
        <div class="space-y-5">
            @foreach ($items as $item)
                @php
                    $loaned = $loan->loanItems->firstWhere('item_id', $item->id);
                @endphp
                <div class="p-4 border rounded-xl flex flex-col gap-2">
                    <label class="flex items-center gap-3 font-medium">
                        <input type="checkbox" name="items[{{ $item->id }}][selected]" value="1"
                            class="w-4 h-4 text-indigo-600 border-gray-300 rounded"
                            @checked($loaned)>
                        {{ $item->name }} (stock: {{ $item->quantity }})
                    </label>

                    <input type="number" name="items[{{ $item->id }}][quantity]"
                           value="{{ old("items.$item->id.quantity", $loaned->quantity ?? '') }}"
                           placeholder="Jumlah"
                           min="1" max="2"
                           class="w-32 border rounded px-3 py-1 text-sm">

                    <textarea name="items[{{ $item->id }}][notes]" rows="2"
                              class="w-full border rounded px-3 py-2 text-sm"
                              placeholder="Catatan (opsional)"
                    >{{ old("items.$item->id.notes", $loaned->note ?? '') }}</textarea>
                </div>
            @endforeach
        </div>

        <div class="text-end">
            <flux:button type="submit"
                    variant="primary"
                    class="hover:cursor-pointer">
                Simpan Perubahan
            </flux:button>
        </div>
    </form>
</x-layouts.app>
