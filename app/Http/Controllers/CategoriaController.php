<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categorias = Categoria::all();

        $title = 'Borrar categoría';
        $text = "¿Estás seguro de que quieres borrar esta categoría?";
        confirmDelete($title, $text);

        return view('pages.admin.categorias.index', [
            'categorias' => $categorias
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.categorias.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required'
        ]);

        Categoria::create($request->all());

        return redirect()->route('categorias.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Categoria $categoria)
    {
        return view('pages.admin.categorias.show', compact('categoria'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categoria $categoria)
    {
        return view('pages.admin.categorias.edit', compact('categoria'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Categoria $categoria)
    {
        // validar los datos
        $request->validate([
            'nombre' => 'required',
        ]);

        // actualizar en la base de datos
        $categoria->update($request->all());

        // redireccionar
        return redirect()->route('categorias.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categoria $categoria)
    {
        $categoria->delete();
        alert()->success('Categoría eliminada con éxito');
        return redirect()->route('categorias.index');
    }
}
