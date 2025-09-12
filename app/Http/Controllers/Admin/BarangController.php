<?php

namespace App\Http\Controllers\Admin;

use App\Models\Barang;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index()
    {
        $barangs = Barang::paginate(10);
        return view('admin.barang.index', compact('barangs'));
    }

    public function create()
    {
        return view('admin.barang.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_barang' => 'required|max:100',
            'jumlah' => 'required|integer|min:0',
            'keterangan' => 'nullable|string'
        ]);

        Barang::create($validated);

        return redirect()->route('admin.barang.index')
                        ->with('success', 'Barang berhasil ditambahkan!');
    }

    public function show(Barang $barang)
    {
        return view('admin.barang.show', compact('barang'));
    }

    public function edit(Barang $barang)
    {
        return view('admin.barang.edit', compact('barang'));
    }

    public function update(Request $request, Barang $barang)
    {
        $validated = $request->validate([
            'nama_barang' => 'required|max:100',
            'jumlah' => 'required|integer|min:0',
            'keterangan' => 'nullable|string'
        ]);

        $barang->update($validated);

        return redirect()->route('admin.barang.index')
                        ->with('success', 'Barang berhasil diupdate!');
    }

    public function destroy(Barang $barang)
    {
        $barang->delete();

        return redirect()->route('admin.barang.index')
                        ->with('success', 'Barang berhasil dihapus!');
    }
}
