@extends('layouts.plantilla')

@section('title', 'Detalle de Usuario - ' . $user->name)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb small">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Usuarios</a></li>
                <li class="breadcrumb-item active">{{ $user->name }}</li>
            </ol>
        </nav>

        <div class="d-flex justify-content-between align-items-end mb-4">
            <h1 class="h3 fw-bold mb-0 text-dark">Expediente de Usuario</h1>
            <div class="gap-2">
                <a href="{{ route('admin.users.index') }}" class="btn btn-light border text-secondary me-2">
                    <i class="fa-solid fa-arrow-left me-1"></i> Volver
                </a>
                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary px-4 shadow-sm">
                    <i class="fa-solid fa-user-pen me-2"></i>Editar Datos
                </a>
            </div>
        </div>

        @include('partials.alerts')

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card shadow-sm border-0 text-center mb-4">
                    <div class="card-body p-4">
                        <div class="avatar-xl bg-soft-primary text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3 shadow-sm" style="width: 100px; height: 100px;">
                            <span class="display-4 fw-bold">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                        </div>
                        <h4 class="fw-bold text-dark mb-1">{{ $user->name }}</h4>
                        <p class="text-muted small mb-3">{{ $user->email }}</p>
                        
                        <div class="d-flex justify-content-center gap-1 flex-wrap">
                            @foreach($user->roles as $role)
                                <span class="badge {{ $role->slug == 'admin' ? 'bg-soft-danger text-danger' : 'bg-soft-info text-info' }} border px-3 py-2 rounded-pill small">
                                    {{ $role->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <h6 class="fw-bold text-dark mb-3">Resumen de Actividad</h6>
                        <ul class="list-unstyled mb-0">
                            <li class="d-flex justify-content-between mb-2 small text-muted">
                                <span>ID del Sistema:</span>
                                <span class="fw-bold text-dark">#{{ $user->id }}</span>
                            </li>
                            <li class="d-flex justify-content-between mb-2 small text-muted">
                                <span>Registrado:</span>
                                <span class="text-dark">{{ $user->created_at->format('d/m/Y') }}</span>
                            </li>
                            <li class="d-flex justify-content-between small text-muted">
                                <span>Hora:</span>
                                <span class="text-dark">{{ $user->created_at->format('H:i') }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="card-title mb-0 fw-bold text-dark small text-uppercase">Información de Acceso</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless align-middle">
                            <tr>
                                <th class="text-muted small fw-normal py-3" style="width: 30%;">Nombre Completo</th>
                                <td class="fw-bold py-3">{{ $user->name }}</td>
                            </tr>
                            <tr class="border-top">
                                <th class="text-muted small fw-normal py-3">Email Principal</th>
                                <td class="py-3">
                                    {{ $user->email }}
                                    <i class="fa-solid fa-circle-check text-success ms-2 small" title="Email Verificado"></i>
                                </td>
                            </tr>
                            <tr class="border-top">
                                <th class="text-muted small fw-normal py-3">Estado de Cuenta</th>
                                <td class="py-3">
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3">
                                        <i class="fa-solid fa-check-circle me-1"></i> Cuenta Activa
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="card shadow-sm border-0 opacity-75">
                    <div class="card-body p-5 text-center bg-light">
                        <i class="fa-solid fa-cart-shopping fs-1 text-muted opacity-25 mb-3"></i>
                        <h6 class="text-muted">Historial de Pedidos (Próximamente)</h6>
                        <p class="small text-muted mb-0">Aquí se mostrarán las compras realizadas por este usuario una vez se integre el módulo de ventas.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .bg-soft-primary { background-color: #eef2ff; }
    .bg-soft-info { background-color: #e0f2fe; color: #0369a1; border-color: #bae6fd !important; }
    .bg-soft-danger { background-color: #fee2e2; color: #b91c1c; border-color: #fecaca !important; }
    .card-header { border-bottom: 1px solid rgba(0,0,0,0.05); }
</style>
@endsection