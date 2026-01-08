<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Pengajuan;
use App\Models\DetailPeminjaman;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LaporanController extends Controller
{
    /**
     * Dashboard Laporan - Overview semua laporan
     */
    public function index()
    {
        $stats = [
            'total_pengajuan' => Pengajuan::count(),
            'total_peminjaman' => DetailPeminjaman::count(),
            'barang_hilang' => DetailPeminjaman::where('status', 2)->count(),
            'keterlambatan' => DetailPeminjaman::where('status', 0)
                ->where('tgl_selesai', '<', now())
                ->count(),
        ];

        return view('admin.laporan.index', compact('stats'));
    }

    /**
     * Laporan Peminjaman
     */
    public function peminjaman(Request $request)
    {
        $query = DetailPeminjaman::with(['pengajuan.user', 'pengajuan.barang']);

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan tanggal
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('tgl_mulai', '>=', $request->tanggal_mulai);
        }
        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('tgl_selesai', '<=', $request->tanggal_selesai);
        }

        // Filter berdasarkan bulan
        if ($request->filled('bulan')) {
            $query->whereMonth('tgl_mulai', $request->bulan);
        }
        if ($request->filled('tahun')) {
            $query->whereYear('tgl_mulai', $request->tahun);
        }

        $peminjamans = $query->latest()->paginate(20);

        // Statistik
        $stats = [
            'total' => $query->count(),
            'dipinjam' => (clone $query)->where('status', 0)->count(),
            'dikembalikan' => (clone $query)->where('status', 1)->count(),
            'hilang' => (clone $query)->where('status', 2)->count(),
        ];

        return view('admin.laporan.peminjaman', compact('peminjamans', 'stats'));
    }

    /**
     * Laporan Barang
     */
    public function barang(Request $request)
    {
        $barangs = Barang::withCount(['pengajuan as total_pengajuan'])
            ->with(['pengajuan' => function($q) {
                $q->where('status', 1); // Hanya yang disetujui
            }])
            ->get()
            ->map(function($barang) {
                $barang->jumlah_dipinjam = $barang->pengajuan->sum('jumlah');
                return $barang;
            });

        // Barang paling sering dipinjam
        $barang_populer = $barangs->sortByDesc('total_pengajuan')->take(10);

        // Barang stok rendah
        $barang_stok_rendah = Barang::where('jumlah', '<', 5)->get();

        // Barang tidak pernah dipinjam
        $barang_tidak_dipinjam = Barang::doesntHave('pengajuan')->get();

        $stats = [
            'total_barang' => Barang::count(),
            'stok_rendah' => $barang_stok_rendah->count(),
            'tidak_dipinjam' => $barang_tidak_dipinjam->count(),
        ];

        return view('admin.laporan.barang', compact('barangs', 'barang_populer', 'barang_stok_rendah', 'barang_tidak_dipinjam', 'stats'));
    }

    /**
     * Laporan Pengajuan
     */
    public function pengajuan(Request $request)
    {
        $query = Pengajuan::with(['user', 'barang', 'admin']);

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan tanggal
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('tgl_pengajuan', '>=', $request->tanggal_mulai);
        }
        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('tgl_pengajuan', '<=', $request->tanggal_selesai);
        }

        // Filter berdasarkan bulan
        if ($request->filled('bulan')) {
            $query->whereMonth('tgl_pengajuan', $request->bulan);
        }
        if ($request->filled('tahun')) {
            $query->whereYear('tgl_pengajuan', $request->tahun);
        }

        $pengajuans = $query->latest('tgl_pengajuan')->paginate(20);

        // Statistik
        $stats = [
            'total' => $query->count(),
            'pending' => (clone $query)->where('status', 0)->count(),
            'approved' => (clone $query)->where('status', 1)->count(),
            'rejected' => (clone $query)->where('status', 2)->count(),
            'approval_rate' => $query->count() > 0 
                ? round(((clone $query)->where('status', 1)->count() / $query->count()) * 100, 2) 
                : 0,
        ];

        return view('admin.laporan.pengajuan', compact('pengajuans', 'stats'));
    }

    /**
     * Laporan Siswa/User
     */
    public function siswa(Request $request)
    {
        $users = User::withCount(['pengajuan as total_pengajuan'])
            ->with(['pengajuan' => function($q) {
                $q->where('status', 1)
                  ->with('detailPeminjaman');
            }])
            ->get()
            ->map(function($user) {
                // Hitung total peminjaman yang disetujui
                $user->total_approved = $user->pengajuan->where('status', 1)->count();
                
                // Hitung keterlambatan
                $user->total_terlambat = $user->pengajuan
                    ->filter(function($pengajuan) {
                        return $pengajuan->detailPeminjaman 
                            && $pengajuan->detailPeminjaman->status == 0
                            && $pengajuan->detailPeminjaman->tgl_selesai < now();
                    })
                    ->count();
                
                return $user;
            });

        // Siswa paling aktif
        $siswa_aktif = $users->sortByDesc('total_pengajuan')->take(10);

        // Siswa dengan keterlambatan
        $siswa_terlambat = $users->filter(function($user) {
            return $user->total_terlambat > 0;
        })->sortByDesc('total_terlambat');

        $stats = [
            'total_siswa' => User::count(),
            'siswa_aktif' => $users->where('total_pengajuan', '>', 0)->count(),
            'siswa_terlambat' => $siswa_terlambat->count(),
        ];

        return view('admin.laporan.siswa', compact('users', 'siswa_aktif', 'siswa_terlambat', 'stats'));
    }

    /**
     * Export Laporan ke PDF (placeholder - perlu library)
     */
    public function exportPdf($type)
    {
        // TODO: Implement PDF export with dompdf or similar
        return back()->with('info', 'Fitur export PDF akan segera hadir');
    }
}