<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Carrito;
use App\Models\Paciente;
use App\Models\Producto;
use App\Models\Inventario;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;


class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ventas = Venta::all();

        $title = 'Borrar venta';
        $text = "¿Estás seguro de que quieres borrar esta venta?";
        confirmDelete($title, $text);

        return view('pages.admin.ventas.index', 
        [
            'ventas' => $ventas,
        ]);
    }

    public function checkout()
    {
        $paciente_id = Auth::user()->paciente->id;
        $carrito = Carrito::where('paciente_id', $paciente_id)->first();
        $productos = $carrito->productos;

        // si no tiene productos en el carrito se redirige a la página de productos
        if ($productos->isEmpty()) {
            return redirect()->route('productos');
        }

        // Calcular el total
        $total = $productos->sum(function ($producto) {
            return $producto->precio_venta * $producto->pivot->cantidad;
        });

        $subtotal = $total / 1.16;
        $iva = $total - $subtotal;

        // truncar a 2 decimales
        $subtotal = number_format($subtotal, 2);
        $iva = number_format($iva, 2);

        return view('pages.paciente.checkout.index', [
            'productos' => $productos,
            'subtotal' => $subtotal,
            'iva' => $iva,
            'total' => $total,
        ]);
    }

    public function chstore(Request $request)
    {
        $request->validate([
            'full_name' => 'required',
            'card_number' => 'required',
            'card_expiration' => 'required',
            'card_cvv' => 'required',
        ]);

        // dd  ($request->all());

        // $cargar el carro del paciente 
        $paciente_id = Auth::user()->paciente->id;
        $carrito = Carrito::where('paciente_id', $paciente_id)->first();
        $productos = $carrito->productos;

        // Calcular el total
        $total = $productos->sum(function ($producto) {
            return $producto->precio_venta * $producto->pivot->cantidad;
        });

        $subtotal = $total / 1.16;
        $iva = $total - $subtotal;

        // Crear la venta
        $venta = new Venta();
        $venta->user_id = auth()->id();
        $venta->fecha_de_venta = now();
        $venta->paciente_id = $paciente_id;
        $venta->subtotal = $subtotal;
        $venta->IVA = $iva;
        $venta->total = $total;
        $venta->save();

        // Procesar los productos
        foreach ($productos as $producto) {
            $cantidad = $producto->pivot->cantidad;

            // Validar que la cantidad solicitada no exceda el inventario
            $inventario = Inventario::where('producto_id', $producto->id)->first();
            if ($inventario->cantidad < $cantidad) {
                return redirect()->back()->withErrors(['error' => "No hay suficiente stock para el producto ID $producto->id"]);
            }

            // Reducir el inventario
            $inventario->cantidad -= $cantidad;
            $inventario->fecha_salida = now();
            $inventario->fecha_entrada = null;
            $inventario->movimiento = 'Salida';
            $inventario->motivo = 'Venta';
            $inventario->cantidad_movimiento = $cantidad;
            $inventario->save();

            // Agregar los detalles de la venta
            $venta->productos()->attach($producto->id, ['cantidad' => $cantidad]);
        }

        // Eliminar el carrito
        $carrito->productos()->detach();

        return redirect()->route('detalle.compra', $venta->id);
    }

    public function compradetail(Venta $venta)
    {
        // Cargar los productos relacionados con la venta
        $venta->load('productos');
        return view('pages.paciente.checkout.detail', [
            'venta' => $venta,
        ]);
    }

    public function comprapdf(Venta $venta)
    {
        $venta->load('productos');
        $pdf = PDF::loadView('pages.paciente.checkout.pdf', [
            'venta' => $venta,
        ]);

        return $pdf->download('venta.pdf');
    }

    public function misCompras()
    {
        $paciente_id = Auth::user()->paciente->id;
        $ventas = Venta::where('paciente_id', $paciente_id)->get();

        return view('pages.paciente.compras.index', [
            'ventas' => $ventas,
        ]);
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pacientes = Paciente::all();
        $productos = Producto::all();
        $inventario = Inventario::all();

        // productos con cantidad en inventario en el objeto
        $productos_inventario = $productos->map(function ($producto) use ($inventario) {
            $producto->cantidad = $inventario->where('producto_id', $producto->id)->sum('cantidad');
            return $producto;
        });

        return view('pages.admin.ventas.create', 
        [
            'pacientes' => $pacientes,
            'productos_inventario' => $productos_inventario,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos de entrada
        $validated = $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'productos.*.id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|integer|min:1',
        ]);

        $total = 0;
        foreach ($request->input('productos') as $producto) {
            $cantidad = $producto['cantidad'];
            $producto = Producto::find($producto['id']);
            $total += $cantidad * $producto->precio_venta;
        }

        $subtotal = $total / 1.16;
        $iva = $total - $subtotal;
            
        // Crear la venta
        $venta = new Venta();
        $venta->user_id = auth()->id();
        $venta->fecha_de_venta = now();
        $venta->paciente_id = $validated['paciente_id'];
        $venta->subtotal = $subtotal;
        $venta->IVA = $iva;
        $venta->total = $total;
        $venta->save();
    
        // Procesar los productos
        foreach ($request->input('productos') as $producto) {
            $productoId = $producto['id'];
            $cantidad = $producto['cantidad'];
    
            // Validar que la cantidad solicitada no exceda el inventario
            $inventario = Inventario::where('producto_id', $productoId)->first();
            if ($inventario->cantidad < $cantidad) {
                return redirect()->back()->withErrors(['error' => "No hay suficiente stock para el producto ID $productoId"]);
            }
    
            // Reducir el inventario
            $inventario->cantidad -= $cantidad;
            $inventario->fecha_salida = now();
            $inventario->fecha_entrada = null;
            $inventario->movimiento = 'Salida';
            $inventario->motivo = 'Venta';
            $inventario->cantidad_movimiento = $cantidad;
            $inventario->save();
    
            // Agregar los detalles de la venta
            $venta->productos()->attach($productoId, ['cantidad' => $cantidad]);
        }
    
        return redirect()->route('ventas.index')->with('success', 'Venta realizada con éxito');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }


    public function detail(Venta $venta)
    {
        // Cargar los productos relacionados con la cotización
        $venta->load('productos'); 
        return view('pages.admin.ventas.ticket', [
            'venta' => $venta,
        ]);
    }

    public function pdf(Venta $venta)
    {
        $venta->load('productos');
        $pdf = PDF::loadView('pages.admin.ventas.pdf', [
            'venta' => $venta,
        ]);

        return $pdf->download('ventas.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Venta $venta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Venta $venta)
    {
        // Cargar los productos relacionados con la venta
        $venta->load('productos');
        
        // Revertir el inventario
        foreach ($venta->productos as $producto) {
            $inventario = Inventario::where('producto_id', $producto->id)->first();
            if ($inventario) {
                $inventario->cantidad += $producto->pivot->cantidad;
                $inventario->fecha_entrada = now();
                $inventario->fecha_salida = null;
                $inventario->movimiento = 'Entrada';
                $inventario->motivo = 'Venta revertida';
                $inventario->cantidad_movimiento = $producto->pivot->cantidad;
                $inventario->save();
            }
        }
        
        // Eliminar los registros en la tabla pivote
        $venta->productos()->detach();
        
        // Eliminar la venta
        $venta->delete();

        alert()->success('Venta eliminada con éxito');
    
        return redirect()->route('ventas.index');
    }

    public function storeCart(Request $request)
    {
        $validated = $request->validate([
            'producto_id' => 'required',
            'cantidad' => 'required|integer|min:1',
        ]);

        $paciente_id = Auth::user()->paciente->id;

        // Verificar si el carrito ya existe
        $carrito = Carrito::where('paciente_id', $paciente_id)->first();
        if (!$carrito) {
            $carrito = new Carrito();
            $carrito->paciente_id = $paciente_id;
            $carrito->save();
        }

        // Verificar si el producto tiene suficiente stock
        $inventario = Inventario::where('producto_id', $validated['producto_id'])->first();
        if (!$inventario || $inventario->cantidad < $validated['cantidad']) {
            return redirect()->back()->withErrors(['error' => "No hay suficiente stock para el producto"]);
        }

        // Verificar la cantidad existente en el carrito
        $cantidadExistente = $carrito->productos->contains($validated['producto_id']) 
            ? $carrito->productos->find($validated['producto_id'])->pivot->cantidad 
            : 0;

        // Calcular la nueva cantidad total
        $nuevaCantidad = $cantidadExistente + $validated['cantidad'];

        // Asegurarse de que la nueva cantidad no supere el stock disponible
        if ($nuevaCantidad > $inventario->cantidad) {
            return redirect()->back()->withErrors(['error' => "No hay suficiente stock para agregar esa cantidad. Tienes $cantidadExistente en el carrito y solo hay $inventario->cantidad en stock."]);
        }

        // Agregar o actualizar el producto en el carrito
        if ($cantidadExistente > 0) {
            $carrito->productos()->updateExistingPivot($validated['producto_id'], ['cantidad' => $nuevaCantidad]);
        } else {
            $carrito->productos()->attach($validated['producto_id'], ['cantidad' => $validated['cantidad']]);
        }

        return redirect()->back()->with('success', 'Producto agregado al carrito');
    }


    public function getCarritoProductos()
    {
        $paciente_id = Auth::user()->paciente->id;
        $carrito = Carrito::where('paciente_id', $paciente_id)->first();
    
        if ($carrito) {
            $productos = $carrito->productos;
    
            // Calcular el total
            $total = $productos->sum(function ($producto) {
                return $producto->precio_venta * $producto->pivot->cantidad;
            });
    
            return response()->json(['productos' => $productos, 'total' => $total]);
        }
    
        return response()->json([], 404);
    }

    // Nuevo método para eliminar un producto del carrito
    public function removeProducto($productoId)
    {
        $paciente_id = Auth::user()->paciente->id;
        $carrito = Carrito::where('paciente_id', $paciente_id)->first();

        if ($carrito) {
            $carrito->productos()->detach($productoId);
            return response()->json(['message' => 'Producto eliminado del carrito.']);
        }

        return response()->json(['message' => 'Carrito no encontrado.'], 404);
    }

    
}
