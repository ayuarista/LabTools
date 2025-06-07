<x-layouts.app :title="__('Loans List')">
    <flux:heading size="xl">Items</flux:heading>
    <section class="mt-8">
        <div class="grid grid-cols-4 gap-4 ">
            @forelse($items as $item)
                <div class="bg-neutral-100 p-5 rounded-xl">
                    <img
                            src="{{ $item->image->file_url }}"
                            alt=""
                            class="w-full  object-cover aspect-square rounded-xl"
                    >
                    <div class="mt-4 ">
                        <h2 class="text-lg mb-1 text-neutral-400">{{ $item->name }}</h2>
                        <p class="text-neutral-500 text-base">Stock : {{ $item->quantity }}</p>
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-500 dark:text-gray-400 p-4">
                    No items found.
                </p>
            @endforelse
        </div>
    </section>
</x-layouts.app>
