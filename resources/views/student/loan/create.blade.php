<x-layouts.app :title="'Buat Peminjaman'">
    <div class=" mx-auto p-8 bg-white text-zinc-800 space-y-6">

        <h1 class="text-2xl font-bold tracking-tight">Formulir Peminjaman Barang</h1>

        <form action="{{ route('loans.store') }}" method="POST" class="space-y-8">
            @csrf

            <div>
                <label for="loan_date" class="block text-sm font-medium text-zinc-700 mb-1">Tanggal Peminjaman<span
                        class="text-red-500">*</span></label>
                <input type="date" name="loan_date" id="loan_date"
                    class="w-full border border-zinc-300 rounded-lg px-4 py-2 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
                    required>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="start_at" class="block text-sm font-medium text-zinc-700 mb-1">Jam Mulai
                        Meminjam<span class="text-red-500">*</span></label>
                    <input type="time" name="start_at" id="start_at"
                        class="w-full border border-zinc-300 rounded-lg px-4 py-2 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
                        required>
                </div>

                <div>
                    <label for="return_at" class="block text-sm font-medium text-zinc-700 mb-1">Jam Mengembalikan<span
                            class="text-red-500">*</span></label>
                    <input type="time" name="return_at" id="return_at"
                        class="w-full border border-zinc-300 rounded-lg px-4 py-2 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
                        required>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-zinc-700 mb-2">Barang yang Dipinjam<span
                        class="text-red-500">*</span></label>

                <div class="space-y-6">
                    <div class="flex items-start gap-3 bg-blue-100 text-blue-800 p-3 rounded-md text-sm leading-6">
                        <i class="fa-solid fa-circle-exclamation mt-1"></i>
                        <p>
                            Kamu bisa memilih 1–2 jenis barang, dan setiap barang boleh dipinjam 1–2 pcs.
                        </p>
                    </div>
                    @foreach ($items as $item)
                        <div class="flex items-start space-x-4 bg-zinc-50 border border-zinc-200 rounded-xl p-4">
                            <input type="checkbox" name="items[{{ $item->id }}][selected]" value="1"
                                class="mt-1 h-5 w-5 text-indigo-600 focus:ring-indigo-500 rounded border-zinc-300">

                            <div class="flex-1 space-y-2">
                                <div class="flex flex-wrap items-center gap-4">
                                    <span class="min-w-[120px] font-medium">{{ $item->name }} (stock:
                                        {{ $item->quantity }})</span>
                                    <input type="number" name="items[{{ $item->id }}][quantity]"
                                        placeholder="Jumlah" min="1"
                                        class="w-24 border border-zinc-300 rounded px-3 py-1 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500">
                                </div>

                                <textarea name="items[{{ $item->id }}][notes]" rows="1"
                                    class="w-full border border-zinc-300 rounded px-3 py-2 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500"
                                    placeholder="Catatan (opsional)"></textarea>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="text-end">
                <flux:button type="submit" variant="primary" class="hover:cursor-pointer">
                    Ajukan Peminjaman
                </flux:button>
            </div>
        </form>
    </div>
</x-layouts.app>
