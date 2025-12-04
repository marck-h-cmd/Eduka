<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $rolesString
     */
    public function handle(Request $request, Closure $next, $rolesString): Response
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Separar los roles por coma
        $roles = explode(',', $rolesString);

        // Verificar si el usuario tiene alguno de los roles permitidos
        $hasRole = false;
        foreach ($roles as $role) {
            $role = trim($role); // Eliminar espacios en blanco
            if ($user->hasRole($role)) {
                $hasRole = true;
                break;
            }
        }

        // Si no tiene ninguno de los roles permitidos, mostrar error 403
        if (!$hasRole) {
            return response()->view('errors.403', [], 403);
        }

        return $next($request);
    }
}
