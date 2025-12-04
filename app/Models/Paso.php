<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paso extends Model
{
    use HasFactory;
    
    protected $table = 'pasos';
    protected $primaryKey = 'id_paso';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'descripcion',
        'tipo_paso',
        'duracion_dias',
        'requiere_documento',
        'requiere_validacion',
        'estado'
    ];

    public function procesos()
    {
        return $this->belongsToMany(Proceso::class, 'proceso_pasos', 'id_paso', 'id_proceso')
                    ->withPivot('orden');
    }


    public function estudianteProcesoPasos()
    {
        return $this->hasMany(EstudianteProcesoPaso::class, 'id_paso', 'id_paso');
    }

}
