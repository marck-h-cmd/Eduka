<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proceso extends Model
{
    use HasFactory;
    
    protected $table = 'procesos';
    protected $primaryKey = 'id_proceso';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'descripcion',
        'duracion_estimada_dias',
        'requiere_pago',
        'monto_pago',
        'estado'
    ];

    public function pasos()
    {
        return $this->belongsToMany(Paso::class, 'proceso_pasos', 'id_proceso', 'id_paso')
                    ->withPivot('orden')
                    ->orderBy('pivot_orden');
    }

    public function estudianteProcesos()
    {
        return $this->hasMany(EstudianteProceso::class, 'id_proceso', 'id_proceso');
    }
}
