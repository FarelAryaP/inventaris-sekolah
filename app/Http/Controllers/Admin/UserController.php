<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nisn' => 'required|numeric|unique:user,nisn',
            'nama' => 'required|max:100',
            'kelas' => 'required|max:10',
            'password' => 'required|min:6|confirmed'
        ]);

        User::create($validated);

        return redirect()->route('admin.users.index')
                        ->with('success', 'Siswa berhasil ditambahkan!');
    }

     public function show(User $user)
    {
        $user->load('pengajuan.barang');
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'nama' => 'required|max:100',
            'kelas' => 'required|max:10',
            'password' => 'nullable|min:6|confirmed'
        ]);

        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')
                        ->with('success', 'Data siswa berhasil diupdate!');
    }

    public function destroy(User $user)
    {
        $hasActiveSubmission = $user->pengajuan()
            ->where('status', '!=', 2)
            ->exists();

        if ($hasActiveSubmission) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Gagal menghapus siswa: masih memiliki pengajuan aktif (pending/disetujui).');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Akun siswa berhasil dihapus.');
    }

    public function resetPassword(Request $request, User $user)
    {
        $request->validate([
            'new_password' => 'required|min:6|confirmed'
        ]);

        $user->update([
            'password' => $request->new_password
        ]);

        return back()->with('success', 'Password berhasil direset!');
    }
}