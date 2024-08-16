<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\Producto;
use App\Models\Inventario;
use Illuminate\Http\Request;

class CompraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $compras = Compra::all();

        $title = 'Borrar compra';
        $text = "¿Estás seguro de que quieres borrar esta compra?";
        confirmDelete($title, $text);


        return view('pages.admin.compras.index', [
            'compras' => $compras
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $productos = Producto::all();
        return view('pages.admin.compras.create',
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
        // validar los datos
        $request->validate([
            'producto_id' => 'required',
            'cantidad' => 'required|integer|min:1',
            'precio' => 'required|numeric|min:0.01',
            'fecha_compra' => 'required|date',
        ]);

        $compra = new Compra();
        $compra->producto_id = $request->input('producto_id');
        $compra->cantidad = $request->input('cantidad');
        $compra->precio = $request->input('precio');
        $compra->fecha_compra = $request->input('fecha_compra');
        $compra->total = ($request->input('cantidad') * $request->input('precio'));
        $compra->save();

        // aumentar la cantidad en el inventario
        $inventario = Inventario::where('producto_id', $request->input('producto_id'))->first();
        if ($inventario) {
            $inventario->cantidad += $request->input('cantidad');
            $inventario->fecha_entrada = now();
            $inventario->fecha_salida = null;
            $inventario->movimiento = 'Entrada';
            $inventario->motivo = 'Compra';
            $inventario->cantidad_movimiento = $request->input('cantidad');
            $inventario->save();
        } else {
            $inventario = new Inventario();
            $inventario->producto_id = $request->input('producto_id');
            $inventario->fecha_entrada = now();
            $inventario->fecha_salida = null;
            $inventario->movimiento = 'Entrada';
            $inventario->motivo = 'Compra';
            $inventario->cantidad = $request->input('cantidad');
            $inventario->cantidad_movimiento = $request->input('cantidad');
            $inventario->save();
        }

        return redirect()->route('compras.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Compra $compra)
    {
        $productos = Producto::all();
        // dd($compra);
        return view('pages.admin.compras.edit', [
            'compra' => $compra,
            'productos' => $productos,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Compra $compra)
    {
        // Validar los datos
        $request->validate([
            'producto_id' => 'required',
            'cantidad' => 'required|integer|min:1',
            'precio' => 'required|numeric|min:0.01',
            'fecha_compra' => 'required|date',
        ]);
    
        // Obtener la cantidad original antes de la actualización
        $cantidadOriginal = $compra->cantidad;
    
        // Actualizar los datos de la compra
        $compra->producto_id = $request->input('producto_id');
        $compra->cantidad = $request->input('cantidad');
        $compra->precio = $request->input('precio');
        $compra->fecha_compra = $request->input('fecha_compra');
        $compra->total = ($request->input('cantidad') * $request->input('precio'));
        $compra->save();
    
        // Calcular la diferencia de cantidad
        $diferenciaCantidad = $request->input('cantidad') - $cantidadOriginal;
    
        // Actualizar la cantidad en el inventario
        $inventario = Inventario::where('producto_id', $request->input('producto_id'))->first();
        if ($inventario) {
            $inventario->cantidad += $diferenciaCantidad;
            $inventario->fecha_entrada = now();
            $inventario->fecha_salida = null;
            $inventario->movimiento = 'Entrada';
            $inventario->motivo = 'Compra actualizada';
            $inventario->cantidad_movimiento = $diferenciaCantidad;           
            $inventario->save();
        } else {
            $inventario = new Inventario();
            $inventario->producto_id = $request->input('producto_id');
            $inventario->fecha_entrada = now();
            $inventario->fecha_salida = null;
            $inventario->movimiento = 'Entrada';
            $inventario->motivo = 'Compra';
            $inventario->cantidad = $request->input('cantidad');
            $inventario->cantidad_movimiento = $request->input('cantidad');
            $inventario->save();
        }
    
        return redirect()->route('compras.index');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Compra $compra)
    {
        // Obtener el producto asociado a la compra
        $inventario = Inventario::where('producto_id', $compra->producto_id)->first();
    
        // Verificar si el producto existe en el inventario
        if ($inventario) {
            // Revertir la cantidad de la compra en el inventario
            $inventario->cantidad -= $compra->cantidad;
            $inventario->fecha_entrada = now();
            $inventario->fecha_salida = null;
            $inventario->movimiento = 'Entrada';
            $inventario->motivo = 'Compra revertida';
            $inventario->cantidad_movimiento = $compra->cantidad;
    
            // Asegurarse de que la cantidad no sea negativa
            if ($inventario->cantidad < 0) {
                $inventario->cantidad = 0;
            }
    
            // Guardar los cambios en el inventario
            $inventario->save();
        }
    
        // Eliminar la compra
        $compra->delete();
    
        alert()->success('Compra eliminada con éxito');
        // Redirigir a la lista de compras
        return redirect()->route('compras.index');
    }
    
}
