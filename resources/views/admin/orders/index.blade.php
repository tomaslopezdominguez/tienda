@extends('layouts.plantilla')

@section('title', 'Gestión de Pedidos - Admin')

@section('content')
<div class="row">
    <div class="col-12">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 fw-bold mb-1 text-dark">Pedidos</h1>
                <p class="text-muted small mb-0">Monitorea y gestiona las ventas de tu tienda en tiempo real.</p>
            </div>
        </div>

        @include('partials.alerts')

        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3 text-uppercase small fw-bold text-secondary">Orden</th>
                                <th class="py-3 text-uppercase small fw-bold text-secondary">Cliente</th>
                                <th class="py-3 text-uppercase small fw-bold text-secondary">Total</th>
                                <th class="py-3 text-uppercase small fw-bold text-secondary">Estado</th>
                                <th class="py-3 text-uppercase small fw-bold text-secondary">Fecha</th>
                                <th class="pe-4 py-3 text-uppercase small fw-bold text-secondary text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                                <tr>
                                    <td class="ps-4">
                                        <span class="fw-bold text-dark">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm me-2 bg-soft-primary text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 32px; height: 32px; font-size: 0.8rem;">
                                                {{ strtoupper(substr($order->usuario->name ?? 'U', 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="fw-medium text-dark">{{ $order->usuario->name ?? 'Usuario Eliminado' }}</div>
                                                <div class="text-muted small">ID: {{ $order->user_id }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="fw-bold text-dark">{{ number_format($order->total, 2) }} €</span>
                                    </td>
                                    <td>
                                        @php
                                            $badgeClass = match($order->status) {
                                                'pendiente' => 'bg-warning text-dark',
                                                'pago_verificado', 'enviado', 'en_reparto' => 'bg-info text-white',
                                                'recibido' => 'bg-success text-white',
                                                'pago_cancelado', 'cancelado' => 'bg-danger text-white',
                                                default => 'bg-secondary text-white',
                                            };
                                        @endphp
                                        <span class="badge {{ $badgeClass }} px-3 py-2 rounded-pill small">
                                            {{ str_replace('_',' ',ucfirst($order->status)) }}
                                        </span>
                                    </td>
                                    <td class="text-muted small">
                                        <i class="fa-regular fa-calendar me-1"></i> {{ $order->created_at->format('d/m/Y') }}<br>
                                        <i class="fa-regular fa-clock me-1"></i> {{ $order->created_at->format('H:i') }}
                                    </td>
                                    <td class="pe-4 text-end">
                                        <div class="d-flex justify-content-end align-items-center gap-2">
                                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-light border" title="Detalles">
                                                <i class="fa-solid fa-eye text-primary"></i>
                                            </a>

                                            <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="d-flex align-items-center gap-1">
                                                @csrf
                                                @method('PATCH')
                                                <select name="status" class="form-select form-select-sm shadow-none" style="width:140px; font-size: 0.85rem;">
                                                    @php
                                                        $states = ['pendiente','pago_verificado','pago_cancelado','cancelado','enviado','en_reparto','recibido'];
                                                    @endphp
                                                    @foreach($states as $st)
                                                        <option value="{{ $st }}" {{ $order->status === $st ? 'selected' : '' }}>
                                                            {{ str_replace('_',' ',ucfirst($st)) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <button class="btn btn-sm btn-primary" title="Actualizar">
                                                    <i class="fa-solid fa-rotate"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="fa-solid fa-receipt fs-1 mb-3 opacity-25"></i>
                                        <p class="mb-0">No hay pedidos registrados aún.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @if(method_exists($orders,'links'))
            <div class="d-flex justify-content-center mt-4">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

@section('styles')
<style>
    .bg-soft-primary { background-color: #e0e7ff; }
    .table thead th { border-bottom: none; font-size: 0.75rem; letter-spacing: 0.05em; }
    .avatar-sm { flex-shrink: 0; }
    .form-select-sm { padding-top: 0.25rem; padding-bottom: 0.25rem; border-radius: 6px; }
    .btn-light:hover { background-color: #f1f5f9; }
</style>
@endsection