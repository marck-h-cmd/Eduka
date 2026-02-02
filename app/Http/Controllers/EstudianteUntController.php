<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use App\Models\EstudianteUnt;
use App\Models\PersonaRol;
use App\Models\Usuario;
use Illuminate\Http\Request;

class EstudianteUntController extends Controller
{
    public function index()
    {
        $estudiantes = EstudianteUnt::with('persona')->get();
        return view('ceestudiantes.index', compact('estudiantes'));
    }

    public function create()
    {
        // Personas que NO sean estudiantes
        $personas = Persona::whereDoesntHave('roles', function($q){
            $q->where('nombre', 'Estudiante');
        })->get();

        return view('ceestudiantes.create', compact('personas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_persona' => 'required',
            'id_escuela' => 'required',
            'id_curricula' => 'required',
            'codigo_matricula' => 'required',
        ]);

        // 1. Crear en estudiantes_unt
        $estudiante = EstudianteUnt::create([
            'id_persona' => $request->id_persona,
            'id_escuela' => $request->id_escuela,
            'id_curricula' => $request->id_curricula,
            'codigo_matricula' => $request->codigo_matricula,
        ]);

        // 2. Asignar rol estudiante
        PersonaRol::create([
            'id_persona' => $request->id_persona,
            'id_rol' => 3, // ID REAL DEL ROL ESTUDIANTE 
            'estado' => 'Activo'
        ]);

        // 3. Crear usuario automático
        $persona = Persona::find($request->id_persona);
        Usuario::crearUsuarioAutomatico($persona);

        return redirect()->route('estudiantes.index')
            ->with('success', 'Estudiante asignado correctamente. Se enviaron las credenciales por correo.');
    }
}
