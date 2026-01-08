@extends('layouts.plantilla')

@section('title', 'Perfil y Roles - ' . $user->name)

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        
        <div class="mb-4 text-center">
            <div class="avatar-lg bg-soft-primary text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3 shadow-sm" style="width: 80px; height: 80px;">
                <i class="fa-solid fa-user-shield fs-1"></i>
            </div>
            <h1 class="h3 fw-bold text-dark">Perfil de Seguridad</h1>
            <p class="text-muted small">Verifica los niveles de acceso asignados a tu cuenta.</p>
        </div>

        @include('partials.alerts')

        <div class="card shadow-sm border-0 overflow-hidden">
            <div class="card-header bg-dark py-3">
                <h5 class="card-title mb-0 text-white small fw-bold text-uppercase tracking-wider">
                    <i class="fa-solid fa-id-card me-2 opacity-75"></i>Información de Identidad
                </h5>
            </div>

            <div class="card-body p-4">
                <div class="row mb-4">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <label class="text-muted small fw-bold text-uppercase d-block">Nombre Completo</label>
                        <span class="fw-bold text-dark fs-5">{{ $user->name }}</span>
                    </div>
                    <div class="col-sm-6">
                        <label class="text-muted small fw-bold text-uppercase d-block">Correo Electrónico</label>
                        <span class="text-dark">{{ $user->email }}</span>
                    </div>
                </div>

                <hr class="my-4 opacity-50">

                <h6 class="fw-bold text-dark mb-3">
                    <i class="fa-solid fa-key me-2 text-primary"></i>Privilegios de Acceso
                </h6>

                @if ($roles->count() > 0)
                    <div class="list-group list-group-flush border rounded">
                        @foreach ($roles as $role)
                            @php $hasRole = $user->hasRole($role->slug); @endphp
                            <div class="list-group-item d-flex justify-content-between align-items-center py-3 {{ $hasRole ? 'bg-light' : '' }}">
                                <div>
                                    <span class="fw-medium {{ $hasRole ? 'text-primary' : 'text-muted' }}">
                                        {{ $role->name }}
                                    </span>
                                    @if($role->slug == 'admin')
                                        <i class="fa-solid fa-crown ms-1 text-warning small" title="Superusuario"></i>
                                    @endif
                                </div>
                                
                                @if($hasRole)
                                    <span class="badge bg-primary rounded-pill px-3 shadow-sm">
                                        <i class="fa-solid fa-check-circle me-1"></i> Activo
                                    </span>
                                @else
                                    <span class="badge bg-light text-muted border rounded-pill px-3">
                                        Inactivo
                                    </span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-light border text-center py-4">
                        <i class="fa-solid fa-user-slash fs-2 d-block mb-2 text-muted opacity-50"></i>
                        <p class="mb-0 text-secondary fw-medium">No hay roles definidos en el sistema.</p>
                    </div>
                @endif
            </div>

            <div class="card-footer bg-light border-top-0 p-4 text-center">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-dark fw-bold py-2 shadow-sm">
                        <i class="fa-solid fa-house-user me-2"></i>Volver al Panel Principal
                    </a>
                </div>
                @if(auth()->user()->hasRole('admin'))
                    <small class="text-muted d-block mt-3 italic">
                        <i class="fa-solid fa-info-circle me-1"></i> Puedes modificar estos permisos desde la sección de Usuarios.
                    </small>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .bg-soft-primary { background-color: #e0e7ff; }
    .tracking-wider { letter-spacing: 0.05em; }
    .list-group-item { border-left: none; border-right: none; }
    .list-group-item:first-child { border-top: none; }
    .list-group-item:last-child { border-bottom: none; }
</style>
@endsection