<x-layouts.app :title="'Daftar Barang'">
    <div class="max-w-7xl mx-auto px-6 py-10 space-y-8">

        <h1 class="text-2xl font-bold text-zinc-800">Barang yang Tersedia</h1>

        @if($items->isEmpty())
            <p class="text-center text-zinc-500 italic py-10">
                Belum ada barang yang tersedia saat ini.
            </p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($items as $item)
                    <div class="bg-white border border-zinc-200 rounded-xl shadow-sm hover:shadow-md transition p-4 flex flex-col">
                        <div class="aspect-square overflow-hidden rounded-lg bg-zinc-100">
                            <img src="{{ $item->image->file_url }}" alt="Foto {{ $item->name }}"
                                 class="w-full h-full object-cover transition hover:scale-105 duration-300">
                        </div>

                        <div class="mt-4 space-y-2">
                            <h2 class="text-lg font-semibold text-zinc-800">{{ $item->name }}</h2>
                            <p class="text-sm text-zinc-600 leading-snug line-clamp-3">{{ $item->description }}</p>
                            <p class="text-sm font-medium text-zinc-700">Stok tersedia: {{ $item->quantity }} pcs</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
</x-layouts.app>
