<x-admin.layouts.app.sidebar :title="$title ?? null" :page="$page ?? 'default'">
    <flux:main>
        {{ $slot }}
    </flux:main>
</x-admin.layouts.app.sidebar>