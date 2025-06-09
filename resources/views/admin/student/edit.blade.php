<x-admin.layouts.app :title="'Edit Siswa'">
    <div class="max-w-xl mx-auto p-6 space-y-6">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-bold text-zinc-800 dark:text-white">Edit Siswa</h1>
            <a href="{{ route('admin.students.index') }}" class="text-sm text-blue-600 hover:underline">← Kembali</a>
        </div>

        <form action="{{ route('admin.students.update', $student->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Nama</label>
                <input type="text" id="name" name="name" value="{{ old('name', $student->name) }}"
                    class="mt-1 block w-full rounded-md border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-zinc-800 dark:text-white shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm">
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', $student->email) }}"
                    class="mt-1 block w-full rounded-md border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-zinc-800 dark:text-white shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm">
            </div>

            <div class="flex justify-end">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded-md">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</x-admin.layouts.app>
