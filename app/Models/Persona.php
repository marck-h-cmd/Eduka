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

    protected $fillable = ['dni', 'nombres', 'apellidos', 'fecha_nacimiento', 'genero', 'direccion', 'telefono', 'email',	'estado', 'foto_url'];

    public function representante()
    {
        return $this->hasOne(InfEstudianteRepresentante::class, 'estudiante_id');
    }

    public function matriculas()
    {
        return $this->hasMany(Matricula::class, 'estudiante_id', 'estudiante_id');
    }
}
