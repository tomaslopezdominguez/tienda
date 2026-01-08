@extends('layouts.plantilla')

@section('title', 'Gestión de Categorías - Admin')

@section('content')
<div class="row">
    <div class="col-12">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 fw-bold mb-1 text-dark">Gestión de Categorías</h1>
                <p class="text-muted small mb-0">Administra las secciones y la organización de tus productos.</p>
            </div>
            <a href="{{ route('admin.categorias.create') }}" class="btn btn-primary px-4 py-2 shadow-sm">
                <i class="fa-solid fa-plus me-2"></i>Nueva Categoría
            </a>
        </div>

        @include('partials.alerts')

        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3 text-uppercase small fw-bold text-secondary" style="width: 80px;">ID</th>
                                <th class="py-3 text-uppercase small fw-bold text-secondary">Categoría</th>
                                <th class="py-3 text-uppercase small fw-bold text-secondary">Descripción</th>
                                <th class="py-3 text-uppercase small fw-bold text-secondary text-center">Productos</th>
                                <th class="pe-4 py-3 text-uppercase small fw-bold text-secondary text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categorias as $categoria)
                                <tr>
                                    <td class="ps-4">
                                        <span class="text-muted fw