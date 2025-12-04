<?php

namespace App\Http\Controllers;

use App\Models\Secretaria;
use App\Models\Persona;
use App\Models\Rol;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

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
     * NOTA: Aquí "create" es en realidad "asignar rol de secretaria a una persona"
     */
    public function create()
    {
        // Obtener personas que NO tienen rol de Secretaria
        $personas = Persona::whereDoesntHave('roles', function($query) {
            $query->where('nombre', 'Secretaria');
        })
        ->where('estado', 'Activo')
        ->get()
        ->map(function($persona) {
            return [
                'id_persona' => $persona->id_persona,
                'nombre_completo' => $persona->nombres . ' ' . $persona->apellidos,
                'dni' => $persona->dni,
            ];
        });

        return view('csecretarias.create', compact('personas'));
    }

    /**
     * Store a newly created resource in storage.
     * FLUJO CORRECTO:
     * 1. Validar que la persona existe
     * 2. Crear registro en tabla 'secretarias'
     * 3. Asignar rol 'Secretaria' a la persona
     * 4. Crear usuario automáticamente
     * 5. Enviar credenciales por email
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_persona' => 'required|exists:personas,id_persona|unique:secretarias,id_persona',
            'emailUniversidad' => 'required|string|max:100|unique:secretarias,emailUniversidad|email',
            'fecha_ingreso' => 'nullable|date',
        ], [
            'id_persona.required' => 'Debe seleccionar una persona.',
            'id_persona.exists' => 'La persona seleccionada no existe.',
            'id_persona.unique' => 'Esta persona ya tiene asignado el rol de Secretaria.',
            'emailUniversidad.required' => 'El email universitario es obligatorio.',
            'emailUniversidad.unique' => 'El email universitario ya está registrado.',
            'emailUniversidad.email' => 'El formato del email no es válido.',
            'fecha_ingreso.date' => 'La fecha de ingreso debe ser una fecha válida.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();
        try {
            $persona = Persona::findOrFail($request->id_persona);

            // 1. Crear registro en tabla secretarias
            $secretaria = Secretaria::create([
                'id_persona' => $persona->id_persona,
                'emailUniversidad' => $request->emailUniversidad,
                'fecha_ingreso' => $request->fecha_ingreso ?? now(),
                'estado' => 'Activo',
            ]);

            // 2. Asignar rol de secretaria
            $rolSecretaria = Rol::where('nombre', 'Secretaria')->first();
            if ($rolSecretaria) {
                $persona->roles()->syncWithoutDetaching([
                    $rolSecretaria->id_rol => ['estado' => 'Activo']
                ]);
            }

            // 3. Crear usuario automáticamente (AQUÍ es donde se crea)
            $resultadoCreacion = Usuario::crearUsuarioAutomatico($persona);
            $credencialesUsuario = $resultadoCreacion['credenciales'];

            $mensaje = 'Secretaria asignada exitosamente.';
            
            // 4. Enviar credenciales por email
            if ($credencialesUsuario) {
                $mensaje .= ' Credenciales creadas: Usuario: ' . $credencialesUsuario['username'] . 
                           ', Email: ' . $credencialesUsuario['email'] . 
                           '. Las credenciales han sido enviadas por email.';

                try {
                    \Mail::to($credencialesUsuario['email'])->send(
                        new \App\Mail\EnviarCredencialesSecretaria(
                            $persona->nombres . ' ' . $persona->apellidos,
                            $credencialesUsuario['email'],
                            $credencialesUsuario['password']
                        )
                    );
                } catch (\Exception $e) {
                    \Log::error('Error sending secretaria credentials email: ' . $e->getMessage());
                    $mensaje .= ' Nota: Hubo un error al enviar el email, pero el usuario fue creado correctamente.';
                }
            }

            DB::commit();

            return redirect()->route('secretarias.index')
                ->with('success', $mensaje);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error al asignar secretaria: ' . $e->getMessage());
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al asignar secretaria: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Secretaria $secretaria)
    {
        $secretaria->load('persona.usuario', 'persona.roles');
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
        $validator = Validator::make($request->all(), [
            'emailUniversidad' => 'required|string|max:100|email|unique:secretarias,emailUniversidad,' . $secretaria->id_secretaria . ',id_secretaria',
            'fecha_ingreso' => 'nullable|date',
            'estado' => 'required|in:Activo,Inactivo',
        ], [
            'emailUniversidad.required' => 'El email universitario es obligatorio.',
            'emailUniversidad.unique' => 'El email universitario ya está registrado.',
            'emailUniversidad.email' => 'El formato del email no es válido.',
            'fecha_ingreso.date' => 'La fecha de ingreso debe ser una fecha válida.',
            'estado.required' => 'El estado es obligatorio.',
            'estado.in' => 'El estado debe ser Activo o Inactivo.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();
        try {
            // Actualizar secretaria
            $secretaria->update([
                'emailUniversidad' => $request->emailUniversidad,
                'fecha_ingreso' => $request->fecha_ingreso,
                'estado' => $request->estado,
            ]);

            // Actualizar email del usuario si existe
            if ($secretaria->persona->usuario) {
                $secretaria->persona->usuario->update([
                    'email' => $request->emailUniversidad,
                    'estado' => $request->estado,
                ]);
            }

            // Actualizar estado del rol
            $rolSecretaria = Rol::where('nombre', 'Secretaria')->first();
            if ($rolSecretaria) {
                $secretaria->persona->roles()->updateExistingPivot(
                    $rolSecretaria->id_rol, 
                    ['estado' => $request->estado]
                );
            }

            DB::commit();

            return redirect()->route('secretarias.index')
                ->with('success', 'Secretaria actualizada exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error al actualizar secretaria: ' . $e->getMessage());
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al actualizar secretaria: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Secretaria $secretaria)
    {
        DB::beginTransaction();
        try {
            // Cambiar estado de la secretaria a Inactivo
            $secretaria->update(['estado' => 'Inactivo']);

            // Desactivar el usuario asociado
            if ($secretaria->persona->usuario) {
                $secretaria->persona->usuario->update(['estado' => 'Inactivo']);
            }

            // Desactivar el rol secretaria de la persona
            $rolSecretaria = Rol::where('nombre', 'Secretaria')->first();
            if ($rolSecretaria) {
                $secretaria->persona->roles()->updateExistingPivot(
                    $rolSecretaria->id_rol, 
                    ['estado' => 'Inactivo']
                );
            }

            DB::commit();

            return redirect()->route('secretarias.index')
                ->with('success', 'Secretaria desactivada exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error al desactivar secretaria: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'Error al desactivar secretaria: ' . $e->getMessage());
        }
    }
}