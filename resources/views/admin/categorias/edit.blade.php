@extends('layouts.plantilla')

@section('title', 'Editar Categoría - Admin')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Admin</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.categorias.index') }}" class="text-decoration-none">Categorías</a></li>
                        <li class="breadcrumb-item active">Editar</li>
                    </ol>
                </nav>
                <h1 class="h3 fw-bold mb-0 text-dark">
                    <i class="fa-solid fa-pen-to-square text-primary me-2"></i>Editar Categoría
                </h1>
            </div>
        </div>

        @include('partials.alerts')

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 border-bottom-0">
                <span class="badge bg-soft-primary text-primary px-3 py-2 rounded-pill">
                    ID: #{{ $categoria->id }}
                </span>
            </div>
            <div class="card-body p-4 p-md-5 pt-0">
                <form action="{{ route('admin.categorias.update', $categoria->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="nombre" class="form-label fw-semibold text-secondary">
                            <i class="fa-solid fa-tag me-1"></i> Nombre de la categoría
                        </label>
                        <input type="text" 
                               name="nombre" 
                               id="nombre"
                               value="{{ old('nombre', $categoria->nombre) }}" 
                               class="form-control form-