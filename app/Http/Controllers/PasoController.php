<?php

namespace App\Http\Controllers;

use App\Models\Paso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PasoController extends Controller
{
    const PAGINATION = 10;

    public function index(Request $request)
    {
        $buscarpor = $request->get('buscarpor');

        $pasos = Paso::where('estado', 'Activo')
            ->when($buscarpor, function ($query) use ($buscarpor) {
                $query->where('nombre', 'like', '%' . $buscarpor . '%')
                      ->orWhere('tipo_paso', 'like', '%' . $buscarpor . '%');
            })
            ->orderBy('id_paso', 'asc')
            ->paginate(self::PAGINATION);

        if ($request->ajax()) {
            return view('tramites.configuracion.pasos.pasos', compact('pasos'))->render();
        }

        return view('tramites.configuracion.pasos.index', compact('pasos', 'buscarpor'));
    }

    public function create()
    {
        return view('tramites.configuracion.pasos.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|max:150',
            'descripcion' => 'nullable',
            'tipo_paso' => 'required|in:Documentación,Validación,Pago,Aprobación,Notificación,Generación',
            'duracion_dias' => 'required|integer|min:1',
            'requiere_documento' => 'required|boolean',
            'requiere_validacion' => 'required|boolean',
        ], [
            'nombre.required' => 'Debe ingresar el nombre del paso.',
            'tipo_paso.required' => 'Debe elegir el tipo de paso.',
            'duracion_dias.min' => 'La duración debe ser mayor a 0.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            Paso::create([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'tipo_paso' => $request->tipo_paso,
                'duracion_dias' => $request->duracion_dias,
                'requiere_documento' => $request->requiere_documento,
                'requiere_validacion' => $request->requiere_validacion,
                'estado' => 'Activo',
            ]);

            return redirect()->route('pasos.index')
                ->with('success', 'Paso creado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors([
                'error' => 'Error al crear el paso: ' . $e->getMessage()
            ]);
        }
    }

    public function show($id)
    {
        $paso = Paso::with('procesoPasos')->findOrFail($id);
        return view('tramites.configuracion.pasos.show', compact('paso'));
    }

    public function edit($id)
    {
        $paso = Paso::findOrFail($id);
        return view('tramites.configuracion.pasos.edit', compact('paso'));
    }

    public function update(Request $request, $id)
    {
        $paso = Paso::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|max:150',
            'descripcion' => 'nullable',
            'tipo_paso' => 'required|in:Documentación,Validación,Pago,Aprobación,Notificación,Generación',
            'duracion_dias' => 'required|integer|min:1',
            'requiere_documento' => 'required|boolean',
            'requiere_validacion' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $paso->update([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'tipo_paso' => $request->tipo_paso,
                'duracion_dias' => $request->duracion_dias,
                'requiere_documento' => $request->requiere_documento,
                'requiere_validacion' => $request->requiere_validacion,
            ]);

            return redirect()->route('pasos.index')
                ->with('success', 'Paso actualizado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors([
                'error' => 'Error al actualizar: ' . $e->getMessage()
            ]);
        }
    }

    public function destroy($id)
    {
        $paso = Paso::findOrFail($id);

        try {
            $paso->estado = 'Inactivo';
            $paso->save();

            return redirect()->route('pasos.index')
                ->with('success', 'Paso eliminado correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors([
                'error' => 'Error al eliminar: ' . $e->getMessage()
            ]);
        }
    }
}
