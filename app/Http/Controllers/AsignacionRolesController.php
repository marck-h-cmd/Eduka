<?php

namespace App\Http\Controllers;

use App\Models\Curricula;
use App\Models\Escuela;
use App\Models\Especialidad;
use App\Models\Persona;
use App\Models\Rol;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AsignacionRolesController extends Controller
{
    /**
     * Mostrar listado de personas sin roles para asignación.
     */
    public function index(Request $solicitud)
    {
        // Verificar permisos basado en el rol ACTIVO actual
        $user = auth()->user();
        $currentRole = $user->getCurrentRole();

        \Log::info('Usuario intentando acceder a asignacion-roles:', [
            'user_id' => $user->id_usuario,
            'username' => $user->username,
            'current_role' => $currentRole ? $currentRole->nombre : 'Sin rol activo',
            'all_roles' => $user->getActiveRoles()->pluck('nombre')->toArray(),
        ]);

        // Solo permitir acceso si el rol ACTIVO es Administrador o Secretaria
        if (! $currentRole || ! in_array($currentRole->nombre, ['Administrador', 'Secretaria'])) {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }

        $buscarpor = $solicitud->get('buscarpor');
        $tipo_busqueda = $solicitud->get('tipo_busqueda', 'nombre');
        $rol_filtro = $solicitud->get('rol_filtro');
        $ordenar_por = $solicitud->get('ordenar_por', 'nombres');

        // Verificar si es una petición AJAX para búsqueda
        if ($solicitud->ajax() && $solicitud->isMethod('post')) {
            return $this->ajaxSearch($solicitud);
        }

        // Mostrar todas las personas activas para permitir asignación de roles adicionales
        $personasSinRoles = Persona::with(['roles', 'docente', 'estudiante', 'secretaria'])
            ->where('estado', 'Activo') // Solo mostrar personas activas
            ->when($buscarpor, function ($query) use ($buscarpor, $tipo_busqueda) {
                switch ($tipo_busqueda) {
                    case 'dni':
                        return $query->where('dni', 'like', '%'.$buscarpor.'%');
                    case 'email':
                        return $query->where('email', 'like', '%'.$buscarpor.'%');
                    case 'nombre':
                    default:
                        return $query->where(function ($q) use ($buscarpor) {
                            $q->where('nombres', 'like', '%'.$buscarpor.'%')
                                ->orWhere('apellidos', 'like', '%'.$buscarpor.'%');
                        });
                }
            })
            ->when($rol_filtro, function ($query) use ($rol_filtro) {
                if ($rol_filtro === 'sin_roles') {
                    // Personas sin roles asignados
                    return $query->whereDoesntHave('roles', function ($q) {
                        $q->where('persona_roles.estado', 'Activo');
                    });
                } else {
                    // Personas con un rol específico
                    return $query->whereHas('roles', function ($q) use ($rol_filtro) {
                        $q->where('persona_roles.id_rol', $rol_filtro)
                            ->where('persona_roles.estado', 'Activo');
                    });
                }
            })
            ->orderBy($ordenar_por)
            ->when($ordenar_por === 'nombres', function ($query) {
                $query->orderBy('apellidos');
            })
            ->paginate(10);

        $roles = Rol::where('estado', 'Activo')->get();

        // Load data for role configuration forms
        $especialidades = Especialidad::where('estado', 'Activo')->get();
        $escuelas = Escuela::where('estado', 'Activo')->get();
        $curriculas = Curricula::with('escuela')->where('estado', 'Vigente')->get();

        return view('casignacionroles.index', compact('personasSinRoles', 'roles', 'especialidades', 'escuelas', 'curriculas', 'buscarpor', 'tipo_busqueda', 'rol_filtro', 'ordenar_por'));
    }

    /**
     * Búsqueda AJAX para personas con filtros avanzados.
     */
    public function ajaxSearch(Request $request)
    {
        // Verificar permisos basado en el rol ACTIVO actual
        $user = auth()->user();
        $currentRole = $user->getCurrentRole();

        if (! $currentRole || ! in_array($currentRole->nombre, ['Administrador', 'Secretaria'])) {
            return response()->json(['error' => 'No tienes permisos para acceder a esta sección.'], 403);
        }

        $buscarpor = $request->get('buscarpor');
        $tipo_busqueda = $request->get('tipo_busqueda', 'nombre');
        $rol_filtro = $request->get('rol_filtro');
        $page = $request->get('page', 1);

        // Construir consulta con filtros
        $personasSinRoles = Persona::with(['roles', 'docente', 'estudiante', 'secretaria'])
            ->where('estado', 'Activo') // Solo mostrar personas activas
            ->when($buscarpor, function ($query) use ($buscarpor, $tipo_busqueda) {
                switch ($tipo_busqueda) {
                    case 'dni':
                        return $query->where('dni', 'like', '%'.$buscarpor.'%');
                    case 'email':
                        return $query->where('email', 'like', '%'.$buscarpor.'%');
                    case 'nombre':
                    default:
                        return $query->where(function ($q) use ($buscarpor) {
                            $q->where('nombres', 'like', '%'.$buscarpor.'%')
                                ->orWhere('apellidos', 'like', '%'.$buscarpor.'%');
                        });
                }
            })
            ->when($rol_filtro, function ($query) use ($rol_filtro) {
                if ($rol_filtro === 'sin_roles') {
                    // Personas sin roles asignados
                    return $query->whereDoesntHave('roles', function ($q) {
                        $q->where('persona_roles.estado', 'Activo');
                    });
                } else {
                    // Personas con un rol específico
                    return $query->whereHas('roles', function ($q) use ($rol_filtro) {
                        $q->where('persona_roles.id_rol', $rol_filtro)
                            ->where('persona_roles.estado', 'Activo');
                    });
                }
            })
            ->orderBy('nombres')
            ->orderBy('apellidos')
            ->paginate(10);

        $roles = Rol::where('estado', 'Activo')->get();

        $html = '';
        foreach ($personasSinRoles as $persona) {
            $html .= '<tr class="persona-row" data-persona-id="'.$persona->id_persona.'">';
            $html .= '<td class="font-weight-bold align-middle">'.$persona->id_persona.'</td>';
            $html .= '<td class="align-middle">';
            $html .= '<strong>'.$persona->nombres.' '.$persona->apellidos.'</strong>';
            $html .= '<br><small class="text-muted">'.($persona->email ?: 'Sin email').'</small>';
            $html .= '</td>';
            $html .= '<td class="align-middle">'.$persona->dni.'</td>';
            $html .= '<td class="text-center align-middle">';

            // Mostrar roles asignados
            if ($persona->roles->count() > 0) {
                $html .= '<div class="d-flex flex-wrap gap-1 justify-content-center">';
                foreach ($persona->roles as $rol) {
                    $iconClass = '';
                    switch ($rol->nombre) {
                        case 'Administrador': $iconClass = 'fas fa-crown text-warning';
                            break;
                        case 'Docente': $iconClass = 'fas fa-chalkboard-teacher text-info';
                            break;
                        case 'Estudiante': $iconClass = 'fas fa-user-graduate text-success';
                            break;
                        case 'Secretaria': $iconClass = 'fas fa-user-tie text-secondary';
                            break;
                        case 'Representante': $iconClass = 'fas fa-user-friends text-primary';
                            break;
                        default: $iconClass = 'fas fa-user-tag text-secondary';
                            break;
                    }
                    $html .= '<span class="badge badge-info d-inline-flex align-items-center" style="font-size: 0.75rem;">';
                    $html .= '<i class="'.$iconClass.' me-1"></i>'.$rol->nombre;
                    $html .= '</span>';
                }
                $html .= '</div>';
            } else {
                $html .= '<span class="badge badge-secondary">Sin roles</span>';
            }
            $html .= '</td>';

            // Columnas de acciones para cada rol
            foreach ($roles as $rol) {
                $html .= '<td class="text-center align-middle">';
                $html .= '<div class="role-assignment-container" data-persona-id="'.$persona->id_persona.'" data-role-id="'.$rol->id_rol.'">';
                if ($persona->roles->contains('id_rol', $rol->id_rol)) {
                    $html .= '<div class="role-assigned-container">';
                    $html .= '<span class="badge badge-success px-3 py-2" title="Rol asignado" style="font-size: 14px; min-width: 32px; display: inline-flex; align-items: center; justify-content: center;">';
                    $html .= '<i class="fas fa-check"></i>';
                    $html .= '</span>';
                    $html .= '<div class="remove-role-overlay remove-role-btn" title="Quitar rol '.$rol->nombre.'">';
                    $html .= '<i class="fas fa-times"></i>';
                    $html .= '</div>';
                    $html .= '</div>';
                } else {
                    $html .= '<button type="button" class="btn btn-sm btn-outline-primary assign-role-btn" title="Asignar rol '.$rol->nombre.'">';
                    $html .= '<i class="fas fa-plus"></i>';
                    $html .= '</button>';
                }
                $html .= '<div class="role-form-container mt-2" style="display: none;">';
                $html .= '<!-- Form will be loaded here -->';
                $html .= '</div>';
                $html .= '</div>';
                $html .= '</td>';
            }

            $html .= '</tr>';
        }

        if ($personasSinRoles->isEmpty()) {
            $html = '<tr><td colspan="'.(4 + $roles->count()).'" class="text-center py-4">';
            $html .= '<i class="fas fa-info-circle fa-2x text-muted mb-2"></i>';
            $html .= '<h5 class="text-muted">No hay personas registradas</h5>';
            $html .= '<p class="text-muted">No se encontraron personas que coincidan con la búsqueda.</p>';
            $html .= '</td></tr>';
        }

        return response()->json([
            'html' => $html,
            'pagination' => $personasSinRoles->appends($request->query())->links()->toHtml(),
            'total' => $personasSinRoles->total(),
            'current_page' => $personasSinRoles->currentPage(),
            'last_page' => $personasSinRoles->lastPage(),
        ]);
    }

    /**
     * Asignar roles a múltiples personas y crear usuarios automáticamente.
     */
    public function asignarRoles(Request $solicitud)
    {
        // Verificar permisos basado en el rol ACTIVO actual
        $user = auth()->user();
        $currentRole = $user->getCurrentRole();

        if (! $currentRole || ! in_array($currentRole->nombre, ['Administrador', 'Secretaria'])) {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }

        // Debug: mostrar qué datos llegan al servidor
        \Log::info('=== DATOS RECIBIDOS EN SERVIDOR ===', [
            'all_data' => $solicitud->all(),
            'assignments' => $solicitud->input('assignments'),
        ]);

        // Log detailed request data for debugging specialty issues
        \Log::info('=== DETALLES COMPLETOS DEL REQUEST ===', [
            'all_request_data' => $solicitud->all(),
            'input_data' => $solicitud->input(),
            'post_data' => $_POST ?? 'N/A',
            'files' => $solicitud->allFiles(),
        ]);

        \Log::info('=== FIN DATOS ===');

        $validador = Validator::make($solicitud->all(), [
            'assignments' => 'required|array|min:1',
            'assignments.*' => 'required|array|min:1',
        ], [
            'assignments.required' => 'Debe asignar al menos un rol a alguna persona.',
            'assignments.*.required' => 'Cada persona debe tener al menos un rol asignado.',
            'assignments.*.min' => 'Cada persona debe tener al menos un rol asignado.',
        ]);

        if ($validador->fails()) {
            \Log::error('Validation failed:', $validador->errors()->all());

            return redirect()->back()
                ->withErrors($validador)
                ->withInput();
        }

        $resultados = [];
        $errores = [];
        $totalRolesAsignados = 0;

        \DB::beginTransaction();
        try {
            foreach ($solicitud->assignments as $personaId => $rolesData) {
                $persona = Persona::findOrFail($personaId);
                $rolesIds = is_array($rolesData) ? $rolesData : [$rolesData];

                // Desactivar todos los roles existentes de la persona
                \DB::table('persona_roles')
                    ->where('id_persona', $personaId)
                    ->update(['estado' => 'Inactivo']);

                // Activar los roles asignados
                foreach ($rolesIds as $rolId) {
                    \DB::table('persona_roles')
                        ->updateOrInsert(
                            ['id_persona' => $personaId, 'id_rol' => $rolId],
                            ['estado' => 'Activo']
                        );

                    $totalRolesAsignados++;

                    // Crear registros específicos según el rol
                    // Buscar datos de configuración en la sesión o request
                    $configData = null;
                    if (session()->has('role_config_'.$personaId.'_'.$rolId)) {
                        $configData = session('role_config_'.$personaId.'_'.$rolId);
                        session()->forget('role_config_'.$personaId.'_'.$rolId);
                    }

                    $this->crearRegistroEspecificoRol($persona, $rolId, $configData);
                }

                // Crear usuario automáticamente si no existe (solo para el primer rol)
                $usuarioCreado = false;
                $credenciales = null;

                if (! $persona->usuario) {
                    $primerRolId = reset($rolesIds);
                    $primerRol = Rol::findOrFail($primerRolId);
                    $resultadoCreacion = Usuario::crearUsuarioAutomatico($persona, $primerRol);
                    $credenciales = $resultadoCreacion['credenciales'];
                    $usuarioCreado = true;
                }

                // Obtener todos los roles asignados para mostrar en resultados
                $rolesAsignados = Rol::whereIn('id_rol', $rolesIds)->get();

                $resultados[] = [
                    'persona' => $persona,
                    'roles' => $rolesAsignados,
                    'usuario_creado' => $usuarioCreado,
                    'credenciales' => $credenciales,
                ];
            }

            \DB::commit();

        } catch (\Exception $e) {
            \DB::rollback();
            \Log::error('Error en asignación de roles:', ['error' => $e->getMessage()]);

            return redirect()->back()
                ->with('error', 'Error al procesar las asignaciones: '.$e->getMessage())
                ->withInput();
        }

        $mensaje = count($resultados).' personas procesadas exitosamente con '.$totalRolesAsignados.' roles asignados.';

        return redirect()->route('asignacion-roles.index')
            ->with('success', $mensaje)
            ->with('resultados', $resultados);
    }

    /**
     * Crear o actualizar registro específico según el rol asignado
     */
    private function crearOActualizarRegistroEspecificoRol(Persona $persona, $rolId, $configData = null)
    {
        \Log::info('=== DATOS EN crearOActualizarRegistroEspecificoRol ===', [
            'persona_id' => $persona->id_persona,
            'rol_id' => $rolId,
            'rol_nombre' => Rol::find($rolId)->nombre,
            'config_data' => $configData,
        ]);

        $rol = Rol::find($rolId);

        switch ($rol->nombre) {
            case 'Docente':
                $docenteData = [
                    'id_persona' => $persona->id_persona,
                    'estado' => 'Activo', // Siempre activo cuando se asigna
                ];

                // Los datos pueden venir anidados bajo 'docente' o directamente
                $docenteConfig = isset($configData['docente']) ? $configData['docente'] : $configData;

                \Log::info('=== DATOS DOCENTE CONFIG ===', [
                    'docenteConfig' => $docenteConfig,
                    'configData' => $configData,
                ]);

                // Combinar email universitario - verificar si viene como email completo o separado
                // Primero buscar en docenteConfig (datos anidados)
                if (isset($docenteConfig['emailUniversidad'])) {
                    // Email completo
                    $docenteData['emailUniversidad'] = $docenteConfig['emailUniversidad'];
                } elseif (isset($docenteConfig['emailUniversidad_username'])) {
                    // Email separado - combinar
                    $domain = $docenteConfig['emailUniversidad_domain'] ?? 'unitru.edu.pe';
                    $docenteData['emailUniversidad'] = $docenteConfig['emailUniversidad_username'].'@'.$domain;
                }
                // Si no está en docenteConfig, buscar en el nivel superior (campos sin corchetes)
                elseif (isset($configData['docente_emailUniversidad_username'])) {
                    $domain = $configData['docente_emailUniversidad_domain'] ?? 'unitru.edu.pe';
                    $docenteData['emailUniversidad'] = $configData['docente_emailUniversidad_username'].'@'.$domain;
                }

                // Campo opcional - buscar tanto en anidados como no anidados
                if (isset($docenteConfig['fecha_contratacion']) && $docenteConfig['fecha_contratacion']) {
                    $docenteData['fecha_contratacion'] = $docenteConfig['fecha_contratacion'];
                }

                \Log::info('=== DATOS DOCENTE A GUARDAR ===', [
                    'docenteData' => $docenteData,
                ]);

                // Buscar docente existente (sin importar estado)
                $docente = \App\Models\Docente::where('id_persona', $persona->id_persona)->first();

                \Log::info('=== DOCENTE ENCONTRADO ===', [
                    'docente_existente' => $docente ? $docente->toArray() : null,
                ]);

                if ($docente) {
                    // Actualizar docente existente
                    $resultado = $docente->update($docenteData);
                    \Log::info('=== RESULTADO UPDATE DOCENTE ===', [
                        'update_result' => $resultado,
                        'docente_despues' => $docente->fresh()->toArray(),
                    ]);

                    // Actualizar especialidades (activar las seleccionadas, preservar las inactivas)
                    \Log::info('=== ACTUALIZANDO ESPECIALIDADES ===');

                    if (isset($docenteConfig['especialidades']) && is_array($docenteConfig['especialidades'])) {
                        $especialidadesIds = array_filter($docenteConfig['especialidades']); // Remover valores vacíos
                        \Log::info('=== ESPECIALIDADES A ACTIVAR ===', [
                            'especialidades_recibidas' => $docenteConfig['especialidades'],
                            'especialidades_filtradas' => $especialidadesIds,
                            'tipo_datos' => gettype($docenteConfig['especialidades']),
                            'conteo' => count($docenteConfig['especialidades']),
                        ]);

                        // Debug: mostrar cada especialidad individualmente
                        foreach ($docenteConfig['especialidades'] as $index => $esp) {
                            \Log::info('=== ESPECIALIDAD INDIVIDUAL ===', [
                                'index' => $index,
                                'valor' => $esp,
                                'tipo' => gettype($esp),
                            ]);
                        }

                        if (! empty($especialidadesIds)) {
                            // Validar que las especialidades existen y están activas
                            $especialidadesValidas = \DB::table('especialidades')
                                ->whereIn('id_especialidad', $especialidadesIds)
                                ->where('estado', 'Activo')
                                ->pluck('id_especialidad')
                                ->toArray();

                            \Log::info('=== ESPECIALIDADES VALIDADAS ===', [
                                'solicitadas' => $especialidadesIds,
                                'validas' => $especialidadesValidas
                            ]);

                            // Solo procesar especialidades válidas
                            foreach ($especialidadesValidas as $especialidadId) {
                                $existingRelation = \DB::table('docente_especialidad')
                                    ->where('id_docente', $docente->id_docente)
                                    ->where('id_especialidad', $especialidadId)
                                    ->first();

                                if ($existingRelation) {
                                    // Si existe, activarla si no está activa
                                    if ($existingRelation->estado !== 'Activo') {
                                        \DB::table('docente_especialidad')
                                            ->where('id_docente', $docente->id_docente)
                                            ->where('id_especialidad', $especialidadId)
                                            ->update(['estado' => 'Activo']);
                                        \Log::info('=== ESPECIALIDAD REACTIVADA ===', ['id_especialidad' => $especialidadId]);
                                    } else {
                                        \Log::info('=== ESPECIALIDAD YA ACTIVA ===', ['id_especialidad' => $especialidadId]);
                                    }
                                } else {
                                    // Si no existe, crear nueva relación
                                    \DB::table('docente_especialidad')->insert([
                                        'id_docente' => $docente->id_docente,
                                        'id_especialidad' => $especialidadId,
                                        'estado' => 'Activo',
                                    ]);
                                    \Log::info('=== ESPECIALIDAD VINCULADA ===', ['id_especialidad' => $especialidadId]);
                                }
                            }

                            // Log especialidades inválidas
                            $especialidadesInvalidas = array_diff($especialidadesIds, $especialidadesValidas);
                            if (!empty($especialidadesInvalidas)) {
                                \Log::warning('=== ESPECIALIDADES INVALIDAS IGNORADAS ===', ['ids' => $especialidadesInvalidas]);
                            }
                        } else {
                            \Log::info('=== NO HAY ESPECIALIDADES PARA ACTIVAR ===');
                        }
                    } else {
                        \Log::info('=== NO SE ENCONTRARON ESPECIALIDADES EN CONFIG ===', [
                            'docenteConfig_keys' => array_keys($docenteConfig),
                            'especialidades_exists' => isset($docenteConfig['especialidades']),
                            'especialidades_value' => $docenteConfig['especialidades'] ?? 'NO EXISTE',
                        ]);
                    }
                } else {
                    // Crear docente nuevo
                    $docente = \App\Models\Docente::create($docenteData);
                    \Log::info('=== DOCENTE CREADO ===', [
                        'docente_nuevo' => $docente->toArray(),
                    ]);

                    // Manejar especialidades múltiples (relación muchos a muchos)
                    if (isset($docenteConfig['especialidades']) && is_array($docenteConfig['especialidades'])) {
                        $especialidadesIds = array_filter($docenteConfig['especialidades']); // Remover valores vacíos
                        if (! empty($especialidadesIds)) {
                            // Para cada especialidad seleccionada, crear relación con estado Activo
                            foreach ($especialidadesIds as $especialidadId) {
                                \DB::table('docente_especialidad')->insert([
                                    'id_docente' => $docente->id_docente,
                                    'id_especialidad' => $especialidadId,
                                    'estado' => 'Activo',
                                ]);
                                \Log::info('=== ESPECIALIDAD VINCULADA (NUEVO DOCENTE) ===', ['id_especialidad' => $especialidadId]);
                            }
                        }
                    }
                }
                break;

            case 'Estudiante':
                $estudianteData = [
                    'id_persona' => $persona->id_persona,
                    'estado' => 'Activo', // Los estudiantes siempre se crean como activos
                ];

                // Los datos pueden venir anidados bajo 'estudiante' o directamente
                $estudianteConfig = isset($configData['estudiante']) ? $configData['estudiante'] : $configData;

                \Log::info('=== DATOS ESTUDIANTE CONFIG ===', [
                    'estudianteConfig' => $estudianteConfig,
                    'configData' => $configData,
                ]);

                // Combinar email universitario - verificar si viene como email completo o separado
                // Primero buscar en estudianteConfig (datos anidados)
                if (isset($estudianteConfig['emailUniversidad'])) {
                    // Email completo
                    $estudianteData['emailUniversidad'] = $estudianteConfig['emailUniversidad'];
                } elseif (isset($estudianteConfig['emailUniversidad_username'])) {
                    // Email separado - combinar
                    $domain = $estudianteConfig['emailUniversidad_domain'] ?? 'unitru.edu.pe';
                    $estudianteData['emailUniversidad'] = $estudianteConfig['emailUniversidad_username'].'@'.$domain;
                }
                // Si no está en estudianteConfig, buscar en el nivel superior (campos sin corchetes)
                elseif (isset($configData['estudiante_emailUniversidad_username'])) {
                    $domain = $configData['estudiante_emailUniversidad_domain'] ?? 'unitru.edu.pe';
                    $estudianteData['emailUniversidad'] = $configData['estudiante_emailUniversidad_username'].'@'.$domain;
                }

                // Campos requeridos
                if (isset($estudianteConfig['anio_ingreso']) && $estudianteConfig['anio_ingreso']) {
                    $estudianteData['anio_ingreso'] = $estudianteConfig['anio_ingreso'];
                }

                if (isset($estudianteConfig['id_escuela']) && $estudianteConfig['id_escuela']) {
                    $estudianteData['id_escuela'] = $estudianteConfig['id_escuela'];
                }

                if (isset($estudianteConfig['id_curricula']) && $estudianteConfig['id_curricula']) {
                    $estudianteData['id_curricula'] = $estudianteConfig['id_curricula'];
                }

                // Campos opcionales
                if (isset($estudianteConfig['anio_egreso']) && $estudianteConfig['anio_egreso']) {
                    $estudianteData['anio_egreso'] = $estudianteConfig['anio_egreso'];
                }

                \Log::info('=== DATOS ESTUDIANTE A GUARDAR ===', [
                    'estudianteData' => $estudianteData,
                ]);

                // Buscar estudiante existente (sin importar estado)
                $estudiante = \App\Models\Estudiante::where('id_persona', $persona->id_persona)->first();

                \Log::info('=== ESTUDIANTE ENCONTRADO ===', [
                    'estudiante_existente' => $estudiante ? $estudiante->toArray() : null,
                ]);

                if ($estudiante) {
                    // Actualizar estudiante existente
                    $resultado = $estudiante->update($estudianteData);
                    \Log::info('=== RESULTADO UPDATE ESTUDIANTE ===', [
                        'update_result' => $resultado,
                        'estudiante_despues' => $estudiante->fresh()->toArray(),
                    ]);
                } else {
                    // Crear estudiante nuevo
                    $estudiante = \App\Models\Estudiante::create($estudianteData);
                    \Log::info('=== ESTUDIANTE CREADO ===', [
                        'estudiante_nuevo' => $estudiante->toArray(),
                    ]);
                }
                break;

            case 'Secretaria':
                $secretariaData = [
                    'id_persona' => $persona->id_persona,
                    'estado' => 'Activo', // Siempre activo cuando se asigna
                ];

                // Los datos pueden venir anidados bajo 'secretaria' o directamente
                $secretariaConfig = isset($configData['secretaria']) ? $configData['secretaria'] : $configData;

                \Log::info('=== DATOS SECRETARIA CONFIG ===', [
                    'secretariaConfig' => $secretariaConfig,
                    'configData' => $configData,
                ]);

                // Combinar email universitario - verificar si viene como email completo o separado
                if (isset($secretariaConfig['emailUniversidad'])) {
                    // Email completo
                    $secretariaData['emailUniversidad'] = $secretariaConfig['emailUniversidad'];
                } elseif (isset($secretariaConfig['emailUniversidad_username'])) {
                    // Email separado - combinar
                    $domain = $secretariaConfig['emailUniversidad_domain'] ?? 'unitru.edu.pe';
                    $secretariaData['emailUniversidad'] = $secretariaConfig['emailUniversidad_username'].'@'.$domain;
                }

                // Campo opcional
                if (isset($secretariaConfig['fecha_ingreso']) && $secretariaConfig['fecha_ingreso']) {
                    $secretariaData['fecha_ingreso'] = $secretariaConfig['fecha_ingreso'];
                }

                \Log::info('=== DATOS SECRETARIA A GUARDAR ===', [
                    'secretariaData' => $secretariaData,
                ]);

                // Buscar secretaria existente (sin importar estado)
                $secretaria = \App\Models\Secretaria::where('id_persona', $persona->id_persona)->first();

                \Log::info('=== SECRETARIA ENCONTRADA ===', [
                    'secretaria_existente' => $secretaria ? $secretaria->toArray() : null,
                ]);

                if ($secretaria) {
                    // Actualizar secretaria existente
                    $resultado = $secretaria->update($secretariaData);
                    \Log::info('=== RESULTADO UPDATE SECRETARIA ===', [
                        'update_result' => $resultado,
                        'secretaria_despues' => $secretaria->fresh()->toArray(),
                    ]);
                } else {
                    // Top-level field
                    $processedConfigData[$key] = $value;
                    \Log::info('=== CAMPO TOP-LEVEL ===', ['key' => $key, 'value' => $value]);
                }
        }
    }

    /**
     * Crear registro específico según el rol asignado (método legacy para compatibilidad)
     */
    private function crearRegistroEspecificoRol(Persona $persona, $rolId, $configData = null)
    {
        // Redirigir al nuevo método que maneja creación y actualización
        $this->crearOActualizarRegistroEspecificoRol($persona, $rolId, $configData);
    }

    /**
     * Cargar formulario específico para un rol via AJAX.
     */
    public function getForm($roleId, $personaId)
    {
        // Verificar permisos basado en el rol ACTIVO actual
        $user = auth()->user();
        $currentRole = $user->getCurrentRole();

        if (! $currentRole || ! in_array($currentRole->nombre, ['Administrador', 'Secretaria'])) {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }

        $rol = Rol::findOrFail($roleId);
        $persona = Persona::findOrFail($personaId);

        // Cargar datos necesarios para los formularios
        $especialidades = Especialidad::where('estado', 'Activo')->get();
        $escuelas = Escuela::where('estado', 'Activo')->get();
        $curriculas = Curricula::with('escuela')->where('estado', 'Vigente')->get();
        $roles = Rol::where('estado', 'Activo')->get();

        // Determinar qué formulario cargar según el rol
        // Usar los mismos formularios que en creación/edición pero adaptados para modal
        switch ($rol->nombre) {
            case 'Docente':
                return view('cpersonas.forms.docente_modal', [
                    'persona' => $persona,
                    'especialidades' => $especialidades,
                ])->render();

            case 'Estudiante':
                return view('cpersonas.forms.estudiante_modal', [
                    'persona' => $persona,
                    'escuelas' => $escuelas,
                    'curriculas' => $curriculas,
                ])->render();

            case 'Secretaria':
                return view('cpersonas.forms.secretaria_modal', [
                    'persona' => $persona,
                ])->render();

            case 'Administrador':
                // Administradores no requieren configuración adicional
                return view('cpersonas.forms.administrador_modal', [
                    'persona' => $persona,
                ])->render();

            case 'Representante':
                return view('cpersonas.forms.representante_modal', [
                    'persona' => $persona,
                ])->render();

            default:
                return response()->json(['error' => 'Formulario no disponible para este rol'], 404);
        }
    }

    /**
     * Guardar configuración de rol en sesión via AJAX.
     */
    public function saveConfig(Request $request)
    {
        // Verificar permisos basado en el rol ACTIVO actual
        $user = auth()->user();
        $currentRole = $user->getCurrentRole();

        if (! $currentRole || ! in_array($currentRole->nombre, ['Administrador', 'Secretaria'])) {
            return response()->json(['success' => false, 'message' => 'No tienes permisos para acceder a esta sección.'], 403);
        }

        $request->validate([
            'persona_id' => 'required|integer',
            'role_id' => 'required|integer',
            'config_data' => 'required|array',
        ]);

        $personaId = $request->persona_id;
        $roleId = $request->role_id;
        $configData = $request->config_data;

        \Log::info('=== DATOS RECIBIDOS EN saveConfig ===', [
            'persona_id' => $personaId,
            'role_id' => $roleId,
            'config_data' => $configData,
            'all_request_data' => $request->all(),
        ]);

        // Guardar en sesión con una clave única
        $sessionKey = 'role_config_'.$personaId.'_'.$roleId;
        session([$sessionKey => $configData]);

        return response()->json(['success' => true, 'message' => 'Configuración guardada correctamente']);
    }

    /**
     * Asignar un rol individual a una persona via AJAX.
     */
    public function asignarRol(Request $request)
    {
        // Verificar permisos basado en el rol ACTIVO actual
        $user = auth()->user();
        $currentRole = $user->getCurrentRole();

        if (! $currentRole || ! in_array($currentRole->nombre, ['Administrador', 'Secretaria'])) {
            return response()->json(['success' => false, 'message' => 'No tienes permisos para acceder a esta sección.'], 403);
        }

        $request->validate([
            'persona_id' => 'required|integer|exists:personas,id_persona',
            'role_id' => 'required|integer|exists:roles,id_rol',
            'config_data' => 'nullable|array',
        ]);

        $personaId = $request->persona_id;
        $roleId = $request->role_id;
        $configData = $request->config_data ?: [];

        // Log all request data for debugging
        \Log::info('=== TODOS LOS DATOS DEL REQUEST ===', [
            'all_request_data' => $request->all(),
            'config_data_raw' => $request->input('config_data'),
            'input_data' => $request->input(),
            'post_data' => $_POST ?? 'N/A',
        ]);

        // Process array fields that come as "field[]":"value" instead of arrays
        $processedConfigData = [];
        \Log::info('=== PROCESANDO CONFIG DATA ===', ['raw_config' => $configData]);

        foreach ($configData as $key => $value) {
            \Log::info('=== PROCESANDO KEY ===', ['key' => $key, 'value' => $value]);

            // Handle array notation like "docente[especialidades][]"
            $startBracket = strpos($key, '[');
            if ($startBracket !== false) {
                // Check if this is array notation ending with []
                $arrayPos = strpos($key, '[]', $startBracket);
                if ($arrayPos !== false) {
                    // Array notation: prefix[field[]]
                    $prefix = substr($key, 0, $startBracket);
                    $field = substr($key, $startBracket + 1, $arrayPos - $startBracket - 1) . '[]';

                    \Log::info('=== MATCH ARRAY NOTATION ===', ['key' => $key, 'prefix' => $prefix, 'field' => $field]);

                    if (! isset($processedConfigData[$prefix])) {
                        $processedConfigData[$prefix] = [];
                    }

                    // Handle array fields (ending with [])
                    if (str_ends_with($field, '[]')) {
                        $arrayField = substr($field, 0, -2); // Remove []
                        \Log::info('=== PROCESANDO ARRAY FIELD ===', ['arrayField' => $arrayField]);

                        if (! isset($processedConfigData[$prefix][$arrayField])) {
                            $processedConfigData[$prefix][$arrayField] = [];
                        }
                        // Convert single value to array or add to existing array
                        if (is_array($value)) {
                            $processedConfigData[$prefix][$arrayField] = array_merge($processedConfigData[$prefix][$arrayField], $value);
                        } else {
                            $processedConfigData[$prefix][$arrayField][] = $value;
                            \Log::info('=== VALOR AGREGADO A ARRAY ===', ['array' => $processedConfigData[$prefix][$arrayField]]);
                        }
                    }
                } else {
                    // Regular bracket notation: prefix[field]
                    $endBracket = strpos($key, ']', $startBracket);
                    if ($endBracket !== false && $endBracket > $startBracket) {
                        $prefix = substr($key, 0, $startBracket);
                        $field = substr($key, $startBracket + 1, $endBracket - $startBracket - 1);

                        \Log::info('=== MATCH REGULAR BRACKET ===', ['key' => $key, 'prefix' => $prefix, 'field' => $field]);

                        if (! isset($processedConfigData[$prefix])) {
                            $processedConfigData[$prefix] = [];
                        }

                        // Regular field
                        $processedConfigData[$prefix][$field] = $value;
                        \Log::info('=== CAMPO REGULAR AGREGADO ===', ['field' => $field, 'value' => $value]);
                    } else {
                        // Malformed bracket notation, treat as top-level field
                        $processedConfigData[$key] = $value;
                        \Log::info('=== CAMPO TOP-LEVEL (MALFORMED BRACKETS) ===', ['key' => $key, 'value' => $value]);
                    }
                }
            } else {
                // Top-level field
                $processedConfigData[$key] = $value;
                \Log::info('=== CAMPO TOP-LEVEL ===', ['key' => $key, 'value' => $value]);
            }

        }

        \Log::info('=== CONFIG DATA PROCESADA ===', ['processed' => $processedConfigData]);

        // Also process nested docente object if it exists
        if (isset($processedConfigData['docente']) && is_array($processedConfigData['docente'])) {
            $docenteProcessed = [];
            foreach ($processedConfigData['docente'] as $key => $value) {
                // Handle malformed keys like "especialidades]" (missing opening bracket)
                if (str_ends_with($key, ']') && !str_starts_with($key, '[')) {
                    // This is likely a malformed array key, fix it
                    $cleanKey = rtrim($key, ']');
                    if (!isset($docenteProcessed[$cleanKey])) {
                        $docenteProcessed[$cleanKey] = [];
                    }
                    if (is_array($value)) {
                        $docenteProcessed[$cleanKey] = array_merge($docenteProcessed[$cleanKey], $value);
                    } else {
                        $docenteProcessed[$cleanKey][] = $value;
                    }
                } else {
                    // Handle array notation in nested docente object
                    $startBracket = strpos($key, '[');
                    if ($startBracket !== false) {
                        $arrayPos = strpos($key, '[]', $startBracket);
                        if ($arrayPos !== false) {
                            $field = substr($key, $startBracket + 1, $arrayPos - $startBracket - 1) . '[]';
                            if (str_ends_with($field, '[]')) {
                                $arrayField = substr($field, 0, -2);
                                if (!isset($docenteProcessed[$arrayField])) {
                                    $docenteProcessed[$arrayField] = [];
                                }
                                if (is_array($value)) {
                                    $docenteProcessed[$arrayField] = array_merge($docenteProcessed[$arrayField], $value);
                                } else {
                                    $docenteProcessed[$arrayField][] = $value;
                                }
                            }
                        } else {
                            $endBracket = strpos($key, ']', $startBracket);
                            if ($endBracket !== false) {
                                $field = substr($key, $startBracket + 1, $endBracket - $startBracket - 1);
                                $docenteProcessed[$field] = $value;
                            } else {
                                $docenteProcessed[$key] = $value;
                            }
                        }
                    } else {
                        $docenteProcessed[$key] = $value;
                    }
                }
            }
            $processedConfigData['docente'] = $docenteProcessed;
        }

        // Use processed data
        $configData = $processedConfigData;

        \Log::info('=== DATOS RECIBIDOS EN asignarRol ===', [
            'persona_id' => $personaId,
            'role_id' => $roleId,
            'config_data_raw' => $request->config_data,
            'config_data_processed' => $configData,
            'session_has_config' => session()->has('role_config_'.$personaId.'_'.$roleId),
            'session_config' => session('role_config_'.$personaId.'_'.$roleId),
        ]);

        $persona = Persona::with(['docente', 'estudiante', 'secretaria'])->findOrFail($personaId);
        $rol = Rol::findOrFail($roleId);

        \DB::beginTransaction();
        try {
            // Verificar si ya tiene este rol asignado
            $asignacionExistente = \DB::table('persona_roles')
                ->where('id_persona', $personaId)
                ->where('id_rol', $roleId)
                ->first();

            if ($asignacionExistente) {
                // Si existe, reactivarla
                \DB::table('persona_roles')
                    ->where('id_persona', $personaId)
                    ->where('id_rol', $roleId)
                    ->update(['estado' => 'Activo']);

                // Reactivar el registro específico si existe
                $this->reactivarRegistroEspecificoPorRol($persona, $rol);

                $mensaje = 'Rol reactivado exitosamente';
            } else {
                // Si no existe, crear nueva asignación
                $persona->roles()->syncWithoutDetaching([$roleId => ['estado' => 'Activo']]);
                $mensaje = 'Rol asignado exitosamente';
            }

            // Buscar datos de configuración en la sesión o usar los datos que llegaron directamente
            $finalConfigData = $configData;
            if (empty($finalConfigData) && session()->has('role_config_'.$personaId.'_'.$roleId)) {
                $finalConfigData = session('role_config_'.$personaId.'_'.$roleId);
                session()->forget('role_config_'.$personaId.'_'.$roleId);

                \Log::info('=== USANDO DATOS DE SESION ===', ['session_data' => $finalConfigData]);

                // Process array fields in session data too
                $processedSessionData = [];
                foreach ($finalConfigData as $key => $value) {
                    // Handle array notation like "docente[especialidades][]"
                    $startBracket = strpos($key, '[');
                    if ($startBracket !== false) {
                        // Check if this is array notation ending with []
                        $arrayPos = strpos($key, '[]', $startBracket);
                        if ($arrayPos !== false) {
                            // Array notation: prefix[field[]]
                            $prefix = substr($key, 0, $startBracket);
                            $field = substr($key, $startBracket + 1, $arrayPos - $startBracket - 1) . '[]';

                            if (! isset($processedSessionData[$prefix])) {
                                $processedSessionData[$prefix] = [];
                            }

                            // Handle array fields (ending with [])
                            if (str_ends_with($field, '[]')) {
                                $arrayField = substr($field, 0, -2); // Remove []
                                if (! isset($processedSessionData[$prefix][$arrayField])) {
                                    $processedSessionData[$prefix][$arrayField] = [];
                                }
                                // Convert single value to array or add to existing array
                                if (is_array($value)) {
                                    $processedSessionData[$prefix][$arrayField] = array_merge($processedSessionData[$prefix][$arrayField], $value);
                                } else {
                                    $processedSessionData[$prefix][$arrayField][] = $value;
                                }
                            }
                        } else {
                            // Regular bracket notation: prefix[field]
                            $endBracket = strpos($key, ']', $startBracket);
                            if ($endBracket !== false && $endBracket > $startBracket) {
                                $prefix = substr($key, 0, $startBracket);
                                $field = substr($key, $startBracket + 1, $endBracket - $startBracket - 1);

                                if (! isset($processedSessionData[$prefix])) {
                                    $processedSessionData[$prefix] = [];
                                }

                                // Regular field
                                $processedSessionData[$prefix][$field] = $value;
                            } else {
                                // Malformed bracket notation, treat as top-level field
                                $processedSessionData[$key] = $value;
                            }
                        }
                    } else {
                        // Top-level field
                        $processedSessionData[$key] = $value;
                    }
                }

                // Also process nested docente object in session data if it exists
                if (isset($processedSessionData['docente']) && is_array($processedSessionData['docente'])) {
                    $docenteProcessed = [];
                    foreach ($processedSessionData['docente'] as $key => $value) {
                        // Handle malformed keys like "especialidades]" (missing opening bracket)
                        if (str_ends_with($key, ']') && !str_starts_with($key, '[')) {
                            // This is likely a malformed array key, fix it
                            $cleanKey = rtrim($key, ']');
                            if (!isset($docenteProcessed[$cleanKey])) {
                                $docenteProcessed[$cleanKey] = [];
                            }
                            if (is_array($value)) {
                                $docenteProcessed[$cleanKey] = array_merge($docenteProcessed[$cleanKey], $value);
                            } else {
                                $docenteProcessed[$cleanKey][] = $value;
                            }
                        } else {
                            // Handle array notation in nested docente object
                            $startBracket = strpos($key, '[');
                            if ($startBracket !== false) {
                                $arrayPos = strpos($key, '[]', $startBracket);
                                if ($arrayPos !== false) {
                                    $field = substr($key, $startBracket + 1, $arrayPos - $startBracket - 1) . '[]';
                                    if (str_ends_with($field, '[]')) {
                                        $arrayField = substr($field, 0, -2);
                                        if (!isset($docenteProcessed[$arrayField])) {
                                            $docenteProcessed[$arrayField] = [];
                                        }
                                        if (is_array($value)) {
                                            $docenteProcessed[$arrayField] = array_merge($docenteProcessed[$arrayField], $value);
                                        } else {
                                            $docenteProcessed[$arrayField][] = $value;
                                        }
                                    }
                                } else {
                                    $endBracket = strpos($key, ']', $startBracket);
                                    if ($endBracket !== false) {
                                        $field = substr($key, $startBracket + 1, $endBracket - $startBracket - 1);
                                        $docenteProcessed[$field] = $value;
                                    } else {
                                        $docenteProcessed[$key] = $value;
                                    }
                                }
                            } else {
                                $docenteProcessed[$key] = $value;
                            }
                        }
                    }
                    $processedSessionData['docente'] = $docenteProcessed;
                }

                $finalConfigData = $processedSessionData;
                \Log::info('=== DATOS DE SESION PROCESADOS ===', ['processed_session_data' => $finalConfigData]);
            }

            // Crear o actualizar registro específico según el rol asignado
            $this->crearOActualizarRegistroEspecificoRol($persona, $rol->id_rol, $finalConfigData);

            // Crear usuario automáticamente si no existe
            $usuarioCreado = false;
            $credencialesUsuario = null;
            if (! $persona->usuario) {
                $resultadoCreacion = Usuario::crearUsuarioAutomatico($persona, $rol);
                $credencialesUsuario = $resultadoCreacion['credenciales'];
                $usuarioCreado = true;
            }

            \DB::commit();

            $mensajeCompleto = $mensaje;
            if ($usuarioCreado && $credencialesUsuario) {
                $mensajeCompleto .= ". Usuario creado con credenciales enviadas por email: {$credencialesUsuario['username']} ({$credencialesUsuario['email']})";
            }

            return response()->json([
                'success' => true,
                'message' => $mensajeCompleto,
            ]);

        } catch (\Exception $e) {
            \DB::rollback();
            \Log::error('Error asignando rol individual:', ['error' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'Error al asignar el rol: '.$e->getMessage(),
            ], 500);
        }
    }

    /**
     * Desasignar un rol individual de una persona via AJAX.
     */
    public function desasignarRol(Request $request)
    {
        // Verificar permisos basado en el rol ACTIVO actual
        $user = auth()->user();
        $currentRole = $user->getCurrentRole();

        if (! $currentRole || ! in_array($currentRole->nombre, ['Administrador', 'Secretaria'])) {
            return response()->json(['success' => false, 'message' => 'No tienes permisos para acceder a esta sección.'], 403);
        }

        $request->validate([
            'persona_id' => 'required|integer|exists:personas,id_persona',
            'role_id' => 'required|integer|exists:roles,id_rol',
        ]);

        $personaId = $request->persona_id;
        $roleId = $request->role_id;

        $persona = Persona::with(['docente', 'estudiante', 'secretaria'])->findOrFail($personaId);
        $rol = Rol::findOrFail($roleId);

        \DB::beginTransaction();
        try {
            // Desactivar la asignación del rol
            $persona->roles()->updateExistingPivot($roleId, ['estado' => 'Inactivo']);

            // Desactivar el registro específico del rol
            $this->desactivarRegistroEspecificoPorRol($persona, $rol);

            \DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Rol '{$rol->nombre}' desasignado exitosamente",
            ]);

        } catch (\Exception $e) {
            \DB::rollback();
            \Log::error('Error desasignando rol individual:', ['error' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'Error al desasignar el rol: '.$e->getMessage(),
            ], 500);
        }
    }

    /**
     * Reactivar registro específico según el rol reasignado
     */
    private function reactivarRegistroEspecificoPorRol($persona, $rol)
    {
        try {
            switch ($rol->nombre) {
                case 'Docente':
                    if ($persona->docente && $persona->docente->estado === 'Inactivo') {
                        $persona->docente->update(['estado' => 'Activo']);
                        \Log::info('Docente reactivado para persona ID: '.$persona->id_persona);
                    }
                    break;

                case 'Estudiante':
                    if ($persona->estudiante && $persona->estudiante->estado === 'Inactivo') {
                        $persona->estudiante->update(['estado' => 'Activo']);
                        \Log::info('Estudiante reactivado para persona ID: '.$persona->id_persona);
                    }
                    break;

                case 'Secretaria':
                    if ($persona->secretaria && $persona->secretaria->estado === 'Inactivo') {
                        $persona->secretaria->update(['estado' => 'Activo']);
                        \Log::info('Secretaria reactivada para persona ID: '.$persona->id_persona);
                    }
                    break;
            }
        } catch (\Exception $e) {
            // Log error but don't stop the process
            \Log::error('Error reactivando registro específico para rol '.$rol->nombre.': '.$e->getMessage());
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
                    $docente = \App\Models\Docente::where('id_persona', $persona->id_persona)->first();
                    if ($docente && $docente->estado === 'Activo') {
                        $docente->update(['estado' => 'Inactivo']);
                        \Log::info('Docente desactivado para persona ID: '.$persona->id_persona);

                        // Also deactivate all docente-especialidad relationships
                        $deactivatedCount = \DB::table('docente_especialidad')
                            ->where('id_docente', $docente->id_docente)
                            ->where('estado', 'Activo')
                            ->update(['estado' => 'Inactivo']);

                        \Log::info('Relaciones docente-especialidad desactivadas: '.$deactivatedCount.' para docente ID: '.$docente->id_docente);
                    }
                    break;

                case 'Estudiante':
                    $estudiante = \App\Models\Estudiante::where('id_persona', $persona->id_persona)->first();
                    if ($estudiante && $estudiante->estado === 'Activo') {
                        $estudiante->update(['estado' => 'Inactivo']);
                        \Log::info('Estudiante desactivado para persona ID: '.$persona->id_persona);
                    }
                    break;

                case 'Secretaria':
                    $secretaria = \App\Models\Secretaria::where('id_persona', $persona->id_persona)->first();
                    if ($secretaria && $secretaria->estado === 'Activo') {
                        $secretaria->update(['estado' => 'Inactivo']);
                        \Log::info('Secretaria desactivada para persona ID: '.$persona->id_persona);
                    }
                    break;
            }
        } catch (\Exception $e) {
            // Log error but don't stop the process
            \Log::error('Error desactivando registro específico para rol '.$rol->nombre.': '.$e->getMessage());
        }
    }

    /**
     * Mostrar resultados de asignación.
     */
    public function resultados()
    {
        // Verificar permisos basado en el rol ACTIVO actual
        $user = auth()->user();
        $currentRole = $user->getCurrentRole();

        if (! $currentRole || ! in_array($currentRole->nombre, ['Administrador', 'Secretaria'])) {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }

        return view('casignacionroles.resultados');
    }
}
