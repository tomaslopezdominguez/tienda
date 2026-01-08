<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionController extends Controller
{
    /**
     * Guarda un dato en la sesión.
     */
    public function set(Request $request)
    {
        $request->session()->put('message', 'Hola desde la sesión');
        return 'Dato guardado en la sesión';
    }

    /**
     * Recupera un dato de la sesión.
     */
    public function get(Request $request)
    {
        $value = $request->session()->get('message');
        if ($value) {
            return "El valor de la sesión es: " . $value;
        } else {
            return "No hay datos en la sesión";
        }
    }

    /**
     * Elimina todos los datos de la sesión.
     */
    public function destroyAll(Request $request)
    {
        $request->session()->flush();
        return 'Todos los datos de la sesión han sido eliminados.';
    }

    /**
     * Elimina un dato específico de la sesión.
     */
    public function destroySpecific(Request $request)
    {
        $request->session()->forget('carrito');
        return 'El dato "carrito" ha sido eliminado de la sesión.';
    }
}