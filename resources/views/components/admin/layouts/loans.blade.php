<x-admin.layouts.app :title="__('Loan Management')">
    <h1 class="text-2xl font-medium">Loan Management</h1>
    <div
        class="flex justify-between items-center mt-3 border border-zinc-200 dark:border-zinc-400 rounded-lg p-3 bg-zinc-100 dark:bg-zinc-900">
        <form action="{{ url()->current() }}" method="get" class="max-w-sm">
            <flux:input.group>
                <flux:input icon="magnifying-glass" placeholder="Search loans..." name="search"
                    value="{{ request('search') }}" />
                <flux:select class="max-w-fit" name="order">
                    <flux:select.option value="book" selected>Book</flux:select.option>
                    <flux:select.option value="user">User</flux:select.option>
                    <flux:select.option value="admin">Admin</flux:select.option>
                </flux:select>
            </flux:input.group>
        </form>
        <div class="flex gap-3">
            <flux:dropdown>
                <flux:button icon:trailing="chevron-down">Options</flux:button>

                <flux:menu>
                    <flux:menu.submenu heading="Sort by">
                        <flux:menu.radio.group>
                            <flux:menu.radio checked>Name</flux:menu.radio>
                            <flux:menu.radio>Date</flux:menu.radio>
                            <flux:menu.radio>Popularity</flux:menu.radio>
                        </flux:menu.radio.group>
                    </flux:menu.submenu>

                    <flux:menu.submenu heading="Status Filter">
                        <flux:menu.checkbox checked>Borrowed</flux:menu.checkbox>
                        <flux:menu.checkbox>Returned</flux:menu.checkbox>
                        <flux:menu.checkbox>Overdue</flux:menu.checkbox>
                    </flux:menu.submenu>
                </flux:menu>
            </flux:dropdown>
            <flux:button variant="primary" icon="plus" as="a" href="/admin/loans/create">Loan</flux:button>
        </div>
    </div>
    <div class="my-5">
        <div
            class="relative flex items-center gap-3 w-fit border border-b-0 border-zinc-200 dark:border-zinc-400 rounded-t-lg px-2 pb-1 bg-zinc-100 dark:bg-zinc-900">
            <a href="/admin/loans"
                class="{{ request()->is('admin/loans') ? 'text-black dark:text-white border-b-2 dark:border-white border-black' : 'text-zinc-500 hover:text-zinc-300' }} font-medium p-3"
                wire:navigate>List</a>
            <a href="/admin/loans/borrowing"
                class="{{ request()->is('admin/loans/borrowing') ? 'text-black dark:text-white border-b-2 dark:border-white border-black' : 'text-zinc-500 hover:text-zinc-300' }} font-medium p-3"
                wire:navigate>Borrowing <flux:badge size="sm" color="blue">
                    {{ App\Models\Loan::borrowed()->count() }}
                </flux:badge></a>
            <a href="/admin/loans/overdue"
                class="{{ request()->is('admin/loans/overdue') ? 'text-black dark:text-white border-b-2 dark:border-white border-black' : 'text-zinc-500 hover:text-zinc-300' }} font-medium p-3"
                wire:navigate>Overdue <flux:badge size="sm" color="red">{{ App\Models\Loan::overdue()->count() }}
                </flux:badge></a>
            <a href="/admin/loans/returning"
                class="{{ request()->is('admin/loans/returning') ? 'text-black dark:text-white border-b-2 dark:border-white border-black' : 'text-zinc-500 hover:text-zinc-300' }} font-medium p-3"
                wire:navigate>Returning <flux:badge size="sm" color="yellow">
                    {{ App\Models\Loan::returning()->count() }}
                </flux:badge></a>
            <a href="/admin/loans/history"
                class="{{ request()->is('admin/loans/history') ? 'text-black dark:text-white border-b-2 dark:border-white border-black' : 'text-zinc-500 hover:text-zinc-300' }} font-medium p-3"
                wire:navigate>History</a>
            <div class="bg-zinc-100 dark:bg-zinc-900 h-0.5 w-full absolute bottom-0 left-0"></div>
        </div>
        <div
            class="border border-zinc-200 dark:border-zinc-400 rounded-b-lg rounded-e-lg bg-zinc-100 dark:bg-zinc-900 -mt-[1px]">
            {{ $slot }}
        </div>
    </div>
    <ul class="flex justify-center gap-3 text-zinc-900 dark:text-white">
        <li>
            <a href="{{ $loans->previousPageUrl() }}"
                class="grid size-8 place-content-center rounded border border-zinc-200 transition-colors hover:bg-zinc-50 rtl:rotate-180 dark:border-zinc-700 dark:hover:bg-zinc-800"
                aria-label="Previous page" wire:navigate>
                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                        clip-rule="evenodd" />
                </svg>
            </a>
        </li>

        <li class="text-sm/8 font-medium tracking-widest">{{ $loans->currentPage() }}/{{ $loans->lastPage() }}</li>

        <li>
            <a href="{{ $loans->nextPageUrl() }}"
                class="grid size-8 place-content-center rounded border border-zinc-200 transition-colors hover:bg-zinc-50 rtl:rotate-180 dark:border-zinc-700 dark:hover:bg-zinc-800"
                aria-label="Next page" wire:navigate>
                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                        clip-rule="evenodd" />
                </svg>
            </a>
        </li>
    </ul>
</x-admin.layouts.app>