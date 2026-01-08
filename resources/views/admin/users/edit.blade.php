@extends('layouts.plantilla')

@section('title', 'Editar Usuario: ' . $user->name)

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10 col-lg-8">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Admin</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}" class="text-decoration-none">Usuarios</a></li>
                        <li class="breadcrumb-item active">Editar</li>
                    </ol>
                </nav>
                <h1 class="h3 fw-bold mb-0 text-dark">
                    <i class="fa-solid fa-user-pen text-primary me-2"></i>Modificar Usuario
                </h1>
            </div>
        </div>

        @include('partials.alerts')

        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row g-4">
                <div class="col-md-7">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body p-4">
                            <h5 class="card-title fw-bold mb-4 text-primary">Perfil del Usuario</h5>
                            
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Nombre</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fa-regular fa-user text-muted"></i></span>
                                    <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                                           class="form-control @error('name') is-invalid @enderror" required>
                                </div>
                                @error('name')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Correo Electrónico</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fa-regular fa-envelope text-muted"></i></span>
                                    <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                                           class="form-control @error('email') is-invalid @enderror" required>
                                </div>
                                @error('email')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                            
                            <hr class="my-4 opacity-50">

                            <h5 class="card-title fw-bold mb-3 text-danger">Actualizar Seguridad</h5>
                            <div class="alert alert-warning border-0 py-2 small">
                                <i class="fa-solid fa-circle-info me-2"></i>Deja la contraseña en blanco si no deseas cambiarla.
                            </div>
                            <div class="mb-0">
                                <label class="form-label fw-semibold">Nueva Contraseña</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fa-solid fa-key text-muted"></i></span>
                                    <input type="password" name="password" 
                                           class="form-control @error('password') is-invalid @enderror" 
                                           placeholder="••••••••">
                                </div>
                                @error('password')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body p-4">
                            <h5 class="card-title fw-bold mb-3 text-center">Permisos y Roles</h5>
                            
                            <div class="bg-light p-3 rounded border mb-3">
                                <label class="form-label fw-semibold d-block">Roles asignados:</label>
                                <select name="roles[]" multiple class="form-select @error('roles') is-invalid @enderror" style="height: 180px;">
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}" 
                                            {{ in_array($role->id, old('roles', $user->roles->pluck('id')->toArray())) ? 'selected' : '' }}>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted d-block mt-2">Ctrl + Click para multi-selección.</small>
                            </div>

                            <div class="d-flex align-items-center p-2 bg-soft-info rounded">
                                <i class="fa-solid fa-clock-rotate-left text-info me-3 fs-4"></i>
                                <div class="small">
                                    <span class="text-muted d-block">Miembro desde:</span>
                                    <span class="fw-bold text-dark">{{ $user->created_at->format('d/m/Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm bg-dark text-white">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="small opacity-75">ID de Usuario:</span>
                                <span class="badge bg-secondary">#{{ $user->id }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0 mt-4 bg-light">
                <div class="card-body d-flex justify-content-end gap-2 p-3">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-link text-decoration-none text-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary px-5 fw-bold shadow-sm">
                        <i class="fa-solid fa-floppy-disk me-2"></i>Actualizar Usuario
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('styles')
<style>
    .bg-soft-info { background-color: #e0f2fe; }
    .input-group-text { border-color: #dee2e6; }
</style>
@endsection