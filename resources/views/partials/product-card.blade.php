<div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden hover-lift transition-all">
    <div class="position-relative overflow-hidden bg-light" style="padding-top: 75%;">
        <img src="{{ $producto->image ?? 'https://place-hold.it/400x300' }}" 
             class="card-img-top position-absolute top-0 start-0 w-100 h-100 object-fit-cover transition-transform" 
             alt="{{ e($producto->nombre) }}">
        
        <div class="position-absolute top-0 end-0 m-3">
            <span class="badge bg-white text-dark shadow-sm fs-6 px-3 py-2 rounded-pill fw-bold">
                {{ number_format($producto->precio, 2) }} €
            </span>
        </div>
    </div>

    <div class="card-body d-flex flex-column p-4">
        <h5 class="card-title fw-bold text-dark mb-1">{{ $producto->nombre }}</h5>
        
        @if($producto->categorias && $producto->categorias->count())
            <div class="mb-3">
                @foreach($producto->categorias as $cat)
                    <span class="badge bg-soft-primary text-primary small fw-normal rounded-pill">
                        {{ $cat->nombre }}
                    </span>
                @endforeach
            </div>
        @endif

        @if(!empty($producto->descripcion))
            <p class="card-text text-muted small mb-4">
                {{ \Illuminate\Support\Str::limit($producto->descripcion, 90) }}
            </p>
        @endif

        <div class="mt-auto">
            <form action="{{ route('carrito.guardar') }}" method="POST" class="mb-2">
                @csrf
                <input type="hidden" name="producto_id" value="{{ $producto->id }}">
                <button class="btn btn-primary w-100 py-2 rounded-3 fw-bold shadow-sm">
                    <i class="fa-solid fa-cart-plus me-2"></i>Añadir al carrito
                </button>
            </form>

            <div class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top">
                <a href="{{ route('productos.show', $producto) }}" class="btn btn-link text-decoration-none text-secondary p-0 small fw-bold">
                    Ver detalles
                </a>

                @auth
                    @if(auth()->user()->hasRole('admin'))
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.productos.edit', $producto->id) }}" 
                               class="btn btn-sm btn-soft-secondary rounded-circle" title="Editar">
                                <i class="fa-solid fa-pen text-secondary"></i>
                            </a>

                            <form action="{{ route('admin.productos.destroy', $producto->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-soft-danger rounded-circle" 
                                        onclick="return confirm('¿Eliminar este producto?')" title="Eliminar">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    @endif
                @endauth
            </div>
        </div>
    </div>
</div>

<style>
    .object-fit-cover { object-fit: cover; }
    .bg-soft-primary { background-color: #eef2ff; color: #4f46e5; }
    .btn-soft-secondary { background-color: #f8fafc; border: 1px solid #e2e8f0; }
    .btn-soft-danger { background-color: #fff1f2; border: 1px solid #fecdd3; color: #e11d48; }
    
    .hover-lift:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.12) !important;
    }
    .hover-lift:hover img {
        transform: scale(1.05);
    }
    .transition-transform { transition: transform 0.5s ease; }
    .transition-all { transition: all 0.3s ease; }
</style>