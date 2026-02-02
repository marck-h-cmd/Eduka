<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentoProceso extends Model
{
    use HasFactory;
    protected $table = 'documentos_proceso';
    protected $primaryKey = 'id_documento';
    public $timestamps = false;

    protected $fillable = [
        'id_estudiante_proceso',
        'id_estudiante_proceso_paso',
        'nombre_archivo',
        'nombre_original',
        'tipo_documento',
        'formato',
        'ruta',
        'tamanio_bytes',
        'subido_por',
        'estado'
    ];

    public function estudianteProceso()
    {
        return $this->belongsTo(EstudianteProceso::class, 'id_estudiante_proceso');
    }

    public function paso()
    {
        return $this->belongsTo(EstudianteProcesoPaso::class, 'id_estudiante_proceso_paso');
    }
}
