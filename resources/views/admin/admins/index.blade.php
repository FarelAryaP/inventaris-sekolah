@extends('layouts.admin')

@section('title', 'Kelola Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>
        <i class="bi bi-person-gear"></i> Manajemen Admin
    </h2>
    @if(auth()->guard('admin')->user()->id_role == 1)
        <a href="{{ route('admin.admins.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Tambah Admin Baru
        </a>
    @endif
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Username</th>
                        <th>Nama</th>
                        <th>Role</th>
                        <th>Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($admins as $admin)
                        <tr>
                            <td>{{ $loop->iteration + ($admins->currentPage() - 1) * $admins->perPage() }}</td>
                            <td><code>{{ $admin->username }}</code></td>
                            <td>{{ $admin->nama }}</td>
                            <td>
                                @if($admin->role)
                                    <span class="badge bg-{{ $admin->id_role == 1 ? 'warning text-dark' : 'secondary' }}">
                                        {{ $admin->role->nama }}
                                    </span>
                                @else
                                    <span class="badge bg-light text-dark">-</span>
                                @endif
                            </td>
                            <td>{{ $admin->created_at->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('admin.admins.show', $admin) }}" 
                                   class="btn btn-sm btn-outline-info">
                                    <i class="bi bi-eye"></i>
                                </a>
                                
                                @if(auth()->guard('admin')->user()->id_role == 1 && 
                                    $admin->id_admin != auth()->guard('admin')->id())
                                    <a href="{{ route('admin.admins.edit', $admin) }}" 
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    
                                    <form action="{{ route('admin.admins.destroy', $admin) }}" 
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('Yakin hapus admin ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Tidak ada admin ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="d-flex justify-content-end mt-3">
            {{ $admins->links() }}
        </div>
    </div>
</div>
@endsection