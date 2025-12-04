<?php

namespace App\Http\Controllers;

use App\Models\DocumentoProceso;
use App\Models\EstudianteProceso;
use App\Models\EstudianteProcesoPaso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class DocumentoProcesoController extends Controller
{
    const PAGINATION = 10;

    public function index(Request $request)
    {
        $buscarpor = $request->get('buscarpor');

        $documentos = DocumentoProceso::with(['estudianteProceso', 'paso'])
            ->where('estado', 'Activo')
            ->when($buscarpor, function ($q) use ($buscarpor) {
                $q->where('nombre_original', 'like', "%$buscarpor%")
                  ->orWhere('tipo_documento', 'like', "%$buscarpor%")
                  ->orWhereHas('estudianteProceso', function ($p) use ($buscarpor) {
                      $p->where('codigo_expediente', 'like', "%$buscarpor%");
                  });
            })
            ->orderBy('id_documento', 'desc')
            ->paginate(self::PAGINATION);

        if ($request->ajax()) {
            return view('tramites.gestion.documentos.documentos', compact('documentos'))->render();
        }

        return view('tramites.gestion.documentos.index', compact('documentos', 'buscarpor'));
    }

    public function create()
    {
        $procesos = EstudianteProceso::where('estado', '!=', 'Anulado')->get();
        $pasos = EstudianteProcesoPaso::all();

        return view('tramites.gestion.documentos.create', compact('procesos', 'pasos'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_estudiante_proceso' => 'required|exists:estudiante_procesos,id_estudiante_proceso',
            'id_estudiante_proceso_paso' => 'nullable|exists:estudiante_proceso_pasos,id_estudiante_proceso_paso',
            'archivo' => 'required|file|max:10240', 
            'tipo_documento' => 'required|in:Solicitud,Constancia,Certificado,Resolución,Acta,Comprobante,Tesis,Informe,Otro',
        ], [
            'archivo.required' => 'Debe seleccionar un archivo.',
            'archivo.max' => 'El tamaño máximo permitido es de 10 MB.',
            'tipo_documento.required' => 'Debe seleccionar un tipo de documento.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $archivo = $request->file('archivo');

            // Datos del archivo
            $nombreOriginal = $archivo->getClientOriginalName();
            $extension = strtoupper($archivo->getClientOriginalExtension());
            $peso = $archivo->getSize();

            // Nombre físico único
            $nombreArchivo = uniqid('doc_') . '.' . $extension;

            // Carpeta por expediente
            $carpeta = 'documentos/' . $request->id_estudiante_proceso;

            // Guardar archivo
            $ruta = $archivo->storeAs($carpeta, $nombreArchivo, 'public');

            DocumentoProceso::create([
                'id_estudiante_proceso' => $request->id_estudiante_proceso,
                'id_estudiante_proceso_paso' => $request->id_estudiante_proceso_paso,
                'nombre_archivo' => $nombreArchivo,
                'nombre_original' => $nombreOriginal,
                'tipo_documento' => $request->tipo_documento,
                'formato' => $extension,
                'ruta' => $ruta,
                'tamanio_bytes' => $peso,
                'subido_por' => auth()->id(),
                'estado' => 'Activo'
            ]);

            return redirect()->route('documentos.index')
                ->with('success', 'Documento subido correctamente.');

        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'Error al subir archivo: ' . $e->getMessage()
            ]);
        }
    }

    public function show($id)
    {
        $documento = DocumentoProceso::with(['estudianteProceso', 'paso'])
            ->findOrFail($id);

        return view('tramites.gestion.documentos.show', compact('documento'));
    }

    public function edit($id)
    {
        $documento = DocumentoProceso::findOrFail($id);
        $procesos = EstudianteProceso::where('estado', '!=', 'Anulado')->get();
        $pasos = EstudianteProcesoPaso::all();

        return view('tramites.gestion.documentos.edit', compact('documento', 'procesos', 'pasos'));
    }

    public function update(Request $request, $id)
    {
        $documento = DocumentoProceso::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'id_estudiante_proceso' => 'required|exists:estudiante_procesos,id_estudiante_proceso',
            'id_estudiante_proceso_paso' => 'nullable|exists:estudiante_proceso_pasos,id_estudiante_proceso_paso',
            'tipo_documento' => 'required|in:Solicitud,Constancia,Certificado,Resolución,Acta,Comprobante,Tesis,Informe,Otro',
            'archivo' => 'nullable|file|max:10240',
        ], [
            'tipo_documento.required' => 'Debe seleccionar un tipo de documento.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            // Si se sube un nuevo archivo, reemplazar el anterior
            if ($request->hasFile('archivo')) {

                $archivo = $request->file('archivo');
                $extension = strtoupper($archivo->getClientOriginalExtension());
                $nombreOriginal = $archivo->getClientOriginalName();
                $peso = $archivo->getSize();

                // Nuevo nombre físico
                $nombreArchivo = uniqid('doc_') . '.' . $extension;

                // Carpeta por expediente
                $carpeta = 'documentos/' . $request->id_estudiante_proceso;

                // Subir nuevo archivo
                $ruta = $archivo->storeAs($carpeta, $nombreArchivo, 'public');

                // Mover documento anterior a "Reemplazado"
                $documento->estado = 'Reemplazado';
                $documento->save();

                // Crear nuevo registro 
                DocumentoProceso::create([
                    'id_estudiante_proceso' => $request->id_estudiante_proceso,
                    'id_estudiante_proceso_paso' => $request->id_estudiante_proceso_paso,
                    'nombre_archivo' => $nombreArchivo,
                    'nombre_original' => $nombreOriginal,
                    'tipo_documento' => $request->tipo_documento,
                    'formato' => $extension,
                    'ruta' => $ruta,
                    'tamanio_bytes' => $peso,
                    'subido_por' => auth()->id(),
                    'estado' => 'Activo'
                ]);

                return redirect()->route('documentos.index')
                    ->with('success', 'Documento actualizado correctamente.');
            }

            // Si NO se sube un archivo, solo actualizar datos
            $documento->update([
                'id_estudiante_proceso' => $request->id_estudiante_proceso,
                'id_estudiante_proceso_paso' => $request->id_estudiante_proceso_paso,
                'tipo_documento' => $request->tipo_documento,
            ]);

            return redirect()->route('documentos.index')
                ->with('success', 'Datos del documento actualizados exitosamente.');

        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'Error al actualizar: ' . $e->getMessage()
            ]);
        }
    }

    public function destroy($id)
    {
        $documento = DocumentoProceso::findOrFail($id);

        try {
            
            $documento->estado = 'Eliminado';
            $documento->save();

            return redirect()->route('documentos.index')
                ->with('success', 'Documento eliminado correctamente.');
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'Error al eliminar: ' . $e->getMessage()
            ]);
        }
    }
}