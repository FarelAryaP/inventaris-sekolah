<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengajuan;
use App\Models\detail_peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PengajuanController extends Controller
{
    public function index()
    {
        $pengajuans = Pengajuan::with(['user', 'barang', 'admin'])
                              ->latest()
                              ->paginate(10);
        
        return view('admin.pengajuan.index', compact('pengajuans'));
    }

    public function show(Pengajuan $pengajuan)
    {
        return view('admin.pengajuan.show', compact('pengajuan'));
    }

    public function approve(Request $request, Pengajuan $pengajuan)
    {
        if ($pengajuan->status != 0) {
            return back()->withErrors(['error' => 'Pengajuan sudah diproses!']);
        }

        DB::transaction(function () use ($pengajuan, $request) {
            $barang = $pengajuan->barang;
            
            if ($barang->jumlah < $pengajuan->jumlah) {
                throw new \Exception('Stok barang tidak mencukupi!');
            }

            $pengajuan->update([
                'status' => 1, // approved
                'id_admin' => Auth::guard('admin')->id()
            ]);

            $barang->decrement('jumlah', $pengajuan->jumlah);

            detail_peminjaman::create([
                'id_pengajuan' => $pengajuan->id_pengajuan,
                'tgl_mulai' => $pengajuan->tgl_mulai,
                'tgl_selesai' => $pengajuan->tgl_selesai,
                'status' => 0 // dipinjam
            ]);
        });

        return redirect()->route('admin.pengajuan.index')
                        ->with('success', 'Pengajuan berhasil disetujui!');
    }

    public function reject(Request $request, Pengajuan $pengajuan)
    {
        if ($pengajuan->status != 0) {
            return back()->withErrors(['error' => 'Pengajuan sudah diproses!']);
        }

        $pengajuan->update([
            'status' => 2, // rejected
            'id_admin' => Auth::guard('admin')->id()
        ]);

        return redirect()->route('admin.pengajuan.index')
                        ->with('success', 'Pengajuan berhasil ditolak!');
    }
}