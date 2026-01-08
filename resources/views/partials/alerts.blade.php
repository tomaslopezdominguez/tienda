<div class="container mt-4">
    {{-- Mensajes de Éxito --}}
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-4 d-flex align-items-center fade show p-3" role="alert">
            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px; flex-shrink: 0;">
                <i class="fa-solid fa-check small"></i>
            </div>
            <div class="flex-grow-1 text-success fw-medium">
                {{ session('success') }}
            </div>
            <button type="button" class="btn-close ms-2" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Mensajes de Error (Sesión) --}}
    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm rounded-4 d-flex align-items-center fade show p-3" role="alert">
            <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px; flex-shrink: 0;">
                <i class="fa-solid fa-xmark small"></i>
            </div>
            <div class="flex-grow-1 text-danger fw-medium">
                {{ session('error') }}
            </div>
            <button type="button" class="btn-close ms-2" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Errores de Validación del Formulario --}}
    @if($errors->any())
        <div class="alert alert-danger border-0 shadow-sm rounded-4 fade show p-3" role="alert">
            <div class="d-flex align-items-center mb-2">
                <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px; flex-shrink: 0;">
                    <i class="fa-solid fa-triangle-exclamation small"></i>
                </div>
                <div class="fw-bold text-danger">Por favor, corrige los siguientes errores:</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <ul class="mb-0 text-danger small ps-5">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>

<style>
    .alert {
        transition: transform 0.2s ease;
    }
    .alert:hover {
        transform: translateY(-2px);
    }
    .alert-success { background-color: #ecfdf5; }
    .alert-danger { background-color: #fef2f2; }
    .btn-close:focus { box-shadow: none; }
</style>