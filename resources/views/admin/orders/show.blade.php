@extends('layouts.plantilla')

@section('title', 'Pedido #' . str_pad($order->id, 5, '0', STR_PAD_LEFT))

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">Pedidos</a></li>
                        <li class="breadcrumb-item active">#{{ $order->id }}</li>
                    </ol>
                </nav>
                <h1 class="h3 fw-bold mb-0 text-dark">Detalle del Pedido #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</h1>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('orders.show', $order) }}" class="btn btn-outline-primary border-0 fw-medium">
                    <i class="fa-solid fa-up-right-from-square me-2"></i>Ver vista cliente
                </a>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-light border fw-medium text-secondary">
                    <i class="fa-solid fa-arrow-left me-2"></i>Volver
                </a>
            </div>
        </div>
    </div>

    @include('partials.alerts')

    <div class="col-lg-8">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3 border-bottom-0">
                <h5 class="card-title fw-bold mb-0"><i class="fa-solid fa-box-archive me-2 text-primary"></i>Productos del Pedido</h5>
            </div>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 text-uppercase small fw-bold text-secondary">Producto</th>
                            <th class="text-center text-uppercase small fw-bold text-secondary">Cantidad</th>
                            <th class="text-end text-uppercase small fw-bold text-secondary">Precio</th>
                            <th class="pe-4 text-end text-uppercase small fw-bold text-secondary">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($order->items as $item)
                        <tr>
                            <td class="ps-4 py-3">
                                <div class="d-flex align-items-center">
                                    <div class="bg-light rounded p-1 me-3" style="width: 50px; height: 50px;">
                                        <img src="{{ $item->producto->imagen ?? '/img/no-image.jpg' }}" 
                                             class="img-fluid rounded shadow-xs" 
                                             alt="{{ $item->producto->nombre ?? 'N/A' }}">
                                    </div>
                                    <div>
                                        <span class="fw-bold d-block text-dark">{{ $item->producto->nombre ?? 'Producto eliminado' }}</span>
                                        <span class="small text-muted">SKU: {{ str_pad($item->producto_id, 6, '0', STR_PAD_LEFT) }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center fw-medium">x{{ $item->cantidad }}</td>
                            <td class="text-end">{{ number_format($item->precio, 2) }} €</td>
                            <td class="pe-4 text-end fw-bold text-dark">{{ number_format($item->precio * $item->cantidad, 2) }} €</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">No hay productos.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer bg-white border-top-0 py-4 pe-4">
                <div class="row justify-content-end">
                    <div class="col-md-5 col-lg-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Subtotal:</span>
                            <span class="fw-medium text-dark">{{ number_format($order->total, 2) }} €</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Envío:</span>
                            <span class="text-success fw-medium">Gratis</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="h6 fw-bold mb-0">Total General:</span>
                            <span class="h4 fw-bold text-primary mb-0">{{ number_format($order->total, 2) }} €</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-4">
                <h6 class="text-uppercase small fw-bold text-secondary mb-3">Estado de la Orden</h6>
                @php
                    $badgeClass = match($order->status) {
                        'pendiente' => 'bg-warning text-dark',
                        'recibido' => 'bg-success text-white',
                        'cancelado', 'pago_cancelado' => 'bg-danger text-white',
                        default => 'bg-primary text-white'
                    };
                @endphp
                <div class="d-flex align-items-center mb-4">
                    <span class="badge {{ $badgeClass }} px-3 py-2 fs-6 rounded-pill w-100">
                        {{ str_replace('_',' ',ucfirst($order->status)) }}
                    </span>
                </div>

                <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Actualizar estado:</label>
                        <select name="status" class="form-select mb-3">
                            @php $states = ['pendiente','pago_verificado','pago_cancelado','cancelado','enviado','en_reparto','recibido']; @endphp
                            @foreach($states as $st)
                                <option value="{{ $st }}" {{ $order->status === $st ? 'selected' : '' }}>
                                    {{ str_replace('_',' ',ucfirst($st)) }}
                                </option>
                            @endforeach
                        </select>
                        <button class="btn btn-primary w-100 py-2 fw-bold" type="submit">
                            <i class="fa-solid fa-floppy-disk me-2"></i>Actualizar Pedido
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h6 class="text-uppercase small fw-bold text-secondary mb-3">Información del Cliente</h6>
                <div class="d-flex align-items-center mb-3">
                    <div class="avatar bg-soft-primary text-primary rounded-circle p-3 me-3 fw-bold">
                        {{ strtoupper(substr($order->user->name ?? 'U', 0, 1)) }}
                    </div>
                    <div>
                        <div class="fw-bold text-dark">{{ $order->user->name ?? 'Usuario desconocido' }}</div>
                        <div class="small text-muted">{{ $order->user->email ?? 'Sin email' }}</div>
                    </div>
                </div>
                <hr class="my-3 text-light">
                <div class="mb-2">
                    <small class="text-muted d-block">Método de Pago:</small>
                    <span class="badge bg-light text-dark border fw-medium">
                        <i class="fa-solid fa-credit-card me-1"></i> {{ strtoupper($order->metodo_pago ?? 'N/A') }}
                    </span>
                </div>
                <div class="mb-0">
                    <small class="text-muted d-block">Fecha del pedido:</small>
                    <span class="fw-medium text-dark">{{ $order->created_at->format('d M, Y - H:i') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .bg-soft-primary { background-color: #e0e7ff; }
    .avatar { width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; }
    .breadcrumb-item a { color: #64748b; text-decoration: none; font-size: 0.85rem; }
    .table thead th { border-bottom: none; }
</style>
@endsection