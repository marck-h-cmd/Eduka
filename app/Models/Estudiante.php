<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    use HasFactory;

    protected $table = 'estudiantesunt';
    protected $primaryKey = 'id_estudiante';
    public $timestamps = false;

    protected $fillable = [
        'id_persona',
        'id_escuela',
        'id_curricula',
        'emailUniversidad',
        'anio_ingreso',
        'anio_egreso',
        'estado',
    ];

    protected $casts = [
        'id_estudiante' => 'integer',
        'id_persona' => 'integer',
        'id_escuela' => 'integer',
        'id_curricula' => 'integer',
        'anio_ingreso' => 'integer',
        'anio_egreso' => 'integer',
    ];

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'id_persona', 'id_persona');
    }

    public function usuario()
    {
        return $this->persona->usuario();
    }

    // Relación con escuela
    public function escuela()
    {
        return $this->belongsTo(Escuela::class, 'id_escuela', 'id_escuela');
    }

    // Relación con Curricula
    public function curricula()
    {
        return $this->belongsTo(Curricula::class, 'id_curricula', 'id_curricula');
    }
}
