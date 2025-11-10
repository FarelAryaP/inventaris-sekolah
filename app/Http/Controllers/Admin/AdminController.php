<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    /**
     * Display a listing of admins.
     */
    public function index()
    {
        $admins = Admin::with('role')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.admins.index', compact('admins'));
    }

    /**
     * Show the form for creating a new admin.
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.admins.create', compact('roles'));
    }

    /**
     * Store a newly created admin in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:100|unique:admin,username',
            'nama' => 'required|string|max:100',
            'password' => 'required|string|min:8|confirmed',
            'id_role' => 'required|exists:role,id_role'
        ], [
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'nama.required' => 'Nama wajib diisi.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'id_role.required' => 'Role wajib dipilih.',
            'id_role.exists' => 'Role tidak valid.'
        ]);

        Admin::create($validated);

        return redirect()->route('admin.admins.index')
            ->with('success', 'Admin berhasil ditambahkan.');
    }

    /**
     * Display the specified admin.
     */
    public function show(Admin $admin)
    {
        $admin->load('role', 'pengajuan');
        return view('admin.admins.show', compact('admin'));
    }

    /**
     * Show the form for editing the specified admin.
     */
    public function edit(Admin $admin)
    {
        $roles = Role::all();
        return view('admin.admins.edit', compact('admin', 'roles'));
    }

    /**
     * Update the specified admin in storage.
     */
    public function update(Request $request, Admin $admin)
    {
        $validated = $request->validate([
            'username' => [
                'required',
                'string',
                'max:100',
                Rule::unique('admin', 'username')->ignore($admin->id_admin, 'id_admin')
            ],
            'nama' => 'required|string|max:100',
            'password' => 'nullable|string|min:8|confirmed',
            'id_role' => 'required|exists:role,id_role'
        ], [
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'nama.required' => 'Nama wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'id_role.required' => 'Role wajib dipilih.',
            'id_role.exists' => 'Role tidak valid.'
        ]);

        // Jika password tidak diisi, hapus dari array validated
        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        $admin->update($validated);

        return redirect()->route('admin.admins.index')
            ->with('success', 'Admin berhasil diperbarui.');
    }

    /**
     * Remove the specified admin from storage.
     */
    public function destroy(Admin $admin)
    {
        // Prevent deleting self
        if ($admin->id_admin === auth()->guard('admin')->id()) {
            return redirect()->route('admin.admins.index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        // Check if admin has related pengajuan
        if ($admin->pengajuan()->count() > 0) {
            return redirect()->route('admin.admins.index')
                ->with('error', 'Admin tidak dapat dihapus karena memiliki data pengajuan terkait.');
        }

        $admin->delete();

        return redirect()->route('admin.admins.index')
            ->with('success', 'Admin berhasil dihapus.');
    }

    /**
     * Reset admin password.
     */
    public function resetPassword(Request $request, Admin $admin)
    {
        $validated = $request->validate([
            'password' => 'required|string|min:8|confirmed'
        ], [
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.'
        ]);

        $admin->update(['password' => $validated['password']]);

        return redirect()->route('admin.admins.index')
            ->with('success', 'Password admin berhasil direset.');
    }
}