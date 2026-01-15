@extends('layouts.plantilla')

@section('title', 'Crear Nuevo Cupón')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="d-flex align-items-center mb-4">
                <div class="bg-primary text-white rounded-3 p-3 me-3 shadow-sm">
                    <i class="fa-solid fa-plus fs-4"></i>
                </div>
                <div>
                    <h2 class="h4 fw-bold text-dark mb-0">Nuevo Cupón de Descuento</h2>
                    <p class="text-muted small mb-0">Define los parámetros de la promoción.</p>
                </div>
            </div>

            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('admin.coupons.store') }}" method="POST">
                        @csrf
                        
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-uppercase text-secondary">Código del Cupón</label>
                                <input type="text" name="code" class="form-control form-control-lg bg-light border-0 @error('code') is-invalid @enderror" 
                                       placeholder="EJ: VERANO2024" value="{{ old('code') }}" required>
                                @error('code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-uppercase text-secondary">Tipo de Descuento</label>
                                <select name="type" class="form-select form-select-lg bg-light border-0" required>
                                    <option value="fixed" {{ old('type') == 'fixed' ? 'selected' : '' }}>Monto Fijo (€)</option>
                                    <option value="percent" {{ old('type') == 'percent' ? 'selected' : '' }}>Porcentual (%)</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-uppercase text-secondary">Valor del Descuento</label>
                                <div class="input-group">
                                    <input type="number" step="0.01" name="value" class="form-control form-control-lg bg-light border-0" 
                                           placeholder="0.00" value="{{ old('value') }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-uppercase text-secondary">Compra Mínima (€)</label>
                                <input type="number" step="0.01" name="min_order_price" class="form-control form-control-lg bg-light border-0" 
                                       placeholder="0.00 (Opcional)" value="{{ old('min_order_price') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-uppercase text-secondary">Fecha de Expiración</label>
                                <input type="date" name="expires_at" class="form-control form-control-lg bg-light border-0" 
                                       value="{{ old('expires_at') }}">
                            </div>

                            <div class="col-md-6 d-flex align-items-center mt-md-5">
                                <div class="form-check form-switch custom-switch">
                                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" checked value="1">
                                    <label class="form-check-label fw-bold text-dark ms-2" for="is_active">Cupón Activo</label>
                                </div>
                            </div>
                        </div>

                        <hr class="my-5 opacity-10">

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('admin.coupons.index') }}" class="btn btn-light px-4 py-2 rounded-pill">
                                <i class="fa-solid fa-arrow-left me-2"></i>Volver
                            </a>
                            <button type="submit" class="btn btn-primary px-5 py-2 fw-bold rounded-pill shadow">
                                <i class="fa-solid fa-save me-2"></i>Crear Cupón
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection