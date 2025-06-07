<x-layouts.app :title="__('Create Loan')">
    <form action="{{ route('loans.store') }}" method="POST" class="space-y-6">
        @csrf

        <div>
            <label for="loan_date" class="block text-sm font-medium text-gray-700">Loan Date</label>
            <input type="date" name="loan_date" id="loan_date"
                   class="mt-1 block w-full border rounded px-3 py-2" required>
        </div>

        <div>
            <label for="return_date" class="block text-sm font-medium text-gray-700">Return Date</label>
            <input type="date" name="return_date" id="return_date"
                   class="mt-1 block w-full border rounded px-3 py-2" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Items to Borrow</label>
            <div class="space-y-4 mt-2">
                @foreach ($items as $item)
                <div class="flex items-center space-x-4">
                    <input type="checkbox" name="items[{{ $item->id }}][selected]" value="1"
                           class="rounded text-indigo-600 border-gray-300 focus:ring-indigo-500">
                    <span class="w-40">{{ $item->name }}</span>
                    <input type="number" name="items[{{ $item->id }}][quantity]"
                           placeholder="Quantity"
                           min="1"
                           class="w-24 border rounded px-2 py-1"
                    >
                </div>
                @endforeach
            </div>
        </div>

        <button type="submit"
                class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
            Submit Loan Request
        </button>
    </form>
</x-layouts.app>
