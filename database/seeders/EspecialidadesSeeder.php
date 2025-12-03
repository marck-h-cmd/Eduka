<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Especialidad;

class EspecialidadesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $especialidades = [
            [
                'nombre' => 'Ingeniería de Software',
                'descripcion' => 'Desarrollo, diseño y mantenimiento de software y sistemas informáticos',
                'estado' => 'Activo'
            ],
            [
                'nombre' => 'Sistemas de Información',
                'descripcion' => 'Gestión y administración de sistemas de información empresariales',
                'estado' => 'Activo'
            ],
            [
                'nombre' => 'Base de Datos',
                'descripcion' => 'Diseño, implementación y administración de bases de datos',
                'estado' => 'Activo'
            ],
            [
                'nombre' => 'Redes y Telecomunicaciones',
                'descripcion' => 'Diseño, implementación y gestión de redes de computadoras',
                'estado' => 'Activo'
            ],
            [
                'nombre' => 'Seguridad Informática',
                'descripcion' => 'Protección de sistemas informáticos contra amenazas y vulnerabilidades',
                'estado' => 'Activo'
            ]
        ];

        foreach ($especialidades as $especialidad) {
            Especialidad::create($especialidad);
        }
    }
}
