<x-layouts.app :title="__('Loans List')">
    <div class="flex items-center justify-between mb-4">
        <flux:heading size="xl">Loans Item</flux:heading>
        <div class="flex gap-4 items-center">
            <form method="GET">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search by user name..."
                    class="border rounded px-3 py-1"
                />
            </form>
            <a href="{{route('loans.create')}}" class="px-6 py-2 bg-neutral-800 rounded-lg text-white">Create Loan </a>
        </div>
    </div>

    @foreach ($loans as $loan)
        <div class="border rounded p-4 mb-6 shadow-sm">
            <div class="mb-6 pb-6 border-b border-b-neutral-800 flex justify-between">
                <div class="flex flex-col gap-4">
                    <p><strong>Tanggal Pinjam:</strong> {{ $loan->loan_date }}</p>
                    <p><strong>Waktu Pinjam:</strong> {{ $loan->start_at }} - {{ $loan->return_at }}</p>
                </div>
                <p class="font-medium capitalize px-5 py-2.5 text-neutral-500 bg-neutral-50 h-fit rounded-lg">{{ $loan->status }}</p>
            </div>

            <h3 class="font-semibold mt-4 mb-2">Daftar Barang:</h3>
            @if ($loan->loanItems->count())
                <div class="grid grid-cols-3 gap-4">
                    @foreach ($loan->loanItems as $item)
                        <div class="p-4 flex gap-4 border border-neutral-500">
                            <img src="{{ $item->item->image->file_url }}" class="size-20" alt="">
                            <div>
                                <strong>{{ $item->item->name ?? 'Barang tidak ditemukan' }}</strong> -
                                {{ $item->quantity }} Pcs
                                @if ($item->note)
                                    <br><span class="text-sm text-gray-500 italic">Catatan: {{ $item->note }}</span>
                                @else
                                    <br><span class="text-sm text-gray-500 italic">Catatan: -</span>

                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 italic">Tidak ada barang yang dipinjam.</p>
            @endif
        </div>
    @endforeach
</x-layouts.app>
