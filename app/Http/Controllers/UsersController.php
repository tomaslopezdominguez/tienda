<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    public function __construct()
    {
        // Protegemos todo este controlador para que sólo acceda admin
        $this->middleware('auth');
        $this->middleware(\App\Http\Middleware\CheckAdminRole::class);
    }

    /**
     * Listado de usuarios (admin).
     */
    public function index()
    {
        $users = User::with('roles')->latest()->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Formulario de creación.
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Guardar nuevo usuario.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'roles'    => 'array'
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'name'  => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            if (!empty($data['roles'])) {
                $user->roles()->sync($data['roles']);
            }

            DB::commit();
            return redirect()->route('admin.users.index')->with('success', 'Usuario creado correctamente.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error al crear usuario: '.$e->getMessage());
        }
    }

    /**
     * Mostrar usuario (admin).
     */
    public function show(User $user)
    {
        $user->load('roles');
        return view('admin.users.show', compact('user'));
    }

    /**
     * Formulario edición.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        $user->load('roles');
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Actualizar usuario.
     */
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,'.$user->id,
            'password' => 'nullable|string|min:6|confirmed',
            'roles'    => 'array'
        ]);

        DB::beginTransaction();
        try {
            $updateData = [
                'name'  => $data['name'],
                'email' => $data['email'],
            ];

            if (!empty($data['password'])) {
                $updateData['password'] = Hash::make($data['password']);
            }

            $user->update($updateData);

            // Sincronizar roles (si no viene roles -> detach)
            $user->roles()->sync($data['roles'] ?? []);

            DB::commit();
            return redirect()->route('admin.users.index')->with('success', 'Usuario actualizado correctamente.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error al actualizar usuario: '.$e->getMessage());
        }
    }

    /**
     * Eliminar usuario (proteger último admin).
     */
    public function destroy(User $user)
    {
        // No permitir que admin se elimine a sí mismo desde aquí (opcional)
        $me = Auth::user();
        if ($me && $me->id === $user->id) {
            return back()->with('error', 'No puedes eliminar tu propia cuenta desde el panel admin.');
        }

        // Si el usuario tiene rol admin, prevenir eliminar último admin
        $adminRole = Role::where('slug', 'admin')->first();
        if ($adminRole && $user->hasRole('admin')) {
            $numAdmins = $adminRole->users()->count();
            if ($numAdmins <= 1) {
                return back()->with('error', 'No se puede eliminar al último administrador.');
            }
        }

        DB::beginTransaction();
        try {
            $user->roles()->detach();
            $user->delete();
            DB::commit();
            return redirect()->route('admin.users.index')->with('success', 'Usuario eliminado correctamente.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Error al eliminar usuario: '.$e->getMessage());
        }
    }

    /**
     * Mis roles (usuario autenticado).
     */
    public function myRoles()
    {
        $user = Auth::user();
        $roles = Role::all();
        return view('admin.myroles', compact('user', 'roles'));
    }
}
