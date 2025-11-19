@extends('layouts.admin')

@section('title', 'Kelola Siswa')

@section('content')

{{-- TITLE --}}
<div class="siswa-title">
    <h1>
        Kelola Siswa
        <small class="text-muted">(Super Admin Only)</small>
    </h1>

    <a href="{{ route('admin.users.create') }}" class="btn btn-success btnCreate">
        Tambah Siswa
    </a>
</div>

{{-- WRAPPER --}}
<div class="card-siswa">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table-siswa">
                <thead class="table-light">
                    <tr>
                        <th>NISN</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Password</th>
                        <th>Terdaftar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                @forelse($users as $userItem)
                    <tr>

                        {{-- NISN --}}
                        <td><code>{{ $userItem->nisn }}</code></td>

                        {{-- NAMA --}}
                        <td>{{ $userItem->nama }}</td>

                        {{-- KELAS --}}
                        <td><span class="badge bg-info">{{ $userItem->kelas }}</span></td>

                        {{-- PASSWORD --}}
                        <td><span class="badge bg-success">Set</span></td>

                        {{-- CREATED --}}
                        <td>{{ $userItem->created_at->format('d/m/Y') }}</td>

                        {{-- ACTION BUTTONS --}}
                        <td>
                            <div class="btn-group-sm action-buttons">

                                {{-- DETAIL --}}
                                <a href="{{ route('admin.users.show', $userItem->nisn) }}"
                                   class="btn-outline info btnShow"
                                   title="Detail">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="48" height="48">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                    <circle cx="12" cy="12" r="3"/></svg>
                                </a>

                                {{-- EDIT --}}
                                <a href="{{ route('admin.users.edit', $userItem->nisn) }}"
                                   class="btn-outline warning btnEdit"
                                   title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="48" height="48">
                                    <path d="M12 20h9"/>
                                    <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z"/></svg>
                                </a>

                                {{-- DELETE --}}
                                <form action="{{ route('admin.users.destroy', $userItem->nisn) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus siswa {{ $userItem->nama }}? Semua data pengajuan akan ikut terhapus.');"
                                      class="deleteForm">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="btn-outline danger"
                                            title="Hapus">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="48" height="48">
                                            <polyline points="3 6 5 6 21 6"/>
                                            <path d="M19 6l-2 14H7L5 6"/>
                                            <path d="M10 11v6"/>
                                            <path d="M14 11v6"/>
                                            <path d="M8 6V4h8v2"/></svg>
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>

                    {{-- ========================= --}}
                    {{-- CUSTOM MODAL: RESET PASS --}}
                    {{-- ========================= --}}
                    <div id="resetModal{{ $userItem->nisn }}" class="custom-modal-overlay">
                        <div class="custom-modal-box">

                            <h3>Reset Password - {{ $userItem->nama }}</h3>
                            <button class="closeCustomModal">&times;</button>

                            <form action="{{ route('admin.users.reset-password', $userItem->nisn) }}"
                                  method="POST">

                                @csrf
                                @method('PATCH')

                                <div class="modal-content-body">

                                    <div class="info-box">
                                        <strong>NISN:</strong> {{ $userItem->nisn }} <br>
                                        <strong>Nama:</strong> {{ $userItem->nama }} <br>
                                        <strong>Kelas:</strong> {{ $userItem->kelas }}
                                    </div>

                                    <label>Password Baru</label>
                                    <input type="password"
                                           name="new_password"
                                           placeholder="Minimal 6 karakter"
                                           required>

                                    <label>Konfirmasi Password</label>
                                    <input type="password"
                                           name="new_password_confirmation"
                                           placeholder="Ketik ulang password"
                                           required>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn cancelBtn">Batal</button>
                                    <button type="submit" class="btn submitBtn">Reset</button>
                                </div>

                            </form>

                        </div>
                    </div>

                    <!-- UNIVERSAL MODAL (SHOW / EDIT / CREATE) -->
                    <div id="siswaModal" class="modal-overlay">
                        <div class="modal-box">
                            <h3 id="siswaModalTitle"></h3>
                            <button class="closeModal">&times;</button>
                            
                            <div class="modal-body-custom" id="siswaModalBody"></div>
                        </div>
                    </div>


                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-5">
                            Belum ada data siswa
                            <div class="mt-3">
                                <a href="{{ route('admin.users.create') }}"
                                   class="btn btn-success btn-sm">
                                    Tambah Siswa Pertama
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>

            </table>
        </div>

        {{-- PAGINATION --}}
        <div class="d-flex justify-content-center mt-3">
            {{ $users->links() }}
        </div>

    </div>

    <div class="card-footer-custom">
        <small>Total: {{ $users->total() }} siswa</small>
    </div>
</div>

{{-- ============================= --}}
{{-- UNIVERSAL MODAL (SHOW/EDIT) --}}
{{-- ============================= --}}
<div id="userModal" class="modal-overlay">
    <div class="modal-box">
        <h3 id="userModalTitle"></h3>
        <button class="closeModal">&times;</button>
        <div id="userModalBody" class="modal-body-custom"></div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {

    const overlay  = document.getElementById("siswaModal");
    const title    = document.getElementById("siswaModalTitle");
    const body     = document.getElementById("siswaModalBody");
    const closeBtn = document.querySelector(".closeModal");

    const openModal  = () => overlay.style.display = "flex";
    const closeModal = () => overlay.style.display = "none";

    // Tutup modal via tombol X
    closeBtn.addEventListener("click", closeModal);

    // Tutup modal via klik area gelap
    overlay.addEventListener("click", e => {
        if (e.target === overlay) closeModal();
    });

    window.initButtons = function() {

        // ===================
        // SHOW DETAIL SISWA
        // ===================
        document.querySelectorAll(".btnShow").forEach(btn => {
            btn.onclick = function(e){
                e.preventDefault();

                fetch(this.href)
                    .then(res => res.text())
                    .then(html => {
                        title.textContent = "Detail Siswa";
                        body.innerHTML = html;
                        openModal();
                    });
            };
        });

        // ===================
        // EDIT SISWA
        // ===================
        document.querySelectorAll(".btnEdit").forEach(btn => {
            btn.onclick = function(e){
                e.preventDefault();

                fetch(this.href)
                    .then(res => res.text())
                    .then(html => {
                        title.textContent = "Edit Siswa";
                        body.innerHTML = html;
                        openModal();
                    });
            };
        });

    };

    initButtons();

    // ===================
    // CREATE SISWA
    // ===================
    document.querySelector(".btnCreate")?.addEventListener("click", function(e){
        e.preventDefault();

        fetch(this.href)
            .then(res => res.text())
            .then(html => {
                title.textContent = "Tambah Siswa";
                body.innerHTML = html;
                openModal();
            });
    });

});

// ===================
// RESET PASSWORD
// ===================
document.addEventListener("DOMContentLoaded", () => {

    document.querySelectorAll(".btnResetPassword").forEach(btn => {
        btn.addEventListener("click", () => {

            // ambil id modal
            const target = btn.getAttribute("data-target");
            const modal  = document.getElementById(target);

            if (!modal) {
                console.error("Modal tidak ditemukan:", target);
                return;
            }

            // buka modal
            modal.style.display = "flex";

            // tombol close (X)
            modal.querySelector(".closeCustomModal").onclick = () => {
                modal.style.display = "none";
            };

            // tombol batal
            modal.querySelector(".cancelBtn").onclick = () => {
                modal.style.display = "none";
            };

            // klik luar modal
            modal.onclick = (e) => {
                if (e.target === modal) modal.style.display = "none";
            };
        });
    });

});

</script>
@endsection
