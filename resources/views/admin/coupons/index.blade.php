@extends('layouts.plantilla')

@section('title', 'Cupones de Descuento')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 fw-bold text-dark mb-1"><i class="fa-solid fa-tags text-primary me-2"></i>Cupones</h1>
            <p class="text-muted small mb-0">Listado de códigos promocionales activos.</p>
        </div>
        <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
            <i class="fa-solid fa-plus me-2"></i>Nuevo Cupón
        </a>
    </div>

    @include('partials.alerts')

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-secondary small text-uppercase">
                    <tr>
                        <th class="ps-4 py-3">Código</th>
                        <th>Tipo</th>
                        <th>Valor</th>
                        <th>Pedido Mín.</th>
                        <th>Expira en</th>
                        <th class="text-end pe-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($coupons as $coupon)
                        <tr>
                            <td class="ps-4">
                                <span class="badge bg-white text-primary border border-primary border-opacity-25 px-3 py-2 font-monospace fs-6 shadow-sm">
                                    {{ $coupon->code }}
                                </span>
                            </td>
                            <td>
                                <span class="text-muted small">
                                    <i class="fa-solid {{ $coupon->type == 'fixed' ? 'fa-money-bill-1' : 'fa-percent' }} me-1"></i>
                                    {{ $coupon->type == 'fixed' ? 'Descuento Fijo' : 'Porcentual' }}
                                </span>
                            </td>
                            <td class="fw-bold text-dark">
                                {{ $coupon->type == 'fixed' ? number_format($coupon->value, 2) . ' €' : number_format($coupon->value, 0) . ' %' }}
                            </td>
                            <td>
                                <span class="text-secondary small">{{ number_format($coupon->min_order_price, 2) }} €</span>
                            </td>
                            <td class="text-muted small">
                                @if($coupon->expires_at && $coupon->expires_at < now())
                                    <span class="text-danger"><i class="fa-solid fa-calendar-xmark me-1"></i>Expirado</span>
                                @else
                                    <i class="fa-regular fa-calendar-check me-1"></i>
                                    {{ $coupon->expires_at ? \Carbon\Carbon::parse($coupon->expires_at)->format('d/m/Y') : 'Ilimitado' }}
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.coupons.edit', $coupon) }}" class="btn btn-sm btn-light border rounded-pill shadow-sm">
                                        <i class="fa-solid fa-pen text-secondary px-1"></i>
                                    </a>
                                    <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-light border rounded-pill shadow-sm text-danger" onclick="return confirm('¿Eliminar este cupón?')">
                                            <i class="fa-solid fa-trash-can px-1"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="opacity-50 mb-3"><i class="fa-solid fa-ticket-simple display-1"></i></div>
                                <p class="text-muted">No hay cupones registrados. Usa los Seeders o crea uno nuevo.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection