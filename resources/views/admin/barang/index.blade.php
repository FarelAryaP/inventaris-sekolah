@extends('layouts.admin')

@section('title', 'Kelola Barang')

@section('content')

@vite(['resources/css/barang.css', 'resources/js/app.js'])

<div class="barang-page">
    <div class="page-header mb-4">
        <h3>Kelola Barang</h3>
            <a href="javascript:void(0);" class="btn-primary" id="btnTambah" data-url="{{ route('admin.barang.create') }}">
                <i class="bi bi-plus-circle"></i> Tambah Barang
            </a>

    </div>

    <div class="card">
        <div class="table-wrapper">
            <table class="barang-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Barang</th>
                        <th>Jumlah</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($barangs as $barang)
                    <tr>
                        <td>{{ $barang->id_barang }}</td>
                        <td>{{ $barang->nama_barang }}</td>
                        <td>
                            <span class="badge {{ $barang->jumlah < 5 ? 'warning' : 'success' }}">
                                {{ $barang->jumlah }}
                            </span>
                        </td>
                        <td>{{ Str::limit($barang->keterangan, 50) ?: '-' }}</td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-outline info btnShow" data-url="{{ route('admin.barang.show', $barang) }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                    </svg>
                                </button>
                                <button class="btn-outline warning btnEdit" data-url="{{ route('admin.barang.edit', $barang) }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 20h9"/>
                                    <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z"/>
                                    </svg>
                                </button>
                                <form action="{{ route('admin.barang.destroy', $barang) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Yakin ingin menghapus barang ini?')"
                                      style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-outline danger">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="3 6 5 6 21 6"/>
                                        <path d="M19 6l-2 14H7L5 6"/>
                                        <path d="M10 11v6"/>
                                        <path d="M14 11v6"/>
                                        <path d="M9 6V4h6v2"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="pagination-wrapper">
            {{ $barangs->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

<!-- ---------- Modal Custom ---------- -->
<div id="customModal" class="custom-modal" aria-hidden="true" role="dialog" aria-modal="true">
  <div class="custom-modal-content" role="document">
    <div class="custom-modal-header">
      <h5 id="modalTitle">Loading...</h5>
      <button class="close-modal" id="closeModal" aria-label="Tutup">&times;</button>
    </div>
    <div class="custom-modal-body" id="modalContent">
      <div class="modal-loader">Memuat data...</div>
    </div>
  </div>
</div>

<!-- ---------- Inline JS  ---------- -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('customModal');
    const modalContent = document.getElementById('modalContent');
    const modalTitle = document.getElementById('modalTitle');
    const closeModalBtn = document.getElementById('closeModal');

    // === FUNGSI SHOW / HIDE MODAL ===
    function showModal() {
        modal.classList.add('show');
        modal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    }
    function hideModal() {
        modal.classList.remove('show');
        modal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    }

    // Tombol close (×)
    closeModalBtn.addEventListener('click', hideModal);
    // Klik di area gelap (backdrop)
    modal.addEventListener('click', function(e) {
        if (e.target === modal) hideModal();
    });

    const loaderHtml = '<div class="modal-loader">Memuat data...</div>';

    // === FUNGSI LOAD MODAL DARI URL ===
    async function loadModal(url, title) {
        modalTitle.textContent = title || 'Detail';
        modalContent.innerHTML = loaderHtml;
        showModal();

        try {
            const res = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            const text = await res.text();

            if (!res.ok) {
                modalContent.innerHTML = `<div class="text-danger p-3">Gagal memuat data (Status: ${res.status})</div>`;
                return;
            }

            // Jika respon bukan partial (full HTML)
            if (/<\/?html/i.test(text) || /<!doctype/i.test(text)) {
                modalContent.innerHTML = `
                    <div class="p-3 text-danger">
                        <strong>Server mengembalikan halaman penuh.</strong><br>
                        Pastikan controller memeriksa request AJAX dan return partial view.
                    </div>`;
                console.log('HTML penuh:', text.slice(0,2000));
                return;
            }

            modalContent.innerHTML = text;
            attachModalFormHandlers();

        } catch (err) {
            console.error('Fetch error:', err);
            modalContent.innerHTML = '<div class="text-danger p-3">Terjadi kesalahan saat memuat data.</div>';
        }
    }

    // === DELEGASI KLIK UNTUK TOMBOL ===
    document.body.addEventListener('click', function(e) {
        const btn = e.target.closest('#btnTambah, .btnShow, .btnEdit');
        if (!btn) return;
        e.preventDefault();

        const url = btn.dataset.url;
        if (!url) return console.warn('Tombol tidak memiliki data-url');

        let title = 'Detail Barang';
        if (btn.id === 'btnTambah') title = 'Tambah Barang';
        else if (btn.classList.contains('btnEdit')) title = 'Edit Barang';

        loadModal(url, title);
    });

   function attachModalFormHandlers() {
    const form = modalContent.querySelector('form');
    if (form) {
        const btnBatal = form.querySelector('.btn-secondary');
        if (btnBatal) {
            btnBatal.addEventListener('click', function(e) {
                e.preventDefault();
                hideModal();
            });
        }
    }

    // Tombol "Tutup" di halaman show
    const btnTutup = modalContent.querySelector('.close-modal');
    if (btnTutup) {
        btnTutup.addEventListener('click', function(e) {
            e.preventDefault();
            hideModal();
        });
    }
}
    console.log('Modal script aktif.');
});
</script>

@endsection
