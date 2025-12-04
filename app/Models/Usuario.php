<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;
use App\Mail\EnviarCredencialesDocente;
use App\Mail\EnviarCredencialesRepresentante;
use App\Mail\EnviarCredencialesSecretaria;
use App\Mail\EnviarCredencialesAdministrador;
use App\Mail\EnviarCredencialesEstudiante;
use Illuminate\Support\Str;

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

    /**
     * Check if user has multiple active roles
     */
    public function hasMultipleRoles()
    {
        return $this->getActiveRoles()->count() > 1;
    }

    /**
     * Get current active role from session or default to first role
     */
    public function getCurrentRole()
    {
        $activeRoles = $this->getActiveRoles();

        if ($activeRoles->isEmpty()) {
            return null;
        }

        // Check if there's a role selected in session
        $sessionRoleId = session('current_role_id');

        if ($sessionRoleId && $activeRoles->contains('id_rol', $sessionRoleId)) {
            return $activeRoles->where('id_rol', $sessionRoleId)->first();
        }

        // Default to first role
        return $activeRoles->first();
    }

    /**
     * Set current active role in session
     */
    public function setCurrentRole($roleId)
    {
        $activeRoles = $this->getActiveRoles();

        if ($activeRoles->contains('id_rol', $roleId)) {
            session(['current_role_id' => $roleId]);
            return true;
        }

        return false;
    }

    /**
     * Crear usuario automáticamente con credenciales generadas para una persona.
     * Solo se crea UN usuario por persona, independientemente de sus roles.
     *
     * @param Persona $persona La persona para la que se creará el usuario
     * @return array Retorna un array con el usuario creado y las credenciales generadas
     */
    public static function crearUsuarioAutomatico(Persona $persona)
    {
        // Verificar si la persona ya tiene un usuario
        if ($persona->usuario) {
            return [
                'usuario' => $persona->usuario,
                'credenciales' => [
                    'username' => $persona->usuario->username,
                    'password' => null, // No reenviar contraseña
                    'email' => $persona->usuario->email
                ]
            ];
        }

        // Generar nombre de usuario único (nombre completo en mayúsculas)
        $nombreUsuarioBase = strtoupper($persona->nombres . ' ' . $persona->apellidos);
        $nombreUsuario = $nombreUsuarioBase;
        $contador = 1;

        while (self::where('username', $nombreUsuario)->exists()) {
            $nombreUsuario = $nombreUsuarioBase . $contador;
            $contador++;
        }

        // Generar email institucional único para la persona
        $emailInstitucional = self::generarEmailInstitucionalUnico($persona);

        // Generar contraseña segura
        $contrasena = self::generarContrasenaSegura();

        // Crear usuario
        $usuario = self::create([
            'id_persona' => $persona->id_persona,
            'username' => $nombreUsuario,
            'password_hash' => bcrypt($contrasena),
            'email' => $emailInstitucional,
            'estado' => 'Activo',
        ]);

        // Enviar credenciales por email (email genérico, ya que es el primer acceso)
        self::enviarCredencialesEmail($persona, $nombreUsuario, $contrasena, $emailInstitucional);

        return [
            'usuario' => $usuario,
            'credenciales' => [
                'username' => $nombreUsuario,
                'password' => $contrasena,
                'email' => $emailInstitucional
            ]
        ];
    }

    /**
     * Generar email institucional único para una persona.
     * Patrón simple: primera letra del nombre + apellido completo + @unitru.edu.pe
     *
     * @param Persona $persona La persona para la que se generará el email
     * @return string Email institucional único generado
     */
    private static function generarEmailInstitucionalUnico(Persona $persona)
    {
        // Base del email: primera letra del nombre + apellido completo (sin sufijos de rol)
        $primeraLetraNombre = strtolower(substr($persona->nombres, 0, 1));
        $apellidoCompleto = strtolower($persona->apellidos);

        // Limpiar espacios y caracteres especiales del apellido
        $apellidoLimpio = preg_replace('/[^a-z]/', '', $apellidoCompleto);

        $baseEmail = $primeraLetraNombre . $apellidoLimpio;
        $emailBase = $baseEmail . '@unitru.edu.pe';

        // Verificar unicidad y agregar contador si es necesario
        $emailFinal = $emailBase;
        $contador = 1;

        while (self::where('email', $emailFinal)->exists()) {
            $emailFinal = $baseEmail . $contador . '@unitru.edu.pe';
            $contador++;
        }

        return $emailFinal;
    }

    /**
     * Generar contraseña segura aleatoria.
     *
     * @param int $longitud Longitud de la contraseña (por defecto 12)
     * @return string Contraseña generada
     */
    private static function generarContrasenaSegura($longitud = 12)
    {
        $mayusculas = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $minusculas = 'abcdefghijklmnopqrstuvwxyz';
        $numeros = '0123456789';
        $caracteresEspeciales = '@$!%*?&';

        $contrasena = '';

        // Asegurar al menos un carácter de cada tipo
        $contrasena .= $mayusculas[rand(0, strlen($mayusculas) - 1)];
        $contrasena .= $minusculas[rand(0, strlen($minusculas) - 1)];
        $contrasena .= $numeros[rand(0, strlen($numeros) - 1)];
        $contrasena .= $caracteresEspeciales[rand(0, strlen($caracteresEspeciales) - 1)];

        // Completar el resto de la contraseña
        $todosCaracteres = $mayusculas . $minusculas . $numeros . $caracteresEspeciales;
        for ($i = 4; $i < $longitud; $i++) {
            $contrasena .= $todosCaracteres[rand(0, strlen($todosCaracteres) - 1)];
        }

        // Mezclar los caracteres
        return str_shuffle($contrasena);
    }

    /**
     * Enviar credenciales por email de bienvenida.
     * Email genérico para el primer acceso al sistema.
     *
     * @param Persona $persona La persona que recibirá el email
     * @param string $nombreUsuario El nombre de usuario generado
     * @param string $contrasena La contraseña generada
     * @param string $emailInstitucional El email institucional generado
     */
    private static function enviarCredencialesEmail(Persona $persona, $nombreUsuario, $contrasena, $emailInstitucional)
    {
        // Enviar al email personal de la persona si existe, sino al institucional
        $emailDestino = $persona->email ?: $emailInstitucional;

        if (!$emailDestino) {
            return; // No enviar email si no hay dirección
        }

        try {
            $nombreCompleto = $persona->nombres . ' ' . $persona->apellidos;

            // Enviar email genérico de bienvenida (usar docente como template base)
            Mail::to($emailDestino)->send(new EnviarCredencialesDocente($nombreCompleto, $emailInstitucional, $contrasena));
        } catch (\Exception $e) {
            // Log error but don't stop the process
            \Log::error('Error sending credentials email: ' . $e->getMessage());
        }
    }
}
