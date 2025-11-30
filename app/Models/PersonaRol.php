<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonaRol extends Model
{
    use HasFactory;

    protected $table = 'persona_roles';
    public $timestamps = false;

    protected $fillable = [
        'id_persona',
        'id_rol',
    ];

    protected $casts = [
        'id_persona' => 'integer',
        'id_rol' => 'integer',
    ];

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'id_persona', 'id_persona');
    }

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'id_rol', 'id_rol');
    }
}
