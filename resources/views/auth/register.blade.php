@extends('layouts.plantilla')

@section('title', 'Registro de Usuario')

@section('content')

<div class="container py-5">
<div class="row justify-content-center">
<div class="col-md-6">
<div class="card shadow-lg">
<div class="card-header bg-primary text-white text-center">
<h2>Crear Cuenta</h2>
</div>

            <div class="card-body p-4">
                <form method="POST" action="{{ route('register.post') }}">
                    @csrf

                    {{-- Nombre --}}
                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Contraseña --}}
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Confirmar Contraseña --}}
                    <div class="mb-3">
                        <label for="password-confirm" class="form-label">Confirmar Contraseña</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">
                            Registrarse
                        </button>
                    </div>
                </form>
            </div>

            <div class="card-footer text-center">
                ¿Ya tienes una cuenta? <a href="{{ route('login') }}">Iniciar Sesión</a>
            </div>
        </div>
    </div>
</div>


</div>
@endsection