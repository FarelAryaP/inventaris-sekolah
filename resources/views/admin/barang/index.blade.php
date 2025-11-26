@extends('layouts.admin')

@section('title', 'Data Barang')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Data Barang</h1>
            <p class="text-gray-600">Kelola inventaris barang sekolah</p>
        </div>
        <a href="{{ route('admin.barang.create') }}" class="btn-primary">
            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Barang
        </a>
    </div>

    <div class="card p-0 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="table-header">No</th>
                        <th class="table-header">Nama Barang</th>
                        <th class="table-header">Jumlah</th>
                        <th class="table-header">Keterangan</th>
                        <th class="table-header">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($barangs as $index => $barang)
                    <tr class="hover:bg-gray-50">
                        <td class="table-cell">{{ $barangs->firstItem() + $index }}</td>
                        <td class="table-cell font-medium">{{ $barang->nama_barang }}</td>
                        <td class="table-cell">
                            <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $barang->jumlah == 0 ? 'bg-red-100 text-red-800' : ($barang->jumlah < 5 ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                                {{ $barang->jumlah }}
                            </span>
                        </td>
                        <td class="table-cell text-gray-500">{{ Str::limit($barang->keterangan, 40) }}</td>
                        <td class="table-cell">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.barang.show', $barang) }}" class="text-blue-600 hover:text-blue-800">Detail</a>
                                <a href="{{ route('admin.barang.edit', $barang) }}" class="text-green-600 hover:text-green-800">Edit</a>
                                <form action="{{ route('admin.barang.destroy', $barang) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <svg class="h-12 w-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                            <p class="text-gray-500">Belum ada data barang</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($barangs->hasPages())
        <div class="bg-gray-50 px-6 py-4 border-t">
            {{ $barangs->links() }}
        </div>
        @endif
    </div>
</div>
@endsection