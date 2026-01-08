@extends('layouts.plantilla')

@section('title', 'Explorar Categorías - Admin')

@section('content')
<div class="row mb-5">
    <div class="col-12">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center bg-white p-4 rounded-4 shadow-sm border">
            <div>
                <h1 class="h3 fw-bold text-dark mb-1">Categorías de Productos</h1>
                <p class="text-muted small mb-0">Gestiona la organización de tu inventario y cómo lo ven tus clientes.</p>
            </div>
            @auth
                @if(auth()->user()->hasRole('admin'))
                    <div class="mt-3 mt-md-0">
                        {{-- CORRECCIÓN: admin.categorias.create --}}
                        <a href="{{ route('admin.categorias.create') }}" class="btn btn-success px-4 py-2 fw-bold shadow-sm">
                            <i class="fa-solid fa-folder-plus me-2"></i>Nueva Categoría
                        </a>
                    </div>
                @endif
            @endauth
        </div>
    </div>
</div>

@include('partials.alerts')

<div class="row g-4">
    @forelse($categorias as $categoria)
        <div class="col-sm-6 col-lg-4 col-xl-3">
            <div class="card h-100 border-0 shadow-sm hover-shadow transition-all rounded-4 overflow-hidden">
                @auth
                    @if(auth()->user()->hasRole('admin'))
                        <div class="position-absolute top-0 end-0 m-2 z-index-10 d-flex gap-1">
                            {{-- CORRECCIÓN: admin.categorias.edit --}}
                            <a href="{{ route('admin.categorias.edit', $categoria) }}" class="btn btn-white btn-sm shadow-sm rounded-circle border p-2" title="Editar">
                                <i class="fa-solid fa-pen text-warning"></i>
                            </a>
                            {{-- CORRECCIÓN: admin.categorias.destroy --}}
                            <form action="{{ route('admin.categorias.destroy', $categoria) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar esta categoría? Esto podría afectar a los productos asociados.');">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-white btn-sm shadow-sm rounded-circle border p-2" title="Eliminar">
                                    <i class="fa-solid fa-trash text-danger"></i>
                                </button>
                            </form>
                        </div>
                    @endif
                @endauth

                <div class="card-body p-4 text-center">
                    <div class="bg-soft-primary text-primary rounded-4 d-inline-flex align-items-center justify-content-center mb-3" style="width: 64px; height: 64px;">
                        <i class="fa-solid fa-layer-group fs-2"></i>
                    </div>
                    
                    <h5 class="fw-bold text-dark mb-2">{{ $categoria->nombre }}</h5>
                    
                    <p class="text-muted small mb-3 line-clamp-2">
                        {{ $categoria->descripcion ?? 'Sin descripción disponible para esta categoría.' }}
                    </p>

                    <hr class="opacity-10 my-3">

                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-light text-secondary border rounded-pill px-3">
                            <i class="fa-solid fa-box-open me-1 small"></i>
                            {{ $categoria->productos_count ?? '0' }} Productos
                        </span>
                        {{-- NOTA: categorias.show es correcta porque es la ruta pública --}}
                        <a href="{{ route('categorias.show', $categoria) }}" class="btn btn-link text-primary fw-bold text-decoration-none p-0 small">
                            Ver catálogo <i class="fa-solid fa-chevron-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center py-5">
            <div class="bg-light d-inline-block p-4 rounded-circle mb-3">
                <i class="fa-solid fa-folder-open text-muted fs-1"></i>
            </div>
            <h4 class="text-muted fw-bold">No hay categorías configuradas</h4>
            <p class="text-secondary">Comienza creando una categoría para organizar tus productos.</p>
        </div>
    @endforelse
</div>

@if(method_exists($categorias,'links'))
    <div class="d-flex justify-content-center mt-5">
        {{ $categorias->links() }}
    </div>
@endif
@endsection

@section('styles')
<style>
    .bg-soft-primary { background-color: #f0f4ff; }
    .hover-shadow:hover { 
        transform: translateY(-5px);
        box-shadow: 0 1rem 3rem rgba(0,0,0,0.1) !important;
    }
    .transition-all { transition: all 0.3s ease; }
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2; 
        line-clamp: 2;         
        -webkit-box-orient: vertical;  
        overflow: hidden;
    }
    .btn-white { background-color: #ffffff; }
    .btn-white:hover { background-color: #f8f9fa; }
    .z-index-10 { z-index: 10; }
</style>
@endsection