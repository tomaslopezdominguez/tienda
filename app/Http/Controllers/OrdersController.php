<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrdersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * ADMIN: listado de pedidos
     */
    public function index()
    {
        // La ruta que llama a este método debe estar protegida por CheckAdminRole en routes
        $orders = Order::with(['usuario', 'items.producto'])->latest()->paginate(20);
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Pedidos del usuario autenticado.
     */
    public function myOrders()
    {
        $user = Auth::user();
        if (! $user) {
            return redirect()->route('login');
        }

        $orders = Order::where('user_id', $user->id)
            ->with('items.producto')
            ->latest()
            ->paginate(12);

        return view('orders.index', compact('orders'));
    }

    /**
     * Mostrar pedido (solo propietario o admin)
     */
    public function show(Order $order)
    {
        $order->load('items.producto', 'usuario');

        $user = Auth::user();
        if (! $user) {
            abort(403, 'No autorizado.');
        }

        // Use helper local para comprobar admin sin lanzar errores
        $isAdmin = $this->userIsAdminSafe($user);

        if (! $isAdmin && $order->user_id !== $user->id) {
            abort(403, 'No tienes permiso para ver este pedido.');
        }

        return $isAdmin ? view('admin.orders.show', compact('order')) : view('orders.show', compact('order'));
    }

    /**
     * ADMIN: cambiar estado del pedido
     */
    public function updateStatus(Request $request, Order $order)
    {
        $allowed = [
            'pendiente',
            'pago_verificado',
            'pago_cancelado',
            'cancelado',
            'enviado',
            'en_reparto',
            'recibido',
        ];

        $data = $request->validate([
            'status' => ['required', 'in:' . implode(',', $allowed)],
        ]);

        $user = Auth::user();
        if (! $user) {
            abort(403, 'No autorizado.');
        }

        $isAdmin = $this->userIsAdminSafe($user);

        if (! $isAdmin) {
            abort(403, 'No autorizado.');
        }

        DB::beginTransaction();
        try {
            $order->update(['status' => $data['status']]);
            DB::commit();
            return back()->with('success', 'Estado actualizado correctamente.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Error al actualizar estado: ' . $e->getMessage());
        }
    }

    /**
     * Helper seguro: determina si $user es admin.
     * No asume existencia de hasRole y captura excepciones que pudieran ocurrir.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    protected function userIsAdminSafe($user): bool
    {
        if (! $user) {
            return false;
        }

        // 1) Si existe el método hasRole, intentamos usarlo (con try/catch)
        if (method_exists($user, 'hasRole')) {
            try {
                return (bool) $user->hasRole('admin');
            } catch (\Throwable $e) {
                // continuar a la comprobación por relación
            }
        }

        // 2) Si existe la relación roles, hacemos una consulta segura a la BD
        if (method_exists($user, 'roles')) {
            try {
                return (bool) $user->roles()->where('slug', 'admin')->exists();
            } catch (\Throwable $e) {
                return false;
            }
        }

        // 3) Fallback: false
        return false;
    }
}
