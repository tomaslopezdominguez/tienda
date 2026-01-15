@extends('layouts.plantilla')

@section('title', 'Dashboard - Panel de Control')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <h1 class="h3 fw-bold text-dark mb-1">Panel de Control</h1>
        <p class="text-muted">Bienvenido al centro de gestión de tu tienda online.</p>
    </div>

    <div class="col-12 mt-2 mb-3">
        <h5 class="fw-bold text-dark">Gestión Principal</h5>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card shadow-sm border-0 h-100 hover-card">
            <div class="card-body p-4 text-center">
                <div class="icon-box bg-primary text-white rounded-3 mx-auto mb-3">
                    <i class="fa-solid fa-user-gear fs-3"></i>
                </div>
                <h5 class="fw-bold">Cuentas y Roles</h5>
                <p class="text-muted small">Administra los permisos de acceso y gestiona la base de datos de clientes.</p>
                <a href="{{ route('admin.users.index') }}" class="btn btn-primary w-100 py-2 fw-bold">Gestionar Usuarios</a>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card shadow-sm border-0 h-100 hover-card">
            <div class="card-body p-4 text-center">
                <div class="icon-box bg-dark text-white rounded-3 mx-auto mb-3">
                    <i class="fa-solid fa-boxes-stacked fs-3"></i>
                </div>
                <h5 class="fw-bold">Catálogo</h5>
                <p class="text-muted small">Controla el inventario, sube fotos de productos y ajusta precios de venta.</p>
                <a href="{{ route('admin.productos.index') }}" class="btn btn-dark w-100 py-2 fw-bold">Gestionar Productos</a>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card shadow-sm border-0 h-100 hover-card">
            <div class="card-body p-4 text-center">
                <div class="icon-box bg-secondary text-white rounded-3 mx-auto mb-3">
                    <i class="fa-solid fa-tags fs-3"></i>
                </div>
                <h5 class="fw-bold">Categorías</h5>
                <p class="text-muted small">Organiza tus productos por familias para mejorar la navegación del cliente.</p>
                <a href="{{ route('admin.categorias.index') }}" class="btn btn-secondary w-100 py-2 fw-bold">Gestionar Categorías</a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    /* Estilos para que los botones se vean bien */
    .icon-box {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .hover-card {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
</style>
@endsection