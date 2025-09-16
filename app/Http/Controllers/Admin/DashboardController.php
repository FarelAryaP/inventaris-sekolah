<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Pengajuan;
use App\Models\detail_peminjaman;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_barang' => Barang::count(),
            'total_siswa' => User::count(),
            'pengajuan_pending' => Pengajuan::where('status', 0)->count(),
            // 'barang_dipinjam' => detail_peminjaman::where('status', 0)->count(),
        ];

        $pengajuan_terbaru = Pengajuan::with(['user', 'barang'])
                                    ->where('status', 0)
                                    ->latest()
                                    ->take(5)
                                    ->get();

        $barang_stok_rendah = Barang::where('jumlah', '<', 5)->take(5)->get();

        return view('admin.dashboard', compact('stats', 'barang_stok_rendah', 'pengajuan_terbaru'));
    }
}