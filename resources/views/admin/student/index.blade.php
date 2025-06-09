<x-admin.layouts.app :title="'Daftar Siswa'">
    <div class="mx-auto space-y-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-zinc-800 dark:text-white">Manajemen Siswa</h1>
        </div>

        <div class="overflow-x-auto rounded-t-lg">
            <table class="min-w-full bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-t-lg">
                <thead class="bg-zinc-800 text-zinc-100 text-left">
                    <tr class="text-sm text-zinc-100">
                        <th class="px-6 py-3 border-b">No</th>
                        <th class="px-6 py-3 border-b">Nama</th>
                        <th class="px-6 py-3 border-b">Email</th>
                        <th class="px-6 py-3 border-b">Total Peminjaman</th>
                        <th class="px-6 py-3 border-b text-right"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($students as $index => $student)
                        <tr class="border-t text-[15px] text-zinc-800 dark:text-zinc-200">
                            <td class="px-6 py-4">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4">{{ $student->name }}</td>
                            <td class="px-6 py-4">{{ $student->email }}</td>
                            <td class="px-6 py-4">
                                @if ($student->loans_count > 0)
                                    {{ $student->loans_count }}x meminjam
                                @else
                                    <span class="italic text-zinc-500">Belum meminjam apapun</span>
                                @endif
                            </td>                            
                            <td class="px-6 py-4 text-right space-x-2">
                                <a href="{{ route('admin.students.edit', $student->id) }}" class="bg-amber-200 text-amber-600 px-4 py-1.5 rounded text-sm hover:cursor-pointer hover:bg-amber-300 transition-all duration-300">Edit</a>
                                <form action="{{ route('admin.students.destroy', $student->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Yakin ingin menghapus siswa ini?')" class="bg-red-200 text-red-600 px-4 py-1.5 rounded text-sm hover:cursor-pointer hover:bg-red-300 transition-all duration-300">Hapus</button>
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
