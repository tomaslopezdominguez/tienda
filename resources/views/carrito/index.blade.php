@extends('layouts.plantilla')

@section('title', 'Tu Carrito de Compra')

@section('content')
<div class="container mx-auto px-4 py-12" style="min-height: 70vh;">
    {{-- ENCABEZADO PRINCIPAL - CORREGIDO CON ESTILOS FIJOS --}}
    <div class="flex flex-col items-center mb-10 text-center">
        {{-- Forzamos el tamaño del círculo para que el icono no crezca --}}
        <div style="width: 80px; height: 80px; background-color: #eef2ff; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-bottom: 1rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <i class="fas fa-shopping-bag" style="color: #4f46e5; font-size: 32px;"></i>
        </div>
        <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight">Tu Carrito</h1>
        <p class="text-gray-500 mt-2">Gestiona tus artículos antes de finalizar el pedido.</p>
    </div>

    @include('partials.alerts')

    @if(empty($carrito))
        {{-- VISTA CARRITO VACÍO: FORZANDO VISIBILIDAD DEL BOTÓN --}}
        <div class="max-w-md mx-auto text-center bg-white p-10 rounded-3xl shadow-sm border border-gray-100" style="background-color: white !important;">
            <div style="font-size: 60px; margin-bottom: 20px;">🛒</div>
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Tu carrito está vacío</h2>
            <p class="text-gray-500 mb-8">Parece que aún no has añadido nada a tu bolsa de la compra.</p>
            
            <a href="{{ route('productos.index') }}" 
               class="btn" 
               style="background-color: #4f46e5 !important; color: white !important; font-weight: bold; padding: 15px 30px; border-radius: 15px; display: block; width: 100%; text-decoration: none; border: none; box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.3);">
                Explorar Productos
            </a>
        </div>
    @else
        @php
            $subtotalGeneral = 0;
            foreach($carrito as $item) { $subtotalGeneral += $item['precio'] * $item['cantidad']; }
            $discount = 0;
            if ($coupon) {
                if ($coupon['type'] == 'fixed') { $discount = min($coupon['value'], $subtotalGeneral); }
                elseif ($coupon['type'] == 'percent') { $discount = $subtotalGeneral * ($coupon['value'] / 100); }
            }
            $totalFinal = max(0, $subtotalGeneral - $discount);
        @endphp

        {{-- BARRA DE NAVEGACIÓN: FORZANDO EL BOTÓN VOLVER --}}
        <div class="max-w-7xl mx-auto flex justify-between items-center mb-8 bg-white p-4 rounded-2xl shadow-sm border border-gray-100" style="background-color: white !important;">
            <div class="flex items-center">
                <div style="background-color: #4f46e5; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 8px;">
                    <i class="fas fa-cart-arrow-down" style="color: white;"></i>
                </div>
                <div class="ml-4 hidden sm:block">
                    <h2 class="text-sm font-bold text-gray-900 leading-none">Mi Selección</h2>
                    <span class="text-xs text-gray-500">{{ count($carrito) }} productos</span>
                </div>
            </div>

            <a href="{{ route('productos.index') }}" 
               style="background-color: #f5f7ff; color: #4338ca; font-weight: bold; padding: 8px 16px; border-radius: 10px; text-decoration: none; font-size: 14px; border: 1px solid #e0e7ff; display: inline-flex; align-items: center;">
                <i class="fas fa-arrow-left" style="margin-right: 8px;"></i> Seguir comprando
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            {{-- LISTADO DE PRODUCTOS --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="hidden md:grid grid-cols-12 bg-gray-50 p-4 text-xs font-bold text-gray-500 uppercase tracking-widest">
                        <div class="col-span-6">Producto</div>
                        <div class="col-span-2 text-center">Precio</div>
                        <div class="col-span-2 text-center">Cantidad</div>
                        <div class="col-span-2 text-right pe-4">Subtotal</div>
                    </div>

                    <div class="divide-y divide-gray-100">
                        @foreach($carrito as $id => $item)
                            <div class="grid grid-cols-1 md:grid-cols-12 p-6 items-center gap-4 hover:bg-gray-50 transition-colors">
                                <div class="col-span-1 md:col-span-6 flex items-center">
                                    <div style="width: 64px; height: 64px; background-color: #f3f4f6; border-radius: 12px; display: flex; align-items: center; justify-content: center; border: 1px solid #e5e7eb; overflow: hidden;">
                                        @if(isset($item['imagen']) && $item['imagen'])
                                            <img src="{{ asset('storage/' . $item['imagen']) }}" style="width: 100%; height: 100%; object-fit: cover;">
                                        @else
                                            <i class="fas fa-image text-2xl text-gray-400"></i>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="font-bold text-gray-900">{{ $item['nombre'] }}</h3>
                                        <form action="{{ route('carrito.eliminar', $id) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button type="submit" style="color: #ef4444; font-size: 12px; background: transparent; border: none; cursor: pointer; font-weight: 600;">
                                                <i class="fas fa-trash-alt" style="margin-right: 4px;"></i> Quitar artículo
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <div class="col-span-1 md:col-span-2 text-center">
                                    <span class="text-gray-600 font-medium">{{ number_format($item['precio'], 2) }}€</span>
                                </div>

                                <div class="col-span-1 md:col-span-2 flex justify-center">
                                    <form action="{{ route('carrito.actualizar', $id) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <div style="background-color: #f9fafb; border: 1px solid #e5e7eb; border-radius: 10px; padding: 0 8px;">
                                            <input type="number" name="cantidad" value="{{ $item['cantidad'] }}" min="1" 
                                                style="width: 45px; border: none; background: transparent; text-align: center; font-weight: bold; padding: 8px 0;" 
                                                onchange="this.form.submit()">
                                        </div>
                                    </form>
                                </div>

                                <div class="col-span-1 md:col-span-2 text-right">
                                    <span style="color: #4f46e5; font-weight: bold;">{{ number_format($item['precio'] * $item['cantidad'], 2) }}€</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- PANEL DE RESUMEN --}}
            <div class="lg:col-span-1">
                {{-- Cupón --}}
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 mb-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">¿Tienes un cupón?</h3>
                    <form action="{{ route('carrito.aplicar-cupon') }}" method="POST" class="flex gap-2">
                        @csrf
                        <input type="text" name="coupon_code" placeholder="Código" style="flex-grow: 1; padding: 10px; border: 1px solid #e5e7eb; border-radius: 12px; background-color: #f9fafb; outline: none;">
                        <button type="submit" style="background-color: #1f2937; color: white; padding: 10px 20px; border-radius: 12px; border: none; font-weight: bold; font-size: 14px;">Aplicar</button>
                    </form>
                </div>

                {{-- Totales --}}
                <div style="background-color: #312e81; color: white; border-radius: 24px; padding: 30px; position: relative; overflow: hidden; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);">
                    <h3 class="text-xl font-bold mb-6">Resumen del pedido</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between" style="opacity: 0.8;">
                            <span>Subtotal</span>
                            <span>{{ number_format($subtotalGeneral, 2) }}€</span>
                        </div>
                        @if($discount > 0)
                        <div class="flex justify-between" style="color: #4ade80;">
                            <span>Descuento</span>
                            <span>-{{ number_format($discount, 2) }}€</span>
                        </div>
                        @endif
                        <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.1); display: flex; justify-content: space-between; align-items: flex-end;">
                            <span class="text-lg">Total</span>
                            <span style="font-size: 30px; font-weight: 800;">{{ number_format($totalFinal, 2) }}€</span>
                        </div>
                    </div>

                    <div class="mt-8">
                        @auth
                            <form action="{{ route('carrito.checkout') }}" method="POST">
                                @csrf
                                <input type="hidden" name="metodo_pago" value="manual">
                                <button type="submit" style="width: 100%; background-color: white; color: #312e81; font-weight: 900; padding: 15px; border-radius: 15px; border: none; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
                                    Pagar Ahora <i class="fas fa-chevron-right" style="margin-left: 10px;"></i>
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" style="width: 100%; display: block; text-align: center; background-color: #4f46e5; color: white; padding: 15px; border-radius: 15px; text-decoration: none; font-weight: bold;">Inicia sesión para pagar</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection