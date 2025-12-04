<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfDocente extends Model
{
    use HasFactory;
    protected $table = 'docentes';
    protected $primaryKey = 'id_docente';
    public $timestamps = false;
    protected $fillable = ['id_persona', 'especialidad', 'fecha_contratacion', 'estado'];

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'id_persona', 'id_persona');
    }
}
