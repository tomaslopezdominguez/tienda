@extends('layouts.plantilla')

@section('title', 'Mis Pedidos | Mi Cuenta')

@section('content')
<div class="container py-5">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Mi Panel</a></li>
                    <li class="breadcrumb-item active">Mis Pedidos</li>
                </ol>
            </nav>
            <h1 class="h3 fw-bold text-dark mb-0">
                <i class="fa-solid fa-box-archive text-primary me-2"></i>Historial de Pedidos
            </h1>
        </div>
        <div class="mt-3 mt-md-0">
            <a href="{{ route('home') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
                <i class="fa-solid fa-cart-shopping me-2"></i>Nueva Compra
            </a>
        </div>
    </div>

    @include('partials.alerts')

    @if($orders->isEmpty())
        <div class="card border-0 shadow-sm rounded-4 text-center py-5">
            <div class="card-body">
                <div class="bg-light d-inline-block p-4 rounded-circle mb-4">
                    <i class="fa-solid fa-receipt display-4 text-muted opacity-50"></i>
                </div>
                <h4 class="fw-bold text-dark">¿Aún no has comprado nada?</h4>
                <p class="text-muted mb-4">Tus pedidos aparecerán aquí una vez que realices tu primera compra.</p>
                <a href="{{ route('home') }}" class="btn btn-outline-primary px-5 py-2 fw-bold">
                    Explorar la tienda
                </a>
            </div>
        </div>
    @else
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-4 py-3 text-secondary small text-uppercase">ID Pedido</th>
                            <th class="py-3 text-secondary small text-uppercase">Fecha</th>
                            <th class="py-3 text-secondary small text-uppercase text-center">Artículos</th>
                            <th class="py-3 text-secondary small text-uppercase text-center">Estado</th>
                            <th class="py-3 text-secondary small text-uppercase text-end">Total</th>
                            <th class="px-4 py-3 text-secondary small text-uppercase text-end">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td class="px-4">
                                <span class="fw-bold text-dark">#{{ $order->id }}</span>
                            </td>
                            <td>
                                <div class="small text-dark">{{ $order->created_at->format('d/m/Y') }}</div>
                                <div class="text-muted small" style="font-size: 0.75rem;">{{ $order->created_at->format('H:i') }}</div>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-soft-secondary text-secondary rounded-pill px-3">
                                    {{ $order->items_count ?? $order->items->count() }} uds.
                                </span>
                            </td>
                            <td class="text-center">
                                @php
                                    $statusClasses = [
                                        'pendiente' => 'bg-soft-warning text-warning',
                                        'pagado' => 'bg-soft-success text-success',
                                        'enviado' => 'bg-soft-info text-info',
                                        'cancelado' => 'bg-soft-danger text-danger',
                                        'entregado' => 'bg-soft-primary text-primary'
                                    ];
                                    $currentClass = $statusClasses[strtolower($order->status)] ?? 'bg-soft-secondary text-secondary';
                                @endphp
                                <span class="badge {{ $currentClass }} text-uppercase fw-bold" style="font-size: 0.7rem; letter-spacing: 0.5px;">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td class="text-end">
                                <span class="fw-bold text-dark fs-5">{{ number_format($order->total, 2) }} €</span>
                            </td>
                            <td class="px-4 text-end">
                                <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-dark px-3 rounded-pill fw-bold">
                                    Ver Detalles
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection

@section('styles')
<style>
    .bg-soft-warning { background-color: #fffbeb; }
    .bg-soft-success { background-color: #ecfdf5; }
    .bg-soft-info { background-color: #f0f9ff; }
    .bg-soft-danger { background-color: #fef2f2; }
    .bg-soft-primary { background-color: #eef2ff; }
    .bg-soft-secondary { background-color: #f8fafc; }
    
    .table thead th { border-bottom: 0; }
    .table tbody td { border-bottom: 1px solid #f1f5f9; padding-top: 1.2rem; padding-bottom: 1.2rem; }
    .table-hover tbody tr:hover { background-color: #f8fafc; }
    
    .breadcrumb-item + .breadcrumb-item::before { content: "›"; }
</style>
@endsection