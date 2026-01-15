@extends('layouts.plantilla')

@section('title', 'Editar Cupón: ' . $coupon->code)

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="d-flex align-items-center mb-4">
                <div class="bg-warning text-dark rounded-3 p-3 me-3 shadow-sm">
                    <i class="fa-solid fa-tag fs-4"></i>
                </div>
                <div>
                    <h2 class="h4 fw-bold text-dark mb-0">Editar Cupón</h2>
                    <p class="text-muted small mb-0">Estás modificando el código: <strong>{{ $coupon->code }}</strong></p>
                </div>
            </div>

            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('admin.coupons.update', $coupon) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-uppercase text-secondary">Código del Cupón</label>
                                <input type="text" name="code" class="form-control form-control-lg bg-light border-0 @error('code') is-invalid @enderror" 
                                       value="{{ old('code', $coupon->code) }}" required>
                                @error('code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-uppercase text-secondary">Tipo de Descuento</label>
                                <select name="type" class="form-select form-select-lg bg-light border-0" required>
                                    <option value="fixed" {{ old('type', $coupon->type) == 'fixed' ? 'selected' : '' }}>Monto Fijo (€)</option>
                                    <option value="percent" {{ old('type', $coupon->type) == 'percent' ? 'selected' : '' }}>Porcentual (%)</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-uppercase text-secondary">Valor del Descuento</label>
                                <input type="number" step="0.01" name="value" class="form-control form-control-lg bg-light border-0" 
                                       value="{{ old('value', $coupon->value) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-uppercase text-secondary">Compra Mínima (€)</label>
                                <input type="number" step="0.01" name="min_order_price" class="form-control form-control-lg bg-light border-0" 
                                       value="{{ old('min_order_price', $coupon->min_order_price) }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-uppercase text-secondary">Fecha de Expiración</label>
                                <input type="date" name="expires_at" class="form-control form-control-lg bg-light border-0" 
                                       value="{{ old('expires_at', $coupon->expires_at ? \Carbon\Carbon::parse($coupon->expires_at)->format('Y-m-d') : '') }}">
                            </div>

                            <div class="col-md-6 d-flex align-items-center mt-md-5">
                                <div class="form-check form-switch custom-switch">
                                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" 
                                           {{ old('is_active', $coupon->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold text-dark ms-2" for="is_active">Cupón Activo</label>
                                </div>
                            </div>
                        </div>

                        <hr class="my-5 opacity-10">

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('admin.coupons.index') }}" class="btn btn-light px-4 py-2 rounded-pill">
                                <i class="fa-solid fa-arrow-left me-2"></i>Cancelar
                            </a>
                            <button type="submit" class="btn btn-warning px-5 py-2 fw-bold rounded-pill shadow">
                                <i class="fa-solid fa-rotate me-2"></i>Actualizar Cupón
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection