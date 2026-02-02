<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use App\Models\Rol;
use App\Models\Usuario;
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
        $escuelas = \App\Models\Escuela::activas()->get();
        $especialidades = \App\Models\Especialidad::activas()->get();
        $curriculas = \App\Models\Curricula::vigentes()->with('escuela')->get();
        return view('cpersonas.create', compact('roles', 'escuelas', 'especialidades', 'curriculas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Combinar email si se proporcionaron username y domain
        if ($request->filled('email_username') && $request->filled('email_domain')) {
            $request->merge(['email' => $request->email_username . '@' . $request->email_domain]);
        }

        // Combinar emails universitarios de roles si se proporcionaron campos separados
        if ($request->filled('docente_emailUniversidad_username') && $request->filled('docente_emailUniversidad_domain')) {
            $request->merge(['docente' => array_merge($request->input('docente', []), [
                'emailUniversidad' => $request->docente_emailUniversidad_username . '@' . $request->docente_emailUniversidad_domain
            ])]);
        }

        if ($request->filled('estudiante_emailUniversidad_username') && $request->filled('estudiante_emailUniversidad_domain')) {
            $request->merge(['estudiante' => array_merge($request->input('estudiante', []), [
                'emailUniversidad' => $request->estudiante_emailUniversidad_username . '@' . $request->estudiante_emailUniversidad_domain
            ])]);
        }

        if ($request->filled('secretaria_emailUniversidad_username') && $request->filled('secretaria_emailUniversidad_domain')) {
            $request->merge(['secretaria' => array_merge($request->input('secretaria', []), [
                'emailUniversidad' => $request->secretaria_emailUniversidad_username . '@' . $request->secretaria_emailUniversidad_domain
            ])]);
        }

        // Preparar datos para creación
        $emailData = $request->all();
        if ($request->filled('email_username') && $request->filled('email_domain')) {
            $emailData['email'] = $request->email_username . '@' . $request->email_domain;
        } elseif ($request->filled('email')) {
            $emailData['email'] = $request->email;
        }

        $validator = Validator::make($request->all(), [
            'nombres' => 'required|string|max:100|min:2|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
            'apellidos' => 'required|string|max:100|min:2|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
            'dni' => 'required|string|size:8|regex:/^[0-9]+$/|unique:personas,dni',
            'telefono' => 'nullable|string|size:9|regex:/^[0-9]+$/',
            'email_username' => 'nullable|string|max:50|min:1|regex:/^[a-zA-Z0-9._-]+$/',
            'email_domain' => 'nullable|string|in:unitru.edu.pe,gmail.com,hotmail.com,outlook.com,yahoo.com',
            'email' => 'nullable|email|max:100|unique:personas,email|regex:/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/',
            'genero' => 'nullable|in:M,F,Otro',
            'direccion' => 'nullable|string|max:255|min:5',
            'fecha_nacimiento' => 'nullable|date|before:today|after:1900-01-01',
            'roles' => 'nullable|array|min:1',
            'roles.*' => 'exists:roles,id_rol',
            // Role-specific fields - validated only when present
            'docente.emailUniversidad' => 'nullable|string|max:100|unique:docentes,emailUniversidad|regex:/^[a-zA-Z0-9._-]+@unitru\.edu\.pe$/',
            'docente.especialidades' => 'nullable|array|min:1|max:10',
            'docente.especialidades.*' => 'exists:especialidades,id_especialidad',
            'docente.fecha_contratacion' => 'nullable|date|after:1990-01-01|before_or_equal:today',
            'estudiante.emailUniversidad' => 'nullable|string|max:100|unique:estudiantesunt,emailUniversidad|regex:/^[a-zA-Z0-9._-]+@unitru\.edu\.pe$/',
            'estudiante.anio_ingreso' => 'nullable|integer|min:2000|max:' . (date('Y') + 5),
            'estudiante.anio_egreso' => 'nullable|integer|min:2000|max:' . (date('Y') + 10),
            'estudiante.id_escuela' => 'nullable|integer|exists:escuelas,id_escuela',
            'estudiante.id_curricula' => 'nullable|integer|exists:curriculas,id_curricula',
            'secretaria.emailUniversidad' => 'nullable|string|max:100|unique:secretarias,emailUniversidad|regex:/^[a-zA-Z0-9._-]+@unitru\.edu\.pe$/',
            'secretaria.fecha_ingreso' => 'nullable|date|after:1990-01-01|before_or_equal:today',
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
            'docente.emailUniversidad.unique' => 'El email universitario ya está registrado para docentes.',
            'estudiante.emailUniversidad.unique' => 'El email universitario ya está registrado para estudiantes.',
            'secretaria.emailUniversidad.unique' => 'El email universitario ya está registrado para secretarias.',
            'roles.*.exists' => 'Uno de los roles seleccionados no es válido.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Custom validation for role-specific required fields
        $rolesSeleccionados = $request->input('roles', []);
        $customErrors = [];

        if (in_array(2, $rolesSeleccionados)) { // Docente
            if (!$request->filled('docente.emailUniversidad')) {
                $customErrors['docente.emailUniversidad'] = 'El email universitario es obligatorio para docentes.';
            }
            if (!$request->has('docente.especialidades') || !is_array($request->input('docente.especialidades')) || empty($request->input('docente.especialidades'))) {
                $customErrors['docente.especialidades'] = 'Debe seleccionar al menos una especialidad para docentes.';
            }
        }

        if (in_array(1, $rolesSeleccionados)) { // Estudiante
            if (!$request->filled('estudiante.emailUniversidad')) {
                $customErrors['estudiante.emailUniversidad'] = 'El email universitario es obligatorio para estudiantes.';
            }
            if (!$request->filled('estudiante.anio_ingreso')) {
                $customErrors['estudiante.anio_ingreso'] = 'El año de ingreso es obligatorio para estudiantes.';
            }
            if (!$request->filled('estudiante.id_curricula')) {
                $customErrors['estudiante.id_curricula'] = 'La currícula es obligatoria para estudiantes.';
            }
        }

        if (in_array(3, $rolesSeleccionados)) { // Secretaria
            if (!$request->filled('secretaria.emailUniversidad')) {
                $customErrors['secretaria.emailUniversidad'] = 'El email universitario es obligatorio para secretarias.';
            }
        }

        if (!empty($customErrors)) {
            return redirect()->back()
                ->withErrors($customErrors)
                ->withInput();
        }

        $persona = Persona::create(collect($emailData)->only([
            'nombres', 'apellidos', 'dni', 'telefono', 'email', 'genero', 'direccion', 'fecha_nacimiento'
        ])->merge(['estado' => 'Activo'])->toArray());

        if ($request->has('roles') && is_array($request->roles) && !empty($request->roles)) {
            $rolesAsignados = [];

            // VERIFICAR Y CREAR USUARIO UNA SOLA VEZ ANTES DE PROCESAR ROLES
            $usuarioCreado = false;
            $credencialesUsuario = null;
            if (!$persona->usuario) {
                $resultadoCreacion = Usuario::crearUsuarioAutomatico($persona);
                $credencialesUsuario = $resultadoCreacion['credenciales'];
                $usuarioCreado = true;
            }

            foreach ($request->roles as $rolId) {
                $rol = Rol::find($rolId);

                // Usar syncWithoutDetaching para asignación segura
                $persona->roles()->syncWithoutDetaching([$rolId => ['estado' => 'Activo']]);

                // Crear registro específico según el rol asignado
                $this->crearRegistroEspecificoPorRol($persona, $rol, $request);

                $rolesAsignados[] = $rol->nombre;
            }

            if (!empty($rolesAsignados)) {
                $mensaje = 'Persona creada exitosamente con roles asignados: ' . implode(', ', $rolesAsignados) . '.';
                if ($usuarioCreado && $credencialesUsuario) {
                    $mensaje .= ' Credenciales creadas: Usuario: ' . $credencialesUsuario['username'] . ', Email: ' . $credencialesUsuario['email'] . '. Las credenciales han sido enviadas por email.';
                }
            } else {
                $mensaje = 'Persona creada exitosamente.';
            }
        } else {
            $mensaje = 'Persona creada exitosamente. Se ha creado una persona sin roles específicos.';
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
        $persona->load([
            'roles' => function($query) {
                $query->where('persona_roles.estado', 'Activo');
            },
            'docente' => function($query) {
                $query->where('estado', 'Activo');
            },
            'docente.especialidades' => function($query) {
                $query->where('docente_especialidad.estado', 'Activo');
            },
            'estudiante' => function($query) {
                $query->where('estado', 'Activo');
            },
            'estudiante.escuela',
            'estudiante.curricula',
            'secretaria' => function($query) {
                $query->where('estado', 'Activo');
            }
        ]);
        $roles = Rol::where('estado', 'Activo')->get();
        $escuelas = \App\Models\Escuela::activas()->get();
        $especialidades = \App\Models\Especialidad::activas()->get();
        $curriculas = \App\Models\Curricula::vigentes()->with('escuela')->get();
        return view('cpersonas.edit', compact('persona', 'roles', 'escuelas', 'especialidades', 'curriculas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Persona $persona)
    {
        // Load relationships to ensure they exist for validation and updates
        $persona->load([
            'roles' => function($query) {
                $query->where('persona_roles.estado', 'Activo');
            },
            'docente',
            'docente.especialidades',
            'estudiante',
            'estudiante.escuela',
            'estudiante.curricula',
            'secretaria'
        ]);

        // Combinar email si se proporcionaron username y domain para validación
        if ($request->filled('email_username') && $request->filled('email_domain')) {
            $request->merge(['email' => $request->email_username . '@' . $request->email_domain]);
        }

        // Combinar emails universitarios de roles si se proporcionaron campos separados
        if ($request->filled('docente_emailUniversidad_username') && $request->filled('docente_emailUniversidad_domain')) {
            $request->merge(['docente' => array_merge($request->input('docente', []), [
                'emailUniversidad' => $request->docente_emailUniversidad_username . '@' . $request->docente_emailUniversidad_domain
            ])]);
        }

        if ($request->filled('estudiante_emailUniversidad_username') && $request->filled('estudiante_emailUniversidad_domain')) {
            $request->merge(['estudiante' => array_merge($request->input('estudiante', []), [
                'emailUniversidad' => $request->estudiante_emailUniversidad_username . '@' . $request->estudiante_emailUniversidad_domain
            ])]);
        }

        if ($request->filled('secretaria_emailUniversidad_username') && $request->filled('secretaria_emailUniversidad_domain')) {
            $request->merge(['secretaria' => array_merge($request->input('secretaria', []), [
                'emailUniversidad' => $request->secretaria_emailUniversidad_username . '@' . $request->secretaria_emailUniversidad_domain
            ])]);
        }

        // Preparar datos para actualización
        $emailData = $request->all();
        if ($request->filled('email_username') && $request->filled('email_domain')) {
            $emailData['email'] = $request->email_username . '@' . $request->email_domain;
        } elseif ($request->filled('email')) {
            $emailData['email'] = $request->email;
        }

        $validator = Validator::make($request->all(), [
            'nombres' => 'required|string|max:100|min:2|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
            'apellidos' => 'required|string|max:100|min:2|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
            'dni' => 'required|string|size:8|regex:/^[0-9]+$/|unique:personas,dni,' . $persona->id_persona . ',id_persona',
            'telefono' => 'nullable|string|size:9|regex:/^[0-9]+$/',
            'email_username' => 'nullable|string|max:50|min:1|regex:/^[a-zA-Z0-9._-]+$/',
            'email_domain' => 'nullable|string|in:unitru.edu.pe,gmail.com,hotmail.com,outlook.com,yahoo.com',
            'email' => 'nullable|email|max:100|unique:personas,email,' . $persona->id_persona . ',id_persona|regex:/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/',
            'genero' => 'nullable|in:M,F,Otro',
            'direccion' => 'nullable|string|max:255|min:5',
            'fecha_nacimiento' => 'nullable|date|before:today|after:1900-01-01',
            'roles' => 'nullable|array|min:1',
            'roles.*' => 'exists:roles,id_rol',
            // Validaciones específicas por rol - solo validar si el rol está seleccionado
            'docente.emailUniversidad' => 'nullable|string|max:100|unique:docentes,emailUniversidad,' . ($persona->docente ? $persona->docente->id_docente : 'null') . ',id_docente|regex:/^[a-zA-Z0-9._-]+@unitru\.edu\.pe$/',
            'docente.especialidades' => 'nullable|array|min:1|max:10',
            'docente.especialidades.*' => 'exists:especialidades,id_especialidad',
            'docente.fecha_contratacion' => 'nullable|date|after:1990-01-01|before_or_equal:today',
            'estudiante.emailUniversidad' => 'nullable|string|max:100|unique:estudiantesunt,emailUniversidad,' . ($persona->estudiante ? $persona->estudiante->id_estudiante : 'null') . ',id_estudiante|regex:/^[a-zA-Z0-9._-]+@unitru\.edu\.pe$/',
            'estudiante.anio_ingreso' => 'nullable|integer|min:2000|max:' . (date('Y') + 5),
            'estudiante.anio_egreso' => 'nullable|integer|min:2000|max:' . (date('Y') + 10),
            'estudiante.id_escuela' => 'nullable|integer|exists:escuelas,id_escuela',
            'estudiante.id_curricula' => 'nullable|integer|exists:curriculas,id_curricula',
            'secretaria.emailUniversidad' => 'nullable|string|max:100|unique:secretarias,emailUniversidad,' . ($persona->secretaria ? $persona->secretaria->id_secretaria : 'null') . ',id_secretaria|regex:/^[a-zA-Z0-9._-]+@unitru\.edu\.pe$/',
            'secretaria.fecha_ingreso' => 'nullable|date|after:1990-01-01|before_or_equal:today',
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
            'roles.*.exists' => 'Uno de los roles seleccionados no es válido.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Custom validation for role-specific required fields in update
        $rolesSeleccionados = $request->input('roles', []);
        $customErrors = [];

        if (in_array(2, $rolesSeleccionados)) { // Docente
            // Para docentes existentes, verificar si ya tienen registro
            $docenteExistente = $persona->docente ? true : false;

            // Verificar email universitario usando formato array
            $docenteEmail = $request->input('docente.emailUniversidad');
            if (!$docenteExistente && (!$docenteEmail || trim($docenteEmail) === '')) {
                $customErrors['docente.emailUniversidad'] = 'El email universitario es obligatorio para docentes.';
            }

            // Verificar especialidades
            $docenteEspecialidades = $request->input('docente.especialidades', []);
            if (!$request->has('docente.especialidades') || !is_array($docenteEspecialidades) || empty($docenteEspecialidades)) {
                $customErrors['docente.especialidades'] = 'Debe seleccionar al menos una especialidad para docentes.';
            }
        }

        if (in_array(1, $rolesSeleccionados)) { // Estudiante
            // Para estudiantes existentes, verificar si ya tienen registro
            $estudianteExistente = $persona->estudiante ? true : false;

            // Verificar email universitario usando formato array
            $estudianteEmail = $request->input('estudiante.emailUniversidad');
            if (!$estudianteExistente && (!$estudianteEmail || trim($estudianteEmail) === '')) {
                $customErrors['estudiante.emailUniversidad'] = 'El email universitario es obligatorio para estudiantes.';
            }

            // Verificar año de ingreso
            $anioIngreso = $request->input('estudiante.anio_ingreso');
            if (!$estudianteExistente && (!$anioIngreso || trim($anioIngreso) === '')) {
                $customErrors['estudiante.anio_ingreso'] = 'El año de ingreso es obligatorio para estudiantes.';
            }

            // Verificar currícula
            $curricula = $request->input('estudiante.id_curricula');
            if (!$curricula || trim($curricula) === '') {
                $customErrors['estudiante.id_curricula'] = 'La currícula es obligatoria para estudiantes.';
            }
        }

        if (in_array(3, $rolesSeleccionados)) { // Secretaria
            // Para secretarias existentes, verificar si ya tienen registro
            $secretariaExistente = $persona->secretaria ? true : false;

            // Verificar email universitario usando formato array
            $secretariaEmail = $request->input('secretaria.emailUniversidad');
            if (!$secretariaExistente && (!$secretariaEmail || trim($secretariaEmail) === '')) {
                $customErrors['secretaria.emailUniversidad'] = 'El email universitario es obligatorio para secretarias.';
            }
        }

        if (!empty($customErrors)) {
            return redirect()->back()
                ->withErrors($customErrors)
                ->withInput();
        }

        $persona->update(collect($emailData)->only([
            'nombres', 'apellidos', 'dni', 'telefono', 'email', 'genero', 'direccion', 'fecha_nacimiento'
        ])->toArray());

        // Gestionar cambios de roles de forma coherente
        $cambiosRealizados = [];

        if ($request->has('roles') && is_array($request->roles) && !empty($request->roles)) {
            // Obtener roles actuales activos de la persona
            $rolesActuales = $persona->roles()->where('persona_roles.estado', 'Activo')
                ->pluck('roles.id_rol')->toArray();

            $rolesNuevos = $request->roles;
            $rolesAgregados = array_diff($rolesNuevos, $rolesActuales);
            $rolesRemovidos = array_diff($rolesActuales, $rolesNuevos);

            // VERIFICAR Y CREAR USUARIO UNA SOLA VEZ ANTES DE PROCESAR ROLES
            $usuarioCreado = false;
            $credencialesUsuario = null;
            if (!empty($rolesAgregados) && !$persona->usuario) {
                $resultadoCreacion = Usuario::crearUsuarioAutomatico($persona);
                $credencialesUsuario = $resultadoCreacion['credenciales'];
                $usuarioCreado = true;
            }

            // Agregar nuevos roles
            foreach ($rolesAgregados as $rolId) {
                $rol = Rol::find($rolId);

                // Verificar si ya existe una asignación (incluso inactiva) y actualizarla, o crear nueva
                $asignacionExistente = \DB::table('persona_roles')
                    ->where('id_persona', $persona->id_persona)
                    ->where('id_rol', $rolId)
                    ->first();

                if ($asignacionExistente) {
                    // Si existe, reactivarla usando DB query directo para asegurar la actualización
                    \DB::table('persona_roles')
                        ->where('id_persona', $persona->id_persona)
                        ->where('id_rol', $rolId)
                        ->update(['estado' => 'Activo']);
                    $cambiosRealizados[] = "Rol reactivado: {$rol->nombre}";
                } else {
                    // Si no existe, crear nueva asignación
                    $persona->roles()->syncWithoutDetaching([$rolId => ['estado' => 'Activo']]);
                    $cambiosRealizados[] = "Rol agregado: {$rol->nombre}";
                }

                // Reactivar o crear registro específico según el rol asignado
                $this->reactivarOCrearRegistroEspecificoPorRol($persona, $rol, $request);
            }

            // Actualizar roles existentes (que no fueron agregados ni removidos)
            $rolesExistentes = array_intersect($rolesNuevos, $rolesActuales);
            foreach ($rolesExistentes as $rolId) {
                $rol = Rol::find($rolId);

                // Detectar cambios específicos antes de actualizar
                $cambiosRol = $this->detectarCambiosEnRolExistente($persona, $rol, $request);

                // Solo actualizar si hay cambios detectados
                if (!empty($cambiosRol)) {
                    $this->crearRegistroEspecificoPorRol($persona, $rol, $request);
                    $cambiosRealizados[] = "Rol actualizado: {$rol->nombre} (" . implode(', ', $cambiosRol) . ")";
                } else {
                    $cambiosRealizados[] = "Rol confirmado: {$rol->nombre}";
                }
            }

            // Agregar mensaje de usuario creado si fue necesario
            if ($usuarioCreado && $credencialesUsuario) {
                $cambiosRealizados[] = "Usuario creado: {$credencialesUsuario['username']} ({$credencialesUsuario['email']})";
            }

            // Remover roles no seleccionados
            foreach ($rolesRemovidos as $rolId) {
                $rol = Rol::find($rolId);
                $persona->roles()->updateExistingPivot($rolId, ['estado' => 'Inactivo']);

                // También desactivar el registro en la tabla específica del rol
                $this->desactivarRegistroEspecificoPorRol($persona, $rol);

                $cambiosRealizados[] = "Rol removido: {$rol->nombre}";
            }

            // Si no hay cambios pero hay roles, verificar si necesitan credenciales
            if (empty($rolesAgregados) && empty($rolesRemovidos) && !empty($rolesNuevos)) {
                $cambiosRealizados[] = "Roles confirmados sin cambios";
            }
        } else {
            // Sin roles - desactivar todas las asignaciones de roles activas
            $rolesDesactivados = $persona->roles()->where('persona_roles.estado', 'Activo')
                ->update(['persona_roles.estado' => 'Inactivo']);
            if ($rolesDesactivados > 0) {
                $cambiosRealizados[] = "Se desactivaron {$rolesDesactivados} asignación(es) de rol(es)";
            }
        }

        // Construir mensaje informativo
        $mensaje = 'Persona actualizada exitosamente.';
        if (!empty($cambiosRealizados)) {
            $mensaje .= ' Cambios realizados: ' . implode(', ', $cambiosRealizados) . '.';
        }

        return redirect()->route('personas.index')
            ->with('success', $mensaje);
    }

    /**
     * Remove the specified resource from storage.
     * Cambia el estado a "Inactivo" manteniendo integridad referencial
     */
    public function destroy(Persona $persona)
    {
        // Verificar si la persona ya está inactiva
        if ($persona->estado === 'Inactivo') {
            return redirect()->route('personas.index')
                ->with('warning', 'La persona ya se encuentra inactiva.');
        }

        // Cambiar el estado de la persona a "Inactivo"
        $persona->update(['estado' => 'Inactivo']);

        // Desactivar todos los usuarios asociados a esta persona
        $usuariosDesactivados = $persona->usuarios()->where('estado', 'Activo')->update(['estado' => 'Inactivo']);

        // Desactivar todas las asignaciones de roles activas de esta persona
        $rolesDesactivados = $persona->roles()->where('persona_roles.estado', 'Activo')
            ->update(['persona_roles.estado' => 'Inactivo']);

        // Construir mensaje informativo sobre qué se desactivó
        $mensaje = 'Persona dada de baja exitosamente.';
        if ($usuariosDesactivados > 0) {
            $mensaje .= " Se desactivaron {$usuariosDesactivados} usuario(s) asociado(s).";
        }
        if ($rolesDesactivados > 0) {
            $mensaje .= " Se desactivaron {$rolesDesactivados} asignación(es) de rol(es).";
        }

        return redirect()->route('personas.index')
            ->with('success', $mensaje);
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

    /**
     * Verificar si el email universitario ya existe según el tipo de rol
     */
    public function verificarEmailUniversitario(Request $request)
    {
        $email = $request->get('email');
        $tipo = $request->get('tipo'); // docente, estudiante, secretaria
        $personaId = $request->get('persona_id'); // ID de la persona para excluir el registro actual

        // Mapear tipos a tablas y campos de ID
        $configuracion = [
            'docente' => ['tabla' => 'docentes', 'campo_id' => 'id_docente'],
            'estudiante' => ['tabla' => 'estudiantesunt', 'campo_id' => 'id_estudiante'],
            'secretaria' => ['tabla' => 'secretarias', 'campo_id' => 'id_secretaria']
        ];

        if (!isset($configuracion[$tipo])) {
            return response()->json([
                'existe' => true,
                'mensaje' => 'Tipo de rol inválido.'
            ]);
        }

        $tabla = $configuracion[$tipo]['tabla'];
        $campoId = $configuracion[$tipo]['campo_id'];

        // Construir query excluyendo registros inactivos y el registro actual si existe
        $query = \DB::table($tabla)
            ->where('emailUniversidad', $email)
            ->where('estado', 'Activo'); // Solo considerar registros activos

        if ($personaId) {
            // Buscar el registro actual de esta persona para excluirlo (independientemente de su estado)
            $registroActual = \DB::table($tabla)->where('id_persona', $personaId)->first();
            if ($registroActual) {
                $query->where($campoId, '!=', $registroActual->$campoId);
            }
        }

        $existe = $query->exists();

        return response()->json([
            'existe' => $existe,
            'mensaje' => $existe ? 'Este email universitario ya está registrado.' : 'Email universitario disponible.'
        ]);
    }

    /**
     * Crear o actualizar registro específico según el rol asignado
     */
    private function crearRegistroEspecificoPorRol($persona, $rol, $request = null)
    {
        try {
            switch ($rol->nombre) {
                case 'Docente':
                    if (!$persona->docente) {
                        // Crear docente nuevo
                        $emailUniversitario = $request && $request->input('docente.emailUniversidad')
                            ? $request->input('docente.emailUniversidad')
                            : $this->generarEmailUniversitario($persona);

                        $docente = \App\Models\Docente::create([
                            'id_persona' => $persona->id_persona,
                            'emailUniversidad' => $emailUniversitario,
                            'fecha_contratacion' => $request ? $request->input('docente.fecha_contratacion') : null,
                            'estado' => 'Activo'
                        ]);

                        // Asignar especialidades si se proporcionaron
                        if ($request && $request->has('docente.especialidades') && is_array($request->input('docente.especialidades'))) {
                            $especialidadesData = [];
                            foreach ($request->input('docente.especialidades') as $especialidadId) {
                                $especialidadesData[$especialidadId] = ['estado' => 'Activo'];
                            }
                            $docente->especialidades()->sync($especialidadesData);
                        }
                    } else {
                        // Actualizar registro existente
                        $updateData = [];

                        // Solo actualizar email si se proporcionó uno nuevo
                        if ($request && $request->input('docente.emailUniversidad')) {
                            $updateData['emailUniversidad'] = $request->input('docente.emailUniversidad');
                        }

                        // Actualizar fecha de contratación si se proporcionó
                        if ($request && $request->input('docente.fecha_contratacion')) {
                            $updateData['fecha_contratacion'] = $request->input('docente.fecha_contratacion');
                        }

                        if (!empty($updateData)) {
                            $persona->docente->update($updateData);
                        }

                        // Actualizar especialidades
                        if ($request && $request->has('docente.especialidades') && is_array($request->input('docente.especialidades'))) {
                            $especialidadesData = [];
                            foreach ($request->input('docente.especialidades') as $especialidadId) {
                                $especialidadesData[$especialidadId] = ['estado' => 'Activo'];
                            }
                            $persona->docente->especialidades()->sync($especialidadesData);
                        } else {
                            // Si no se proporcionaron especialidades, desasociar todas
                            $persona->docente->especialidades()->detach();
                        }
                    }
                    break;

                case 'Estudiante':
                    if (!$persona->estudiante) {
                        // Crear estudiante nuevo
                        $emailUniversitario = $request && $request->input('estudiante.emailUniversidad')
                            ? $request->input('estudiante.emailUniversidad')
                            : $this->generarEmailUniversitario($persona);

                        \App\Models\Estudiante::create([
                            'id_persona' => $persona->id_persona,
                            'id_escuela' => $request ? $request->input('estudiante.id_escuela') : 1,
                            'id_curricula' => $request ? $request->input('estudiante.id_curricula') : null,
                            'emailUniversidad' => $emailUniversitario,
                            'anio_ingreso' => $request ? $request->input('estudiante.anio_ingreso') : date('Y'),
                            'anio_egreso' => $request ? $request->input('estudiante.anio_egreso') : null,
                            'estado' => 'Activo'
                        ]);
                    } else {
                        // Actualizar registro existente
                        $updateData = [];

                        // Solo actualizar email si se proporcionó uno nuevo
                        if ($request && $request->input('estudiante.emailUniversidad')) {
                            $updateData['emailUniversidad'] = $request->input('estudiante.emailUniversidad');
                        }

                        // Actualizar otros campos si se proporcionaron
                        if ($request && $request->input('estudiante.id_escuela')) {
                            $updateData['id_escuela'] = $request->input('estudiante.id_escuela');
                        }

                        if ($request && $request->input('estudiante.id_curricula')) {
                            $updateData['id_curricula'] = $request->input('estudiante.id_curricula');
                        }

                        if ($request && $request->input('estudiante.anio_ingreso')) {
                            $updateData['anio_ingreso'] = $request->input('estudiante.anio_ingreso');
                        }

                        if ($request && $request->input('estudiante.anio_egreso')) {
                            $updateData['anio_egreso'] = $request->input('estudiante.anio_egreso');
                        }

                        if (!empty($updateData)) {
                            $persona->estudiante->update($updateData);
                        }
                    }
                    break;

                case 'Secretaria':
                    \Log::info('Procesando rol Secretaria para persona ID: ' . $persona->id_persona);

                    if (!$persona->secretaria) {
                        \Log::info('Creando nueva secretaria');

                        // Crear secretaria nueva
                        $emailUniversitario = $request && $request->input('secretaria.emailUniversidad')
                            ? $request->input('secretaria.emailUniversidad')
                            : $this->generarEmailUniversitario($persona);

                        \Log::info('Email universitario para secretaria: ' . $emailUniversitario);

                        $secretariaData = [
                            'id_persona' => $persona->id_persona,
                            'emailUniversidad' => $emailUniversitario,
                            'fecha_ingreso' => $request ? $request->input('secretaria.fecha_ingreso') : date('Y-m-d'),
                            'estado' => 'Activo'
                        ];

                        \Log::info('Datos para crear secretaria:', $secretariaData);

                        $secretaria = \App\Models\Secretaria::create($secretariaData);

                        \Log::info('Secretaria creada con ID: ' . $secretaria->id_secretaria);
                    } else {
                        \Log::info('Actualizando secretaria existente');

                        // Actualizar registro existente
                        $updateData = [];

                        // Solo actualizar email si se proporcionó uno nuevo
                        if ($request && $request->input('secretaria.emailUniversidad')) {
                            $updateData['emailUniversidad'] = $request->input('secretaria.emailUniversidad');
                        }

                        // Actualizar fecha de ingreso si se proporcionó
                        if ($request && $request->input('secretaria.fecha_ingreso')) {
                            $updateData['fecha_ingreso'] = $request->input('secretaria.fecha_ingreso');
                        }

                        if (!empty($updateData)) {
                            \Log::info('Actualizando secretaria con datos:', $updateData);
                            $persona->secretaria->update($updateData);
                        }
                    }
                    break;
            }
        } catch (\Exception $e) {
            // Log error but don't stop the process
            \Log::error('Error creando/actualizando registro específico para rol ' . $rol->nombre . ': ' . $e->getMessage());
        }
    }

    /**
     * Detectar cambios específicos en un rol existente
     */
    private function detectarCambiosEnRolExistente($persona, $rol, $request)
    {
        $cambios = [];

        switch ($rol->nombre) {
            case 'Docente':
                if ($persona->docente) {
                    // Verificar email universitario
                    if ($request->input('docente.emailUniversidad') &&
                        $request->input('docente.emailUniversidad') !== $persona->docente->emailUniversidad) {
                        $cambios[] = 'email universitario';
                    }

                    // Verificar fecha de contratación
                    if ($request->input('docente.fecha_contratacion') &&
                        $request->input('docente.fecha_contratacion') !== $persona->docente->fecha_contratacion) {
                        $cambios[] = 'fecha contratación';
                    }

                    // Verificar especialidades (comparar arrays)
                    if ($request->has('docente.especialidades') &&
                        is_array($request->input('docente.especialidades'))) {
                        $especialidadesActuales = $persona->docente->especialidades->pluck('id_especialidad')->toArray();
                        $especialidadesNuevas = $request->input('docente.especialidades');

                        sort($especialidadesActuales);
                        sort($especialidadesNuevas);

                        if ($especialidadesActuales !== $especialidadesNuevas) {
                            $cambios[] = 'especialidades';
                        }
                    }
                }
                break;

            case 'Estudiante':
                if ($persona->estudiante) {
                    // Verificar email universitario
                    if ($request->input('estudiante.emailUniversidad') &&
                        $request->input('estudiante.emailUniversidad') !== $persona->estudiante->emailUniversidad) {
                        $cambios[] = 'email universitario';
                    }

                    // Verificar escuela
                    if ($request->input('estudiante.id_escuela') &&
                        $request->input('estudiante.id_escuela') != $persona->estudiante->id_escuela) {
                        $cambios[] = 'escuela';
                    }

                    // Verificar currícula
                    if ($request->input('estudiante.id_curricula') &&
                        $request->input('estudiante.id_curricula') != $persona->estudiante->id_curricula) {
                        $cambios[] = 'currícula';
                    }

                    // Verificar año de ingreso
                    if ($request->input('estudiante.anio_ingreso') &&
                        $request->input('estudiante.anio_ingreso') != $persona->estudiante->anio_ingreso) {
                        $cambios[] = 'año ingreso';
                    }

                    // Verificar año de egreso
                    if ($request->input('estudiante.anio_egreso') &&
                        $request->input('estudiante.anio_egreso') != $persona->estudiante->anio_egreso) {
                        $cambios[] = 'año egreso';
                    }
                }
                break;

            case 'Secretaria':
                if ($persona->secretaria) {
                    // Verificar email universitario
                    if ($request->input('secretaria.emailUniversidad') &&
                        $request->input('secretaria.emailUniversidad') !== $persona->secretaria->emailUniversidad) {
                        $cambios[] = 'email universitario';
                    }

                    // Verificar fecha de ingreso
                    if ($request->input('secretaria.fecha_ingreso') &&
                        $request->input('secretaria.fecha_ingreso') !== $persona->secretaria->fecha_ingreso) {
                        $cambios[] = 'fecha ingreso';
                    }
                }
                break;
        }

        return $cambios;
    }

    /**
     * Reactivar registro específico según el rol reasignado o crear nuevo
     */
    private function reactivarOCrearRegistroEspecificoPorRol($persona, $rol, $request = null)
    {
        try {
            switch ($rol->nombre) {
                case 'Docente':
                    if ($persona->docente) {
                        // Reactivar registro existente
                        $persona->docente->update(['estado' => 'Activo']);
                        \Log::info('Docente reactivado para persona ID: ' . $persona->id_persona);

                        // Actualizar datos si se proporcionaron
                        if ($request) {
                            $updateData = [];
                            if ($request->input('docente.emailUniversidad')) {
                                $updateData['emailUniversidad'] = $request->input('docente.emailUniversidad');
                            }
                            if ($request->input('docente.fecha_contratacion')) {
                                $updateData['fecha_contratacion'] = $request->input('docente.fecha_contratacion');
                            }
                            if (!empty($updateData)) {
                                $persona->docente->update($updateData);
                            }

                            // Actualizar especialidades
                            if ($request->has('docente.especialidades') && is_array($request->input('docente.especialidades'))) {
                                $especialidadesData = [];
                                foreach ($request->input('docente.especialidades') as $especialidadId) {
                                    $especialidadesData[$especialidadId] = ['estado' => 'Activo'];
                                }
                                $persona->docente->especialidades()->sync($especialidadesData);
                            }
                        }
                    } else {
                        // Crear registro nuevo
                        $emailUniversitario = $request && $request->input('docente.emailUniversidad')
                            ? $request->input('docente.emailUniversidad')
                            : $this->generarEmailUniversitario($persona);

                        $docente = \App\Models\Docente::create([
                            'id_persona' => $persona->id_persona,
                            'emailUniversidad' => $emailUniversitario,
                            'fecha_contratacion' => $request ? $request->input('docente.fecha_contratacion') : null,
                            'estado' => 'Activo'
                        ]);

                        // Asignar especialidades si se proporcionaron
                        if ($request && $request->has('docente.especialidades') && is_array($request->input('docente.especialidades'))) {
                            $especialidadesData = [];
                            foreach ($request->input('docente.especialidades') as $especialidadId) {
                                $especialidadesData[$especialidadId] = ['estado' => 'Activo'];
                            }
                            $docente->especialidades()->sync($especialidadesData);
                        }
                    }
                    break;

                case 'Estudiante':
                    if ($persona->estudiante) {
                        // Reactivar registro existente
                        $persona->estudiante->update(['estado' => 'Activo']);
                        \Log::info('Estudiante reactivado para persona ID: ' . $persona->id_persona);

                        // Actualizar datos si se proporcionaron
                        if ($request) {
                            $updateData = [];
                            if ($request->input('estudiante.emailUniversidad')) {
                                $updateData['emailUniversidad'] = $request->input('estudiante.emailUniversidad');
                            }
                            if ($request->input('estudiante.id_escuela')) {
                                $updateData['id_escuela'] = $request->input('estudiante.id_escuela');
                            }
                            if ($request->input('estudiante.id_curricula')) {
                                $updateData['id_curricula'] = $request->input('estudiante.id_curricula');
                            }
                            if ($request->input('estudiante.anio_ingreso')) {
                                $updateData['anio_ingreso'] = $request->input('estudiante.anio_ingreso');
                            }
                            if ($request->input('estudiante.anio_egreso')) {
                                $updateData['anio_egreso'] = $request->input('estudiante.anio_egreso');
                            }
                            if (!empty($updateData)) {
                                $persona->estudiante->update($updateData);
                            }
                        }
                    } else {
                        // Crear registro nuevo
                        $emailUniversitario = $request && $request->input('estudiante.emailUniversidad')
                            ? $request->input('estudiante.emailUniversidad')
                            : $this->generarEmailUniversitario($persona);

                        \App\Models\Estudiante::create([
                            'id_persona' => $persona->id_persona,
                            'id_escuela' => $request ? $request->input('estudiante.id_escuela') : 1,
                            'id_curricula' => $request ? $request->input('estudiante.id_curricula') : null,
                            'emailUniversidad' => $emailUniversitario,
                            'anio_ingreso' => $request ? $request->input('estudiante.anio_ingreso') : date('Y'),
                            'anio_egreso' => $request ? $request->input('estudiante.anio_egreso') : null,
                            'estado' => 'Activo'
                        ]);
                    }
                    break;

                case 'Secretaria':
                    \Log::info('Procesando rol Secretaria para persona ID: ' . $persona->id_persona);

                    if ($persona->secretaria) {
                        // Reactivar registro existente
                        $persona->secretaria->update(['estado' => 'Activo']);
                        \Log::info('Secretaria reactivada para persona ID: ' . $persona->id_persona);

                        // Actualizar datos si se proporcionaron
                        if ($request) {
                            $updateData = [];
                            if ($request->input('secretaria.emailUniversidad')) {
                                $updateData['emailUniversidad'] = $request->input('secretaria.emailUniversidad');
                            }
                            if ($request->input('secretaria.fecha_ingreso')) {
                                $updateData['fecha_ingreso'] = $request->input('secretaria.fecha_ingreso');
                            }
                            if (!empty($updateData)) {
                                $persona->secretaria->update($updateData);
                            }
                        }
                    } else {
                        // Crear registro nuevo
                        \Log::info('Creando nueva secretaria');

                        $emailUniversitario = $request && $request->input('secretaria.emailUniversidad')
                            ? $request->input('secretaria.emailUniversidad')
                            : $this->generarEmailUniversitario($persona);

                        \Log::info('Email universitario para secretaria: ' . $emailUniversitario);

                        $secretariaData = [
                            'id_persona' => $persona->id_persona,
                            'emailUniversidad' => $emailUniversitario,
                            'fecha_ingreso' => $request ? $request->input('secretaria.fecha_ingreso') : date('Y-m-d'),
                            'estado' => 'Activo'
                        ];

                        \Log::info('Datos para crear secretaria:', $secretariaData);

                        $secretaria = \App\Models\Secretaria::create($secretariaData);

                        \Log::info('Secretaria creada con ID: ' . $secretaria->id_secretaria);
                    }
                    break;
            }
        } catch (\Exception $e) {
            // Log error but don't stop the process
            \Log::error('Error reactivando/creando registro específico para rol ' . $rol->nombre . ': ' . $e->getMessage());
        }
    }

    /**
     * Desactivar registro específico según el rol removido
     */
    private function desactivarRegistroEspecificoPorRol($persona, $rol)
    {
        try {
            switch ($rol->nombre) {
                case 'Docente':
                    if ($persona->docente && $persona->docente->estado === 'Activo') {
                        $persona->docente->update(['estado' => 'Inactivo']);
                        \Log::info('Docente desactivado para persona ID: ' . $persona->id_persona);
                    }
                    break;

                case 'Estudiante':
                    if ($persona->estudiante && $persona->estudiante->estado === 'Activo') {
                        $persona->estudiante->update(['estado' => 'Inactivo']);
                        \Log::info('Estudiante desactivado para persona ID: ' . $persona->id_persona);
                    }
                    break;

                case 'Secretaria':
                    if ($persona->secretaria && $persona->secretaria->estado === 'Activo') {
                        $persona->secretaria->update(['estado' => 'Inactivo']);
                        \Log::info('Secretaria desactivada para persona ID: ' . $persona->id_persona);
                    }
                    break;
            }
        } catch (\Exception $e) {
            // Log error but don't stop the process
            \Log::error('Error desactivando registro específico para rol ' . $rol->nombre . ': ' . $e->getMessage());
        }
    }

    /**
     * Generar email universitario único para una persona
     */
    private function generarEmailUniversitario($persona)
    {
        // Base del email: primera letra del nombre + apellido completo
        $primeraLetraNombre = strtolower(substr($persona->nombres, 0, 1));
        $apellidoCompleto = strtolower($persona->apellidos);

        // Limpiar espacios y caracteres especiales del apellido
        $apellidoLimpio = preg_replace('/[^a-z]/', '', $apellidoCompleto);

        $baseEmail = $primeraLetraNombre . $apellidoLimpio;
        $emailBase = $baseEmail . '@unitru.edu.pe';

        // Verificar unicidad y agregar contador si es necesario
        $emailFinal = $emailBase;
        $contador = 1;

        // Verificar en todas las tablas de roles
        $tablas = ['docentes', 'estudiantesunt', 'secretarias'];
        foreach ($tablas as $tabla) {
            while (\DB::table($tabla)->where('emailUniversidad', $emailFinal)->exists()) {
                $emailFinal = $baseEmail . $contador . '@unitru.edu.pe';
                $contador++;
            }
        }

        return $emailFinal;
    }
}
