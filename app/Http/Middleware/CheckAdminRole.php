<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // <- importar el modelo
use Symfony\Component\HttpFoundation\Response;

class CheckAdminRole
{
    /**
     * Maneja una solicitud entrante.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1) Si no está autenticado -> redirigir a login
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        // 2) Obtener el usuario autenticado
        /** @var User|null $user */
        $user = Auth::user();

        // 3) Si por alguna razón no es el modelo User o es null -> negar acceso
        if (! $user instanceof User) {
            return redirect('/')->with('error', 'Acceso no autorizado.');
        }

        // 4) Verificación segura: usa method_exists por si el método no existe
        if (method_exists($user, 'hasRole') && $user->hasRole('admin')) {
            return $next($request);
        }

        // 5) Si no es admin -> redirigir al home con mensaje de error
        return redirect('/')->with('error', 'Acceso no autorizado. Se requiere rol de Administrador.');
    }
}
