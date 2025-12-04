<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curricula extends Model
{
    use HasFactory;

    protected $table = 'curriculas';
    protected $primaryKey = 'id_curricula';
    public $timestamps = false;

    protected $fillable = [
        'id_escuela',
        'nombre',
        'anio_inicio',
        'anio_fin',
        'estado',
    ];

    protected $casts = [
        'id_curricula' => 'integer',
        'id_escuela' => 'integer',
        'anio_inicio' => 'integer',
        'anio_fin' => 'integer',
    ];

    // Relación con Escuela
    public function escuela()
    {
        return $this->belongsTo(Escuela::class, 'id_escuela', 'id_escuela');
    }

    // Relación con Estudiantes
    public function estudiantes()
    {
        return $this->hasMany(Estudiante::class, 'id_curricula', 'id_curricula');
    }

    // Scope para curriculas vigentes
    public function scopeVigentes($query)
    {
        return $query->where('estado', 'Vigente');
    }

    // Scope para filtrar por escuela
    public function scopePorEscuela($query, $idEscuela)
    {
        return $query->where('id_escuela', $idEscuela);
    }
}
