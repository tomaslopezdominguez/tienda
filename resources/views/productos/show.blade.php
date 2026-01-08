@extends('layouts.plantilla')

@section('title', 'Detalle: ' . $producto->nombre)

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('productos.index') }}" class="text-decoration-none">Catálogo</a></li>
            <li class="breadcrumb-item active text-truncate" style="max-width: 250px;">{{ $producto->nombre }}</li>
        </ol>
    </nav>

    <div class="row g-5">
        {{-- COLUMNA DE IMAGEN --}}
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
                <div class="p-4">
                    @php $imgUrl = $producto->imagen ? asset('storage/' . $producto->imagen) : asset('img/default-product.png'); @endphp
                    <img src="{{ $imgUrl }}" 
                         alt="{{ $producto->nombre }}" 
                         class="img-fluid w-100 object-fit-contain" 
                         style="max-height: 500px; min-height: 300px;">
                </div>
            </div>
        </div>
        
        {{-- COLUMNA DE DETALLES --}}
        <div class="col-lg-6">
            <div class="ps-lg-4">
                {{-- Etiquetas de Categoría --}}
                @foreach($producto->categorias as $cat)
                    <span class="badge bg-soft-primary text-primary rounded-pill px-3 mb-2">{{ $cat->nombre }}</span>
                @endforeach

                <h1 class="display-5 fw-bold text-dark mb-3">{{ $producto->nombre }}</h1>
                
                <div class="d-flex align-items-center mb-4">
                    <h2 class="text-primary fw-bold mb-0 me-3">{{ number_format($producto->precio, 2) }} €</h2>
                    @if($producto->stock > 0)
                        <span class="badge bg-soft-success text-success border border-success border-opacity-10 px-3 py-2">
                            <i class="fa-solid fa-check-circle me-1"></i> Stock Disponible ({{ $producto->stock }})
                        </span>
                    @else
                        <span class="badge bg-soft-danger text-danger border border-danger border-opacity-10 px-3 py-2">
                            <i class="fa-solid fa-circle-xmark me-1"></i> Agotado
                        </span>
                    @endif
                </div>

                <div class="mb-4 border-top border-bottom py-4">
                    <h6 class="fw-bold text-uppercase small text-muted mb-3">Descripción del Producto</h6>
                    <p class="text-secondary lh-lg mb-0">
                        {{ $producto->descripcion ?? 'Este producto no tiene una descripción detallada todavía.' }}
                    </p>
                </div>

                {{-- FORMULARIO COMPRA --}}
                <form action="{{ route('carrito.guardar') }}" method="POST">
                    @csrf
                    <input type="hidden" name="producto_id" value="{{ $producto->id }}">
                    
                    <div class="row g-3 align-items-end mb-4">
                        <div class="col-sm-4 col-md-3">
                            <label class="form-label small fw-bold">Cantidad</label>
                            <input type="number" name="cantidad" value="1" min="1" max="{{ $producto->stock }}" 
                                   class="form-control bg-light border-0 py-2" 
                                   @if($producto->stock == 0) disabled @endif>
                        </div>
                        <div class="col-sm-8 col-md-9">
                            <button class="btn btn-primary w-100 py-3 fw-bold shadow-sm" @if($producto->stock == 0) disabled @endif>
                                <i class="fa-solid fa-cart-plus me-2"></i> Añadir al Carrito
                            </button>
                        </div>
                    </div>
                </form>

                {{-- ACCIONES DE ADMINISTRADOR --}}
                @auth
                    @if(auth()->user()->hasRole('admin'))
                        <div class="bg-light p-3 rounded-4 d-flex gap-2 mt-5 border border-dashed border-secondary border-opacity-25">
                            <span class="small fw-bold text-muted align-self-center me-auto ps-2">ADMIN TOOLS:</span>
                            <a href="{{ route('admin.productos.edit', $producto->id) }}" class="btn btn-warning btn-sm px-3 rounded-pill">
                                <i class="fas fa-edit me-1"></i> Editar
                            </a>
                            <form action="{{ route('admin.productos.destroy', $producto->id) }}" method="POST" class="d-inline" 
                                  onsubmit="return confirm('¿Está seguro de eliminar este producto?');">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm px-3 rounded-pill">
                                    <i class="fas fa-trash-alt me-1"></i> Eliminar
                                </button>
                            </form>
                        </div>
                    @endif
                @endauth
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .bg-soft-primary { background-color: #eef2ff; }
    .bg-soft-success { background-color: #ecfdf5; }
    .bg-soft-danger { background-color: #fef2f2; }
    .border-dashed { border-style: dashed !important; }
    .object-fit-contain { object-fit: contain; }
</style>
@endsection