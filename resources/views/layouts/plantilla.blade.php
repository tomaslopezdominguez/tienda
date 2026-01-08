<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mi Tienda Online')</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />

    <style>
        :root {
            --primary-color: #2563eb;
            --admin-color: #dc3545;
        }
        body { font-family: 'Inter', sans-serif; background-color: #f8f9fa; color: #334155; }
        
        /* Navbar Styles */
        .navbar { box-shadow: 0 2px 15px rgba(0,0,0,0.05); border-bottom: 1px solid #e2e8f0; }
        .nav-link { font-weight: 500; color: #64748b !important; transition: all 0.2s; }
        .nav-link:hover { color: var(--primary-color) !important; }
        
        /* Admin specific link */
        .nav-admin { color: var(--admin-color) !important; font-weight: 700 !important; }
        .nav-admin:hover { opacity: 0.8; }

        /* Buttons & Cards */
        .btn-primary { background-color: var(--primary-color); border: none; padding: 0.6rem 1.2rem; font-weight: 600; border-radius: 8px; transition: all 0.3s; }
        .btn-primary:hover { background-color: #1d4ed8; transform: translateY(-1px); }
        .card { border: none; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); }
        
        /* Cart Badge */
        .badge-cart { position: absolute; top: -5px; right: -5px; font-size: 0.7rem; border: 2px solid white; }

        /* Dropdowns */
        .dropdown-menu { border-radius: 12px; padding: 0.5rem; margin-top: 10px; }
        .dropdown-item { border-radius: 8px; padding: 0.6rem 1rem; font-size: 0.9rem; }
    </style>
    @yield('styles')
</head>
<body>
    <header class="sticky-top">
        <nav class="navbar navbar-expand-lg navbar-light bg-white py-3">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                    <img src="/img/logo.jpg" width="45" height="45" alt="Logo" class="rounded-circle me-2">
                    <span class="fw-bold fs-4 text-dark">Mi<span class="text-primary">Tienda</span></span>
                </a>

                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navMain">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link mx-2" href="{{ route('home') }}">Inicio</a></li>
                        <li class="nav-item"><a class="nav-link mx-2" href="{{ route('categorias.index') }}">Categorías</a></li>
                        <li class="nav-item"><a class="nav-link mx-2" href="{{ route('productos.index') }}">Productos</a></li>

                        {{-- SECCIÓN ADMIN --}}
                        @auth
                            @if(auth()->user()->hasRole('admin'))
                                <li class="nav-item dropdown ms-lg-3">
                                    <a class="nav-link dropdown-toggle nav-admin" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown">
                                        <i class="fa-solid fa-user-shield me-1"></i> Gestión Admin
                                    </a>
                                    <ul class="dropdown-menu shadow-lg border-0">
                                        <li><h6 class="dropdown-header text-uppercase small fw-bold">Ventas</h6></li>
                                        <li><a class="dropdown-item" href="{{ route('admin.orders.index') }}"><i class="fa-solid fa-receipt me-2 text-muted"></i>Pedidos</a></li>
                                        <li><a class="dropdown-item" href="{{ route('admin.coupons.index') }}"><i class="fa-solid fa-ticket me-2 text-muted"></i>Cupones</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><h6 class="dropdown-header text-uppercase small fw-bold">Catálogo</h6></li>
                                        <li><a class="dropdown-item" href="{{ route('admin.productos.index') }}"><i class="fa-solid fa-box me-2 text-muted"></i>Productos</a></li>
                                        <li><a class="dropdown-item" href="{{ route('admin.categorias.index') }}"><i class="fa-solid fa-tags me-2 text-muted"></i>Categorías</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item fw-bold text-primary" href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-chart-line me-2"></i>Dashboard General</a></li>
                                    </ul>
                                </li>
                            @endif
                        @endauth
                    </ul>

                    <div class="d-flex align-items-center">
                        <a href="{{ route('carrito.mostrar') }}" class="btn btn-light position-relative me-3 border-0 rounded-circle p-2">
                            <i class="fa-solid fa-cart-shopping text-secondary fs-5"></i>
                            @if(session('cart') && count(session('cart')) > 0)
                                <span class="badge rounded-pill bg-danger badge-cart">
                                    {{ count(session('cart')) }}
                                </span>
                            @endif
                        </a>

                        @auth
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary dropdown-toggle border-0 fw-semibold" type="button" data-bs-toggle="dropdown">
                                    <i class="fa-regular fa-user-circle me-1 fs-5"></i> {{ auth()->user()->name }}
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                    <li><a class="dropdown-item" href="{{ route('orders.my') }}"><i class="fa-solid fa-box me-2 text-muted"></i>Mis Compras</a></li>
                                    <li><a class="dropdown-item" href="#"><i class="fa-solid fa-gear me-2 text-muted"></i>Mi Perfil</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button class="dropdown-item text-danger" type="submit">
                                                <i class="fa-solid fa-arrow-right-from-bracket me-2"></i>Cerrar Sesión
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-link text-decoration-none text-secondary me-2">Entrar</a>
                            <a href="{{ route('register') }}" class="btn btn-primary shadow-sm">Registro</a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main class="container my-5" style="min-height: 70vh;">
        @include('partials.alerts')
        @yield('content')
    </main>

    <footer class="bg-white py-5 border-top mt-auto">
        <div class="container text-center text-muted">
            <div class="mb-3">
                <a href="#" class="text-decoration-none text-muted mx-2">Términos</a>
                <a href="#" class="text-decoration-none text-muted mx-2">Privacidad</a>
                <a href="#" class="text-decoration-none text-muted mx-2">Contacto</a>
            </div>
            <p class="mb-0 small fw-medium">&copy; {{ date('Y') }} Mi Tienda Online. Hecho con <i class="fa-solid fa-heart text-danger"></i> para el mundo.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>