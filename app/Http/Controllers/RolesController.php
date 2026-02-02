<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RolesController extends Controller
{
    const PAGINATION = 10;

    public function index(Request $request)
    {
        $buscarpor = $request->get('buscarpor');

        // Si es una petición de verificación de nombre único
        if ($request->has('verificar') && $request->verificar === 'true') {
            $nombre = $request->get('buscarpor');
            $existe = Rol::where('estado', 'Activo')
                        ->where('nombre', $nombre)
                        ->exists();

            return response()->json([
                'roles' => [
                    'data' => $existe ? [['nombre' => $nombre]] : []
                ]
            ]);
        }

        $roles = Rol::where('estado', 'Activo')
            ->where(function ($query) use ($buscarpor) {
                $query->where('nombre', 'like', '%' . $buscarpor . '%')
                    ->orWhere('descripcion', 'like', '%' . $buscarpor . '%');
            })
            ->orderBy('nombre', 'asc')
            ->paginate(self::PAGINATION);

        // Si es AJAX, devuelve solo el contenido (como para paginación)
        if ($request->ajax()) {
            return view('croles.roles', compact('roles'))->render();
        }

        return view('croles.index', compact('roles', 'buscarpor'));
    }

    public function create()
    {
        return view('croles.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:100|min:2|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/|unique:roles,nombre',
            'descripcion' => 'nullable|string|max:255'
        ], [
            'nombre.required' => 'El campo nombre es obligatorio.',
            'nombre.string' => 'El campo nombre debe ser una cadena de texto.',
            'nombre.max' => 'El campo nombre no puede tener más de 100 caracteres.',
            'nombre.min' => 'El campo nombre debe tener al menos 2 caracteres.',
            'nombre.regex' => 'El campo nombre solo puede contener letras y espacios.',
            'nombre.unique' => 'El nombre del rol ya está registrado.',
            'descripcion.string' => 'El campo descripción debe ser una cadena de texto.',
            'descripcion.max' => 'El campo descripción no puede tener más de 255 caracteres.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $rol = Rol::create([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'estado' => 'Activo'
            ]);

            return redirect()->route('roles.index')
                ->with('success', 'Rol creado exitosamente.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Error al crear el rol: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function show($id)
    {
        $rol = Rol::with(['personas' => function($query) {
            $query->where('persona_roles.estado', 'Activo');
        }])->findOrFail($id);
        return view('croles.show', compact('rol'));
    }

    public function edit($id)
    {
        $rol = Rol::findOrFail($id);
        return view('croles.edit', compact('rol'));
    }

    public function update(Request $request, $id)
    {
        $rol = Rol::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:100|min:2|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/|unique:roles,nombre,' . $id . ',id_rol',
            'descripcion' => 'nullable|string|max:255'
        ], [
            'nombre.required' => 'El campo nombre es obligatorio.',
            'nombre.string' => 'El campo nombre debe ser una cadena de texto.',
            'nombre.max' => 'El campo nombre no puede tener más de 100 caracteres.',
            'nombre.min' => 'El campo nombre debe tener al menos 2 caracteres.',
            'nombre.regex' => 'El campo nombre solo puede contener letras y espacios.',
            'nombre.unique' => 'El nombre del rol ya está registrado.',
            'descripcion.string' => 'El campo descripción debe ser una cadena de texto.',
            'descripcion.max' => 'El campo descripción no puede tener más de 255 caracteres.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $rol->update([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion
            ]);

            return redirect()->route('roles.index')
                ->with('success', 'Rol actualizado exitosamente.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Error al actualizar el rol: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function destroy($id)
    {
        $rol = Rol::findOrFail($id);

        // Verificar si tiene personas asociadas activas
        if ($rol->personas()->count() > 0) {
            return redirect()->back()
                ->withErrors(['error' => 'No se puede eliminar el rol porque tiene personas asociadas activas.']);
        }

        try {
            // Cambiar el estado a "Inactivo" en lugar de eliminar
            $rol->cambiarEstado('Inactivo');

            // Si hay asignaciones de roles, también cambiar su estado a "Inactivo"
            $rol->personas()->update(['persona_roles.estado' => 'Inactivo']);

            return redirect()->route('roles.index')
                ->with('success', 'Rol eliminado exitosamente.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Error al eliminar el rol: ' . $e->getMessage()]);
        }
    }
}
