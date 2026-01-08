@extends('layouts.plantilla')

@section('title', 'Detalle del Pedido #' . $order->id)

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4 d-print-none">
        <a href="{{ route('orders.my') }}" class="btn btn-link text-decoration-none p-0 text-secondary">
            <i class="fa-solid fa-arrow-left me-2"></i>Volver a mis pedidos
        </a>
        <button onclick="window.print();" class="btn btn-outline-dark btn-sm rounded-pill px-4 shadow-sm">
            <i class="fa-solid fa-print me-2"></i>Imprimir Recibo
        </button>
    </div>

    @include('partials.alerts')

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0">Resumen de Artículos</h5>
                        <span class="badge bg-soft-primary text-primary rounded-pill px-3">
                            {{ $order->items->count() }} {{ $order->items->count() > 1 ? 'productos' : 'producto' }}
                        </span>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0 px-4 py-3 text-muted small text-uppercase">Producto</th>
                                <th class="border-0 py-3 text-muted small text-uppercase text-center">Cant.</th>
                                <th class="border-0 py-3 text-muted small text-uppercase text-end">Precio</th>
                                <th class="border-0 px-4 py-3 text-muted small text-uppercase text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                            <tr>
                                <td class="px-4 py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0 me-3">
                                            @if($item->producto->imagen)
                                                <img src="{{ asset('storage/' . $item->producto->imagen) }}" 
                                                     alt="{{ $item->producto->nombre }}"
                                                     width="60" class="rounded-3 shadow-sm">
                                            @else
                                                <div class="bg-light rounded-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                    <i class="fa-solid fa-image text-muted opacity-25"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <h6 class="fw-bold mb-0">{{ $item->producto->nombre }}</h6>
                                            <small class="text-muted">Ref: {{ str_pad($item->producto->id, 5, '0', STR_PAD_LEFT) }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center fw-bold">{{ $item->cantidad }}</td>
                                <td class="text-end text-muted">{{ number_format($item->precio, 2) }} €</td>
                                <td class="px-4 text-end fw-bold text-dark">
                                    {{ number_format($item->precio * $item->cantidad, 2) }} €
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4 text-center">
                    <h6 class="text-uppercase text-muted small fw-bold mb-3 tracking-wider">Estado del Pedido</h6>
                    @php
                        $statusColor = match(strtolower($order->status)) {
                            'pendiente' => 'warning',
                            'pagado' => 'success',
                            'enviado' => 'info',
                            'entregado' => 'primary',
                            'cancelado' => 'danger',
                            default => 'secondary'
                        };
                    @endphp
                    <div class="display-6 mb-2">
                        <i class="fa-solid fa-circle-check text-{{ $statusColor }}"></i>
                    </div>
                    <h4 class="fw-bold text-{{ $statusColor }} text-uppercase mb-1">{{ $order->status }}</h4>
                    <p class="small text-muted mb-0">Pedido realizado el {{ $order->created_at->format('d M, Y') }}</p>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3 border-bottom pb-2">Resumen de Pago</h6>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Método:</span>
                        <span class="fw-bold text-dark text-capitalize">
                            <i class="fa-solid fa-credit-card me-1 small text-muted"></i>
                            {{ $order->metodo_pago ?? 'No especificado' }}
                        </span>
                    </div>

                    <hr class="my-3 opacity-10">

                    <div class="d-flex justify-content-between mb-2 small">
                        <span class="text-muted">Base Imponible:</span>
                        <span class="text-dark">{{ number_format($order->total / 1.21, 2) }} €</span>
                    </div>

                    @if($order->discount > 0)
                    <div class="d-flex justify-content-between mb-2 small text-danger">
                        <span>Descuento ({{ $order->coupon_code }}):</span>
                        <span>-{{ number_format($order->discount, 2) }} €</span>
                    </div>
                    @endif

                    <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                        <span class="h5 fw-bold mb-0">Total:</span>
                        <span class="h4 fw-bold mb-0 text-primary">{{ number_format($order->total, 2) }} €</span>
                    </div>
                </div>
            </div>

            <div class="p-3 bg-soft-primary rounded-4 border border-primary border-opacity-10 d-print-none">
                <div class="d-flex align-items-center">
                    <i class="fa-solid fa-headset text-primary fs-4 me-3"></i>
                    <div>
                        <h6 class="fw-bold mb-1 small">¿Algún problema?</h6>
                        <a href="#" class="small text-primary text-decoration-none fw-bold">Contactar con soporte</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .bg-soft-primary { background-color: #f0f4ff; }
    .tracking-wider { letter-spacing: 0.1em; }

    /* Estilos específicos para impresión */
    @media print {
        /* Ocultar elementos innecesarios */
        .d-print-none, .btn, nav, footer, .bg-soft-primary { 
            display: none !important; 
        }

        /* Ajustar tarjetas para que se vean bien en papel */
        .card { 
            border: 1px solid #dee2e6 !important; 
            box-shadow: none !important; 
            margin-bottom: 20px !important;
        }

        body { 
            background-color: #fff !important; 
            color: #000 !important; 
        }

        .container {
            width: 100% !important;
            max-width: 100% !important;
            padding: 0 !important;
        }

        .text-primary { color: #000 !important; }
    }
</style>
@endsection