<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstudianteProceso extends Model
{
    use HasFactory;
    protected $table = 'estudiante_procesos';
    protected $primaryKey = 'id_estudiante_proceso';
    public $timestamps = false;
    protected $fillable = [
        'id_estudiante',
        'id_proceso',
        'codigo_expediente',
        'fecha_inicio',
        'fecha_limite',
        'fecha_fin',
        'porcentaje_avance',
        'observaciones',
        'usuario_registro',
        'estado'
    ];

    protected $casts = [
        'fecha_inicio' => 'datetime',
        'fecha_fin' => 'datetime',
        'fecha_limite' => 'date'
    ];

    public function proceso()
    {
        return $this->belongsTo(Proceso::class, 'id_proceso', 'id_proceso');
    }

    public function pasos()
    {
        return $this->hasMany(EstudianteProcesoPaso::class, 'id_estudiante_proceso', 'id_estudiante_proceso');
    }

    public function documentos()
    {
        return $this->hasMany(DocumentoProceso::class, 'id_estudiante_proceso', 'id_estudiante_proceso');
    }
}
