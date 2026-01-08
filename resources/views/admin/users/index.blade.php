@extends('layouts.plantilla')

@section('title', 'Gestión de Usuarios - Admin')

@section('content')
<div class="row">
    <div class="col-12">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 fw-bold mb-1 text-dark">Usuarios del Sistema</h1>
                <p class="text-muted small mb-0">Administra las cuentas, roles y permisos de acceso.</p>
            </div>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary shadow-sm">
                <i class="fa-solid fa-user-plus me-2"></i>Nuevo Usuario
            </a>
        </div>

        @include('partials.alerts')

        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3 text-uppercase small fw-bold text-secondary" style="width: 70px;">ID</th>
                                <th class="py-3 text-uppercase small fw-bold text-secondary">Usuario</th>
                                <th class="py-3 text-uppercase small fw-bold text-secondary">Roles</th>
                                <th class="py-3 text-uppercase small fw-bold text-secondary">Registro</th>
                                <th class="pe-4 py-3 text-uppercase small fw-bold text-secondary text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <td class="ps-4 text-muted small">#{{ $user->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-soft-primary text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold me-3" style="width: 40px; height: 40px;">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark">{{ $user->name }}</div>
                                                <div class="text-muted small">{{ $user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @foreach($user->roles as $role)
                                            <span class="badge {{ $role->slug == 'admin' ? 'bg-soft-danger text-danger' : 'bg-soft-info text-info' }} border px-2 py-1 small">
                                                <i class="fa-solid {{ $role->slug == 'admin' ? 'fa-shield-halved' : 'fa-user' }} me-1 small"></i>
                                                {{ $role->name }}
                                            </span>
                                        @endforeach
                                    </td>
                                    <td class="text-muted small">
                                        {{ $user->created_at->diffForHumans() }}
                                    </td>
                                    <td class="pe-4 text-end">
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-light border" title="Ver Perfil">
                                                <i class="fa-solid fa-eye text-muted"></i>
                                            </a>
                                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-light border" title="Editar">
                                                <i class="fa-solid fa-user-pen text-primary"></i>
                                            </a>

                                            @php
                                                $isAdmin = $user->hasRole('admin');
                                                $adminCount = \App\Models\Role::where('slug','admin')->first()->users()->count();
                                                $canDelete = !$isAdmin || ($isAdmin && $adminCount > 1);
                                            @endphp

                                            @if($canDelete)
                                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de eliminar este usuario?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-light border" title="Eliminar">
                                                        <i class="fa-solid fa-trash text-danger"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <button class="btn btn-sm btn-light border opacity-50" disabled title="No puedes eliminar al último administrador">
                                                    <i class="fa-solid fa-trash text-danger"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="fa-solid fa-users-slash fs-1 d-block mb-3 opacity-25"></i>
                                        No se encontraron usuarios registrados.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @if(method_exists($users, 'links'))
            <div class="d-flex justify-content-center mt-4">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

@section('styles')
<style>
    .bg-soft-primary { background-color: #e0e7ff; }
    .bg-soft-info { background-color: #e0f2fe; color: #0369a1; border-color: #bae6fd !important; }
    .bg-soft-danger { background-color: #fee2e2; color: #b91c1c; border-color: #fecaca !important; }
    .avatar-sm { font-size: 0.85rem; border: 1px solid #c7d2fe; }
    .table thead th { border-bottom: none; font-size: 0.7rem; letter-spacing: 0.05em; }
    .btn-light:hover { background-color: #f1f5f9; border-color: #cbd5e1; }
</style>
@endsection