<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-white dark:bg-zinc-800" data-page="{{ $page ?? 'default' }}">
    <div id="placeholder" class="w-[255px] h-full hidden lg:block"></div>
    <flux:sidebar fixed stashable id="fixedSidebar"
        class="border-r border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 fixed left-0 top-0 bottom-0">
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

        <a href="/admin/dashboard" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
            <x-admin.icons.app-logo />
        </a>

        <flux:navlist variant="outline">
            <flux:navlist.group :heading="__('Platform')" class="grid">
                <flux:navlist.item icon="home" :href="'/admin/dashboard'" :current="request()-> is('admin/dashboard')"
                    wire:navigate>{{ __('Dashboard') }}
                </flux:navlist.item>
            </flux:navlist.group>
            <flux:navlist.group :heading="__('Management')" class="grid">
                <flux:navlist.item icon="rectangle-stack" :href="route('admin.item.index')"
                    :current="request()->routeIs('item.*')" wire:navigate>
                    {{ __('List Barang') }}
                </flux:navlist.item>
                <flux:navlist.item icon="clipboard-document-check" :href="'/admin/loans'"
                    :current="request()->is('admin/loans*')" wire:navigate>{{ __('Peminjaman') }}
                </flux:navlist.item>
                <flux:navlist.item icon="arrow-uturn-left" :href="route('admin.return-item.index')"
                    :current="request()->routeIs('return-items*')" wire:navigate>{{ __('Pengembalian') }}
                </flux:navlist.item>
                <flux:navlist.item icon="calendar-date-range" :href="route('admin.history-item.index')"
                    :current="request()->routeIs('history-items*')" wire:navigate>{{ __('Riwayat Pengembalian') }}
                </flux:navlist.item>
                <flux:navlist.item icon="users" :href="'/admin/students'"
                    :current="request()->is('admin/students*')" wire:navigate>{{ __('Management Siswa') }}
                </flux:navlist.item>
            </flux:navlist.group>
        </flux:navlist>

        <flux:spacer />

        <!-- Desktop User Menu -->
        <flux:dropdown position="bottom" align="start">
            <flux:profile :name="auth()->user()->name" :initials="auth()->user()->initials()"
                icon-trailing="chevrons-up-down" />

            <flux:menu class="w-[220px]">
                <flux:menu.radio.group>
                    <div class="p-0 text-sm font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                            <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                <span
                                    class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                    {{ auth()->user()->initials() }}
                                </span>
                            </span>

                            <div class="grid flex-1 text-start text-sm leading-tight">
                                <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                    </div>
                </flux:menu.radio.group>

                <form method="POST" action="{{ route('admin.logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                        {{ __('Log Out') }}
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:sidebar>

    <!-- Mobile User Menu -->
    <flux:header class="lg:hidden">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

        <flux:spacer />

        <flux:dropdown position="top" align="end">
            <flux:profile :initials="auth()->user()->initials()" icon-trailing="chevron-down" />

            <flux:menu>
                <flux:menu.radio.group>
                    <div class="p-0 text-sm font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                            <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                <span
                                    class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                    {{ auth()->user()->initials() }}
                                </span>
                            </span>

                            <div class="grid flex-1 text-start text-sm leading-tight">
                                <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                    </div>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <flux:menu.separator />

                <form method="POST" action="{{ route('admin.logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                        {{ __('Log Out') }}
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:header>

    {{ $slot }}

    @fluxScripts
</body>

</html>
