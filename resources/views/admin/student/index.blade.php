<x-admin.layouts.app :title="'Daftar Siswa'">
    <div class="max-w-6xl mx-auto p-6 space-y-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-zinc-800 dark:text-white">Manajemen Siswa</h1>
            <a href="{{ route('admin.students.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm">Tambah Siswa</a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl">
                <thead class="bg-zinc-100 dark:bg-zinc-800 text-left">
                    <tr class="text-sm text-zinc-600 dark:text-zinc-300">
                        <th class="px-6 py-3 border-b">#</th>
                        <th class="px-6 py-3 border-b">Nama</th>
                        <th class="px-6 py-3 border-b">Email</th>
                        <th class="px-6 py-3 border-b">Total Peminjaman</th>
                        <th class="px-6 py-3 border-b text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($students as $index => $student)
                        <tr class="border-t text-sm text-zinc-700 dark:text-zinc-200">
                            <td class="px-6 py-4">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4">{{ $student->name }}</td>
                            <td class="px-6 py-4">{{ $student->email }}</td>
                            <td class="px-6 py-4">{{ $student->loans_count }}</td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <a href="{{ route('admin.students.edit', $student->id) }}" class="text-amber-600 text-sm">Edit</a>
                                <form action="{{ route('admin.students.destroy', $student->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Yakin ingin menghapus siswa ini?')" class="text-red-600 text-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-6 text-zinc-500">Belum ada siswa terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin.layouts.app>
