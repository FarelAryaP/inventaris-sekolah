@extends('layouts.admin')

@section('title', 'Kelola Admin')

@section('content')
<div class="table-title">
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
<div class="custom-alert alert-success show" role="alert">
    {{ session('success') }}
    <button type="button" class="alert-close">×</button>
</div>
@endif

@if(session('error'))
<div class="custom-alert alert-danger show" role="alert">
    {{ session('error') }}
    <button type="button" class="alert-close">×</button>
</div>
@endif

<div class="card-admins">
    <div class="card-body">
    <div class="table-responsive">
        <table class="table-admins">
        <thead class="table-light">
        <tr>
          <th>No</th>
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
                    <span class="text-dark">-</span>
                  @endif
                </td>
                
              
                <td>{{ $admin->created_at->format('d M Y') }}</td>
                <td>
                <div class="action-buttons">
                  <a href="{{ route('admin.admins.show', $admin) }}" class="btn-outline info btnShow">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="48" height="48">
                      <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                      <circle cx="12" cy="12" r="3"/>
                    </svg>
                  </a>
                                
            @if(auth()->guard('admin')->user()->id_role == 1 && $admin->id_admin != auth()->guard('admin')->id())
                <a href="{{ route('admin.admins.edit', $admin) }}" class="btn-outline warning btnEdit">
                    <svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="48" height="48">
                        <path d="M12 20h9"/>
                        <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z"/>
                    </svg>
                </a>
                                    
            <form action="{{ route('admin.admins.destroy', $admin) }}" 
                  method="POST" 
                  onsubmit="return confirm('Yakin hapus admin ini?')"
                  style=""display:inline>
                @csrf
                @method('DELETE')
                    <button type="submit" class="btn-outline danger">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="48" height="48">
                          <polyline points="3 6 5 6 21 6"/>
                          <path d="M19 6l-2 14H7L5 6"/>
                          <path d="M10 11v6"/>
                          <path d="M14 11v6"/>
                          <path d="M8 6V4h8v2"/>
                        </svg>
                    </button>
            </form>
            </div>
                @endif
                    </td>
              </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-info">Tidak ada admin ditemukan.</td>
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

<!-- UNIVERSAL MODAL -->
<div id="adminModal" class="modal-overlay">
    <div class="modal-box">
            <h3 id="adminModalTitle"></h3>
            <button class="closeModal">&times;</button>

        <div class="modal-body-custom" id="adminModalBody"></div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {

    const overlay = document.getElementById("adminModal");
    const title   = document.getElementById("adminModalTitle");
    const body    = document.getElementById("adminModalBody");
    const closeBtn = document.querySelector(".closeModal");

    const openModal = () => overlay.style.display = "flex";
    const closeModal = () => overlay.style.display = "none";

    // Close by clicking button
    closeBtn.addEventListener("click", closeModal);

    // Close by clicking overlay
    overlay.addEventListener("click", e => {
        if (e.target === overlay) closeModal();
    });

    window.initButtons = function() {

        // SHOW
        document.querySelectorAll(".btnShow").forEach(btn => {
            btn.onclick = function(e){
                e.preventDefault();
                fetch(this.href)
                    .then(res => res.text())
                    .then(html => {
                        title.textContent = "Detail Admin";
                        body.innerHTML = html;
                        openModal();
                    });
            };
        });

        // EDIT
        document.querySelectorAll(".btnEdit").forEach(btn => {
            btn.onclick = function(e){
                e.preventDefault();
                fetch(this.href)
                    .then(res => res.text())
                    .then(html => {
                        title.textContent = "Edit Admin";
                        body.innerHTML = html;
                        openModal();
                    });
            };
        });
    };

    initButtons();

    // CREATE
    document.querySelector("a.btn-success")?.addEventListener("click", function(e){
        e.preventDefault();
        fetch(this.href)
            .then(res => res.text())
            .then(html => {
                title.textContent = "Tambah Admin";
                body.innerHTML = html;
                openModal();
            });
    });

});

document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll('.alert-close').forEach(btn => {
        btn.addEventListener('click', () => {
            const alertBox = btn.parentElement; // ambil parent alert
            alertBox.style.opacity = 0;
            setTimeout(() => {
                alertBox.style.display = 'none';
            }, 300); // waktu animasi
        });
    });
});


</script>



@endsection