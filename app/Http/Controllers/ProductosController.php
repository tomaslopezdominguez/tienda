<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class productosController extends Controller
{
    public function __construct()
    {
        // Protege las acciones administrativas (solo admin puede crear/editar/borrar)
        $this->middleware('auth')->only(['create','store','edit','update','destroy']);
        $this->middleware(\App\Http\Middleware\CheckAdminRole::class)
             ->only(['create','store','edit','update','destroy']);
    }

    /**
     * Listado público de productos (tienda)
     */
    public function index()
    {
        $productos = Producto::orderBy('posicion')->get();
        return view('productos.index', ['productos' => $productos]);
    }

    /**
     * Mostrar formulario para crear producto (ADMIN)
     */
    public function create()
    {
        $categorias = Categoria::all();
        return view('admin.productos.create', compact('categorias'));
    }

    /**
     * Guardar nuevo producto (ADMIN)
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre'      => 'required|string|max:255|unique:productos,nombre',
            'descripcion' => 'nullable|string',
            'precio'      => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'posicion'    => 'required|integer',
            'categorias'  => 'array',
            // NUEVO: Validación para la imagen (opcional en la creación)
            'imagen'      => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', 
        ]);

        $ruta_imagen = null;

        // NUEVO: Manejo de la subida de imagen
        if ($request->hasFile('imagen')) {
            // Guarda el archivo en storage/app/public/productos y obtiene la ruta relativa
            $ruta_imagen = $request->file('imagen')->store('productos', 'public');
        }

        $product = Producto::create([
            'nombre'      => $data['nombre'],
            'descripcion' => $data['descripcion'] ?? null,
            'precio'      => $data['precio'],
            'stock'       => $data['stock'],
            'posicion'    => $data['posicion'],
            'imagen'      => $ruta_imagen, // NUEVO: Guardar la ruta
        ]);

        if (!empty($data['categorias'])) {
            $product->categorias()->sync($data['categorias']);
        }

        return redirect()->route('admin.productos.index')->with('success', 'Producto creado correctamente.');
    }

    /**
     * Ver detalle público del producto
     */
    public function show(Producto $producto)
    {
        $producto->load('categorias');
        return view('productos.show', compact('producto'));
    }

    /**
     * Mostrar formulario de edición (ADMIN)
     */
    public function edit(Producto $producto)
    {
        $categorias = Categoria::all();
        $producto->load('categorias');
        return view('admin.productos.edit', compact('producto', 'categorias'));
    }


    public function update(Request $request, Producto $producto)
    {
        $data = $request->validate([
            'nombre'      => 'required|string|max:255|unique:productos,nombre,'.$producto->id,
            'descripcion' => 'nullable|string',
            'precio'      => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'posicion'    => 'required|integer',
            'categorias'  => 'array',
            // NUEVO: Validación para la imagen (opcional)
            'imagen'      => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', 
        ]);

        // 1. Manejo de la subida y eliminación de imagen
        if ($request->hasFile('imagen')) {
            // Eliminar la imagen anterior si existe
            if ($producto->imagen) {
                Storage::disk('public')->delete($producto->imagen);
            }

            // Guardar la nueva imagen
            $ruta_imagen = $request->file('imagen')->store('productos', 'public');
            $data['imagen'] = $ruta_imagen; // Añadir la nueva ruta a los datos de actualización
        }

        // 2. Actualizar el producto con todos los datos (incluyendo la nueva ruta de imagen si aplica)
        $producto->update($data);

        // 3. Sincronizar categorías
        if (isset($data['categorias'])) {
            $producto->categorias()->sync($data['categorias']);
        } else {
            $producto->categorias()->detach();
        }

        return redirect()->route('admin.productos.index')->with('success', 'Producto actualizado correctamente.');
    }

    /**
     * Eliminar producto (ADMIN) — comprobando si aparece en pedidos.
     */
   public function destroy(Producto $producto)
    {
        // Impedir borrado si existe en order_items (histórico)
        if ($producto->orderItems()->exists()) {
            return redirect()->route('admin.productos.index')
                ->with('error', 'No se puede eliminar el producto: está incluido en pedidos.');
        }
        
        // NUEVO: 1. Eliminar el archivo de imagen del storage
        if ($producto->imagen) {
            Storage::disk('public')->delete($producto->imagen);
        }

        // 2. Desasociar categorías
        $producto->categorias()->detach();

        // 3. Eliminar
        $producto->delete();

        return redirect()->route('admin.productos.index')->with('success', 'Producto eliminado correctamente.');
    }
}

