<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Pengajuan;
use App\Models\Barang;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::guard('user')->user();
        
        $stats = [
            'total_pengajuan' => Pengajuan::where('nisn', $user->nisn)->count(),
            'pengajuan_pending' => Pengajuan::where('nisn', $user->nisn)->where('status', 0)->count(),
            'pengajuan_approved' => Pengajuan::where('nisn', $user->nisn)->where('status', 1)->count(),
            'barang_tersedia' => Barang::where('jumlah', '>', 0)->count(),
        ];

        $pengajuan_terbaru = Pengajuan::with(['barang', 'admin'])
                                    ->where('nisn', $user->nisn)
                                    ->latest('tgl_pengajuan')
                                    ->take(5)
                                    ->get();

        $barang_tersedia = Barang::where('jumlah', '>', 0)
                                ->orderBy('nama_barang')
                                ->take(6)
                                ->get();

        return view('user.dashboard', compact(
            'stats', 
            'pengajuan_terbaru', 
            'barang_tersedia', 
            'user'
        ));
    }
}
