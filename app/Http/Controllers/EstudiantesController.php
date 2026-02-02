<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Models\Persona;
use App\Models\Rol;
use App\Models\Usuario;
use App\Models\Escuela;
use App\Models\Curricula;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EstudiantesController extends Controller
{
    /**
     * Display a listing of the resource.
     * Lista solo los estudiantes que tienen el rol "Estudiante" activo
     */
    public function index(Request $request)
    {
        // Obtener parámetro de búsqueda
        $buscar = $request->get('buscarpor');
        
        // Query base con relaciones - FILTRAR SOLO ESTUDIANTES CON ROL ACTIVO
        $query = Estudiante::with(['persona.roles', 'escuela', 'curricula'])
            ->where('estudiantesunt.estado', '!=', 'Inactivo')
            // Filtrar solo personas que tienen el rol "Estudiante" activo
            ->whereHas('persona.roles', function($q) {
                $q->where('roles.nombre', 'Estudiante')
                  ->where('persona_roles.estado', 'Activo');
            });
        
        // Aplicar filtro de búsqueda si existe
        if ($buscar) {
            $query->where(function($q) use ($buscar) {
                $q->whereHas('persona', function($subq) use ($buscar) {
                    $subq->where('nombres', 'LIKE', "%{$buscar}%")
                         ->orWhere('apellidos', 'LIKE', "%{$buscar}%")
                         ->orWhere('dni', 'LIKE', "%{$buscar}%");
                })
                ->orWhere('emailUniversidad', 'LIKE', "%{$buscar}%");
            });
        }
        
        // Paginar resultados
        $estudiantes = $query->paginate(10);
        
        // Mantener parámetro de búsqueda en la paginación
        if ($buscar) {
            $estudiantes->appends(['buscarpor' => $buscar]);
        }
        
        return view('cestudiantes.index', compact('estudiantes'));
    }

    /**
     * Show the form for creating a new resource.
     * NOTA: Este método ya existe y es manejado por otro módulo
     */
    public function create()
    {
        return view('cestudiantes.create');
    }

    /**
     * Store a newly created resource in storage.
     * NOTA: Este método ya existe y es manejado por otro módulo
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
            'emailUniversidad' => 'required|string|max:100|unique:estudiantesunt,emailUniversidad',
            'anio_ingreso' => 'required|integer|min:1900|max:' . (date('Y') + 10),
            'anio_egreso' => 'nullable|integer|min:1900|max:' . (date('Y') + 20),
            'id_escuela' => 'nullable|integer', 
            'id_curricula' => 'nullable|integer', 
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
            'anio_ingreso.required' => 'El año de ingreso es obligatorio.',
            'anio_ingreso.integer' => 'El año de ingreso debe ser un número entero.',
            'anio_ingreso.min' => 'El año de ingreso no puede ser anterior a 1900.',
            'anio_ingreso.max' => 'El año de ingreso no puede ser mayor a ' . (date('Y') + 10) . '.',
            'anio_egreso.integer' => 'El año de egreso debe ser un número entero.',
            'anio_egreso.min' => 'El año de egreso no puede ser anterior a 1900.',
            'anio_egreso.max' => 'El año de egreso no puede ser mayor a ' . (date('Y') + 20) . '.',
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

        // Crear registro estudiante
        $estudiante = Estudiante::create([
            'id_persona' => $persona->id_persona,
            'id_escuela' => $request->id_escuela,
            'id_curricula' => $request->id_curricula,
            'emailUniversidad' => $request->emailUniversidad,
            'anio_ingreso' => $request->anio_ingreso,
            'anio_egreso' => $request->anio_egreso,
            'estado' => 'Activo',
        ]);

        // Asignar rol de estudiante
        $rolEstudiante = Rol::where('nombre', 'Estudiante')->first();
        if ($rolEstudiante) {
            $persona->roles()->syncWithoutDetaching([$rolEstudiante->id_rol => ['estado' => 'Activo']]);
        }

        // Crear usuario automáticamente
        $resultadoCreacion = Usuario::crearUsuarioAutomatico($persona);
        $credencialesUsuario = $resultadoCreacion['credenciales'];

        $mensaje = 'Estudiante creado exitosamente.';
        if ($credencialesUsuario) {
            $mensaje .= ' Credenciales creadas: Usuario: ' . $credencialesUsuario['username'] . ', Email: ' . $credencialesUsuario['email'] . '. Las credenciales han sido enviadas por email.';

            // Enviar email específico para estudiante
            try {
                \Mail::to($credencialesUsuario['email'])->send(new \App\Mail\EnviarCredencialesEstudiante(
                    $persona->nombres . ' ' . $persona->apellidos,
                    $credencialesUsuario['email'],
                    $credencialesUsuario['password']
                ));
            } catch (\Exception $e) {
                \Log::error('Error sending estudiante credentials email: ' . $e->getMessage());
            }
        }

        return redirect()->route('estudiantes.index')
            ->with('success', $mensaje);
    }

    /**
     * Display the specified resource.
     * Muestra los detalles completos de un estudiante específico
     */
    public function show(Estudiante $estudiante)
    {
        // Cargar todas las relaciones necesarias
        $estudiante->load([
            'persona.roles',
            'persona.usuario',
            'escuela',
            'curricula'
        ]);
        
        return view('cestudiantes.show', compact('estudiante'));
    }

    /**
     * Show the form for editing the specified resource.
     * Muestra el formulario de edición del estudiante
     */
    public function edit(Estudiante $estudiante)
    {
        // Cargar relaciones
        $estudiante->load(['persona', 'escuela', 'curricula']);
        
        // Obtener escuelas y currículas activas para los selects
        $escuelas = Escuela::where('estado', 'Activo')
            ->orderBy('nombre')
            ->get();
            
        $curriculas = Curricula::where('estado', 'Vigente')
            ->orderBy('nombre')
            ->get();
        
        return view('cestudiantes.edit', compact('estudiante', 'escuelas', 'curriculas'));
    }

    /**
     * Update the specified resource in storage.
     * Actualiza los datos del estudiante
     */
    public function update(Request $request, Estudiante $estudiante)
    {
        // Combinar email si se proporcionaron username y domain
        $emailData = $request->all();
        if ($request->filled('email_username') && $request->filled('email_domain')) {
            $emailData['email'] = $request->email_username . '@' . $request->email_domain;
        } elseif ($request->filled('email')) {
            $emailData['email'] = $request->email;
        }

        // Validación con reglas específicas
        $validator = Validator::make($emailData, [
            'nombres' => 'required|string|max:100|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
            'apellidos' => 'required|string|max:100|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
            'dni' => 'required|string|size:8|regex:/^[0-9]+$/|unique:personas,dni,' . $estudiante->persona->id_persona . ',id_persona',
            'telefono' => 'nullable|string|size:9|regex:/^[0-9]+$/',
            'email' => 'nullable|email|max:100|unique:personas,email,' . $estudiante->persona->id_persona . ',id_persona|regex:/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/',
            'genero' => 'nullable|in:M,F,Otro',
            'direccion' => 'nullable|string|max:255',
            'fecha_nacimiento' => 'nullable|date|before:today',
            'emailUniversidad' => 'required|string|max:100|unique:estudiantesunt,emailUniversidad,' . $estudiante->id_estudiante . ',id_estudiante',
            'anio_ingreso' => 'required|integer|min:1900|max:' . (date('Y') + 10),
            'anio_egreso' => 'nullable|integer|min:1900|max:' . (date('Y') + 20),
            'estado' => 'required|in:Activo,Egresado,Inactivo',
            'id_escuela' => 'nullable|integer|exists:escuelas,id_escuela',
            'id_curricula' => 'nullable|integer|exists:curriculas,id_curricula',
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
            'anio_ingreso.required' => 'El año de ingreso es obligatorio.',
            'anio_ingreso.integer' => 'El año de ingreso debe ser un número entero.',
            'anio_ingreso.min' => 'El año de ingreso no puede ser anterior a 1900.',
            'anio_ingreso.max' => 'El año de ingreso no puede ser mayor a ' . (date('Y') + 10) . '.',
            'anio_egreso.integer' => 'El año de egreso debe ser un número entero.',
            'anio_egreso.min' => 'El año de egreso no puede ser anterior a 1900.',
            'anio_egreso.max' => 'El año de egreso no puede ser mayor a ' . (date('Y') + 20) . '.',
            'estado.required' => 'El estado es obligatorio.',
            'estado.in' => 'El estado debe ser Activo, Egresado o Inactivo.',
            'id_escuela.exists' => 'La escuela seleccionada no es válida.',
            'id_curricula.exists' => 'La currícula seleccionada no es válida.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Actualizar datos de la persona
        $estudiante->persona->update(collect($emailData)->only([
            'nombres', 'apellidos', 'dni', 'telefono', 'email', 'genero', 'direccion', 'fecha_nacimiento'
        ])->toArray());

        // Actualizar datos específicos del estudiante
        $estudiante->update([
            'id_escuela' => $request->id_escuela,
            'id_curricula' => $request->id_curricula,
            'emailUniversidad' => $request->emailUniversidad,
            'anio_ingreso' => $request->anio_ingreso,
            'anio_egreso' => $request->anio_egreso,
            'estado' => $request->estado,
        ]);

        return redirect()->route('estudiantes.index')
            ->with('success', 'Estudiante actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     * Cambia el estado del estudiante a Inactivo (soft delete)
     */
    public function destroy(Estudiante $estudiante)
    {
        // Cambiar estado del estudiante a Inactivo
        $estudiante->update(['estado' => 'Inactivo']);

        // Desactivar el rol estudiante de la persona
        $rolEstudiante = Rol::where('nombre', 'Estudiante')->first();
        if ($rolEstudiante) {
            $estudiante->persona->roles()->updateExistingPivot(
                $rolEstudiante->id_rol, 
                ['estado' => 'Inactivo']
            );
        }

        return redirect()->route('estudiantes.index')
            ->with('success', 'Estudiante dado de baja exitosamente.');
    }
}