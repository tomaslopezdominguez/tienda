@extends('layouts.plantilla')

@section('title', 'Nuevo Producto | Admin')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4 d-print-none">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Panel</a></li>
            <li class="breadcrumb-item"><a href="{{ route('productos.index') }}" class="text-decoration-none">Productos</a></li>
            <li class="breadcrumb-item active">Nuevo</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                    <div class="d-flex align-items-center">
                        <div class="bg-soft-success text-success rounded-3 p-3 me-3">
                            <i class="fa-solid fa-box-open fs-3"></i>
                        </div>
                        <div>
                            <h2 class="h4 fw-bold text-dark mb-0">Crear Nuevo Producto</h2>
                            <p class="text-muted small mb-0">Completa la información detallada de tu nuevo artículo.</p>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('admin.productos.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-7 border-end-md">
                                <div class="mb-4">
                                    <label class="form-label small fw-bold text-secondary text-uppercase">Nombre del Producto</label>
                                    <input name="nombre" class="form-control form-control-lg bg-light border-0 @error('nombre') is-invalid @enderror" 
                                           value="{{ old('nombre') }}" placeholder="Ej: Smartphone Samsung Galaxy..." required autofocus>
                                    @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="mb-4">
                                    <label class="form-label small fw-bold text-secondary text-uppercase">Descripción Detallada</label>
                                    <textarea name="descripcion" class="form-control bg-light border-0 @error('descripcion') is-invalid @enderror" 
                                              rows="6" placeholder="Describe las características principales...">{{ old('descripcion') }}</textarea>
                                    @error('descripcion')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="col-md-5">
                                <div class="row g-3 mb-4">
                                    <div class="col-6">
                                        <label class="form-label small fw-bold text-secondary text-uppercase">Precio (€)</label>
                                        <div class="input-group">
                                            <span class="input-group-text border-0 bg-light text-muted">€</span>
                                            <input name="precio" type="number" step="0.01" class="form-control bg-light border-0 @error('precio') is-invalid @enderror" 
                                                   value="{{ old('precio', '0.00') }}" required>
                                        </div>
                                        @error('precio')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-6">
                                        <label class="form-label small fw-bold text-secondary text-uppercase">Stock</label>
                                        <input name="stock" type="number" class="form-control bg-light border-0 @error('stock') is-invalid @enderror" 
                                               value="{{ old('stock', 0) }}" required>
                                        @error('stock')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label small fw-bold text-secondary text-uppercase">Posición en Tienda</label>
                                    <input name="posicion" type="number" class="form-control bg-light border-0" 
                                           value="{{ old('posicion', 0) }}" title="Define el orden de aparición">
                                    <small class="text-muted small">Cero es la posición por defecto.</small>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label small fw-bold text-secondary text-uppercase">Categorías</label>
                                    <select name="categorias[]" class="form-select bg-light border-0 @error('categorias') is-invalid @enderror" 
                                            multiple style="height: 120px;">
                                        @foreach($categorias as $categoria)
                                            <option value="{{ $categoria->id }}" {{ in_array($categoria->id, old('categorias', [])) ? 'selected' : '' }}>
                                                {{ $categoria->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="form-text small"><i class="fa-solid fa-circle-info me-1"></i>Usa Ctrl / Cmd para multiselección.</div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4 opacity-10">

                        <div class="d-flex gap-3">
                            <button type="submit" class="btn btn-success px-5 py-2 fw-bold shadow-sm">
                                <i class="fa-solid fa-save me-2"></i>Guardar Producto
                            </button>
                            <a href="{{ route('productos.index') }}" class="btn btn-outline-secondary px-4 py-2">
                                Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="mt-4 p-3 bg-soft-primary rounded-4 border-start border-4 border-primary">
                <div class="d-flex align-items-center">
                    <i class="fa-solid fa-lightbulb text-primary me-3 fs-4"></i>
                    <p class="small text-muted mb-0">
                        <strong>Nota:</strong> Una vez creado el producto, podrás subir las imágenes correspondientes desde la pantalla de edición.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .bg-soft-success { background-color: #dcfce7; }
    .bg-soft-primary { background-color: #eef2ff; }
    .form-control:focus, .form-select:focus { 
        background-color: #fff !important; 
        box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.1); 
        border: 1px solid #198754 !important; 
    }
    @media (min-width: 768px) {
        .border-end-md { border-right: 1px solid #f1f5f9 !important; padding-right: 2.5rem; }
    }
</style>
@endsection