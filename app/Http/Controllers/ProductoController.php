<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;



class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // buscar en la base de datos todos los productos
        $productos = Producto::all();
        
        $title = 'Borrar producto';
        $text = "¿Estás seguro de que quieres borrar este producto?";
        confirmDelete($title, $text);

        return view('pages.admin.productos.index', [
            'productos' => $productos
        ]);
    }

    public function PublicIndex()
    {
        // buscar en la base de datos todos los productos
        $productos = Producto::all();
        return view('pages.paciente.productos.index', 
            ['productos' => $productos]
        );
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categorias = Categoria::all();
        return view('pages.admin.productos.create',
            [
                'categorias' => $categorias
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
            'imagen' => 'required|image|mimes:jpeg,png,jpg', // Ajusta el tamaño máximo según tus necesidades
            'nombre' => 'required',
            'categoria_id' => 'required',
            'precio_venta' => 'required',
            'marca' => 'required',
            'descripcion' => 'required',
        ]);

          // Obtener la imagen del request
          $imagen = $request->file('imagen');
        
          // Crear un nombre único para la imagen
          $imageName = Str::uuid().'.'.$imagen->extension();
          
          // Crear una instancia de la imagen usando Intervention Image
          $serverImage = Image::make($imagen);
          
          // Redimensionar la imagen
          $serverImage->fit(600, 600);
          
          // Guardar la imagen modificada en el directorio public_path('productos/')
          $imagePath = 'imagenes/' . $imageName;
          $serverImage->save(public_path($imagePath)); // Usa public_path en lugar de storage_path

        // guardar en la base de datos
        Producto::create([
            'imagen' => $imagePath,
            'nombre' => $request->nombre,
            'categoria_id' => $request->categoria_id,
            'precio_venta' => $request->precio_venta,
            'marca' => $request->marca,
            'descripcion' => $request->descripcion,
        ]);

        // redireccionar
        return redirect()->route('productos.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Producto $producto)
    {
        return view('pages.paciente.productos.show', 
            ['producto' => $producto,]
        );
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Producto $producto)
    {
        $categorias = Categoria::all();
        return view('pages.admin.productos.edit', 
            [
                'producto' => $producto,
                'categorias' => $categorias
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Producto $producto)
    {
        // validar los datos
        $request->validate([
            'nombre' => 'required',
            'categoria_id' => 'required',
            'precio_venta' => 'required',
            'marca' => 'required',
            'descripcion' => 'required',
            'imagen' => 'sometimes|image|mimes:jpeg,png,jpg', // Ajusta el tamaño máximo según tus necesidades
        ]);

        // si se sube una nueva imagen
        if ($request->hasFile('imagen')) {
            // Obtener la imagen del request
            $imagen = $request->file('imagen');
            
            // Crear un nombre único para la imagen
            $imageName = Str::uuid().'.'.$imagen->extension();
            
            // Crear una instancia de la imagen usando Intervention Image
            $serverImage = Image::make($imagen);
            
            // Redimensionar la imagen
            $serverImage->fit(600, 600);
            
            // Guardar la imagen modificada en el directorio public_path('productos/')
            $imagePath = 'imagenes/' . $imageName;
            $serverImage->save(public_path($imagePath)); // Usa public_path en lugar de storage_path

            // eliminar la imagen anterior del servidor
            unlink(public_path($producto->imagen));

            // actualizar la imagen en la base de datos
            $producto->update([
                'imagen' => $imagePath,
                'nombre' => $request->nombre,
                'categoria_id' => $request->categoria_id,
                'precio_venta' => $request->precio_venta,
                'marca' => $request->marca,
                'descripcion' => $request->descripcion,
            ]);
        } else {
            // actualizar los datos en la base de datos
            $producto->update([
                'nombre' => $request->nombre,
                'categoria_id' => $request->categoria_id,
                'precio_venta' => $request->precio_venta,
                'marca' => $request->marca,
                'descripcion' => $request->descripcion,
            ]);
        }

        // redireccionar
        return redirect()->route('productos.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producto $producto)
    {
         // eliminar de la base de datos
         $producto->delete();

         // eliminar la imagen del servidor
        unlink(public_path($producto->imagen));

         alert()->success('Producto eliminado con éxito');
         
         // redireccionar
         return redirect()->route('productos.index');
    }
}
