<section class="w-full mt-12 ">
    <div class="flex justify-between items-center mb-4">
        <flux:input placeholder="Search items..." class="max-w-96" wire:model.live='search' />
        <a href="{{ route('admin.item.create') }}"
            class="px-4 py-2.5 bg-neutral-800 flex items-center text-white text-sm gap-3 font-medium">
            <span>
                <x-heroicon-o-plus class="size-4" />
            </span>
            Add Item
        </a>
    </div>
    <table class="w-full">
        <thead>
            <tr>
                <th class="bg-neutral-800 text-white p-4 text-sm text-start">No</th>
                <th class="bg-neutral-800 text-white p-4 text-sm text-start">Image</th>
                <th class="bg-neutral-800 text-white p-4 text-sm text-start">Name</th>
                <th class="bg-neutral-800 text-white p-4 text-sm text-start">Description</th>
                <th class="bg-neutral-800 text-white p-4 text-sm text-start">Quantity</th>
                <th class="bg-neutral-800 text-white p-4 text-sm text-start"></th>
            </tr>
        </thead>
        <tbody>

            @php
                $i = 1;
            @endphp
            @forelse($items as $index => $item)
                <tr class="p-2 border">
                    <td class="p-4">{{ $i }}</td>
                    <td class="p-4">
                        <img src=" {{ $item->image->file_url }}" alt="" class="size-16 rounded">
                    </td>
                    <td class="p-4 ">{{ $item->name }}</td>
                    <td class="p-4">{{ Str::limit($item->description, 20) }}</td>
                    <td class="p-4">{{ $item->quantity }}</td>
                    <td class="p-4  ">
                        <div class="flex items-center gap-4">

                            <a href="{{ route('admin.item.edit', $item->id) }}"
                                class="px-4 py-2 text-sm bg-amber-500 text-white rounded-xl ">Edit</a>
                            <form action="{{ route('admin.item.destroy', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="px-4 py-2 text-sm bg-red-500 text-white rounded-xl ">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @php
                    $i++;
                @endphp
            @empty
                <tr class=" border">
                    <td colspan="5" class="text-center text-gray-500 dark:text-gray-400 p-4">
                        No items found.
                    </td>
                </tr>
            @endforelse

        </tbody>
    </table>
</section>
