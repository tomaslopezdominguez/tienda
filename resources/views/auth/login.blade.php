@extends('layouts.plantilla')

@section('title', 'Iniciar Sesión | Tienda')

@section('content')
<div class="row justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="col-md-5 col-lg-4">
        
        <div class="text-center mb-4">
            <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center shadow" style="width: 70px; height: 70px;">
                <i class="fa-solid fa-lock fs-2"></i>
            </div>
            <h2 class="fw-bold mt-3 text-dark">Bienvenido</h2>
            <p class="text-muted">Ingresa tus credenciales para continuar</p>
        </div>

        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body p-4 p-md-5">
                
                @include('partials.alerts')

                <form method="POST" action="{{ route('login.post') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label small fw-bold text-uppercase text-secondary">Correo Electrónico</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fa-regular fa-envelope text-muted"></i></span>
                            <input type="email" 
                                   class="form-control bg-light border-start-0 @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" 
                                   placeholder="nombre@ejemplo.com" required autofocus autocomplete="username">
                        </div>
                        @error('email')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <label for="password" class="form-label small fw-bold text-uppercase text-secondary">Contraseña</label>
                            <a href="#" class="small text-decoration-none">¿La olvidaste?</a>
                        </div>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-key text-muted"></i></span>
                            <input type="password" 
                                   class="form-control bg-light border-start-0 @error('password') is-invalid @enderror" 
                                   id="password" name="password" 
                                   placeholder="••••••••" required autocomplete="current-password">
                        </div>
                        @error('password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label small text-secondary" for="remember">Mantener sesión iniciada</label>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg fw-bold shadow-sm py-3">
                            Acceder a mi cuenta
                        </button>
                    </div>
                </form>

                <div class="text-center mt-4 pt-2 border-top">
                    <p class="small text-muted mb-0">¿Aún no tienes cuenta?</p>
                    <a href="{{ route('register') }}" class="fw-bold text-decoration-none text-primary">Regístrate gratis</a>
                </div>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('home') }}" class="text-muted text-decoration-none small">
                <i class="fa-solid fa-arrow-left me-1"></i> Volver a la tienda
            </a>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .input-group-text { border-color: #dee2e6; }
    .form-control:focus { box-shadow: none; border-color: #0d6efd; }
    .form-control { border-color: #dee2e6; }
    body { background-color: #f8f9fa; }
</style>
@endsection