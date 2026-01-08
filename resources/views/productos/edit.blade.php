@extends('layouts.plantilla')

@section('title', 'Editar: ' . $producto->nombre)

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Panel</a></li>
            <li class="breadcrumb-item"><a href="{{ route('productos.index') }}" class="text-decoration-none">Productos</a></li>
            <li class="breadcrumb-item active">Editar #{{ $producto->id }}</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-lg-11">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="bg-soft-primary text-primary rounded-3 p-3 me-3">
                                <i class="fa-solid fa-pen-to-square fs-3"></i>
                            </div>
                            <div>
                                <h2 class="h4 fw-bold text-dark mb-0">Editar Producto</h2>
                                <p class="text-muted small mb-0">Estás modificando: <strong>{{ $producto->nombre }}</strong></p>
                            </div>
                        </div>
                        <a href="{{ route('productos.show', $producto) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                            <i class="fa-solid fa-eye me-1"></i> Ver en tienda
                        </a>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('admin.productos.update', $producto) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row g-4">
                            <div class="col-md-7 border-end-md">
                                <div class="mb-4">
                                    <label class="form-label small fw-bold text-secondary text-uppercase">Nombre del Producto</label>
                                    <input name="nombre" class="form-control form-control-lg bg-light border-0 @error('nombre') is-invalid @enderror" 
                                           value="{{ old('nombre', $producto->nombre) }}" required>
                                    @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="mb-4">
                                    <label class="form-label small fw-bold text-secondary text-uppercase">Descripción</label>
                                    <textarea name="descripcion" class="form-control bg-light border-0 @error('descripcion') is-invalid @enderror" 
                                              rows="6">{{ old('descripcion', $producto->descripcion) }}</textarea>
                                    @error('descripcion')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label small fw-bold text-secondary text-uppercase">Precio (€)</label>
                                        <input name="precio" type="number" step="0.01" class="form-control bg-light border-0" 
                                               value="{{ old('precio', $producto->precio) }}" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label small fw-bold text-secondary text-uppercase">Stock</label>
                                        <input name="stock" type="number" class="form-control bg-light border-0" 
                                               value="{{ old('stock', $producto->stock) }}" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label small fw-bold text-secondary text-uppercase">Posición</label>
                                        <input name="posicion" type="number" class="form-control bg-light border-0" 
                                               value="{{ old('posicion', $producto->posicion) }}">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-5">
                                <h6 class="fw-bold text-dark mb-3"><i class="fa-solid fa-image me-2 text-primary"></i>Imagen del Producto</h6>
                                
                                <div class="mb-4 text-center p-3 bg-light rounded-4 border-2 border-dashed">
                                    @if ($producto->imagen)
                                        <div class="position-relative d-inline-block mb-3">
                                            <img src="{{ asset('storage/' . $producto->imagen) }}" 
                                                 alt="Actual" class="img-thumbnail rounded-3 shadow-sm" style="max-height: 180px;">
                                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary shadow">Actual</span>
                                        </div>
                                    @else
                                        <div class="py-4 text-muted">
                                            <i class="fa-solid fa-cloud-arrow-up display-4 opacity-25"></i>
                                            <p class="small mt-2">Sin imagen asignada</p>
                                        </div>
                                    @endif

                                    <div class="text-start mt-3">
                                        <label class="form-label small fw-bold text-secondary text-uppercase">Subir Nueva Imagen</label>
                                        <input class="form-control form-control-sm @error('imagen') is-invalid @enderror" 
                                               type="file" name="imagen" id="imgInp">
                                        @error('imagen')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        <small class="text-muted d-block mt-2" style="font-size: 0.75rem;">
                                            Formatos: JPG, PNG, WEBP. Máx: 2MB.
                                        </small>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label small fw-bold text-secondary text-uppercase">Categorías</label>
                                    <select name="categorias[]" class="form-select bg-light border-0" multiple style="height: 150px;">
                                        @php $selected = old('categorias', $producto->categorias->pluck('id')->toArray()); @endphp
                                        @foreach($categorias as $categoria)
                                            <option value="{{ $categoria->id }}" {{ in_array($categoria->id, $selected) ? 'selected' : '' }}>
                                                {{ $categoria->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="form-text small">Manten Ctrl/Cmd para seleccionar varias.</div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-5 pt-3 border-top d-flex gap-3">
                            <button type="submit" class="btn btn-primary px-5 py-2 fw-bold shadow-sm rounded-pill">
                                <i class="fa-solid fa-rotate me-2"></i>Actualizar Producto
                            </button>
                            <a href="{{ route('productos.index') }}" class="btn btn-light px-4 py-2 rounded-pill">
                                Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .bg-soft-primary { background-color: #eef2ff; }
    .border-dashed { border: 2px dashed #dee2e6 !important; }
    .form-control:focus, .form-select:focus { 
        background-color: #fff !important; 
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1);
        border: 1px solid #0d6efd !important;
    }
    @media (min-width: 768px) {
        .border-end-md { border-right: 1px solid #f1f5f9 !important; padding-right: 2.5rem; }
    }
</style>
@endsection