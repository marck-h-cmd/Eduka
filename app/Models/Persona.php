<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;

    protected $table = 'personas';
    protected $primaryKey = 'id_persona';
    public $timestamps = false;

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'id_persona';
    }

    protected $fillable = [
        'nombres',
        'apellidos',
        'dni',
        'telefono',
        'email',
        'genero',
        'direccion',
        'fecha_nacimiento',
        'estado',
    ];

    protected $casts = [
        'id_persona' => 'integer',
        'fecha_nacimiento' => 'date',
    ];

    public function usuarios()
    {
        return $this->hasMany(Usuario::class, 'id_persona', 'id_persona');
    }

    public function roles()
    {
        return $this->belongsToMany(Rol::class, 'persona_roles', 'id_persona', 'id_rol');
    }

    public function usuario()
    {
        return $this->hasOne(Usuario::class, 'id_persona', 'id_persona');
    }
}
