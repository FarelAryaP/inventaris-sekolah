@extends('layouts.admin')

@section('title', 'Manajemen Admin')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Manajemen Admin</h1>
            <p class="text-gray-600">Kelola data akun admin dan staff</p>
        </div>
        <a href="{{ route('admin.admins.create') }}" class="btn-primary">
            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Admin
        </a>
    </div>

    <!-- Table -->
    <div class="card p-0 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="table-header">No</th>
                        <th class="table-header">Username</th>
                        <th class="table-header">Nama</th>
                        <th class="table-header">Role</th>
                        <th class="table-header">Terdaftar</th>
                        <th class="table-header">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($admins as $index => $admin)
                    <tr class="hover:bg-gray-50">
                        <td class="table-cell">{{ $admins->firstItem() + $index }}</td>
                        <td class="table-cell font-medium">{{ $admin->username }}</td>
                        <td class="table-cell">{{ $admin->nama }}</td>
                        <td class="table-cell">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $admin->id_role == 1 ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $admin->role->nama }}
                            </span>
                        </td>
                        <td class="table-cell">{{ $admin->created_at->format('d M Y') }}</td>
                        <td class="table-cell">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.admins.show', $admin->id_admin) }}" class="text-blue-600 hover:text-blue-800">Detail</a>
                                <a href="{{ route('admin.admins.edit', $admin->id_admin) }}" class="text-green-600 hover:text-green-800">Edit</a>
                                @if($admin->id_admin != Auth::guard('admin')->user()->id_admin)
                                <form action="{{ route('admin.admins.destroy', $admin->id_admin) }}" method="POST" class="inline" 
                                      onsubmit="return confirm('Yakin ingin menghapus admin ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">Hapus</button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <svg class="h-12 w-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <p class="text-gray-500">Belum ada data admin</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($admins->hasPages())
        <div class="bg-gray-50 px-6 py-4 border-t">
            {{ $admins->links() }}
        </div>
        @endif
    </div>
</div>
@endsection