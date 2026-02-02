<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Secretaria extends Model
{
    use HasFactory;

    protected $table = 'secretarias';
    protected $primaryKey = 'id_secretaria';
    public $timestamps = false;

    protected $fillable = [
        'id_persona',
        'emailUniversidad',
        'fecha_ingreso',
        'estado',
    ];

    protected $casts = [
        'id_secretaria' => 'integer',
        'id_persona' => 'integer',
        'fecha_ingreso' => 'date',
    ];

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'id_persona', 'id_persona');
    }

    public function usuario()
    {
        return $this->persona->usuario();
    }
}
