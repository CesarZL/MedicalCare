<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Medico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class MedicoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $medicos = Medico::all();

        $title = 'Borrar medico';
        $text = "¿Estás seguro de que quieres borrar a este medico?";
        confirmDelete($title, $text);


        return view('pages.admin.medicos.index',
            ['medicos' => $medicos]
        );
    }

    public function PublicIndex()
    {
        $medicos = Medico::all();
        return view('pages.paciente.medicos.index', 
            ['medicos' => $medicos]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.medicos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $request->validate([
            'name' => 'required|string',
            'imagen' => 'required|image',
            'email' => 'required|email|unique:users,email',
            'telefono' => 'required|string|unique:users,telefono',
            'curp' => 'required|string|unique:users,curp|max:18',
            'especialidad' => 'required|string',
            'cedula' => 'required|string|unique:medicos,cedula|max:8',
            'password' => 'required|string|confirmed',
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

        // Create the user
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'curp' => $request->input('curp'),            
            'rol' => '1', // 1 si es doctor, 2 si es paciente, 0 si es administrador
            'telefono' => $request->input('telefono'),
            'password' => Hash::make($request->input('password')),
        ]);

        // Create the medico associated with the user
        Medico::create([
            'user_id' => $user->id,
            'imagen' => $imagePath,
            'especialidad' => $request->input('especialidad'),
            'cedula' => $request->input('cedula'),
            'direccion' => $request->input('direccion'),
        ]);
        
        // Optionally, redirect somewhere after creation
        return redirect()->route('medicos.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Medico $medico)
    {
        return view('pages.admin.medicos.edit',
            ['medico' => $medico]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Medico $medico)
    {
        $request->validate([
            'name' => 'required|string',
            'imagen' => 'sometimes|image',
            'email' => 'required|email|unique:users,email,'.$medico->user->id,
            'telefono' => 'required|string|unique:users,telefono,'.$medico->user->id,
            'curp' => 'required|string|unique:users,curp,'.$medico->user->id.'|max:18',
            'especialidad' => 'required|string',
            'cedula' => 'required|string|unique:medicos,cedula,'.$medico->id.'|max:8',
            'direccion' => 'required|string',
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
            unlink(public_path($medico->imagen));

            // actualizar la imagen en la base de datos
            $medico->update([
                'imagen' => $imagePath,
                'especialidad' => $request->especialidad,
                'cedula' => $request->cedula,
                'direccion' => $request->direccion,
            ]);

            $medico->user->update([
                'name' => $request->name,
                'email' => $request->email,
                'curp' => $request->curp,
                'telefono' => $request->telefono,
            ]);

        } else {
            // actualizar los datos en la base de datos
            $medico->update([
                'especialidad' => $request->especialidad,
                'cedula' => $request->cedula,
                'direccion' => $request->direccion,
            ]);

            $medico->user->update([
                'name' => $request->name,
                'email' => $request->email,
                'curp' => $request->curp,
                'telefono' => $request->telefono,
                'password' => Hash::make($request->password),
            ]);
        }
        

        // Optionally, redirect somewhere after update
        return redirect()->route('medicos.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Medico $medico)
    {
        $medico->delete();
        $medico->user->delete();
        alert()->success('Medico eliminado con éxito');
        return redirect()->route('medicos.index');
    }
}
