@extends('layouts.plantilla')

@section('title', 'Nuevo Producto - Admin')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10 col-lg-8">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Admin</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.productos.index') }}" class="text-decoration-none">Productos</a></li>
                        <li class="breadcrumb-item active">Nuevo</li>
                    </ol>
                </nav>
                <h1 class="h3 fw-bold mb-0 text-dark">
                    <i class="fa-solid fa-plus-circle text-primary me-2"></i>Añadir Nuevo Producto
                </h1>
            </div>
        </div>

        @include('partials.alerts')

        <form action="{{ route('admin.productos.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row g-4">
                <div class="col-md-7">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body p-4">
                            <h5 class="card-title fw-bold mb-4">Información General</h5>
                            
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Nombre del producto</label>
                                <input type="text" name="nombre" value="{{ old('nombre') }}" 
                                       class="form-control form-control-lg @error('nombre') is-invalid @enderror" 
                                       placeholder="Ej: Camiseta de Algodón Orgánico" required>
                                @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Descripción detallada</label>
                                <textarea name="descripcion" rows="6" class="form-control" 
                                          placeholder="Escribe las características principales...">{{ old('descripcion') }}</textarea>
                            </div>

                            <div class="mb-0">
                                <label class="form-label fw-semibold">Categorías</label>
                                <select name="categorias[]" class="form-select" multiple style="height: 120px;">
                                    @foreach($categorias as $categoria)
                                        <option value="{{ $categoria->id }}" {{ in_array($categoria->id, old('categorias',[])) ? 'selected' : '' }}>
                                            {{ $categoria->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Mantén presionado Ctrl (o Cmd) para seleccionar varias.</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body p-4">
                            <h5 class="card-title fw-bold mb-3">Multimedia</h5>
                            <div class="mb-3">
                                <div id="preview-container" class="bg-light rounded mb-3 d-flex align-items-center justify-content-center border" style="height: 200px; overflow: hidden;">
                                    <img id="image-preview" src="#" alt="Vista previa" class="img-fluid d-none">
                                    <div id="placeholder-icon" class="text-center text-muted">
                                        <i class="fa-solid fa-image fs-1 d-block mb-2 opacity-25"></i>
                                        <small>Vista previa de imagen</small>
                                    </div>
                                </div>
                                <label for="imagen_producto" class="btn btn-outline-primary btn-sm w-100">
                                    <i class="fa-solid fa-upload me-2"></i>Seleccionar Imagen
                                </label>
                                <input class="form-control d-none @error('imagen') is-invalid @enderror" 
                                       type="file" id="imagen_producto" name="imagen" accept="image/*">
                                @error('imagen')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4">
                            <h5 class="card-title fw-bold mb-3">Inventario y Precio</h5>
                            
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-primary">Precio de venta (€)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white">€</span>
                                    <input type="number" step="0.01" name="precio" value="{{ old('precio') }}" 
                                           class="form-control fw-bold @error('precio') is-invalid @enderror" required>
                                </div>
                                @error('precio')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>

                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label class="form-label fw-semibold">Stock</label>
                                    <input type="number" name="stock" value="{{ old('stock', 0) }}" 
                                           class="form-control @error('stock') is-invalid @enderror" required>
                                    @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label fw-semibold">Orden/Pos.</label>
                                    <input type="number" name="posicion" value="{{ old('posicion', 0) }}" 
                                           class="form-control @error('posicion') is-invalid @enderror" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0 mt-4 bg-light">
                <div class="card-body d-flex justify-content-end gap-2 p-3">
                    <a href="{{ route('admin.productos.index') }}" class="btn btn-link text-decoration-none text-secondary fw-medium">Cancelar</a>
                    <button type="submit" class="btn btn-primary px-5 py-2 fw-bold">
                        <i class="fa-solid fa-save me-2"></i>Guardar Producto
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Script para vista previa de imagen
    document.getElementById('imagen_producto').onchange = function (evt) {
        const [file] = this.files;
        if (file) {
            const preview = document.getElementById('image-preview');
            const placeholder = document.getElementById('placeholder-icon');
            preview.src = URL.createObjectURL(file);
            preview.classList.remove('d-none');
            placeholder.classList.add('d-none');
        }
    }
</script>
@endsection