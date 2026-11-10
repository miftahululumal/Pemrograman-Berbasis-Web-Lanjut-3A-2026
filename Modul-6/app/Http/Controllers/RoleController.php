<?php

namespace App\Http\Controllers;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    // Menampilkan daftar role
    public function index()
    {
        $roles = Role::with('permissions')->get();

        return view('role.index', compact('roles'));
    }

    // Menampilkan form tambah role
    public function create()
    {
        return view('role.create');
    }

    // Menyimpan role baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
        ]);

        Role::create([
            'name' => $request->name,
            'guard_name' => 'web',
        ]);

        return redirect()->route('role.index')
            ->with('success', 'Role berhasil ditambahkan.');
    }

    // Menampilkan form edit role
    public function edit($id)
    {
        $role = Role::with('permissions')->findOrFail($id);

        return view('role.edit', compact('role'));
    }

    // Memperbarui role dan permission
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('roles', 'name')->ignore($role->id),
            ],
            'permissions' => 'nullable|array',
            'permissions.*' => 'string|exists:permissions,name',
        ]);

        $role->update([
            'name' => $request->name,
        ]);

        $permissions = $request->input('permissions', []);

        $role->syncPermissions($permissions);

        return redirect()->route('role.index')
            ->with('success', 'Role dan permission berhasil diperbarui.');
    }

    // Menghapus role
    public function destroy($id)
    {
        $role = Role::findOrFail($id);

        if (in_array($role->name, ['admin', 'petugas', 'siswa'])) {
            return redirect()->route('role.index')
                ->with('error', 'Role bawaan sistem tidak boleh dihapus.');
        }

        if ($role->users()->exists()) {
            return redirect()->route('role.index')
                ->with('error', 'Role masih digunakan oleh pengguna.');
        }

        $role->delete();

        return redirect()->route('role.index')
            ->with('success', 'Role berhasil dihapus.');
    }
}
