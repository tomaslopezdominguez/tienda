@extends('layouts.plantilla')

@section('title', 'Nuestros productos | Tienda')

@section('content')
<div class="container py-4">
    <div class="row align-items-center mb-5">
        <div class="col-md-6">
            <h1 class="fw-bold text-dark mb-1">Catálogo de Productos</h1>
            <p class="text-muted">Descubre nuestra selección exclusiva de artículos de alta calidad.</p>
        </div>
        <div class="col-md-6 text-md-end">
            @auth
                @if(auth()->user()->hasRole('admin'))
                    <a href="{{ route('admin.productos.create') }}" class="btn btn-success px-4 py-2 rounded-pill fw-bold shadow-sm">
                        <i class="fa-solid fa-plus me-2"></i>Crear Nuevo Producto
                    </a>
                @endif
            @endauth
        </div>
    </div>

    @include('partials.alerts')

    <div class="row g-4">
        @forelse($productos as $producto)
            <div class="col-sm-6 col-lg-4 col-xl-3">
                {{-- Usamos el parcial de tarjeta que acabamos de estilizar --}}
                @include('partials.product-card', ['producto' => $producto])
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <div class="bg-light d-inline-block p-4 rounded-circle mb-3">
                    <i class="fa-solid fa-box-open text-muted display-4"></i>
                </div>
                <h4 class="text-muted fw-bold">No hay productos disponibles</h4>
                <p class="text-secondary">Estamos actualizando nuestro catálogo. ¡Vuelve pronto!</p>
                <a href="{{ url('/') }}" class="btn btn-outline-primary px-4 mt-2">Actualizar página</a>
            </div>
        @endforelse
    </div>

    @if(method_exists($productos,'links'))
        <div class="d-flex justify-content-center mt-5">
            <div class="shadow-sm rounded-pill p-2 bg-white">
                {{ $productos->links() }}
            </div>
        </div>
    @endif
</div>
@endsection

@section('styles')
<style>
    /* Estilos para la paginación de Bootstrap en Laravel */
    .pagination { margin-bottom: 0; }
    .page-item.active .page-link {
        background-color: #4f46e5;
        border-color: #4f46e5;
    }
    .page-link {
        color: #4f46e5;
        border-radius: 50% !important;
        margin: 0 3px;
        border: none;
    }
</style>
@endsection