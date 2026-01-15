<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::orderBy('id', 'desc')->paginate(10);
        return view('admin.coupons.index', compact('coupons'));
    }

    public function create()
    {
        return view('admin.coupons.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:coupons,code|max:50',
            'type' => 'required|in:fixed,percent',
            'value' => 'required|numeric|min:0.01',
            'min_order_price' => 'nullable|numeric|min:0',
            'expires_at' => 'nullable|date|after_or_equal:today',
            // Cambiamos 'boolean' por 'nullable' aquí para manejar el checkbox
            'is_active' => 'nullable', 
        ]);
        
        $data = $request->all();
        
        // CORRECCIÓN: Si el checkbox no viene en el request, le asignamos false (0)
        $data['is_active'] = $request->has('is_active') ? true : false;

        Coupon::create($data);

        return redirect()->route('admin.coupons.index')->with('success', 'Cupón creado correctamente.');
    }

    public function edit(Coupon $coupon)
    {
        return view('admin.coupons.edit', compact('coupon'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        $request->validate([
            'code' => 'required|string|max:50|unique:coupons,code,' . $coupon->id,
            'type' => 'required|in:fixed,percent',
            'value' => 'required|numeric|min:0.01',
            'min_order_price' => 'nullable|numeric|min:0',
            'expires_at' => 'nullable|date|after_or_equal:today',
            'is_active' => 'nullable',
        ]);
        
        $data = $request->all();
        
        // CORRECCIÓN: Manejo del checkbox en la actualización
        $data['is_active'] = $request->has('is_active') ? true : false;

        $coupon->update($data);

        return redirect()->route('admin.coupons.index')->with('success', 'Cupón actualizado correctamente.');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return redirect()->route('admin.coupons.index')->with('success', 'Cupón eliminado correctamente.');
    }
}