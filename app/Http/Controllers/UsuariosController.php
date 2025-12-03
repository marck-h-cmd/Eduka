<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Persona;
use Illuminate\Support\Facades\Validator;

class UsuariosController extends Controller
{
    const PAGINATION = 10;

    public function index(Request $request)
    {
        $buscarpor = $request->get('buscarpor');

        $usuarios = Usuario::with(['persona.roles' => function($query) {
            $query->where('persona_roles.estado', 'Activo');
        }])->where('estado', 'Activo')
        ->where(function ($query) use ($buscarpor) {
            if ($buscarpor) {
                $query->where('username', 'like', '%' . $buscarpor . '%')
                      ->orWhere('email', 'like', '%' . $buscarpor . '%')
                      ->orWhereHas('persona', function($q) use ($buscarpor) {
                          $q->where('nombres', 'like', '%' . $buscarpor . '%')
                            ->orWhere('apellidos', 'like', '%' . $buscarpor . '%');
                      });
            }
        })
        ->orderBy('username', 'asc')
        ->paginate(self::PAGINATION);

        // Si es AJAX, devuelve solo el contenido
        if ($request->ajax()) {
            return view('cusuarios.usuarios', compact('usuarios'))->render();
        }

        return view('cusuarios.index', compact('usuarios', 'buscarpor'));
    }

    public function create()
    {
        // Solo personas activas que tienen roles asignados
        $personas = Persona::with(['roles' => function($query) {
            $query->where('persona_roles.estado', 'Activo');
        }])->where('estado', 'Activo')
        ->whereHas('roles', function($query) {
            $query->where('persona_roles.estado', 'Activo');
        })
        ->whereDoesntHave('usuario') // Solo personas que no tienen usuario
        ->orderBy('nombres')
        ->orderBy('apellidos')
        ->get();

        // Verificar si viene un persona_id desde la URL
        $personaPreseleccionada = null;
        if (request()->has('persona_id')) {
            $personaId = request()->get('persona_id');
            $personaPreseleccionada = $personas->find($personaId);
        }

        return view('cusuarios.create', compact('personas', 'personaPreseleccionada'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_persona' => 'required|exists:personas,id_persona',
            'username' => 'required|string|max:50|unique:usuarios,username',
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'
            ],
            'email' => 'nullable|email|max:100|unique:usuarios,email',
        ], [
            'id_persona.required' => 'Debe seleccionar una persona.',
            'id_persona.exists' => 'La persona seleccionada no existe.',
            'username.required' => 'El nombre de usuario es obligatorio.',
            'username.unique' => 'Este nombre de usuario ya está registrado.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.regex' => 'La contraseña debe contener al menos una mayúscula, una minúscula, un número y un carácter especial (@$!%*?&).',
            'password.confirmed' => 'La confirmación de contraseña no coincide.',
            'email.email' => 'El email debe tener un formato válido.',
            'email.unique' => 'Este email ya está registrado.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Verificar que la persona existe, está activa y tiene roles asignados
        $persona = Persona::with(['roles' => function($query) {
            $query->where('persona_roles.estado', 'Activo');
        }])->where('id_persona', $request->id_persona)
        ->where('estado', 'Activo')->first();

        if (!$persona) {
            return redirect()->back()
                ->withErrors(['error' => 'La persona seleccionada no existe o no está activa.'])
                ->withInput();
        }

        if ($persona->roles->isEmpty()) {
            return redirect()->back()
                ->withErrors(['error' => 'La persona seleccionada no tiene roles asignados.'])
                ->withInput();
        }

        // Verificar que la persona no tenga ya un usuario
        if ($persona->usuario) {
            return redirect()->back()
                ->withErrors(['error' => 'Esta persona ya tiene un usuario asignado.'])
                ->withInput();
        }

        try {
            // Si no se proporciona email, usar el de la persona
            $email = $request->filled('email') ? $request->email : $persona->email;

            Usuario::create([
                'id_persona' => $persona->id_persona,
                'username' => $request->username,
                'password_hash' => bcrypt($request->password),
                'email' => $email,
                'estado' => 'Activo',
            ]);

            return redirect()->route('usuarios.index')
                ->with('success', 'Usuario creado exitosamente.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Error al crear el usuario: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function edit($id)
    {
        $usuario = Usuario::with(['persona.roles' => function($query) {
            $query->where('persona_roles.estado', 'Activo');
        }])->findOrFail($id);

        return view('cusuarios.edit', compact('usuario'));
    }

    public function update(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:50|unique:usuarios,username,' . $id . ',id_usuario',
            'password' => 'nullable|string|min:8|confirmed',
            'email' => 'required|email|max:100|unique:usuarios,email,' . $id . ',id_usuario',
            'estado' => 'required|in:Activo,Inactivo,Bloqueado',
        ], [
            'username.required' => 'El nombre de usuario es obligatorio.',
            'username.unique' => 'Este nombre de usuario ya está registrado.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'La confirmación de contraseña no coincide.',
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'El email debe tener un formato válido.',
            'email.unique' => 'Este email ya está registrado.',
            'estado.required' => 'El estado es obligatorio.',
            'estado.in' => 'El estado debe ser Activo, Inactivo o Bloqueado.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $updateData = [
                'username' => $request->username,
                'email' => $request->email,
                'estado' => $request->estado,
            ];

            // Only update password if provided
            if ($request->filled('password')) {
                $updateData['password_hash'] = bcrypt($request->password);
            }

            $usuario->update($updateData);

            return redirect()->route('usuarios.index')
                ->with('success', 'Usuario actualizado exitosamente.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Error al actualizar el usuario: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function destroy($id)
    {
        $usuario = Usuario::findOrFail($id);

        // Cambiar el estado a "Inactivo" en lugar de eliminar
        $usuario->update(['estado' => 'Inactivo']);

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario eliminado exitosamente.');
    }

    public function show($id)
    {
        $usuario = Usuario::with(['persona.roles' => function($query) {
            $query->where('persona_roles.estado', 'Activo');
        }])->findOrFail($id);

        return view('cusuarios.show', compact('usuario'));
    }

    public function confirmar($id)
    {
        $usuario = Usuario::with(['persona.roles' => function($query) {
            $query->where('persona_roles.estado', 'Activo');
        }])->findOrFail($id);

        return view('cusuarios.confirmar', compact('usuario'));
    }
}
