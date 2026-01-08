<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\OrdersController;
use App\Http\Middleware\CheckAdminRole;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Rutas limpias organizadas: públicas, auth, usuario, admin.
|
*/

// -------------------------
// 1) HOME / TIENDA (público)
// -------------------------
Route::get('/', [ProductosController::class, 'index'])->name('home');
Route::get('/tienda', [ProductosController::class, 'index']);

// Public: solo index + show
Route::resource('productos', ProductosController::class)->only(['index', 'show']);
Route::resource('categorias', CategoriaController::class)->only(['index', 'show']);

// -------------------------
// 2) SESSION (debug/demo)
// -------------------------
Route::prefix('session')->group(function () {
    Route::get('/set', [SessionController::class, 'set'])->name('session.set');
    Route::get('/get', [SessionController::class, 'get'])->name('session.get');
    Route::get('/destroy-all', [SessionController::class, 'destroyAll'])->name('session.destroyAll');
    Route::get('/destroy-specific', [SessionController::class, 'destroySpecific'])->name('session.destroySpecific');
});

// -------------------------
// 3) CARRITO
// -------------------------
Route::prefix('carrito')->group(function () {
    Route::post('/guardar', [CarritoController::class, 'agregar'])->name('carrito.guardar');
    Route::get('/', [CarritoController::class, 'mostrar'])->name('carrito.mostrar');
    Route::patch('/{id}', [CarritoController::class, 'actualizar'])->name('carrito.actualizar');
    Route::delete('/{id}', [CarritoController::class, 'eliminar'])->name('carrito.eliminar');
    Route::post('/aplicar-cupon', [CarritoController::class, 'aplicarCupon'])->name('carrito.aplicar-cupon');
    Route::delete('/eliminar-cupon', [CarritoController::class, 'eliminarCupon'])->name('carrito.eliminar-cupon'); 
});

// Checkout (crear pedido) requiere usuario autenticado
Route::middleware('auth')->post('/carrito/checkout', [CarritoController::class, 'checkout'])->name('carrito.checkout');

// -------------------------
// 4) AUTENTICACIÓN (guest)
// -------------------------
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'postRegister'])->name('register.post');

    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'postLogin'])->name('login.post');
});

// Logout y dashboard
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
Route::get('/dashboard', [AuthController::class, 'dashboard'])->middleware('auth')->name('dashboard');

// -------------------------
// 5) RUTAS USUARIO (autenticado)
// -------------------------
Route::middleware('auth')->group(function () {
    // Mis pedidos (usuario)
    Route::get('/mis-pedidos', [OrdersController::class, 'myOrders'])->name('orders.my');
    // Ver un pedido (solo propietario o admin - controlado en controller/policy)
    Route::get('/orders/{order}', [OrdersController::class, 'show'])->name('orders.show');
});

// -------------------------
// 6) PANEL ADMIN (auth + CheckAdminRole::class)
// -------------------------
Route::middleware(['auth', CheckAdminRole::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard admin
        Route::get('/', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        // Usuarios (CRUD completo) -> admin.users.*
        Route::resource('users', UsersController::class);

        // Productos: acciones administrativas (create/store/edit/update/destroy)
        // Se añade 'index' para el listado del panel de administración
        Route::resource('productos', ProductosController::class)
            ->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

        // Categorías: acciones administrativas
        Route::resource('categorias', CategoriaController::class)
            ->only(['index','create', 'store', 'edit', 'update', 'destroy']);

        // Pedidos admin
        Route::get('orders', [OrdersController::class, 'index'])->name('orders.index');
        Route::get('orders/{order}', [OrdersController::class, 'show'])->name('orders.show');
        Route::patch('orders/{order}/status', [OrdersController::class, 'updateStatus'])->name('orders.updateStatus');

        // Categorías: acciones administrativas
        Route::resource('categorias', CategoriaController::class)
            ->only(['index','create', 'store', 'edit', 'update', 'destroy']);
            
        // NUEVAS RUTAS: Gestión de Cupones por el Administrador
        Route::resource('coupons', App\Http\Controllers\Admin\CouponController::class);

        // Pedidos admin
        Route::get('orders', [OrdersController::class, 'index'])->name('orders.index');

        
    });