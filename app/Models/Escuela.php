<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Escuela extends Model
{
    protected $table = 'escuelas';
    protected $primaryKey = 'id_escuela';
    public $timestamps = false; // La tabla no tiene campos de timestamp

    protected $fillable = [
        'id_facultad',
        'nombre',
        'descripcion',
        'estado'
    ];

    protected $casts = [
        'estado' => 'string',
    ];

    // Relación con estudiantes
    public function estudiantes()
    {
        return $this->hasMany(Estudiante::class, 'id_escuela', 'id_escuela');
    }

    // Relación con curriculas
    public function curriculas()
    {
        return $this->hasMany(Curricula::class, 'id_escuela', 'id_escuela');
    }

    // Scope para escuelas activas
    public function scopeActivas($query)
    {
        return $query->where('estado', 'Activo');
    }
}
