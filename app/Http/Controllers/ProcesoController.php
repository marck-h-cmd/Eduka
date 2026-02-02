<?php

namespace App\Http\Controllers;

use App\Models\Proceso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProcesoController extends Controller
{
    const PAGINATION = 10;

    public function index(Request $request)
    {
        $buscarpor = $request->get('buscarpor');

        $procesos = Proceso::where('estado', 'Activo')
            ->where(function ($query) use ($buscarpor) {
                if (!empty($buscarpor)) {
                    $query->where('nombre', 'like', '%' . $buscarpor . '%')
                          ->orWhere('descripcion', 'like', '%' . $buscarpor . '%');
                }
            })
            ->orderBy('id_proceso', 'asc')
            ->paginate(self::PAGINATION);

        if ($request->ajax()) {
            return view('tramites.configuracion.procesos.procesos', compact('procesos'))->render();
        }

        return view('tramites.configuracion.procesos.index', compact('procesos', 'buscarpor'));
    }

    public function create()
    {
        return view('tramites.configuracion.procesos.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|max:150',
            'descripcion' => 'nullable',
            'duracion_estimada_dias' => 'required|integer|min:1',
            'requiere_pago' => 'required|boolean',
            'monto_pago' => 'required|numeric|min:0',
        ], [
            'nombre.required' => 'Debe ingresar un nombre para el proceso.',
            'duracion_estimada_dias.required' => 'Debe indicar la duración estimada.',
            'duracion_estimada_dias.min' => 'La duración debe ser mayor a 0.',
            'monto_pago.min' => 'El monto no puede ser negativo.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
    
            $request->merge([
                'fecha_creacion' => now()   
            ]);

            Proceso::create($request->all());

            return redirect()->route('procesos.index')
                ->with('success', 'Proceso creado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Error al crear el proceso: ' . $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $proceso = Proceso::with('pasos')->findOrFail($id);
        return view('tramites.configuracion.procesos.show', compact('proceso'));
    }

    public function edit($id)
    {
        $proceso = Proceso::findOrFail($id);
        return view('tramites.configuracion.procesos.edit', compact('proceso'));
    }

    public function update(Request $request, $id)
    {
        $proceso = Proceso::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|max:150',
            'descripcion' => 'nullable',
            'duracion_estimada_dias' => 'required|integer|min:1',
            'requiere_pago' => 'required|boolean',
            'monto_pago' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $proceso->update($request->all());

            return redirect()->route('procesos.index')
                ->with('success', 'Proceso actualizado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Error al actualizar: ' . $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        $proceso = Proceso::findOrFail($id);

        try {
            // Soft delete (estado = Inactivo)
            $proceso->estado = 'Inactivo';
            $proceso->save();

            return redirect()->route('procesos.index')
                ->with('success', 'Proceso eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Error al eliminar: ' . $e->getMessage()]);
        }
    }
}
