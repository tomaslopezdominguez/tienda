@extends('layouts.plantilla')

@section('title', 'Nueva Categoría | Admin')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Panel</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.categorias.index') }}" class="text-decoration-none">Categorías</a></li>
                <li class="breadcrumb-item active">Nueva</li>
            </ol>
        </nav>

        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header bg-white border-0 pt-4 pb-0 text-center">
                <div class="bg-soft-success text-success rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 50px; height: 50px;">
                    <i class="fa-solid fa-folder-plus fs-4"></i>
                </div>
                <h2 class="h4 fw-bold text-dark mb-0">Crear Nueva Categoría</h2>
                <p class="text-muted small">Organiza tus productos para facilitar la navegación del cliente.</p>
            </div>

            <div class="card-body p-4">
                <form action="{{ route('admin.categorias.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="nombre" class="form-label small fw-bold text-secondary text-uppercase">Nombre de la Categoría</label>
                        <input type="text" name="nombre" id="nombre"
                               class="form-control form-control-lg bg-light border-0 @error('nombre') is-invalid @enderror" 
                               value="{{ old('nombre') }}" 
                               placeholder="Ej: Electrónica, Ropa de Invierno..." 
                               required autofocus>
                        @error('nombre')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="slug" class="form-label small fw-bold text-secondary text-uppercase">Slug (URL)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0 text-muted small">mi-tienda.com/</span>
                            <input type="text" name="slug" id="slug" 
                                   class="form-control bg-light border-0 text-muted" 
                                   value="{{ old('slug') }}" placeholder="nombre-de-la-categoria">
                        </div>
                        <small class="text-muted fst-italic">Se generará automáticamente si se deja vacío.</small>
                    </div>

                    <div class="mb-4">
                        <label for="descripcion" class="form-label small fw-bold text-secondary text-uppercase">Descripción (Opcional)</label>
                        <textarea name="descripcion" id="descripcion" rows="4" 
                                  class="form-control bg-light border-0" 
                                  placeholder="Describe brevemente qué tipo de productos contiene esta categoría...">{{ old('descripcion') }}</textarea>
                    </div>

                    <div class="d-flex gap-2 pt-2">
                        <button type="submit" class="btn btn-success flex-grow-1 py-2 fw-bold shadow-sm">
                            <i class="fa-solid fa-check me-2"></i>Guardar Categoría
                        </button>
                        <a href="{{ route('admin.categorias.index') }}" class="btn btn-outline-secondary px-4 py-2">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="mt-4 p-3 bg-light rounded-3 border-start border-4 border-info">
            <div class="d-flex align-items-center">
                <i class="fa-solid fa-lightbulb text-info me-3 fs-4"></i>
                <p class="small text-muted mb-0">
                    <strong>Tip SEO:</strong> Usa nombres descriptivos y palabras clave en tus categorías para que tus productos aparezcan más fácil en Google.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .bg-soft-success { background-color: #dcfce7; }
    .form-control:focus { background-color: #fff !important; box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.1); border: 1px solid #198754 !important; }
    .breadcrumb-item + .breadcrumb-item::before { content: "›"; font-size: 1.2rem; line-height: 1; }
    .fst-italic { font-style: italic; }
</style>
@endsection