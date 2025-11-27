<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\InfDocente;
use App\Models\InfEstudiante;
use App\Models\InfRepresentante;

class UsuariosController extends Controller
{
    const PAGINATION = 10;

    public function index()
    {
        $usuarios = Usuario::paginate(self::PAGINATION);
        return view('cusuarios.index', compact('usuarios'));
    }

    public function create()
    {
        $profesores = InfDocente::all();
        $estudiantes = InfEstudiante::all();
        $representantes = InfRepresentante::all();
        return view('cusuarios.create', compact('profesores', 'estudiantes', 'representantes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'username' => 'required|string|max:50',
            'password_hash' => 'required|string|max:255',
            'nombres' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'rol' => 'required|in:Administrador,Secretaría,Profesor,Contador,Estudiante,Representante',
            'profesor_id' => 'nullable|integer',
            'estudiante_id' => 'nullable|integer',
            'representante_id' => 'nullable|integer',
        ]);
        // Limpiar campos según el rol
        switch ($data['rol']) {
            case 'Profesor':
                $data['estudiante_id'] = null;
                $data['representante_id'] = null;
                break;
            case 'Estudiante':
                $data['profesor_id'] = null;
                $data['representante_id'] = null;
                break;
            case 'Representante':
                $data['profesor_id'] = null;
                $data['estudiante_id'] = null;
                break;
            default:
                $data['profesor_id'] = null;
                $data['estudiante_id'] = null;
                $data['representante_id'] = null;
        }
        // Set default values for estado, ultima_sesion, cambio_password_requerido
        $data['estado'] = 'Activo';
        $data['ultima_sesion'] = now();
        $data['cambio_password_requerido'] = false;
        // Hash password before saving
        $data['password_hash'] = bcrypt($data['password_hash']);
        Usuario::create($data);
        return redirect()->route('usuarios.index')->with('datos', 'Usuario registrado correctamente.');
    }

    public function edit($usuario_id)
    {
        $usuario = Usuario::findOrFail($usuario_id);
        $profesores = InfDocente::all();
        $estudiantes = InfEstudiante::all();
        $representantes = InfRepresentante::all();
        return view('cusuarios.edit', compact('usuario', 'profesores', 'estudiantes', 'representantes'));
    }

    public function update(Request $request, $usuario_id)
    {
        $data = $request->validate([
            'username' => 'required|string|max:50',
            'password_hash' => 'required|string|max:255',
            'nombres' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'rol' => 'required|in:Administrador,Secretaría,Profesor,Contador,Estudiante,Representante',
            'ultima_sesion' => 'nullable|date',
            'estado' => 'required|in:Activo,Inactivo,Bloqueado',
            'cambio_password_requerido' => 'required|boolean',
            'profesor_id' => 'nullable|integer',
            'estudiante_id' => 'nullable|integer',
            'representante_id' => 'nullable|integer',
        ]);
        // Limpiar campos según el rol
        switch ($data['rol']) {
            case 'Profesor':
                $data['estudiante_id'] = null;
                $data['representante_id'] = null;
                break;
            case 'Estudiante':
                $data['profesor_id'] = null;
                $data['representante_id'] = null;
                break;
            case 'Representante':
                $data['profesor_id'] = null;
                $data['estudiante_id'] = null;
                break;
            default:
                $data['profesor_id'] = null;
                $data['estudiante_id'] = null;
                $data['representante_id'] = null;
        }
        $usuario = Usuario::findOrFail($usuario_id);
        // Only hash password if it was changed
        if ($data['password_hash'] !== $usuario->password_hash) {
            $data['password_hash'] = bcrypt($data['password_hash']);
        }
        $usuario->update($data);
        return redirect()->route('usuarios.index')->with('datos', 'Usuario actualizado correctamente.');
    }

    public function destroy($usuario_id)
    {
        $usuario = Usuario::findOrFail($usuario_id);
        $usuario->delete();
        return redirect()->route('usuarios.index')->with('datos', 'Usuario eliminado correctamente.');
    }

    public function show($usuario_id)
    {
        $usuario = Usuario::findOrFail($usuario_id);
        return view('cusuarios.show', compact('usuario'));
    }

    public function confirmar($usuario_id)
    {
        $usuario = Usuario::findOrFail($usuario_id);
        return view('cusuarios.confirmar', compact('usuario'));
    }
}
