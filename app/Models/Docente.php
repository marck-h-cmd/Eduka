<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
    use HasFactory;

    protected $table = 'docentes';
    protected $primaryKey = 'id_docente';
    public $timestamps = false;

    protected $fillable = [
        'id_persona',
        'emailUniversidad',
        'fecha_contratacion',
        'estado',
    ];

    protected $casts = [
        'id_docente' => 'integer',
        'id_persona' => 'integer',
        'fecha_contratacion' => 'date',
    ];

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'id_persona', 'id_persona');
    }

    public function usuario()
    {
        return $this->persona->usuario();
    }

    // Relación muchos a muchos con Especialidad
    public function especialidades()
    {
        return $this->belongsToMany(Especialidad::class, 'docente_especialidad', 'id_docente', 'id_especialidad')
                    ->wherePivot('estado', 'Activo')
                    ->withPivot('estado', 'id_docente', 'id_especialidad');
    }
}
