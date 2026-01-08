<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CouponController extends Controller
{
    /**
     * Muestra una lista de todos los cupones.
     */
    public function index()
    {
        $coupons = Coupon::orderBy('id', 'desc')->paginate(10);
        return view('admin.coupons.index', compact('coupons'));
    }

    /**
     * Muestra el formulario para crear un nuevo cupón.
     */
    public function create()
    {
        return view('admin.coupons.create');
    }

    /**
     * Almacena un nuevo cupón en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:coupons,code|max:50',
            'type' => 'required|in:fixed,percent',
            'value' => 'required|numeric|min:0.01',
            'min_order_price' => 'nullable|numeric|min:0',
            'expires_at' => 'nullable|date|after_or_equal:today',
            'is_active' => 'boolean',
        ]);
        
        $data = $request->all();
        $data['is_active'] = $request->has('is_active'); // checkbox handling

        Coupon::create($data);

        return redirect()->route('admin.coupons.index')->with('success', 'Cupón creado correctamente.');
    }

    /**
     * Muestra el formulario para editar un cupón existente.
     */
    public function edit(Coupon $coupon)
    {
        return view('admin.coupons.edit', compact('coupon'));
    }

    /**
     * Actualiza el cupón especificado en la base de datos.
     */
    public function update(Request $request, Coupon $coupon)
    {
        $request->validate([
            // Excluir el cupón actual de la comprobación de unicidad
            'code' => 'required|string|max:50|unique:coupons,code,' . $coupon->id,
            'type' => 'required|in:fixed,percent',
            'value' => 'required|numeric|min:0.01',
            'min_order_price' => 'nullable|numeric|min:0',
            'expires_at' => 'nullable|date|after_or_equal:today',
            'is_active' => 'boolean',
        ]);
        
        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        $coupon->update($data);

        return redirect()->route('admin.coupons.index')->with('success', 'Cupón actualizado correctamente.');
    }

    /**
     * Elimina el cupón especificado.
     */
    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return redirect()->route('admin.coupons.index')->with('success', 'Cupón eliminado correctamente.');
    }
}