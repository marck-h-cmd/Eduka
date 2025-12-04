<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcesoPaso extends Model
{
    use HasFactory;
    
    protected $table = 'proceso_pasos';
    public $timestamps = false;

    protected $fillable = [
        'id_proceso',
        'id_paso',
        'orden',
        'es_obligatorio',
        'dias_plazo',
        'estado'
    ];

    public function proceso()
    {
        return $this->belongsTo(Proceso::class, 'id_proceso', 'id_proceso');
    }

    public function paso()
    {
        return $this->belongsTo(Paso::class, 'id_paso', 'id_paso');
    }
}
