<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstudianteProcesoPaso extends Model
{
    use HasFactory;
    protected $table = 'estudiante_proceso_pasos';
    protected $primaryKey = 'id_estudiante_proceso_paso';
    public $timestamps = false;
    
    protected $fillable = [
        'id_estudiante_proceso',
        'id_paso',
        'fecha_inicio',
        'fecha_limite',
        'fecha_entrega',
        'fecha_validacion',
        'validado_por',
        'observacion',
        'estado'
    ];

    protected $casts = [
        'fecha_inicio' => 'datetime',
        'fecha_entrega' => 'datetime',
        'fecha_validacion' => 'datetime',
        'fecha_limite' => 'date'
    ];

    public function estudianteProceso()
    {
        return $this->belongsTo(EstudianteProceso::class, 'id_estudiante_proceso');
    }

    public function paso()
    {
        return $this->belongsTo(Paso::class, 'id_paso');
    }

    public function documentos()
    {
        return $this->hasMany(DocumentoProceso::class, 'id_estudiante_proceso_paso');
    }    
}
