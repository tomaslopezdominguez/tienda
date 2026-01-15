@extends('layouts.plantilla')

@section('title', 'Gestión de Productos - Admin')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 fw-bold mb-1 text-dark">Inventario de Productos</h1>
                <p class="text-muted small mb-0">Gestiona el stock, precios y visibilidad de tu catálogo.</p>
            </div>
            <a href="{{ route('admin.productos.create') }}" class="btn btn-primary shadow-sm">
                <i class="fa-solid fa-plus me-2"></i>Nuevo Producto
            </a>
        </div>

        @include('partials.alerts')

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body py-3">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <span class="text-muted small fw-bold text-uppercase">Resumen:</span>
                        <span class="badge bg-light text-dark border ms-2">{{ $productos->total() }} Productos totales</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3 text-uppercase small fw-bold text-secondary" style="width: 80px;">Ref.</th>
                                <th class="py-3 text-uppercase small fw-bold text-secondary">Producto</th>
                                <th class="py-3 text-uppercase small fw-bold text-secondary">Categorías</th>
                                <th class="py-3 text-uppercase small fw-bold text-secondary">Precio</th>
                                <th class="py-3 text-uppercase small fw-bold text-secondary text-center">Stock</th>
                                <th class="pe-4 py-3 text-uppercase small fw-bold text-secondary text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($productos as $producto)
                                <tr>
                                    <td class="ps-4 text-muted small">
                                        #{{ str_pad($producto->id, 4, '0', STR_PAD_LEFT) }}
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-light rounded p-1 me-3 border" style="width: 50px; height: 50px; overflow: hidden;">
                                                @if($producto->imagen)
                                                    <img src="{{ asset('storage/' . trim($producto->imagen, '/')) }}" 
                                                         class="img-fluid rounded shadow-xs" 
                                                         style="object-fit: cover; width: 100%; height: 100%;"
                                                         alt="{{ $producto->nombre }}">
                                                @else
                                                    <img src="{{ asset('img/no-image.jpg') }}" 
                                                         class="img-fluid rounded opacity-50" 
                                                         style="object-fit: cover; width: 100%; height: 100%;">
                                                @endif
                                            </div>
                                            <div>
                                                <span class="fw-bold d-block text-dark">{{ $producto->nombre }}</span>
                                                <span class="text-muted small">Posición: {{ $producto->posicion }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @foreach($producto->categorias as $cat)
                                            <span class="badge bg-soft-info text-info border border-info-subtle small px-2">
                                                {{ $cat->nombre }}
                                            </span>
                                        @endforeach
                                    </td>
                                    <td>
                                        <span class="fw-bold text-dark">{{ number_format($producto->precio, 2) }} €</span>
                                    </td>
                                    <td class="text-center">
                                        @if($producto->stock <= 5)
                                            <span class="badge bg-danger px-3 py-2 rounded-pill shadow-sm">
                                                <i class="fa-solid fa-triangle-exclamation me-1"></i> {{ $producto->stock }}
                                            </span>
                                        @else
                                            <span class="badge bg-light text-dark border px-3 py-2 rounded-pill">
                                                {{ $producto->stock }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="pe-4 text-end">
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="{{ route('productos.show', $producto) }}" class="btn btn-sm btn-light border" title="Ver en tienda" target="_blank">
                                                <i class="fa-solid fa-eye text-muted"></i>
                                            </a>
                                            <a href="{{ route('admin.productos.edit', $producto) }}" class="btn btn-sm btn-light border" title="Editar">
                                                <i class="fa-solid fa-pen-to-square text-primary"></i>
                                            </a>
                                            <form action="{{ route('admin.productos.destroy', $producto) }}" method="POST" onsubmit="return confirm('¿Eliminar producto?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-light border">
                                                    <i class="fa-solid fa-trash text-danger"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">No hay productos.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @if(method_exists($productos,'links'))
            <div class="d-flex justify-content-center mt-4">
                {{ $productos->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

@section('styles')
<style>
    .bg-soft-info { background-color: #e0f2fe; color: #0369a1; }
    .table thead th { border-bottom: none; font-size: 0.75rem; letter-spacing: 0.05em; }
    .btn-light:hover { background-color: #f1f5f9; border-color: #cbd5e1; }
</style>
@endsection