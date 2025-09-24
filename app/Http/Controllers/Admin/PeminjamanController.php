<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\detail_peminjaman;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjamans = detail_peminjaman::with(['pengajuan.user', 'pengajuan.barang'])
                                      ->latest()
                                      ->paginate(10);
        
        return view('admin.peminjaman.index', compact('peminjamans'));
    }

    public function show(detail_peminjaman $peminjaman)
    {
        return view('admin.peminjaman.show', compact('peminjaman'));
    }

    public function kembalikan(detail_peminjaman $peminjaman)
    {
        if ($peminjaman->status != 0) {
            return back()->withErrors(['error' => 'Barang sudah dikembalikan atau hilang!']);
        }

        DB::transaction(function () use ($peminjaman) {
            // Update status peminjaman
            $peminjaman->update([
                'status' => 1 // dikembalikan
            ]);

            // Tambah kembali stok barang
            $barang = $peminjaman->pengajuan->barang;
            $barang->increment('jumlah', $peminjaman->pengajuan->jumlah);
        });

        return redirect()->route('admin.peminjaman.index')
                        ->with('success', 'Barang berhasil dikembalikan!');
    }

    public function hilang(detail_peminjaman $peminjaman)
    {
        if ($peminjaman->status != 0) {
            return back()->withErrors(['error' => 'Barang sudah dikembalikan atau hilang!']);
        }

        $peminjaman->update([
            'status' => 2 // hilang
        ]);

        return redirect()->route('admin.peminjaman.index')
                        ->with('success', 'Status barang diubah menjadi hilang!');
    }

    public function laporanPeminjaman()
    {
        $peminjamans = detail_peminjaman::with(['pengajuan.user', 'pengajuan.barang'])
                                      ->get();
        
        return view('admin.laporan.peminjaman', compact('peminjamans'));
    }
}