<x-admin.layouts.app :title="__('List Items')">
    <flux:heading size="xl">Items</flux:heading>
    <section class="w-full mt-12 ">
        <form action="{{ route('admin.item.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div>
                <label for="name" class="block font-semibold">Nama Item</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}"
                    class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring focus:border-blue-300">
            </div>

            <div>
                <label for="description" class="block font-semibold">Deskripsi</label>
                <textarea name="description" id="description" rows="4"
                    class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring focus:border-blue-300">{{ old('description') }}</textarea>
            </div>

            <div>
                <label for="stock" class="block font-semibold">Stok</label>
                <input type="number" name="stock" id="stock" min="0" value="{{ old('stock') }}"
                    class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:outline-none focus:ring focus:border-blue-300">
            </div>

            <div>
                <label for="image" class="block font-semibold">Upload Gambar (opsional)</label>
                <input type="file" name="image" id="image"
                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
                        file:rounded-full file:border-0
                        file:text-sm file:font-semibold
                        file:bg-zinc-50 file:text-zinc-800
                        hover:file:bg-zinc-100">
            </div>

            <div class="pt-4">
                <button type="submit"
                    class="bg-zinc-800 text-white px-6 py-2 rounded hover:bg-zinc-900 transition">Simpan</button>
                <a href="{{ route('admin.item.index') }}" class="ml-4 text-gray-600 hover:underline">Kembali</a>
            </div>
        </form>

    </section>
</x-admin.layouts.app>
