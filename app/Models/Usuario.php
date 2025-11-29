<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';
    public $timestamps = false;

    protected $fillable = [
        'id_persona',
        'username',
        'password_hash',
        'estado',
        'email',
        'ultima_sesion',
    ];

    protected $casts = [
        'id_usuario' => 'integer',
        'id_persona' => 'integer',
    ];

    public function docente()
    {
        return $this->belongsTo(InfDocente::class, 'profesor_id', 'profesor_id');
    }

    public function estudiante()
    {
        return $this->belongsTo(InfEstudiante::class, 'estudiante_id', 'estudiante_id');
    }

    public function representante()
    {
        return $this->belongsTo(InfRepresentante::class, 'representante_id', 'representante_id');
    }

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'id_persona', 'id_persona');
    }

    public function roles()
    {
        return $this->persona->roles();
    }

    /**
     * Check if user has a specific role
     */
    public function hasRole($roleName)
    {
        return $this->persona->roles()->where('nombre', $roleName)->exists();
    }

    /**
     * Check if user has any of the specified roles
     */
    public function hasAnyRole($roles)
    {
        return $this->persona->roles()->whereIn('nombre', (array) $roles)->exists();
    }

    /**
     * Get user's active roles
     */
    public function getActiveRoles()
    {
        return $this->persona->roles()->where('persona_roles.estado', 'Activo')->get();
    }
}
