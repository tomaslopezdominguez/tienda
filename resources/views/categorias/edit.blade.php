@extends('layouts.plantilla')

@section('title', 'Editar Categoría: ' . $categoria->nombre)

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10 col-lg-8">
        
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Admin</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('categorias.index') }}" class="text-decoration-none">Categorías</a></li>
                        <li class="breadcrumb-item active">Editar</li>
                    </ol>
                </nav>
                <h1 class="h3 fw-bold text-dark mb-0">
                    <i class="fa-solid fa-pen-to-square text-warning me-2"></i>Editar Categoría
                </h1>
            </div>
            <a href="{{ route('categorias.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fa-solid fa-arrow-left me-1"></i> Volver al listado
            </a>
        </div>

        @include('partials.alerts')

        <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
            <div class="card-header bg-white py-3 border-bottom">
                <div class="d-flex align-items-center">
                    <div class="bg-soft-warning p-2 rounded-3 me-3">
                        <i class="fa-solid fa-folder-open text-warning"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">Modificar registro</h5>
                        <p class="text-muted small mb-0">Editando: <span class="badge bg-light text-dark border">{{ $categoria->nombre }}</span></p>
                    </div>
                </div>
            </div>

            <div class="card-body p-4 p-md-5">
                <form action="{{ route('categorias.update', $categoria->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-4">
                        <div class="col-12">
                            <label for="nombre" class="form-label fw-bold text-secondary small text-uppercase">Nombre de la Categoría</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="fa-solid fa-tag text-muted"></i></span>
                                <input type="text" name="nombre" id="nombre" 
                                       class="form-control form-control-lg bg-light border-0 @error('nombre') is-invalid @enderror" 
                                       value="{{ old('nombre', $categoria->nombre) }}" required>
                            </div>
                            @error('nombre')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12">
                            <label for="descripcion" class="form-label fw-bold text-secondary small text-uppercase">Descripción detallada</label>
                            <textarea name="descripcion" id="descripcion" rows="5" 
                                      class="form-control bg-light border-0 @error('descripcion') is-invalid @enderror" 
                                      placeholder="Explica qué tipo de productos pertenecen a esta categoría...">{{ old('descripcion', $categoria->descripcion) }}</textarea>
                            @error('descripcion')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12">
                            <div class="p-3 rounded-3 bg-light border">
                                <div class="d-flex align-items-center text-muted small">
                                    <i class="fa-solid fa-circle-info me-2"></i>
                                    <span>Esta categoría contiene actualmente <strong>{{ $categoria->productos_count ?? 0 }}</strong> productos asociados.</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 pt-3">
                            <div class="d-grid d-md-flex justify-content-md-end gap-2">
                                <button type="submit" class="btn btn-warning px-5 py-2 fw-bold text-dark shadow-sm">
                                    <i class="fa-solid fa-rotate me-2"></i>Actualizar ahora
                                </button>
                                <a href="{{ route('categorias.index') }}" class="btn btn-light px-4 py-2 border">
                                    Descartar cambios
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .bg-soft-warning { background-color: #fffbeb; }
    .form-control:focus { background-color: #fff !important; box-shadow: 0 0 0 0.25rem rgba(255, 193, 7, 0.15); border: 1px solid #ffc107 !important; }
    .breadcrumb-item + .breadcrumb-item::before { content: "›"; font-size: 1.2rem; line-height: 1; }
</style>
@endsection