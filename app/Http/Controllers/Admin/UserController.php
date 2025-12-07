<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::latest()->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'role' => 'required|in:lector,editor,admin',
            'is_active' => 'nullable|boolean',
        ]);

        // Evitar que el admin se quite su propio rol de admin
        if ($user->id === auth()->id() && $data['role'] !== 'admin') {
            return back()->withErrors(['role' => 'No puedes cambiar tu propio rol de administrador.']);
        }

        // Si is_active no viene en el request, mantener el valor actual
        if (!isset($data['is_active'])) {
            $data['is_active'] = $user->is_active;
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('status', 'Usuario actualizado exitosamente.');
    }

    /**
     * Toggle user active status
     */
    public function toggleStatus(User $user)
    {
        // Evitar que el admin se desactive a sí mismo
        if ($user->id === auth()->id()) {
            return back()->withErrors(['error' => 'No puedes desactivarte a ti mismo.']);
        }

        $user->is_active = !$user->is_active;
        $user->save();

        $status = $user->is_active ? 'activado' : 'desactivado';
        return back()->with('status', "Usuario {$status} exitosamente.");
    }
}