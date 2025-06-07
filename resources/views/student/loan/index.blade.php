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

    <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-100">
            <tr class="text-left text-gray-600 uppercase tracking-wider">
                <th class="px-4 py-2">Item</th>
                <th class="px-4 py-2">Loan Date</th>
                <th class="px-4 py-2">Return Date</th>
                <th class="px-4 py-2">Status</th>
                <th class="px-4 py-2">Qty</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($loans as $loan)
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-4 py-2">{{ $loan->loanItem->name }}</td>
                    <td class="px-4 py-2">{{ $loan->loan_date }}</td>
                    <td class="px-4 py-2">{{ $loan->return_date }}</td>
                    <td class="px-4 py-2">
                        @php
                            $statusColors = [
                                'pending' => 'bg-yellow-100 text-yellow-800',
                                'approved' => 'bg-green-100 text-green-800',
                                'returned' => 'bg-blue-100 text-blue-800',
                                'rejected' => 'bg-red-100 text-red-800',
                            ];
                        @endphp
                        <span class="px-2 py-1 rounded text-xs font-semibold {{ $statusColors[$loan->status] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ ucfirst($loan->status) }}
                            </span>
                    </td>
                    <td class="px-4 py-2">{{ $loan->quantity }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-4 py-4 text-center text-gray-500">No loan data found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</x-layouts.app>
