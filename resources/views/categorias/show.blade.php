@extends('layouts.plantilla')

@section('title', 'Productos en ' . $categoria->nombre)

@section('content')
<div class="container py-4">
    
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb small">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('categorias.index') }}" class="text-decoration-none">Categorías</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $categoria->nombre }}</li>
        </ol>
    </nav>

    <div class="bg-white rounded-4 shadow-sm border p-4 p-md-5 mb-5 overflow-hidden position-relative">
        <div class="row align-items-center position-relative" style="z-index: 2;">
            <div class="col-md-8">
                <span class="badge bg-soft-primary text-primary px-3 py-2 rounded-pill mb-3 uppercase fw-bold tracking-wider" style="font-size: 0.7rem;">
                    Explorando Colección
                </span>
                <h1 class="display-5 fw-bold text-dark mb-3">{{ $categoria->nombre }}</h1>
                <p class="lead text-muted mb-0 max-w-600">
                    {{ $categoria->descripcion ?? 'Descubre nuestra selección exclusiva de productos cuidadosamente elegidos para ti.' }}
                </p>
            </div>
            
            <div class="col-md-4 text-md-end mt-4 mt-md-0">
                <div class="d-flex flex-wrap justify-content-md-end gap-2">
                    <a href="{{ route('productos.index') }}" class="btn btn-light border px-4">
                        <i class="fa-solid fa-border-all me-2"></i>Todos los productos
                    </a>

                    @auth
                        @if(auth()->user()->hasRole('admin'))
                            <div class="dropdown">
                                <button class="btn btn-dark dropdown-toggle px-4" type="button" data-bs-toggle="dropdown">
                                    <i class="fa-solid fa-gear me-2"></i>Gestionar
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0">
                                    <li>
                                        <a class="dropdown-item py-2" href="{{ route('admin.categorias.edit', $categoria) }}">
                                            <i class="fa-solid fa-pen-to-square text-warning me-2"></i>Editar Categoría
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ route('admin.categorias.destroy', $categoria) }}" method="POST" onsubmit="return confirm('¿Eliminar esta categoría?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="dropdown-item py-2 text-danger">
                                                <i class="fa-solid fa-trash me-2"></i>Eliminar Categoría
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
        <div class="position-absolute top-0 end-0 opacity-10 mt-n4 me-n4">
            <i class="fa-solid fa-tags" style="font-size: 15rem; transform: rotate(-15deg);"></i>
        </div>
    </div>

    <div class="d-flex align-items-center mb-4">
        <h2 class="h4 fw-bold mb-0">Artículos disponibles</h2>
        <div class="ms-3 flex-grow-1 border-bottom opacity-10"></div>
        <span class="ms-3 badge border text-muted fw-normal">{{ $categoria->productos->count() }} resultados</span>
    </div>

    <div class="row g-4">
        @forelse($categoria->productos as $producto)
            <div class="col-sm-6 col-lg-4 col-xl-3">
                @include('partials.product-card', ['producto' => $producto])
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5 bg-light rounded-4 border border-dashed">
                    <div class="mb-3">
                        <i class="fa-solid fa-box-open fs-1 text-muted opacity-25"></i>
                    </div>
                    <h5 class="text-muted">No hay productos en esta categoría aún.</h5>
                    <p class="small text-secondary">Estamos trabajando para traer las mejores novedades muy pronto.</p>
                    <a href="{{ route('home') }}" class="btn btn-primary mt-3 px-4">Volver a la tienda</a>
                </div>
            </div>
        @endforelse
    </div>

    @if(method_exists($categoria->productos, 'links'))
        <div class="d-flex justify-content-center mt-5">
            {{ $categoria->productos->links() }}
        </div>
    @endif
</div>
@endsection

@section('styles')
<style>
    .bg-soft-primary { background-color: #eef2ff; }
    .max-w-600 { max-width: 600px; }
    .tracking-wider { letter-spacing: 0.05em; }
    .breadcrumb-item + .breadcrumb-item::before { content: "›"; }
    /* Efecto para las cards de productos dentro de esta vista */
    .product-card { transition: transform 0.3s ease; }
    .product-card:hover { transform: translateY(-8px); }
</style>
@endsection