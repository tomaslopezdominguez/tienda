@extends('layouts.plantilla')

@section('title', 'Mi Panel de Usuario')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between bg-white p-4 rounded-4 shadow-sm border-start border-4 border-primary">
                <div>
                    <h1 class="h3 fw-bold mb-1">¡Hola de nuevo, {{ Auth::user()->name }}! 👋</h1>
                    <p class="text-muted mb-0 small">Este es tu resumen de cuenta y actividades recientes.</p>
                </div>
                <div class="d-none d-md-block">
                    <span class="badge bg-soft-primary text-primary px-3 py-2 rounded-pill">
                        Cliente desde {{ Auth::user()->created_at->format('M Y') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i> {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="dismiss" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                <div class="card-body p-4 text-center">
                    <div class="avatar-xl bg-soft-primary text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <span class="display-6 fw-bold">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                    </div>
                    <h5 class="fw-bold mb-1">{{ Auth::user()->name }}</h5>
                    <p class="text-muted small mb-3">{{ Auth::user()->email }}</p>
                    <a href="#" class="btn btn-sm btn-outline-primary rounded-pill px-4">Editar Perfil</a>
                </div>
                <div class="list-group list-group-flush border-top">
                    <a href="{{ route('home') }}" class="list-group-item list-group-item-action py-3 border-0">
                        <i class="fa-solid fa-bag-shopping me-3 text-primary"></i>Ir a la Tienda
                    </a>
                    <a href="#" class="list-group-item list-group-item-action py-3 border-0">
                        <i class="fa-solid fa-box me-3 text-muted"></i>Mis Pedidos
                    </a>
                    <a href="#" class="list-group-item list-group-item-action py-3 border-0">
                        <i class="fa-solid fa-heart me-3 text-muted"></i>Lista de Deseos
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                        <div class="d-flex align-items-center">
                            <div class="icon-box bg-soft-success text-success rounded-3 p-3 me-3">
                                <i class="fa-solid fa-truck-fast fs-4"></i>
                            </div>
                            <div>
                                <h6 class="text-muted small mb-1">Pedidos en curso</h6>
                                <h4 class="fw-bold mb-0">0</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                        <div class="d-flex align-items-center">
                            <div class="icon-box bg-soft-info text-info rounded-3 p-3 me-3">
                                <i class="fa-solid fa-ticket fs-4"></i>
                            </div>
                            <div>
                                <h6 class="text-muted small mb-1">Cupones disponibles</h6>
                                <h4 class="fw-bold mb-0">1</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold mb-0 small text-uppercase tracking-wider">Actividad Reciente</h5>
                </div>
                <div class="card-body p-5 text-center bg-light bg-opacity-50">
                    <div class="mb-3 opacity-25">
                        <i class="fa-solid fa-clock-rotate-left display-4"></i>
                    </div>
                    <h6 class="text-muted">Aún no tienes pedidos registrados</h6>
                    <p class="small text-secondary mb-4">¡Anímate a realizar tu primera compra y aprovecha nuestros descuentos!</p>
                    <a href="{{ route('productos.index') }}" class="btn btn-primary px-4 shadow-sm">
                        Explorar catálogo
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .bg-soft-primary { background-color: #eef2ff; }
    .bg-soft-success { background-color: #ecfdf5; }
    .bg-soft-info { background-color: #f0f9ff; }
    .icon-box { width: 56px; height: 56px; display: flex; align-items: center; justify-content: center; }
    .list-group-item-action:hover { background-color: #f8fafc; color: #4f46e5; }
    .tracking-wider { letter-spacing: 0.05em; }
</style>
@endsection