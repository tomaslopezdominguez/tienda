<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // --- MÉTODOS DE LOGIN ---
    
    /**
     * Muestra el formulario de login.
     */
    public function login()
    {
        // Redirige al dashboard si ya está logueado
        if (Auth::check()) {
            return redirect()->route('dashboard'); 
        }
        return view('auth.login');
    }

    /**
     * Procesa la solicitud de login.
     */
    public function postLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Redirige al dashboard general (que a su vez llama al método dashboard para la lógica de roles)
            return redirect()->route('dashboard'); 
        }

        // Falla de autenticación
        throw ValidationException::withMessages([
            'email' => ['Las credenciales proporcionadas no coinciden con nuestros registros.'],
        ]);
    }

    /**
     * Cierra la sesión del usuario.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    // --- MÉTODOS DE REGISTRO ---

    public function showRegistrationForm()
    {
        // Redirige al dashboard si ya está logueado
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        
        // Retorna la vista de registro
        return view('auth.register'); 
    }

    public function postRegister(Request $request)
    {
        // 1. Validar los datos
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'], 
            'password' => ['required', 'string', 'min:8', 'confirmed'], 
        ]);

        // 2. Crear el usuario
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        // 3. Iniciar sesión y redirigir
        Auth::login($user);
        $request->session()->regenerate();

        // Redirige al dashboard general
        return redirect()->route('dashboard')->with('status', '¡Registro exitoso! Ya has iniciado sesión.');
    }

    // --- MÉTODOS PRIVADOS Y DASHBOARD ---

    /**
     * Dashboard general.
     * Verifica el rol y decide la redirección.
     */
    public function dashboard()
    {
        /** @var User $user */
        $user = Auth::user();

        // CORREGIDO: Usamos la ruta correcta 'admin.dashboard'
        // También se elimina el 'method_exists' innecesario ya que el modelo User lo tiene.
        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard'); // <--- ¡AQUÍ ESTÁ EL CAMBIO!
        }

        // Si es un usuario normal, va a la vista de usuario estándar
        return view('dashboard.user_home');
    }

    /**
     * Muestra el panel principal del área privada (solo para 'admin').
     */
    public function private()
    {
        // NOTA: Este método 'private' no es llamado por el dashboard, pero se deja por si lo necesitas.
        return view('admin.private'); 
    }

    /**
     * Muestra los roles del usuario actual (solo para 'admin').
     */
    public function myroles()
    {
        /** @var User $user */
        $user = Auth::user();

        // Carga los roles si el método existe
        $roles = method_exists($user, 'roles') ? $user->roles()->pluck('name')->toArray() : ['No roles method defined'];

        return view('admin.myroles', compact('user', 'roles')); 
    }
}