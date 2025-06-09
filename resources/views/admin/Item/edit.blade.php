<x-admin.layouts.app :title="__('List Items')">
    <flux:heading size="xl">Items</flux:heading>
    <section class="w-full mt-12 ">
        <form action="{{ route('admin.item.update', $item->id) }}" method="POST" enctype="multipart/form-data"
            class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block font-semibold">Nama Item</label>
                <input type="text" name="name" id="name" value="{{ old('name', $item->name) }}"
                    class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring focus:border-blue-300">
            </div>

            <div>
                <label for="description" class="block font-semibold">Deskripsi</label>
                <textarea name="description" id="description" rows="4"
                    class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring focus:border-blue-300">{{ old('description', $item->description) }}</textarea>
            </div>

            <div>
                <label for="quantity" class="block font-semibold">Stok</label>
                <input type="number" name="quantity" id="quantity" min="0"
                    value="{{ old('quantity', $item->quantity) }}"
                    class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring focus:border-blue-300">
            </div>

            <div>
                <label for="image" class="block font-semibold">Gambar</label>
                @if ($item->image)
                    <div class="mb-2">
                        <img src="{{ $item->image->file_url }}" alt="Item Image" class="h-24 rounded">
                    </div>
                @endif
                <input type="file" name="image" id="image"
                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
                        file:rounded-full file:border-0
                        file:text-sm file:font-semibold
                        file:bg-zinc-50 file:text-zinc-800
                        hover:file:bg-zinc-100">
            </div>

            <div class="pt-4">
                <button type="submit"
                    class="bg-zinc-800 text-white px-6 py-2 rounded hover:bg-zinc-900 transition">Perbarui</button>
                <a href="{{ route('admin.item.index') }}" class="ml-4 text-gray-600 hover:underline">Batal</a>
            </div>
        </form>
    </section>
</x-admin.layouts.app>
