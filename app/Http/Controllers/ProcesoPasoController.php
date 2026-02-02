<?php

namespace App\Http\Controllers;

use App\Models\ProcesoPaso;
use App\Models\Proceso;
use App\Models\Paso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProcesoPasoController extends Controller
{
    const PAGINATION = 15;

    public function index(Request $request)
    {
        $buscarpor = $request->get('buscarpor');

        $proceso_pasos = ProcesoPaso::with(['proceso', 'paso'])
            ->where('estado', 'Activo')
            ->when($buscarpor, function ($query) use ($buscarpor) {
                $query->whereHas('proceso', function ($q) use ($buscarpor) {
                    $q->where('nombre', 'like', '%' . $buscarpor . '%');
                })
                ->orWhereHas('paso', function ($q) use ($buscarpor) {
                    $q->where('nombre', 'like', '%' . $buscarpor . '%');
                });
            })
            ->orderBy('id_proceso')
            ->orderBy('orden')
            ->paginate(self::PAGINATION);

        if ($request->ajax()) {
            return view('tramites.configuracion.procesos_pasos.proceso_pasos', compact('proceso_pasos'))->render();
        }

        return view('tramites.configuracion.procesos_pasos.index', compact('proceso_pasos', 'buscarpor'));
    }

    public function create()
    {
        $procesos = Proceso::where('estado', 'Activo')->get();
        $pasos = Paso::where('estado', 'Activo')->get();

        return view('tramites.configuracion.procesos_pasos.create', compact('procesos', 'pasos'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_proceso' => 'required|exists:procesos,id_proceso',
            'id_paso' => 'required|exists:pasos,id_paso',
            'orden' => 'required|integer|min:1',
            'es_obligatorio' => 'required|boolean',
            'dias_plazo' => 'nullable|integer|min:1',
        ], [
            'id_proceso.required' => 'Debe seleccionar un proceso.',
            'id_paso.required' => 'Debe seleccionar un paso.',
            'orden.required' => 'Debe indicar un orden.',
            'orden.min' => 'El orden debe ser mayor o igual a 1.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Validar paso duplicado dentro del mismo proceso
        $existe = ProcesoPaso::where('id_proceso', $request->id_proceso)
            ->where('id_paso', $request->id_paso)
            ->exists();

        if ($existe) {
            return back()->withErrors(['error' => 'Este paso ya está asignado a este proceso.'])
                ->withInput();
        }

        // Validar orden único dentro del proceso
        $ordenDuplicado = ProcesoPaso::where('id_proceso', $request->id_proceso)
            ->where('orden', $request->orden)
            ->exists();

        if ($ordenDuplicado) {
            return back()->withErrors(['error' => 'El orden seleccionado ya existe en este proceso.'])
                ->withInput();
        }

        try {
            ProcesoPaso::create([
                'id_proceso' => $request->id_proceso,
                'id_paso' => $request->id_paso,
                'orden' => $request->orden,
                'es_obligatorio' => $request->es_obligatorio,
                'dias_plazo' => $request->dias_plazo,
                'estado' => 'Activo'
            ]);

            return redirect()->route('proceso_pasos.index')
                ->with('success', 'Paso asignado exitosamente al proceso.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al crear la asignación: ' . $e->getMessage()]);
        }
    }

    public function show($id_proceso, $id_paso)
    {
        $procesoPaso = ProcesoPaso::with(['proceso', 'paso'])
            ->where('id_proceso', $id_proceso)
            ->where('id_paso', $id_paso)
            ->firstOrFail();

        return view('tramites.configuracion.procesos_pasos.show', compact('procesoPaso'));
    }

    public function edit($id_proceso, $id_paso)
    {
        $procesoPaso = ProcesoPaso::where('id_proceso', $id_proceso)
            ->where('id_paso', $id_paso)
            ->firstOrFail();

        $procesos = Proceso::where('estado', 'Activo')->get();
        $pasos = Paso::where('estado', 'Activo')->get();

        return view('tramites.configuracion.procesos_pasos.edit', compact('procesoPaso', 'procesos', 'pasos'));
    }

    public function update(Request $request, $id_proceso, $id_paso)
    {
        $procesoPaso = ProcesoPaso::where('id_proceso', $id_proceso)
            ->where('id_paso', $id_paso)
            ->firstOrFail();

        $validator = Validator::make($request->all(), [
            'orden' => 'required|integer|min:1',
            'es_obligatorio' => 'required|boolean',
            'dias_plazo' => 'nullable|integer|min:1',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Validar orden duplicado en edición
        $ordenDuplicado = ProcesoPaso::where('id_proceso', $id_proceso)
            ->where('orden', $request->orden)
            ->where('id_paso', '!=', $id_paso)
            ->exists();

        if ($ordenDuplicado) {
            return back()->withErrors(['error' => 'Otro paso en este proceso ya tiene ese orden.'])
                ->withInput();
        }

        try {
            $procesoPaso->update([
                'orden' => $request->orden,
                'es_obligatorio' => $request->es_obligatorio,
                'dias_plazo' => $request->dias_plazo,
            ]);

            return redirect()->route('proceso_pasos.index')
                ->with('success', 'Asignación actualizada exitosamente.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al actualizar: ' . $e->getMessage()]);
        }
    }

    public function destroy($id_proceso, $id_paso)
    {
        $procesoPaso = ProcesoPaso::where('id_proceso', $id_proceso)
            ->where('id_paso', $id_paso)
            ->firstOrFail();

        try {
            $procesoPaso->estado = 'Inactivo';
            $procesoPaso->save();

            return redirect()->route('proceso_pasos.index')
                ->with('success', 'Paso eliminado del proceso correctamente.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al eliminar: ' . $e->getMessage()]);
        }
    }
}
