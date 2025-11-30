<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PersonasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $personas = Persona::with(['roles' => function($query) {
            $query->where('persona_roles.estado', 'Activo');
        }])->where('estado', 'Activo')->paginate(10);
        return view('cpersonas.index', compact('personas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Rol::where('estado', 'Activo')->get();
        return view('cpersonas.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Combinar email si se proporcionaron username y domain
        $emailData = $request->all();
        if ($request->filled('email_username') && $request->filled('email_domain')) {
            $emailData['email'] = $request->email_username . '@' . $request->email_domain;
        } elseif ($request->filled('email')) {
            $emailData['email'] = $request->email;
        }

        $validator = Validator::make($emailData, [
            'nombres' => 'required|string|max:100|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
            'apellidos' => 'required|string|max:100|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
            'dni' => 'required|string|size:8|regex:/^[0-9]+$/|unique:personas,dni',
            'telefono' => 'nullable|string|size:9|regex:/^[0-9]+$/',
            'email' => 'nullable|email|max:100|unique:personas,email|regex:/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/',
            'genero' => 'nullable|in:M,F,Otro',
            'direccion' => 'nullable|string|max:255',
            'fecha_nacimiento' => 'nullable|date|before:today',
            'rol' => 'nullable|exists:roles,id_rol',
        ], [
            'nombres.required' => 'El campo nombres es obligatorio.',
            'nombres.regex' => 'El campo nombres solo puede contener letras y espacios.',
            'nombres.max' => 'El campo nombres no puede tener más de 100 caracteres.',
            'apellidos.required' => 'El campo apellidos es obligatorio.',
            'apellidos.regex' => 'El campo apellidos solo puede contener letras y espacios.',
            'apellidos.max' => 'El campo apellidos no puede tener más de 100 caracteres.',
            'dni.required' => 'El campo DNI es obligatorio.',
            'dni.size' => 'El DNI debe contener exactamente 8 dígitos.',
            'dni.regex' => 'El DNI solo puede contener números.',
            'dni.unique' => 'El DNI ya está registrado.',
            'telefono.size' => 'El teléfono debe contener exactamente 9 dígitos.',
            'telefono.regex' => 'El teléfono solo puede contener números.',
            'email.email' => 'El campo email debe ser una dirección de correo electrónico válida.',
            'email.regex' => 'El formato del email no es válido.',
            'email.unique' => 'El email ya está registrado.',
            'email.max' => 'El campo email no puede tener más de 100 caracteres.',
            'direccion.max' => 'El campo dirección no puede tener más de 255 caracteres.',
            'fecha_nacimiento.date' => 'El campo fecha de nacimiento debe ser una fecha válida.',
            'fecha_nacimiento.before' => 'La fecha de nacimiento no puede ser futura.',
            'rol.exists' => 'El rol seleccionado no es válido.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $persona = Persona::create(collect($emailData)->only([
            'nombres', 'apellidos', 'dni', 'telefono', 'email', 'genero', 'direccion', 'fecha_nacimiento'
        ])->merge(['estado' => 'Activo'])->toArray());

        if ($request->has('rol') && $request->rol) {
            $persona->roles()->attach($request->rol);
            $mensaje = 'Persona creada exitosamente.';
        } else {
            $mensaje = 'Persona creada exitosamente. Se ha creado una persona sin rol específico.';
        }

        return redirect()->route('personas.index')
            ->with('success', $mensaje);
    }

    /**
     * Display the specified resource.
     */
    public function show(Persona $persona)
    {
        $persona->load(['roles' => function($query) {
            $query->where('persona_roles.estado', 'Activo');
        }]);
        return view('cpersonas.show', compact('persona'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Persona $persona)
    {
        $persona->load(['roles' => function($query) {
            $query->where('persona_roles.estado', 'Activo');
        }]);
        $roles = Rol::where('estado', 'Activo')->get();
        return view('cpersonas.edit', compact('persona', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Persona $persona)
    {
        // Combinar email si se proporcionaron username y domain
        $emailData = $request->all();
        if ($request->filled('email_username') && $request->filled('email_domain')) {
            $emailData['email'] = $request->email_username . '@' . $request->email_domain;
        } elseif ($request->filled('email')) {
            $emailData['email'] = $request->email;
        }

        $validator = Validator::make($emailData, [
            'nombres' => 'required|string|max:100|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
            'apellidos' => 'required|string|max:100|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
            'dni' => 'required|string|size:8|regex:/^[0-9]+$/|unique:personas,dni,' . $persona->id_persona . ',id_persona',
            'telefono' => 'nullable|string|size:9|regex:/^[0-9]+$/',
            'email' => 'required|email|max:100|unique:personas,email,' . $persona->id_persona . ',id_persona|regex:/^[^\s@]+@[^\s@]+\.[^\s@]+$/',
            'genero' => 'nullable|in:M,F,Otro',
            'direccion' => 'nullable|string|max:255',
            'fecha_nacimiento' => 'nullable|date|before:today',
            'rol' => 'nullable|exists:roles,id_rol',
        ], [
            'nombres.required' => 'El campo nombres es obligatorio.',
            'nombres.regex' => 'El campo nombres solo puede contener letras y espacios.',
            'nombres.max' => 'El campo nombres no puede tener más de 100 caracteres.',
            'apellidos.required' => 'El campo apellidos es obligatorio.',
            'apellidos.regex' => 'El campo apellidos solo puede contener letras y espacios.',
            'apellidos.max' => 'El campo apellidos no puede tener más de 100 caracteres.',
            'dni.required' => 'El campo DNI es obligatorio.',
            'dni.size' => 'El DNI debe contener exactamente 8 dígitos.',
            'dni.regex' => 'El DNI solo puede contener números.',
            'dni.unique' => 'El DNI ya está registrado.',
            'telefono.size' => 'El teléfono debe contener exactamente 9 dígitos.',
            'telefono.regex' => 'El teléfono solo puede contener números.',
            'email.required' => 'El campo email es obligatorio.',
            'email.email' => 'El campo email debe ser una dirección de correo electrónico válida.',
            'email.regex' => 'El formato del email no es válido.',
            'email.unique' => 'El email ya está registrado.',
            'email.max' => 'El campo email no puede tener más de 100 caracteres.',
            'direccion.max' => 'El campo dirección no puede tener más de 255 caracteres.',
            'fecha_nacimiento.date' => 'El campo fecha de nacimiento debe ser una fecha válida.',
            'fecha_nacimiento.before' => 'La fecha de nacimiento no puede ser futura.',
            'rol.exists' => 'El rol seleccionado no es válido.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $persona->update(collect($emailData)->only([
            'nombres', 'apellidos', 'dni', 'telefono', 'email', 'genero', 'direccion', 'fecha_nacimiento'
        ])->toArray());

        if ($request->has('rol') && $request->rol) {
            $persona->roles()->sync([$request->rol]);
        } else {
            $persona->roles()->detach();
        }

        return redirect()->route('personas.index')
            ->with('success', 'Persona actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Persona $persona)
    {
        // Cambiar el estado a "Inactivo" en lugar de eliminar
        $persona->update(['estado' => 'Inactivo']);

        // Si la persona tiene usuarios asociados, también cambiar su estado a "Inactivo"
        if ($persona->usuarios()->count() > 0) {
            $persona->usuarios()->update(['estado' => 'Inactivo']);
        }

        // Cambiar el estado de las asignaciones de roles a "Inactivo"
        $persona->roles()->update(['persona_roles.estado' => 'Inactivo']);

        return redirect()->route('personas.index')
            ->with('success', 'Persona eliminada exitosamente.');
    }

    /**
     * Verificar si el DNI ya existe
     */
    public function verificarDni(Request $request)
    {
        $dni = $request->get('dni');
        $personaId = $request->get('persona_id');

        $query = Persona::where('dni', $dni);

        if ($personaId) {
            $query->where('id_persona', '!=', $personaId);
        }

        $existe = $query->exists();

        return response()->json([
            'existe' => $existe,
            'mensaje' => $existe ? 'El DNI ya está registrado.' : 'DNI disponible.'
        ]);
    }

    /**
     * Verificar si el email ya existe
     */
    public function verificarEmail(Request $request)
    {
        $email = $request->get('email');
        $personaId = $request->get('persona_id');

        $query = Persona::where('email', $email);

        if ($personaId) {
            $query->where('id_persona', '!=', $personaId);
        }

        $existe = $query->exists();

        return response()->json([
            'existe' => $existe,
            'mensaje' => $existe ? 'El email ya está registrado.' : 'Email disponible.'
        ]);
    }
}
