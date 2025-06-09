<x-admin.layouts.app :title="'Edit Siswa'">
    <section class="mx-auto space-y-8 p-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold">Edit Data Siswa</h1>
        </div>

        <form action="{{ route('admin.students.update', $student->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="space-y-2">
                <label for="name" class="block text-sm font-medium text-zinc-800 dark:text-white">Nama</label>
                <flux:input id="name" name="name" type="text" :value="old('name', $student->name)" placeholder="Nama siswa" />
            </div>

            <div class="space-y-2">
                <label for="email" class="block text-sm font-medium text-zinc-800 dark:text-white">Email</label>
                <flux:input id="email" name="email" type="email" :value="old('email', $student->email)" placeholder="Email siswa" />
            </div>

            <div class="space-y-2">
                <label for="password" class="block text-sm font-medium text-zinc-800 dark:text-white">Password Baru</label>
                <flux:input id="password" name="password" type="password" placeholder="Biarkan kosong jika tidak diganti" />
            </div>

            <div class="flex items-center gap-3 justify-end">
                <a href="{{ route('admin.students.index') }}" class="px-5 py-2 rounded-md border border-gray-300 text-sm hover:cursor-pointer hover:bg-zinc-800 text-black hover:text-white transition-all duration-200">
                    Kembali
                </a>
                <flux:button type="submit" variant="primary" class="hover:cursor-pointer">Simpan Perubahan</flux:button>
            </div>
        </form>
    </section>
</x-admin.layouts.app>
