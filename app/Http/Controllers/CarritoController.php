<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\OrderItem;
use App\Models\Coupon; // ¡Importar el modelo Coupon!
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Exception; // Para manejar excepciones en el checkout
use App\Models\Order;


class CarritoController extends Controller
{
    /**
     * Agrega un producto al carrito o incrementa su cantidad.
     */
    public function agregar(Request $request)
    {
        $productoId = $request->input('producto_id');
        $producto = Producto::find($productoId);

        if (!$producto) {
            return redirect()->back()->with('error', 'El producto no existe.');
        }

        $carrito = $request->session()->get('carrito', []);

        // 1. Obtener la cantidad que ya hay en el carrito
        $cantidad_actual = isset($carrito[$productoId]) ? $carrito[$productoId]['cantidad'] : 0;
        $cantidad_solicitada = $cantidad_actual + 1; // Se está añadiendo una unidad más

        // 2. COMPROBACIÓN DE STOCK: Validar la cantidad total solicitada
        if ($producto->stock < $cantidad_solicitada) {
            return redirect()->back()->with('error', 'Stock insuficiente. Solo quedan ' . $producto->stock . ' unidades de ' . $producto->nombre . ' disponibles.');
        }

        // 3. Actualizar la sesión si el stock es suficiente
        if (isset($carrito[$productoId])) {
            $carrito[$productoId]['cantidad']++;
        } else {
            $carrito[$productoId] = [
                'id' => $producto->id,
                'nombre' => $producto->nombre,
                'precio' => $producto->precio,
                'cantidad' => 1,
                'imagen' => $producto->imagen ?? null, // Opcional: para mostrar en el carrito
            ];
        }

        $request->session()->put('carrito', $carrito);

        return redirect()->back()->with('success', 'Producto añadido al carrito.');
    }

    /**
     * Muestra la página del carrito, pasando el carrito y el cupón aplicado.
     */
    public function mostrar(Request $request)
    {
        $carrito = $request->session()->get('carrito', []);
        $coupon = $request->session()->get('coupon', null); // Obtener cupón de la sesión
        
        // El cupón se pasa a la vista para mostrar el descuento
        return view('carrito.index', compact('carrito', 'coupon'));
    }

    /**
     * Actualiza la cantidad de un producto en el carrito. (PATCH)
     */
    public function actualizar(Request $request, $id)
    {
        $request->validate(['cantidad' => 'required|integer|min:1']);
        $cantidad = (int)$request->input('cantidad');
        
        // Obtener el producto para comprobar su stock
        $producto = Producto::find($id);

        if (!$producto) {
            return redirect()->route('carrito.mostrar')->with('error', 'Producto no encontrado.');
        }

        // COMPROBACIÓN DE STOCK: Validar la nueva cantidad total
        if ($producto->stock < $cantidad) {
            return redirect()->route('carrito.mostrar')->with('error', 'La cantidad solicitada de ' . $producto->nombre . ' excede el stock disponible (' . $producto->stock . ' unidades).');
        }

        $carrito = $request->session()->get('carrito', []);

        if (isset($carrito[$id])) {
            $carrito[$id]['cantidad'] = $cantidad;
            $request->session()->put('carrito', $carrito);
            return redirect()->route('carrito.mostrar')->with('success', 'Cantidad de producto actualizada.');
        }

        return redirect()->route('carrito.mostrar')->with('error', 'Producto no encontrado en el carrito.');
    }

    /**
     * Elimina un producto del carrito. (DELETE)
     */
    public function eliminar(Request $request, $id)
    {
        $carrito = $request->session()->get('carrito', []);

        if (isset($carrito[$id])) {
            unset($carrito[$id]);
            $request->session()->put('carrito', $carrito);
            return redirect()->route('carrito.mostrar')->with('warning', 'Producto eliminado del carrito.');
        }

        return redirect()->route('carrito.mostrar')->with('error', 'Producto no encontrado en el carrito.');
    }

    /**
     * Checkout: crea un pedido (Order) a partir del carrito en sesión.
     */
    public function checkout(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para finalizar el pedido.');
        }

        $carrito = $request->session()->get('carrito', []);

        if (empty($carrito)) {
            return redirect()->route('carrito.mostrar')->with('error', 'El carrito está vacío.');
        }

        DB::beginTransaction();

        try {
            $total = 0;
            $items = [];

            // 1. Recorrido y comprobación de stock con bloqueo
            foreach ($carrito as $line) {
                // Bloqueo para evitar problemas de concurrencia
                $producto = Producto::lockForUpdate()->find($line['id']); 

                if (!$producto) {
                    throw new Exception("Producto no encontrado: ID {$line['id']}");
                }

                $cantidad = max(1, (int)$line['cantidad']);

                // COMPROBACIÓN DE STOCK FINAL (con bloqueo)
                if ($producto->stock < $cantidad) {
                    throw new Exception("Stock insuficiente para {$producto->nombre} (disponible: {$producto->stock}).");
                }

                $subtotal = $producto->precio * $cantidad;
                $total += $subtotal;

                $items[] = [
                    'producto' => $producto,
                    'cantidad' => $cantidad,
                    'precio' => $producto->precio,
                ];
            }

            // 2. LÓGICA DE CUPÓN Y DESCUENTO
            $coupon = $request->session()->get('coupon', null);
            $discount = 0;
            
            if ($coupon) {
                $discount = $this->calculateDiscount($total, $coupon); 
                $total -= $discount; 
                $total = max(0, $total); // Asegurar que el total no sea negativo
            }

            // 3. Crear pedido
            $order = Order::create([
                'user_id' => Auth::id(),
                'total' => $total, // Total CON descuento
                'discount' => $discount, // Guardar el valor del descuento
                'coupon_code' => $coupon['code'] ?? null, // Guardar el código del cupón
                'status' => 'pendiente',
                'metodo_pago' => $request->input('metodo_pago', null),
                // FALTA: añadir 'direccion_id' aquí
            ]);

            // 4. Crear order_items y reducir stock
            foreach ($items as $it) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'producto_id' => $it['producto']->id,
                    'cantidad' => $it['cantidad'],
                    'precio' => $it['precio'],
                ]);

                // Reducir stock del producto
                $it['producto']->decrement('stock', $it['cantidad']);
            }

            DB::commit();

            // 5. Vaciar carrito y cupón
            $request->session()->forget('carrito');
            $request->session()->forget('coupon'); 

            return redirect()->route('orders.show', $order)->with('success', 'Pedido creado correctamente.');

        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('carrito.mostrar')->with('error', 'Error al crear el pedido: '.$e->getMessage());
        }
    }

    /**
     * Aplica un cupón al carrito validando sus condiciones.
     */
    public function aplicarCupon(Request $request)
    {
        $couponCode = strtoupper($request->input('coupon_code'));
        
        if (empty($couponCode)) {
            $request->session()->forget('coupon');
            return redirect()->route('carrito.mostrar')->with('warning', 'Cupón eliminado del carrito.');
        }

        $coupon = Coupon::where('code', $couponCode)->first();

        // 1. Validar existencia
        if (!$coupon) {
            return redirect()->route('carrito.mostrar')->with('error', 'Código de cupón no válido.');
        }

        // 2. Validar que esté activo y no haya expirado (usando método del modelo)
        if (!$coupon->isValid()) {
            return redirect()->route('carrito.mostrar')->with('error', 'Este cupón no es válido o ha expirado.');
        }
        
        // Calcular el subtotal del carrito para la comprobación de precio mínimo
        $carrito = $request->session()->get('carrito', []);
        $subtotal = 0;
        foreach ($carrito as $item) {
            $subtotal += $item['precio'] * $item['cantidad'];
        }

        // 3. Validar precio mínimo de pedido
        if ($subtotal < $coupon->min_order_price) {
            return redirect()->route('carrito.mostrar')->with('error', 'El pedido mínimo para aplicar este cupón es de ' . number_format($coupon->min_order_price, 2) . ' €.');
        }

        // 4. Si todo es válido, guardar el cupón en la sesión
        $request->session()->put('coupon', [
            'code' => $coupon->code,
            'type' => $coupon->type,
            'value' => $coupon->value,
        ]);

        return redirect()->route('carrito.mostrar')->with('success', 'Cupón ' . $coupon->code . ' aplicado correctamente.');
    }
    
    /**
     * Elimina el cupón de la sesión.
     */
    public function eliminarCupon(Request $request)
    {
        $request->session()->forget('coupon');
        return redirect()->route('carrito.mostrar')->with('warning', 'Cupón eliminado.');
    }
    
    /**
     * Calcula el descuento aplicado por el cupón (función auxiliar)
     */
    private function calculateDiscount($subtotal, $coupon)
    {
        if (empty($coupon)) {
            return 0;
        }

        if ($coupon['type'] === 'fixed') {
            // Descuento fijo
            $discount = $coupon['value'];
            // Asegurar que el descuento no sea mayor que el subtotal
            return min($discount, $subtotal); 
        } 
        
        if ($coupon['type'] === 'percent') {
            // Descuento porcentual
            return $subtotal * ($coupon['value'] / 100);
        }

        return 0;
    }
}