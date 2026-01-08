@extends('layouts.plantilla')

@section('title', 'Editar: ' . $producto->nombre)

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10 col-lg-8">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Admin</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.productos.index') }}" class="text-decoration-none">Productos</a></li>
                        <li class="breadcrumb-item active">Editar</li>
                    </ol>
                </nav>
                <h1 class="h3 fw-bold mb-0 text-dark">
                    <i class="fa-solid fa-pen-to-square text-primary me-2"></i>Editar Producto
                </h1>
            </div>
            <a href="{{ route('productos.show', $producto) }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                <i class="fa-solid fa-eye me-1"></i> Ver en tienda
            </a>
        </div>

        @include('partials.alerts')

        <form action="{{ route('admin.productos.update', $producto->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row g-4">
                <div class="col-md-7">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body p-4">
                            <h5 class="card-title fw-bold mb-4 text-primary">Detalles del Producto</h5>
                            
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Nombre del producto</label>
                                <input type="text" name="nombre" value="{{ old('nombre', $producto->nombre) }}" 
                                       class="form-control form-control-lg @error('nombre') is-invalid @enderror" required>
                                @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Descripción</label>
                                <textarea name="descripcion" rows="6" class="form-control">{{ old('descripcion', $producto->descripcion) }}</textarea>
                            </div>

                            <div class="mb-0">
                                <label class="form-label fw-semibold">Categorías</label>
                                <select name="categorias[]" class="form-select @error('categorias') is-invalid @enderror" multiple style="height: 120px;">
                                    @foreach($categorias as $categoria)
                                        <option value="{{ $categoria->id }}"
                                            {{ in_array($categoria->id, old('categorias', $producto->categorias->pluck('id')->toArray())) ? 'selected' : '' }}>
                                            {{ $categoria->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Mantén presionado Ctrl/Cmd para selección múltiple.</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="card shadow-sm border-0 mb-4 text-center">
                        <div class="card-body p-4">
                            <h5 class="card-title fw-bold mb-3 text-start">Imagen</h5>
                            
                            <div id="preview-container" class="bg-light rounded mb-3 d-flex align-items-center justify-content-center border position-relative" style="height: 220px; overflow: hidden;">
                                <img id="image-preview" 
                                     src="{{ $producto->imagen ? asset('storage/' . $producto->imagen) : '#' }}" 
                                     alt="Vista previa" 
                                     class="img-fluid {{ $producto->imagen ? '' : 'd-none' }}">
                                
                                <div id="placeholder-icon" class="text-muted {{ $producto->imagen ? 'd-none' : '' }}">
                                    <i class="fa-solid fa-image fs-1 d-block mb-2 opacity-25"></i>
                                    <small>Sin imagen actual</small>
                                </div>
                            </div>

                            <label for="imagen_producto" class="btn btn-outline-primary btn-sm w-100 mb-2">
                                <i class="fa-solid fa-camera me-2"></i>Cambiar Imagen
                            </label>
                            <input class="form-control d-none @error('imagen') is-invalid @enderror" 
                                   type="file" id="imagen_producto" name="imagen" accept="image/*">
                            <small class="text-muted d-block">Subir nuevo archivo para reemplazar</small>
                        </div>
                    </div>

                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4">
                            <h5 class="card-title fw-bold mb-3">Gestión de Stock</h5>
                            
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-primary">Precio Actual (€)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white">€</span>
                                    <input type="number" step="0.01" name="precio" value="{{ old('precio', $producto->precio) }}" 
                                           class="form-control fw-bold @error('precio') is-invalid @enderror" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label class="form-label fw-semibold">Stock</label>
                                    <input type="number" name="stock" value="{{ old('stock', $producto->stock) }}" 
                                           class="form-control @error('stock') is-invalid @enderror" required>
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label fw-semibold">Posición</label>
                                    <input type="number" name="posicion" value="{{ old('posicion', $producto->posicion) }}" 
                                           class="form-control" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0 mt-4 bg-light">
                <div class="card-body d-flex justify-content-between align-items-center p-3">
                    <small class="text-muted ms-2">Última actualización: {{ $producto->updated_at->format('d/m/Y H:i') }}</small>
                    <div class="gap-2">
                        <a href="{{ route('admin.productos.index') }}" class="btn btn-link text-decoration-none text-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary px-5 fw-bold shadow-sm">
                            <i class="fa-solid fa-rotate me-2"></i>Actualizar Producto
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Script para previsualizar la nueva imagen antes de subirla
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