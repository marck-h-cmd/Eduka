<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use App\Models\Persona;
use App\Models\Rol;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DocentesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $docentes = Docente::with('persona')->where('estado', 'Activo')->paginate(10);
        return view('cdocentes.index', compact('docentes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cdocentes.create');
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
            'emailUniversidad' => 'required|string|max:100|unique:docentes,emailUniversidad',
            'especialidad' => 'nullable|string|max:100',
            'fecha_contratacion' => 'nullable|date',
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
            'emailUniversidad.required' => 'El email universitario es obligatorio.',
            'emailUniversidad.unique' => 'El email universitario ya está registrado.',
            'especialidad.max' => 'La especialidad no puede tener más de 100 caracteres.',
            'fecha_contratacion.date' => 'La fecha de contratación debe ser una fecha válida.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Crear persona
        $persona = Persona::create(collect($emailData)->only([
            'nombres', 'apellidos', 'dni', 'telefono', 'email', 'genero', 'direccion', 'fecha_nacimiento'
        ])->merge(['estado' => 'Activo'])->toArray());

        // Crear registro docente
        $docente = Docente::create([
            'id_persona' => $persona->id_persona,
            'emailUniversidad' => $request->emailUniversidad,
            'especialidad' => $request->especialidad,
            'fecha_contratacion' => $request->fecha_contratacion,
            'estado' => 'Activo',
        ]);

        // Asignar rol de docente
        $rolDocente = Rol::where('nombre', 'Docente')->first();
        if ($rolDocente) {
            $persona->roles()->syncWithoutDetaching([$rolDocente->id_rol => ['estado' => 'Activo']]);
        }

        // Crear usuario automáticamente
        $resultadoCreacion = Usuario::crearUsuarioAutomatico($persona);
        $credencialesUsuario = $resultadoCreacion['credenciales'];

        $mensaje = 'Docente creado exitosamente.';
        if ($credencialesUsuario) {
            $mensaje .= ' Credenciales creadas: Usuario: ' . $credencialesUsuario['username'] . ', Email: ' . $credencialesUsuario['email'] . '. Las credenciales han sido enviadas por email.';

            // Enviar email específico para docente
            try {
                \Mail::to($credencialesUsuario['email'])->send(new \App\Mail\EnviarCredencialesDocente(
                    $persona->nombres . ' ' . $persona->apellidos,
                    $credencialesUsuario['email'],
                    $credencialesUsuario['password']
                ));
            } catch (\Exception $e) {
                \Log::error('Error sending docente credentials email: ' . $e->getMessage());
            }
        }

        return redirect()->route('docentes.index')
            ->with('success', $mensaje);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $docente = Docente::with('persona')->findOrFail($id);
        return view('cdocentes.show', compact('docente'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $docente = Docente::with('persona', 'especialidades')->findOrFail($id);
        $especialidades = \App\Models\Especialidad::where('estado', 'Activo')->get();
     
        return view('cdocentes.edit', compact('docente', 'especialidades'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Docente $docente)
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
            'dni' => 'required|string|size:8|regex:/^[0-9]+$/|unique:personas,dni,' . $docente->persona->id_persona . ',id_persona',
            'telefono' => 'nullable|string|size:9|regex:/^[0-9]+$/',
            'email' => 'nullable|email|max:100|unique:personas,email,' . $docente->persona->id_persona . ',id_persona|regex:/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/',
            'genero' => 'nullable|in:M,F,Otro',
            'direccion' => 'nullable|string|max:255',
            'fecha_nacimiento' => 'nullable|date|before:today',
            'emailUniversidad' => 'required|string|max:100|unique:docentes,emailUniversidad,' . $docente->id_docente . ',id_docente',
            'fecha_contratacion' => 'nullable|date',
            'estado' => 'required|in:Activo,Inactivo',
            'especialidades' => 'required|array|min:1',
            'especialidades.*' => 'integer|exists:especialidades,id_especialidad',
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
            'emailUniversidad.required' => 'El email universitario es obligatorio.',
            'emailUniversidad.unique' => 'El email universitario ya está registrado.',
            'fecha_contratacion.date' => 'La fecha de contratación debe ser una fecha válida.',
            'estado.required' => 'El estado es obligatorio.',
            'estado.in' => 'El estado debe ser Activo o Inactivo.',
            'especialidades.required' => 'Debe seleccionar al menos una especialidad.',
            'especialidades.min' => 'Debe seleccionar al menos una especialidad.',
            'especialidades.*.exists' => 'Una o más especialidades seleccionadas no son válidas.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Actualizar persona
        $docente->persona->update(collect($emailData)->only([
            'nombres', 'apellidos', 'dni', 'telefono', 'email', 'genero', 'direccion', 'fecha_nacimiento'
        ])->toArray());

        // Actualizar docente
        $docente->update([
            'emailUniversidad' => $request->emailUniversidad,
            'fecha_contratacion' => $request->fecha_contratacion,
            'estado' => $request->estado,
        ]);

        // Actualizar especialidades
        $especialidades = $request->especialidades ?? [];
        $syncData = [];
        foreach ($especialidades as $especialidadId) {
            $syncData[$especialidadId] = ['estado' => 'Activo'];
        }
        $docente->especialidades()->sync($syncData);

        return redirect()->route('docentes.index')
            ->with('success', 'Docente actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Docente $docente)
    {
        // Cambiar estado del docente a Inactivo
        $docente->update(['estado' => 'Inactivo']);

        // Desactivar el rol docente de la persona
        $rolDocente = Rol::where('nombre', 'Docente')->first();
        if ($rolDocente) {
            $docente->persona->roles()->updateExistingPivot($rolDocente->id_rol, ['estado' => 'Inactivo']);
        }

        return redirect()->route('docentes.index')
            ->with('success', 'Docente dado de baja exitosamente.');
    }
}
