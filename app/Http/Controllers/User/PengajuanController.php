<?php
// app/Http/Controllers/User/PengajuanController.php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Pengajuan;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengajuanController extends Controller
{
    public function index()
    {
        $user = Auth::guard('user')->user();

        $pengajuans = Pengajuan::with(['barang', 'admin'])
                              ->where('nisn', $user->nisn)
                              ->latest()
                              ->paginate(10);
        
        return view('user.pengajuan.index', compact('pengajuans'));
    }

    public function create()
    {
        $barangs = Barang::where('jumlah', '>', 0)->get();
        return view('user.pengajuan.create', compact('barangs'));
    }

    public function store(Request $request)
    {
        $user = Auth::guard('user')->user();
        
        $validated = $request->validate([
            'id_barang' => 'required|exists:barang,id_barang',
            'jumlah' => 'required|integer|min:1',
            'tgl_mulai' => 'required|date|after_or_equal:today',
            'tgl_selesai' => 'required|date|after:tgl_mulai'
        ]);

        // Cek stok barang
        $barang = Barang::find($validated['id_barang']);
        if ($barang->jumlah < $validated['jumlah']) {
            return back()->withErrors([
                'jumlah' => 'Stok barang tidak mencukupi. Stok tersedia: ' . $barang->jumlah
            ])->withInput();
        }

        Pengajuan::create([
            'nisn' => $user->nisn,
            'id_barang' => $validated['id_barang'],
            'jumlah' => $validated['jumlah'],
            'tgl_pengajuan' => now(),
            'tgl_mulai' => $validated['tgl_mulai'],
            'tgl_selesai' => $validated['tgl_selesai'],
            'status' => 0 // pending
        ]);

        return redirect()->route('user.pengajuan.index')
                        ->with('success', 'Pengajuan berhasil disubmit!');
    }

    public function show(Pengajuan $pengajuan)
    {
        $user = Auth::guard('user')->user();
        
        // Pastikan user hanya bisa melihat pengajuan sendiri
        if ($pengajuan->nisn != $user->nisn) {
            abort(403);
        }

        return view('user.pengajuan.show', compact('pengajuan'));
    }
}