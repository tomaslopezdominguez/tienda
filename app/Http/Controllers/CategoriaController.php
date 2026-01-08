<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function __construct()
    {
        // Crear / editar / borrar SOLO admin
        $this->middleware('auth')->only(['create','store','edit','update','destroy']);
        $this->middleware(\App\Http\Middleware\CheckAdminRole::class)
            ->only(['create','store','edit','update','destroy']);
    }

    /**
     * Listado público de categorías
     */
    public function index()
    {
        $categorias = Categoria::withCount('productos')->paginate(15);
        return view('categorias.index', compact('categorias'));
    }

    /**
     * Vista pública de una categoría
     */
    public function show(Categoria $categoria)
    {
        $categoria->load('productos');
        return view('categorias.show', compact('categoria'));
    }

    /**
     * Crear categoría (ADMIN)
     */
    public function create()
    {
        return view('admin.categorias.create');
    }

    /**
     * Guardar categoría (ADMIN)
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255|unique:categorias,nombre',
            'descripcion' => 'nullable|string',
        ]);

        Categoria::create($data);

        return redirect()->route('admin.categorias.index')
            ->with('success', 'Categoría creada correctamente.');
    }

    /**
     * Editar categoría (ADMIN)
     */
    public function edit(Categoria $categoria)
    {
        return view('admin.categorias.edit', compact('categoria'));
    }

    /**
     * Actualizar categoría (ADMIN)
     */
    public function update(Request $request, Categoria $categoria)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255|unique:categorias,nombre,'.$categoria->id,
            'descripcion' => 'nullable|string',
        ]);

        $categoria->update($data);

        return redirect()->route('admin.categorias.index')
            ->with('success', 'Categoría actualizada.');
    }

    /**
     * Eliminar categoría SOLO si no tiene productos
     */
    public function destroy(Categoria $categoria)
    {
        if ($categoria->productos()->exists()) {
            return redirect()->route('admin.categorias.index')
                ->with('error', 'No se puede eliminar: la categoría tiene productos.');
        }

        $categoria->delete();

        return redirect()->route('admin.categorias.index')
            ->with('success', 'Categoría eliminada.');
    }
}
