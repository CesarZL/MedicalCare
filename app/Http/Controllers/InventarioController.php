<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Inventario;
use Illuminate\Http\Request;

class InventarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inventarios = Inventario::all();

        $title = 'Borrar entrada en inventario';
        $text = "¿Estás seguro de que quieres borrar esta entrada en el inventario?";
        confirmDelete($title, $text);

        return view('pages.admin.inventarios.index', [
            'inventarios' => $inventarios
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $productos = Producto::all();
        return view('pages.admin.inventarios.create',
            [
                'productos' => $productos,
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos
        $request->validate([
            'producto_id' => 'required',
            'motivo' => 'required',
            'cantidad' => 'required',
        ]);
    
        // Buscar si ya existe una entrada en el inventario para este producto
        $producto_id = $request->input('producto_id');
        $inventario = Inventario::where('producto_id', $producto_id)->first();
    
        if ($inventario) {
            // Si existe, actualizar la cantidad
            $inventario->cantidad += $request->input('cantidad');
            $inventario->fecha_entrada = now();
            $inventario->fecha_salida = null;
            $inventario->movimiento = 'Entrada'; // 'Entrada' o 'Salida'
            $inventario->motivo = $request->input('motivo');
            $inventario->cantidad_movimiento = $request->input('cantidad');
            $inventario->save();
        } else {
            // Si no existe, crear una nueva entrada en el inventario
            $inventario = new Inventario();
            $inventario->producto_id = $producto_id;
            $inventario->fecha_entrada = now();
            $inventario->fecha_salida = null;
            $inventario->movimiento = 'Entrada'; // 'Entrada' o 'Salida'
            $inventario->motivo = $request->input('motivo');
            $inventario->cantidad = $request->input('cantidad');
            $inventario->cantidad_movimiento = $request->input('cantidad');
            $inventario->save();
        }
    
        return redirect()->route('inventarios.index');
    }
    
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inventario $inventario)
    {
        $productos = Producto::all();
        $categorias = Categoria::all();
        // dd($inventario);
        return view('pages.admin.inventarios.edit', [
            'inventario' => $inventario,
            'productos' => $productos,
            'categorias' => $categorias
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inventario $inventario)
    {
        // Validar los datos
        $request->validate([
            'producto_id' => 'required',
            'motivo' => 'sometimes',
            'cantidad' => 'required|integer|min:0',
        ]);
    
        // Obtener la cantidad actual en el inventario
        $cantidadActual = $inventario->cantidad;
    
        // Determinar el movimiento automáticamente
        $cantidadNueva = $request->input('cantidad');
        $diferencia = $cantidadNueva - $cantidadActual;
    
        if ($diferencia > 0) {
            // Si la diferencia es positiva, es una entrada
            $inventario->movimiento = 'Entrada';
            $inventario->cantidad_movimiento = $diferencia;
            $inventario->motivo = 'Entrada por ajuste'; // Puedes ajustar este valor según tus necesidades
            $inventario->fecha_entrada = now(); // Opcional: Puedes ajustar la fecha según sea necesario
            $inventario->fecha_salida = null;
            $inventario->cantidad = $cantidadActual + $diferencia;
        } elseif ($diferencia < 0) {
            // Si la diferencia es negativa, es una salida
    
            // Revisar que haya suficiente cantidad en inventario para la salida
            if ($cantidadActual + $diferencia < 0) {
                return back()->withErrors(['cantidad' => 'No hay suficiente cantidad en inventario para realizar la salida'])->withInput();
            }
    
            $inventario->movimiento = 'Salida';
            $inventario->cantidad_movimiento = $diferencia;
            $inventario->motivo = 'Salida por ajuste'; // Puedes ajustar este valor según tus necesidades
            $inventario->fecha_salida = now(); // Opcional: Puedes ajustar la fecha según sea necesario
            $inventario->fecha_entrada = null;
            $inventario->cantidad = $cantidadActual + $diferencia;
        } else {
            // Si la diferencia es cero, no se hace ningún cambio en la cantidad ni en el movimiento
            // En este caso, se puede considerar cualquier movimiento válido, por ejemplo, 'Ajuste'
            $inventario->movimiento = 'Ajuste'; // Puedes ajustar este valor según tus necesidades
            $inventario->cantidad_movimiento = 0;
            $inventario->motivo = 'Ajuste de inventario'; // Puedes ajustar este valor según tus necesidades
            $inventario->fecha_entrada = null;
            $inventario->fecha_salida = null;
        }
    
        // Actualizar los demás datos del inventario
        $inventario->producto_id = $request->input('producto_id');
        $inventario->save();
    
        return redirect()->route('inventarios.index');
    }
    
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inventario $inventario)
    {
        $inventario->delete();
        alert()->success('Entrada en inventario eliminada con éxito');
        return redirect()->route('inventarios.index');
    }
}
