<?php

namespace App\Http\Controllers;

use App\Models\Secretaria;
use App\Models\Persona;
use App\Models\Rol;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SecretariasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $secretarias = Secretaria::with('persona')->where('estado', 'Activo')->paginate(10);
        return view('csecretarias.index', compact('secretarias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('csecretarias.create');
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
            'emailUniversidad' => 'required|string|max:100|unique:secretarias,emailUniversidad',
            'fecha_ingreso' => 'nullable|date',
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
            'fecha_ingreso.date' => 'La fecha de ingreso debe ser una fecha válida.',
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

        // Crear registro secretaria
        $secretaria = Secretaria::create([
            'id_persona' => $persona->id_persona,
            'emailUniversidad' => $request->emailUniversidad,
            'fecha_ingreso' => $request->fecha_ingreso,
            'estado' => 'Activo',
        ]);

        // Asignar rol de secretaria
        $rolSecretaria = Rol::where('nombre', 'Secretaria')->first();
        if ($rolSecretaria) {
            $persona->roles()->syncWithoutDetaching([$rolSecretaria->id_rol => ['estado' => 'Activo']]);
        }

        // Crear usuario automáticamente
        $resultadoCreacion = Usuario::crearUsuarioAutomatico($persona);
        $credencialesUsuario = $resultadoCreacion['credenciales'];

        $mensaje = 'Secretaria creada exitosamente.';
        if ($credencialesUsuario) {
            $mensaje .= ' Credenciales creadas: Usuario: ' . $credencialesUsuario['username'] . ', Email: ' . $credencialesUsuario['email'] . '. Las credenciales han sido enviadas por email.';

            // Enviar email específico para secretaria
            try {
                \Mail::to($credencialesUsuario['email'])->send(new \App\Mail\EnviarCredencialesSecretaria(
                    $persona->nombres . ' ' . $persona->apellidos,
                    $credencialesUsuario['email'],
                    $credencialesUsuario['password']
                ));
            } catch (\Exception $e) {
                \Log::error('Error sending secretaria credentials email: ' . $e->getMessage());
            }
        }

        return redirect()->route('secretarias.index')
            ->with('success', $mensaje);
    }

    /**
     * Display the specified resource.
     */
    public function show(Secretaria $secretaria)
    {
        $secretaria->load('persona');
        return view('csecretarias.show', compact('secretaria'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Secretaria $secretaria)
    {
        $secretaria->load('persona');
        return view('csecretarias.edit', compact('secretaria'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Secretaria $secretaria)
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
            'dni' => 'required|string|size:8|regex:/^[0-9]+$/|unique:personas,dni,' . $secretaria->persona->id_persona . ',id_persona',
            'telefono' => 'nullable|string|size:9|regex:/^[0-9]+$/',
            'email' => 'nullable|email|max:100|unique:personas,email,' . $secretaria->persona->id_persona . ',id_persona|regex:/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/',
            'genero' => 'nullable|in:M,F,Otro',
            'direccion' => 'nullable|string|max:255',
            'fecha_nacimiento' => 'nullable|date|before:today',
            'emailUniversidad' => 'required|string|max:100|unique:secretarias,emailUniversidad,' . $secretaria->id_secretaria . ',id_secretaria',
            'fecha_ingreso' => 'nullable|date',
            'estado' => 'required|in:Activo,Inactivo',
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
            'fecha_ingreso.date' => 'La fecha de ingreso debe ser una fecha válida.',
            'estado.required' => 'El estado es obligatorio.',
            'estado.in' => 'El estado debe ser Activo o Inactivo.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Actualizar persona
        $secretaria->persona->update(collect($emailData)->only([
            'nombres', 'apellidos', 'dni', 'telefono', 'email', 'genero', 'direccion', 'fecha_nacimiento'
        ])->toArray());

        // Actualizar secretaria
        $secretaria->update([
            'emailUniversidad' => $request->emailUniversidad,
            'fecha_ingreso' => $request->fecha_ingreso,
            'estado' => $request->estado,
        ]);

        return redirect()->route('secretarias.index')
            ->with('success', 'Secretaria actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Secretaria $secretaria)
    {
        // Cambiar estado de la secretaria a Inactivo
        $secretaria->update(['estado' => 'Inactivo']);

        // Desactivar el rol secretaria de la persona
        $rolSecretaria = Rol::where('nombre', 'Secretaria')->first();
        if ($rolSecretaria) {
            $secretaria->persona->roles()->updateExistingPivot($rolSecretaria->id_rol, ['estado' => 'Inactivo']);
        }

        return redirect()->route('secretarias.index')
            ->with('success', 'Secretaria dada de baja exitosamente.');
    }
}
