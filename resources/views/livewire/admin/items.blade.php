<section class="w-full mt-12">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-4">
        <flux:input placeholder="Search items..." class="w-full sm:max-w-96" wire:model.live='search' />

        <a href="{{ route('admin.item.create') }}"
            class="px-4 py-2.5 bg-neutral-800 flex items-center text-white text-sm gap-3 font-medium rounded-md">
            <x-heroicon-o-plus class="size-4" />
            Add Item
        </a>
    </div>

    <div class="overflow-x-auto rounded-lg border border-zinc-200 dark:border-zinc-700">
        <table class="min-w-full text-sm text-left divide-y divide-zinc-200 dark:divide-zinc-700">
            <thead class="bg-neutral-800 text-white">
                <tr>
                    <th class="p-4">No</th>
                    <th class="p-4">Image</th>
                    <th class="p-4">Name</th>
                    <th class="p-4">Description</th>
                    <th class="p-4">Quantity</th>
                    <th class="p-4 text-center">Action</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-zinc-900 divide-y divide-zinc-200 dark:divide-zinc-700">
                @php $i = 1; @endphp
                @forelse($items as $index => $item)
                    <tr>
                        <td class="p-4">{{ $i }}</td>
                        <td class="p-4">
                            <img src="{{ $item->image->file_url }}" alt="{{ $item->name }}"
                                class="size-16 rounded object-cover" />
                        </td>
                        <td class="p-4">{{ $item->name }}</td>
                        <td class="p-4">{{ Str::limit($item->description, 30) }}</td>
                        <td class="p-4">{{ $item->quantity }}</td>
                        <td class="p-4 text-center">
                            <div class="flex justify-center flex-wrap gap-2">
                                <a href="{{ route('admin.item.edit', $item->id) }}"
                                    class="bg-amber-100 text-amber-700 rounded-md px-3 py-1 text-sm font-medium">Edit</a>
                                <form action="{{ route('admin.item.destroy', $item->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus item ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-100 text-red-700 rounded-md px-3 py-1 text-sm font-medium">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @php $i++; @endphp
                @empty
                    <tr>
                        <td colspan="6" class="p-4 text-center text-zinc-500 italic">
                            Tidak ada data barang.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>