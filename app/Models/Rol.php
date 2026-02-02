<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    use HasFactory;

    protected $table = 'roles';

    protected $primaryKey = 'id_rol';

    public $timestamps = false;

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'id_rol';
    }

    protected $fillable = ['nombre', 'descripcion', 'estado'];

    // Scope para filtrar roles activos
    public function scopeActivos($query)
    {
        return $query->where('estado', 'Activo');
    }

    // Scope para filtrar roles inactivos
    public function scopeInactivos($query)
    {
        return $query->where('estado', 'Inactivo');
    }

    public function personas()
    {
        return $this->belongsToMany(Persona::class, 'persona_roles', 'id_rol', 'id_persona')
                    ->wherePivot('estado', 'Activo')
                    ->where('personas.estado', 'Activo');
    }

    // Método para verificar si el rol puede ser eliminado
    public function puedeSerEliminado()
    {
        return $this->personas()->count() === 0;
    }

    // Método para cambiar estado (soft delete)
    public function cambiarEstado($nuevoEstado)
    {
        $this->update(['estado' => $nuevoEstado]);
    }
}
