<div class="card h-100 border-0 shadow-sm rounded-4 hover-lift transition-all">
    <div class="card-body d-flex flex-column p-4">
        <div class="d-flex align-items-center mb-3">
            <div class="bg-soft-primary text-primary rounded-3 p-2 me-3">
                <i class="fa-solid fa-folder-open fs-5"></i>
            </div>
            <h5 class="card-title fw-bold text-dark mb-0">{{ $categoria->nombre }}</h5>
        </div>

        <p class="text-muted small mb-4">
            <i class="fa-solid fa-box-open me-1"></i>
            {{ $categoria->productos_count ?? $categoria->productos()->count() }} Productos disponibles
        </p>

        <div class="mt-auto pt-3 border-top d-flex justify-content-between align-items-center">
            <a href="{{ route('categorias.show', $categoria) }}" class="btn btn-sm btn-light border fw-bold px-3 rounded-pill text-primary">
                Ver Catálogo
            </a>

            @auth
                @if(auth()->user()->hasRole('admin'))
                    <div class="d-flex gap-1">
                        <a href="{{ route('admin.categorias.edit', $categoria) }}" 
                           class="btn btn-sm btn-soft-secondary rounded-circle shadow-sm" 
                           title="Editar">
                            <i class="fa-solid fa-pen-to-square text-secondary"></i>
                        </a>

                        <form action="{{ route('admin.categorias.destroy', $categoria) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="btn btn-sm btn-soft-danger rounded-circle shadow-sm" 
                                    onclick="return confirm('¿Estás seguro de eliminar esta categoría? Los productos podrían quedar sin categoría.')"
                                    title="Eliminar">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </form>
                    </div>
                @endif
            @endauth
        </div>
    </div>
</div>

<style>
    /* Estilos personalizados para estas tarjetas */
    .bg-soft-primary { background-color: #eef2ff; }
    .btn-soft-secondary { background-color: #f8fafc; border: 1px solid #e2e8f0; }
    .btn-soft-danger { background-color: #fff1f2; border: 1px solid #fecdd3; color: #e11d48; }
    
    .hover-lift {
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }
    .hover-lift:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important;
    }
    .transition-all { transition: all 0.3s ease; }
    
    .rounded-4 { border-radius: 1rem !important; }
</style>