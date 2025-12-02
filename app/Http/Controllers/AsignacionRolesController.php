<?php

namespace App\Http\Controllers;

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
            'all_roles' => $user->getActiveRoles()->pluck('nombre')->toArray()
        ]);

        // Solo permitir acceso si el rol ACTIVO es Administrador o Secretaria
        if (!$currentRole || !in_array($currentRole->nombre, ['Administrador', 'Secretaria'])) {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }

        // Verificar si es una petición AJAX para búsqueda
        if ($solicitud->ajax() && $solicitud->isMethod('post')) {
            return $this->ajaxSearch($solicitud);
        }

        $buscarpor = $solicitud->get('buscarpor');
        $estado_filtro = $solicitud->get('estado_filtro');
        $ordenar_por = $solicitud->get('ordenar_por', 'nombres');

        // Mostrar todas las personas activas para permitir asignación de roles adicionales
        $personasSinRoles = Persona::where('estado', 'Activo')
            ->when($estado_filtro, function($query) use ($estado_filtro) {
                return $query->where('estado', $estado_filtro);
            })
            ->when($buscarpor, function($query) use ($buscarpor) {
                $query->where(function($q) use ($buscarpor) {
                    $q->where('nombres', 'like', '%' . $buscarpor . '%')
                      ->orWhere('apellidos', 'like', '%' . $buscarpor . '%')
                      ->orWhere('dni', 'like', '%' . $buscarpor . '%')
                      ->orWhere('email', 'like', '%' . $buscarpor . '%')
                      ->orWhere('telefono', 'like', '%' . $buscarpor . '%');
                });
            })
            ->orderBy($ordenar_por)
            ->when($ordenar_por === 'nombres', function($query) {
                $query->orderBy('apellidos');
            })
            ->paginate(10);

        $roles = Rol::where('estado', 'Activo')->get();

        return view('casignacionroles.index', compact('personasSinRoles', 'roles', 'buscarpor', 'estado_filtro', 'ordenar_por'));
    }

    /**
     * Búsqueda AJAX para personas.
     */
    private function ajaxSearch(Request $solicitud)
    {
        $buscarpor = $solicitud->get('buscarpor');

        $personasSinRoles = Persona::where('estado', 'Activo')
            ->when($buscarpor, function($query) use ($buscarpor) {
                $query->where(function($q) use ($buscarpor) {
                    $q->where('nombres', 'like', '%' . $buscarpor . '%')
                      ->orWhere('apellidos', 'like', '%' . $buscarpor . '%')
                      ->orWhere('dni', 'like', '%' . $buscarpor . '%')
                      ->orWhere('email', 'like', '%' . $buscarpor . '%')
                      ->orWhere('telefono', 'like', '%' . $buscarpor . '%');
                });
            })
            ->orderBy('nombres')
            ->orderBy('apellidos')
            ->paginate(10);

        $roles = Rol::where('estado', 'Activo')->get();

        $html = '';
        foreach($personasSinRoles as $persona) {
            $html .= '<tr class="persona-row" data-persona-id="' . $persona->id_persona . '">';
            $html .= '<td><input type="checkbox" class="persona-checkbox" name="selected_personas[]" value="' . $persona->id_persona . '" style="transform: scale(1.2);"></td>';
            $html .= '<td>' . $persona->id_persona . '</td>';
            $html .= '<td>' . $persona->nombres . '</td>';
            $html .= '<td>' . $persona->apellidos . '</td>';
            $html .= '<td>' . $persona->dni . '</td>';
            $html .= '<td>' . ($persona->email ?: 'No registrado') . '</td>';
            $html .= '<td>' . ($persona->telefono ?: 'No registrado') . '</td>';
            $html .= '<td>';
            if($persona->roles->count() > 0) {
                foreach($persona->roles as $rol) {
                    $html .= '<span class="badge badge-info mr-1" data-role-id="' . $rol->id_rol . '">' . $rol->nombre . '</span>';
                }
            } else {
                $html .= '<span class="badge badge-secondary">Sin roles</span>';
            }
            $html .= '</td>';
            $html .= '<td class="role-management-cell" style="display: none; min-width: 200px;">';
            $html .= '<div class="role-manager p-2 border rounded" data-persona-id="' . $persona->id_persona . '" style="background-color: #f8f9fa;">';
            $html .= '<div class="current-roles-manager mb-2">';
            $html .= '<small class="text-muted d-block mb-1">Roles actuales:</small>';
            $html .= '<div class="d-flex flex-wrap gap-1">';
            if($persona->roles->count() > 0) {
                foreach($persona->roles as $rol) {
                    $html .= '<span class="badge badge-info role-tag position-relative" data-role-id="' . $rol->id_rol . '" style="font-size: 0.75rem;">';
                    $html .= $rol->nombre;
                    $html .= '<button type="button" class="btn-close btn-close-white position-absolute remove-role-btn" style="font-size: 0.5rem; padding: 0.1rem; top: -2px; right: -2px; width: 12px; height: 12px;" data-role-id="' . $rol->id_rol . '" aria-label="Remove role"></button>';
                    $html .= '</span>';
                }
            } else {
                $html .= '<span class="text-muted small">Sin roles asignados</span>';
            }
            $html .= '</div></div>';
            $html .= '<div class="add-roles-section">';
            if($roles->count() > $persona->roles->count()) {
                $html .= '<select class="form-select form-select-sm add-role-select" style="font-size: 0.75rem;">';
                $html .= '<option value="">Seleccionar rol...</option>';
                foreach($roles as $rol) {
                    if(!$persona->roles->contains('id_rol', $rol->id_rol)) {
                        $html .= '<option value="' . $rol->id_rol . '" data-role-name="' . $rol->nombre . '">' . $rol->nombre . '</option>';
                    }
                }
                $html .= '</select>';
            } else {
                $html .= '<div class="text-muted small">Todos los roles ya están asignados</div>';
            }
            $html .= '</div></div></td>';
            $html .= '<td><span class="badge badge-' . ($persona->estado == 'Activo' ? 'success' : 'danger') . '">' . $persona->estado . '</span></td>';
            $html .= '</tr>';
        }

        if($personasSinRoles->isEmpty()) {
            $html = '<tr><td colspan="10" class="text-center">No hay personas registradas que coincidan con la búsqueda.</td></tr>';
        }

        return response()->json([
            'html' => $html,
            'pagination' => $personasSinRoles->appends(request()->query())->links()->toHtml()
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

        if (!$currentRole || !in_array($currentRole->nombre, ['Administrador', 'Secretaria'])) {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }

        // Debug: mostrar qué datos llegan al servidor
        \Log::info('=== DATOS RECIBIDOS EN SERVIDOR ===', [
            'all_data' => $solicitud->all(),
            'selected_personas' => $solicitud->input('selected_personas'),
            'assignments' => $solicitud->input('assignments')
        ]);
        \Log::info('=== FIN DATOS ===');

        $validador = Validator::make($solicitud->all(), [
            'selected_personas' => 'required|array|min:1',
            'selected_personas.*' => 'required|exists:personas,id_persona',
            'assignments' => 'required|array',
        ], [
            'selected_personas.required' => 'Debe seleccionar al menos una persona.',
            'selected_personas.*.exists' => 'Una de las personas seleccionadas no existe.',
            'assignments.required' => 'Debe asignar roles a las personas seleccionadas.',
        ]);

        if ($validador->fails()) {
            \Log::error('Validation failed:', $validador->errors()->all());
            return redirect()->back()
                ->withErrors($validador)
                ->withInput();
        }

        $resultados = [];
        $errores = [];

        foreach ($solicitud->selected_personas as $personaId) {
            try {
                // Verificar que la persona tenga al menos un rol asignado
                if (!isset($solicitud->assignments[$personaId]['roles']) ||
                    empty($solicitud->assignments[$personaId]['roles']) ||
                    !is_array($solicitud->assignments[$personaId]['roles'])) {
                    $persona = Persona::find($personaId);
                    $errores[] = "La persona {$persona->nombres} {$persona->apellidos} no tiene roles asignados.";
                    continue;
                }

                $persona = Persona::findOrFail($personaId);
                $rolesIds = $solicitud->assignments[$personaId]['roles'];

                // Lógica manual para manejar el estado de los roles
                // 1. Desactivar todos los roles existentes de la persona
                \DB::table('persona_roles')
                    ->where('id_persona', $personaId)
                    ->update(['estado' => 'Inactivo']);

                // 2. Activar los roles que deben estar asignados
                foreach ($rolesIds as $rolId) {
                    \DB::table('persona_roles')
                        ->updateOrInsert(
                            ['id_persona' => $personaId, 'id_rol' => $rolId],
                            ['estado' => 'Activo']
                        );
                }

                // Crear usuario automáticamente si no existe (solo para el primer rol)
                $usuarioCreado = false;
                $credenciales = null;
                $usuario = null;

                if (!$persona->usuario) {
                    $primerRolId = reset($rolesIds); // Obtener el primer rol
                    $primerRol = Rol::findOrFail($primerRolId);
                    $resultadoCreacion = Usuario::crearUsuarioAutomatico($persona, $primerRol);
                    $usuario = $resultadoCreacion['usuario'];
                    $credenciales = $resultadoCreacion['credenciales'];
                    $usuarioCreado = true;
                }

                // Obtener todos los roles asignados para mostrar en resultados
                $rolesAsignados = Rol::whereIn('id_rol', $rolesIds)->get();

                $resultados[] = [
                    'persona' => $persona,
                    'roles' => $rolesAsignados,
                    'usuario_creado' => $usuarioCreado,
                    'credenciales' => $credenciales
                ];

            } catch (\Exception $e) {
                $errores[] = "Error al procesar la asignación para persona ID {$personaId}: " . $e->getMessage();
            }
        }

        $totalRolesAsignados = 0;
        foreach ($resultados as $resultado) {
            $totalRolesAsignados += $resultado['roles']->count();
        }

        $mensaje = count($resultados) . ' personas procesadas exitosamente con ' . $totalRolesAsignados . ' roles asignados.';
        if (!empty($errores)) {
            $mensaje .= ' Sin embargo, hubo algunos errores: ' . implode(' ', $errores);
        }

        return redirect()->route('asignacion-roles.index')
            ->with('success', $mensaje)
            ->with('resultados', $resultados);
    }



    /**
     * Mostrar resultados de asignación.
     */
    public function resultados()
    {
        // Verificar permisos basado en el rol ACTIVO actual
        $user = auth()->user();
        $currentRole = $user->getCurrentRole();

        if (!$currentRole || !in_array($currentRole->nombre, ['Administrador', 'Secretaria'])) {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }

        return view('casignacionroles.resultados');
    }
}
