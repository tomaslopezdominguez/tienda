@extends('layouts.plantilla')

@section('title', 'Nuevo Usuario - Admin')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10 col-lg-8">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Admin</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}" class="text-decoration-none">Usuarios</a></li>
                        <li class="breadcrumb-item active">Nuevo</li>
                    </ol>
                </nav>
                <h1 class="h3 fw-bold mb-0 text-dark">
                    <i class="fa-solid fa-user-plus text-primary me-2"></i>Registrar Nuevo Usuario
                </h1>
            </div>
        </div>

        @include('partials.alerts')

        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            
            <div class="row g-4">
                <div class="col-md-7">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body p-4">
                            <h5 class="card-title fw-bold mb-4 text-primary">Información Personal</h5>
                            
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Nombre Completo</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fa-regular fa-user text-muted"></i></span>
                                    <input type="text" name="name" value="{{ old('name') }}" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           placeholder="Ej: Juan Pérez" required autofocus>
                                </div>
                                @error('name')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Correo Electrónico</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fa-regular fa-envelope text-muted"></i></span>
                                    <input type="email" name="email" value="{{ old('email') }}" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           placeholder="usuario@ejemplo.com" required>
                                </div>
                                @error('email')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                <small class="text-muted">Se utilizará como nombre de usuario para el inicio de sesión.</small>
                            </div>
                            
                            <hr class="my-4 opacity-50">

                            <h5 class="card-title fw-bold mb-3 text-primary">Seguridad</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Contraseña</label>
                                    <input type="password" name="password" 
                                           class="form-control @error('password') is-invalid @enderror" 
                                           placeholder="••••••••" required>
                                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Confirmar</label>
                                    <input type="password" name="password_confirmation" 
                                           class="form-control" placeholder="••••••••" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body p-4 text-center">
                            <div class="bg-soft-primary text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                <i class="fa-solid fa-shield-halved fs-3"></i>
                            </div>
                            <h5 class="fw-bold mb-3">Roles de Usuario</h5>
                            
                            <div class="text-start">
                                <label class="form-label fw-semibold">Asignar privilegios:</label>
                                <select name="roles[]" multiple class="form-select @error('roles') is-invalid @enderror" style="height: 160px;">
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}" {{ in_array($role->id, old('roles', [])) ? 'selected' : '' }}>
                                            {{ $role->name }} ({{ strtoupper($role->slug) }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('roles')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                <div class="alert alert-light border mt-3 mb-0 py-2">
                                    <small class="text-muted">
                                        <i class="fa-solid fa-circle-info me-1"></i> 
                                        Usa <strong>Ctrl + Click</strong> (o Cmd) para seleccionar múltiples roles.
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card bg-primary text-white shadow-sm border-0">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center">
                                <i class="fa-solid fa-envelope-circle-check fs-4 me-3"></i>
                                <p class="small mb-0">Se recomienda notificar al usuario una vez creada la cuenta para que proceda al cambio de contraseña.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0 mt-4 bg-light">
                <div class="card-body d-flex justify-content-between align-items-center p-3">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-link text-decoration-none text-secondary fw-medium">
                        <i class="fa-solid fa-xmark me-1"></i> Cancelar y volver
                    </a>
                    <button type="submit" class="btn btn-primary px-5 py-2 fw-bold shadow-sm">
                        <i class="fa-solid fa-user-check me-2"></i>Crear Usuario
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('styles')
<style>
    .bg-soft-primary { background-color: #e0e7ff; }
    .form-label { font-size: 0.9rem; }
    .input-group-text { border-color: #dee2e6; }
</style>
@endsection