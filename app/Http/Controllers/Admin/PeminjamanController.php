<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DetailPeminjaman;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjamans = DetailPeminjaman::with(['pengajuan.user', 'pengajuan.barang'])
                                      ->latest()
                                      ->paginate(10);
        
        return view('admin.peminjaman.index', compact('peminjamans'));
    }

    public function show(DetailPeminjaman $peminjaman)
    {
        return view('admin.peminjaman.show', compact('peminjaman'));
    }

    public function kembalikan(DetailPeminjaman $peminjaman)
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

    public function hilang(DetailPeminjaman $peminjaman)
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

    public function laporanPeminjaman(Request $request)
    {
        $query = DetailPeminjaman::with(['pengajuan.user', 'pengajuan.barang']);

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan periode
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('tgl_mulai', '>=', $request->tanggal_mulai);
        }
        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('tgl_selesai', '<=', $request->tanggal_selesai);
        }

        $peminjamans = $query->latest()->get();

        // Statistik
        $stats = [
            'total' => $peminjamans->count(),
            'dipinjam' => $peminjamans->where('status', 0)->count(),
            'dikembalikan' => $peminjamans->where('status', 1)->count(),
            'hilang' => $peminjamans->where('status', 2)->count(),
        ];

        return view('admin.laporan.peminjaman', compact('peminjamans', 'stats'));
    }
}