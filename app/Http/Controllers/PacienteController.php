<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PacienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pacientes = Paciente::all();

        $title = 'Borrar paciente';
        $text = "¿Estás seguro de que quieres borrar este paciente?";
        confirmDelete($title, $text);

        return view('pages.admin.pacientes.index', [
            'pacientes' => $pacientes
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.pacientes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required | email',
            'telefono' => 'required | numeric | digits:10 | unique:users',
            'curp' => 'required | max:18 | unique:users',
            'sexo' => 'required',
            'tipo_sangre' => 'required',
            'password' => 'required | min:8 | confirmed',            
        ]);

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'curp' => $request->input('curp'),
            'password' => Hash::make($request->input('password')),
            'telefono' => $request->input('telefono'),
        ]);

        Paciente::create([
            'user_id' => $user->id,
            'sexo' => $request->input('sexo'),
            'tipo_sangre' => $request->input('tipo_sangre'),
        ]);       

        return redirect()->route('pacientes.index');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Paciente $paciente)
    {
        return view('pages.admin.pacientes.edit', compact('paciente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Paciente $paciente)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required | email',
            'telefono' => 'required | numeric | digits:10',
            'curp' => 'required | max:18',
            'sexo' => 'required',
            'tipo_sangre' => 'required',
        ]);

        $paciente->user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'curp' => $request->input('curp'),
            'telefono' => $request->input('telefono'),
        ]);

        $paciente->update([
            'sexo' => $request->input('sexo'),
            'tipo_sangre' => $request->input('tipo_sangre'),
        ]);

        return redirect()->route('pacientes.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Paciente $paciente)
    {
        $paciente->delete();
        $paciente->user->delete();
        alert()->success('Paciente eliminado con éxito');
        return redirect()->route('pacientes.index')->with('success', 'Paciente eliminado exitosamente');
    }
}
