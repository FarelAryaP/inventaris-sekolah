@extends('layouts.admin')

@section('title', 'Manajemen Siswa')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Manajemen Siswa</h1>
            <p class="text-gray-600">Kelola data akun siswa</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn-primary">
            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Siswa
        </a>
    </div>

    <!-- Table -->
    <div class="card p-0 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="table-header">No</th>
                        <th class="table-header">NISN</th>
                        <th class="table-header">Nama</th>
                        <th class="table-header">Kelas</th>
                        <th class="table-header">Total Pengajuan</th>
                        <th class="table-header">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($users as $index => $user)
                    <tr class="hover:bg-gray-50">
                        <td class="table-cell">{{ $users->firstItem() + $index }}</td>
                        <td class="table-cell font-medium">{{ $user->nisn }}</td>
                        <td class="table-cell">{{ $user->nama }}</td>
                        <td class="table-cell">{{ $user->kelas }}</td>
                        <td class="table-cell">{{ $user->pengajuan()->count() }}</td>
                        <td class="table-cell">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.users.show', $user) }}" class="text-blue-600 hover:text-blue-800">Detail</a>
                                <a href="{{ route('admin.users.edit', $user) }}" class="text-green-600 hover:text-green-800">Edit</a>
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" 
                                      onsubmit="return confirm('Yakin ingin menghapus siswa ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <svg class="h-12 w-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            <p class="text-gray-500">Belum ada data siswa</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
        <div class="bg-gray-50 px-6 py-4 border-t">
            {{ $users->links() }}
        </div>
        @endif
    </div>
</div>
@endsection