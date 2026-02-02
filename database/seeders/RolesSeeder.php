<?php

namespace Database\Seeders;

use App\Models\Rol;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['nombre' => 'Administrador', 'descripcion' => 'Usuario con acceso completo al sistema', 'estado' => 'Activo'],
            ['nombre' => 'Docente', 'descripcion' => 'Profesor del colegio', 'estado' => 'Activo'],
            ['nombre' => 'Estudiante', 'descripcion' => 'Alumno del colegio', 'estado' => 'Activo'],
            ['nombre' => 'Secretaria', 'descripcion' => 'Secretaria administrativa del colegio', 'estado' => 'Activo'],
            ['nombre' => 'Representante', 'descripcion' => 'Padre o tutor del estudiante', 'estado' => 'Activo'],
        ];

        foreach ($roles as $rol) {
            Rol::updateOrCreate(
                ['nombre' => $rol['nombre']],
                $rol
            );
        }
    }
}
