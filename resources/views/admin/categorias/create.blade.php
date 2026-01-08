@extends('layouts.plantilla')

@section('title', 'Crear Categoría - Admin')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Admin</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.categorias.index') }}" class="text-decoration-none">Categorías</a></li>
                        <li class="breadcrumb-item active">Nueva</li>
                    </ol>
                </nav>
                <h1 class="h3 fw-bold mb-0 text-dark">Nueva Categoría</h1>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-4 p-md-5">
                <form action="{{ route('admin.categorias.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="nombre" class="form-label fw-semibold text-secondary">
                            <i class="fa-solid fa-tag me-1"></i> Nombre de la categoría
                        </label>
                        <input type="text" 
                               name="nombre" 
                               id="nombre"
                               placeholder="Ej: Electrónica, Ropa de Invierno..."
                               value="{{ old('nombre') }}" 
                               class="form-control form-control-lg @error('nombre') is-invalid @enderror" 
                               required>
                        @error('nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">El nombre debe ser único y descriptivo.</div>
                    </div>

                    <div class="mb-4">
                        <label for="descripcion" class="form-label fw-semibold text-secondary">
                            <i class="fa-solid fa-align-left me-1"></i> Descripción (Opcional)
                        </label>
                        <textarea name="descripcion" 
                                  id="descripcion"
                                  rows="4" 
                                  placeholder="Describe brevemente qué productos incluirá esta categoría..."
                                  class="form-control @error('descripcion') is-invalid @enderror">{{ old('descripcion') }}</textarea>
                        @error('descripcion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr class="my-4 text-light">

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('admin.categorias.index') }}" class="btn btn-light btn-lg px-4 me-md-2 fw-medium">
                            Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary btn-lg px-5">
                            <i class="fa-solid fa-check me-2"></i>Guardar Categoría
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection