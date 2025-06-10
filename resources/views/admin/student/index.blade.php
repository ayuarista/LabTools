<x-admin.layouts.app :title="'Daftar Siswa'">
    <div class="mx-auto space-y-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-zinc-800 dark:text-white">Manajemen Siswa</h1>
        </div>

        <div class="overflow-x-auto rounded-lg border border-zinc-200 dark:border-zinc-700">
            <table class="min-w-full bg-white dark:bg-zinc-900 text-sm">
                <thead class="bg-zinc-800 text-zinc-100 text-left">
                    <tr>
                        <th class="px-4 py-3 whitespace-nowrap">No</th>
                        <th class="px-4 py-3 whitespace-nowrap">Nama</th>
                        <th class="px-4 py-3 whitespace-nowrap">NIS</th>
                        <th class="px-4 py-3 whitespace-nowrap">Kelas</th>
                        <th class="px-4 py-3 whitespace-nowrap">Jurusan</th>
                        <th class="px-4 py-3 whitespace-nowrap">Email</th>
                        <th class="px-4 py-3 whitespace-nowrap">Total Peminjaman</th>
                        <th class="px-4 py-3 whitespace-nowrap text-right"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($students as $index => $student)
                        <tr class="border-t text-zinc-800 dark:text-zinc-200">
                            <td class="px-4 py-3 whitespace-nowrap">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ $student->name }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ $student->profile?->nis ?? '-' }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ $student->profile?->kelas ?? '-' }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ $student->profile?->jurusan ?? '-' }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ $student->email }}</td>

                            <td class="px-4 py-3 whitespace-nowrap">
                                @if ($student->loans_count > 0)
                                    {{ $student->loans_count }}x meminjam
                                @else
                                    <span class="italic text-zinc-500">Belum meminjam</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-right space-x-2">
                                <a href="{{ route('admin.students.edit', $student->id) }}"
                                    class="bg-amber-200 text-amber-600 px-4 py-1.5 rounded text-sm font-medium hover:cursor-pointer hover:bg-amber-300 transition-all duration-300">
                                    Edit
                                </a>
                                <form action="{{ route('admin.students.destroy', $student->id) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Yakin ingin menghapus siswa ini?')"
                                        class="bg-red-200 text-red-600 px-4 py-1.5 rounded text-sm font-medium hover:cursor-pointer hover:bg-red-300 transition-all duration-300">
                                        Hapus
                                    </button>
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
