<?php

namespace App\Http\Controllers;

use App\Models\EstudianteProcesoPaso;
use App\Models\EstudianteProceso;
use App\Models\Paso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EstudianteProcesoPasoController extends Controller
{
    const PAGINATION = 10;

    public function index(Request $request)
    {
        $buscarpor = $request->get('buscarpor');

        $pasos = EstudianteProcesoPaso::with(['estudianteProceso', 'paso'])
            ->when($buscarpor, function ($query) use ($buscarpor) {
                $query->whereHas('paso', function ($q) use ($buscarpor) {
                    $q->where('nombre', 'like', '%' . $buscarpor . '%');
                })
                ->orWhereHas('estudianteProceso', function ($q) use ($buscarpor) {
                    $q->where('codigo_expediente', 'like', '%' . $buscarpor . '%');
                });
            })
            ->orderBy('id_estudiante_proceso_paso', 'desc')
            ->paginate(self::PAGINATION);

        if ($request->ajax()) {
            return view('tramites.gestion.estudiante_proceso_pasos.pasos', compact('pasos'))->render();
        }

        return view('tramites.gestion.estudiante_proceso_pasos.index', compact('pasos', 'buscarpor'));
    }

    public function create()
    {
        $procesos = EstudianteProceso::where('estado', '!=', 'Anulado')->get();
        $pasos = Paso::where('estado', 'Activo')->get();

        return view('tramites.gestion.estudiante_proceso_pasos.create', compact('procesos', 'pasos'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_estudiante_proceso' => 'required|exists:estudiante_procesos,id_estudiante_proceso',
            'id_paso' => 'required|exists:pasos,id_paso',
            'fecha_inicio' => 'nullable|date',
            'fecha_limite' => 'nullable|date',
            'fecha_entrega' => 'nullable|date',
            'fecha_validacion' => 'nullable|date',
            'estado' => 'required|in:Bloqueado,Pendiente,En progreso,Entregado,Aprobado,Rechazado,Vencido',
        ], [
            'id_estudiante_proceso.required' => 'Debe seleccionar un expediente.',
            'id_paso.required' => 'Debe seleccionar un paso.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Validar que no se repita el paso dentro del expediente
        $existe = EstudianteProcesoPaso::where('id_estudiante_proceso', $request->id_estudiante_proceso)
            ->where('id_paso', $request->id_paso)
            ->exists();

        if ($existe) {
            return back()->withErrors([
                'error' => 'Este paso ya está asignado a este estudiante en el proceso.'
            ])->withInput();
        }

        try {
            EstudianteProcesoPaso::create($request->all());

            return redirect()->route('estudiante_proceso_pasos.index')
                ->with('success', 'Paso asignado correctamente al estudiante.');
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'Error al guardar el registro: ' . $e->getMessage()
            ]);
        }
    }

    public function show($id)
    {
        $paso = EstudianteProcesoPaso::with(['estudianteProceso', 'paso', 'documentos'])
            ->findOrFail($id);

        return view('tramites.gestion.estudiante_proceso_pasos.show', compact('paso'));
    }

    public function edit($id)
    {
        $paso = EstudianteProcesoPaso::findOrFail($id);
        $procesos = EstudianteProceso::where('estado', '!=', 'Anulado')->get();
        $pasos = Paso::where('estado', 'Activo')->get();

        return view('tramites.gestion.estudiante_proceso_pasos.edit', compact('paso', 'procesos', 'pasos'));
    }

    public function update(Request $request, $id)
    {
        $paso = EstudianteProcesoPaso::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'fecha_inicio' => 'nullable|date',
            'fecha_limite' => 'nullable|date',
            'fecha_entrega' => 'nullable|date',
            'fecha_validacion' => 'nullable|date',
            'estado' => 'required|in:Bloqueado,Pendiente,En progreso,Entregado,Aprobado,Rechazado,Vencido',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Validaciones de lógica temporal garantizadas por la BD (CHECK)
        if ($request->fecha_entrega && $request->fecha_inicio && $request->fecha_entrega < $request->fecha_inicio) {
            return back()->withErrors([
                'error' => 'La fecha de entrega no puede ser menor a la fecha de inicio.'
            ])->withInput();
        }

        if ($request->fecha_validacion && $request->fecha_entrega && $request->fecha_validacion < $request->fecha_entrega) {
            return back()->withErrors([
                'error' => 'La fecha de validación no puede ser menor a la fecha de entrega.'
            ])->withInput();
        }

        try {
            $paso->update($request->all());

            return redirect()->route('estudiante_proceso_pasos.index')
                ->with('success', 'Paso actualizado correctamente.');
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'Error al actualizar: ' . $e->getMessage()
            ]);
        }
    }

    public function destroy($id)
    {
        $paso = EstudianteProcesoPaso::findOrFail($id);

        try {

            $paso->estado = 'Vencido';
            $paso->save();

            return redirect()->route('estudiante_proceso_pasos.index')
                ->with('success', 'Paso desactivado correctamente.');
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'Error al eliminar: ' . $e->getMessage()
            ]);
        }
    }
}