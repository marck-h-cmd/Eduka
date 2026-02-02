<?php

namespace App\Http\Controllers;

use App\Models\EstudianteProceso;
use App\Models\Proceso;
use App\Models\Estudiante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EstudianteProcesoController extends Controller
{
    const PAGINATION = 10;

    public function index(Request $request)
    {
        $buscarpor = $request->get('buscarpor');

        $procesos = EstudianteProceso::with(['proceso'])
            ->when($buscarpor, function ($query) use ($buscarpor) {
                $query->where('codigo_expediente', 'like', "%$buscarpor%")
                      ->orWhereHas('proceso', function ($q) use ($buscarpor) {
                          $q->where('nombre', 'like', "%$buscarpor%");
                      })
                      ->orWhereHas('estudiante', function ($q) use ($buscarpor) {
                          $q->where('nombres', 'like', "%$buscarpor%")
                            ->orWhere('apellidos', 'like', "%$buscarpor%");
                      });
            })
            ->where('estado', '!=', 'Anulado')
            ->orderBy('id_estudiante_proceso', 'desc')
            ->paginate(self::PAGINATION);

        if ($request->ajax()) {
            return view('tramites.gestion.estudiante_procesos.estudiante_procesos', compact('procesos'))->render();
        }

        return view('tramites.gestion.estudiante_procesos.index', compact('procesos', 'buscarpor'));
    }

    public function create()
    {
        $procesos = Proceso::where('estado', 'Activo')->get();
        $estudiantes = Estudiante::all();

        return view('tramites.gestion.estudiante_procesos.create', compact('procesos', 'estudiantes'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_estudiante' => 'required|exists:estudiantes,estudiante_id',
            'id_proceso' => 'required|exists:procesos,id_proceso',
            'codigo_expediente' => 'nullable|max:30|unique:estudiante_procesos,codigo_expediente',
            'fecha_inicio' => 'required|date',
            'fecha_limite' => 'nullable|date|after_or_equal:fecha_inicio',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'porcentaje_avance' => 'numeric|min:0|max:100',
            'estado' => 'required|in:Pendiente,En curso,En revisión,Observado,Finalizado,Anulado',
        ], [
            'id_estudiante.required' => 'Debe seleccionar un estudiante.',
            'id_proceso.required' => 'Debe seleccionar un proceso.',
            'fecha_limite.after_or_equal' => 'La fecha límite debe ser posterior o igual a la fecha de inicio.',
            'fecha_fin.after_or_equal' => 'La fecha de fin debe ser posterior o igual a la fecha de inicio.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            EstudianteProceso::create($request->all());

            return redirect()->route('estudiante_procesos.index')
                ->with('success', 'Expediente registrado correctamente.');
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'Error al registrar el expediente: ' . $e->getMessage()
            ]);
        }
    }

    public function show($id)
    {
        $proceso = EstudianteProceso::with(['proceso', 'pasos', 'documentos'])
            ->findOrFail($id);

        return view('tramites.gestion.estudiante_procesos.show', compact('proceso'));
    }

    public function edit($id)
    {
        $proceso = EstudianteProceso::findOrFail($id);
        $procesos = Proceso::where('estado', 'Activo')->get();
        $estudiantes = Estudiante::all();

        return view('tramites.gestion.estudiante_procesos.edit', compact('proceso', 'procesos', 'estudiantes'));
    }

    public function update(Request $request, $id)
    {
        $procesoEst = EstudianteProceso::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'id_estudiante' => 'required|exists:estudiantes,estudiante_id',
            'id_proceso' => 'required|exists:procesos,id_proceso',
            'codigo_expediente' => "nullable|max:30|unique:estudiante_procesos,codigo_expediente,$id,id_estudiante_proceso",
            'fecha_inicio' => 'required|date',
            'fecha_limite' => 'nullable|date|after_or_equal:fecha_inicio',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'porcentaje_avance' => 'numeric|min:0|max:100',
            'estado' => 'required|in:Pendiente,En curso,En revisión,Observado,Finalizado,Anulado',
        ], [
            'fecha_limite.after_or_equal' => 'La fecha límite debe ser posterior o igual a la fecha de inicio.',
            'fecha_fin.after_or_equal' => 'La fecha de fin debe ser posterior o igual a la fecha de inicio.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $procesoEst->update($request->all());

            return redirect()->route('estudiante_procesos.index')
                ->with('success', 'Expediente actualizado correctamente.');
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'Error al actualizar el expediente: ' . $e->getMessage()
            ]);
        }
    }

    public function destroy($id)
    {
        $proceso = EstudianteProceso::findOrFail($id);

        try {
            // Soft delete → estado = Anulado
            $proceso->estado = 'Anulado';
            $proceso->save();

            return redirect()->route('estudiante_procesos.index')
                ->with('success', 'Expediente anulado correctamente.');
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'Error al anular el expediente: ' . $e->getMessage()
            ]);
        }
    }
}
