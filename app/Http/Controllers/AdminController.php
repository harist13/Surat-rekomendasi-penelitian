<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

   public function akun(Request $request)
    {
        $search = $request->input('search', ''); // Ambil kata kunci pencarian dari request
        $perPage = $request->input('per_page', 10); // Ambil jumlah item per halaman dari request, default 10

        $usersQuery = User::query();

        if ($search) {
            $usersQuery->where('nip', 'like', '%' . $search . '%')
                    ->orWhere('username', 'like', '%' . $search . '%')
                    ->orWhere('no_telp', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
        }

        $users = $usersQuery->paginate($perPage); // Gunakan per_page untuk paginasi
        $roles = Role::all();
        return view('admin.akun', compact('users', 'roles', 'search', 'perPage'));
    }


    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'nip' => 'required|unique:user,nip',
            'username' => 'required|unique:user,username',
            'password' => 'required|min:6',
            'no_telp' => 'required',
            'email' => 'required|email|unique:user,email',
            'role' => 'required|exists:roles,name',
        ]);

        $user = User::create([
            'nip' => $validated['nip'],
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']),
            'no_telp' => $validated['no_telp'],
            'email' => $validated['email'],
            'role' => $validated['role'],
        ]);

        // Assign role to user using Spatie
        $user->assignRole($validated['role']);

        return redirect()->route('akun')->with('success', 'User berhasil ditambahkan');
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'nip' => ['required', Rule::unique('user')->ignore($user->id)],
            'username' => ['required', Rule::unique('user')->ignore($user->id)],
            'no_telp' => 'required',
            'email' => ['required', 'email', Rule::unique('user')->ignore($user->id)],
            'role' => 'required|exists:roles,name',
        ]);

        // Remove role from the data being passed to update()
        $userUpdateData = [
            'nip' => $validated['nip'],
            'username' => $validated['username'],
            'no_telp' => $validated['no_telp'],
            'email' => $validated['email'],
        ];

        // Only update password if a new one is provided
        if ($request->filled('password')) {
            $userUpdateData['password'] = Hash::make($request->password);
        }

        $user->update($userUpdateData);

        // Sync roles using Spatie
        $user->syncRoles([$validated['role']]);

        return redirect()->route('akun')->with('success', 'User berhasil diupdate');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('akun')->with('success', 'User berhasil dihapus');
    }

    public function getUsersData()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function getUserById($id)
    {
        $user = User::findOrFail($id);
        // Add the user's role to the response data
        $userData = $user->toArray();
        $userData['role'] = $user->getRoleNames()->first();
        return response()->json($userData);
    }
}