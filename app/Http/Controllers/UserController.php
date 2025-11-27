<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use DateTime;
use Illuminate\Queue\Middleware\RateLimited;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\RateLimiter;

class UserController extends Controller
{
    public function showLogin()
    {
        return view('clogin.usuario');
    }

    public function showLoginPassword()
    {
        return view('clogin.password');
    }
    /*
    public function verificalogin(Request $request){
        //return dd($request->all());
        $data=request()->validate([
            'email'=>'required',
            'password'=>'required'
        ],
        [
            'email.required'=>'Ingrese Correo',
            'password.required'=>'Ingrese contraseña',
        ]);
        /*
        if (Auth::attempt($data)){
            $con='OK';
        }

        $email=$request->get('email');

        $query=User::where('email','=',$email)->get();

        if ($query->count()!=0)
        {
            $hashp=$query[0]->password;
            $password=$request->get('password');
            if (password_verify($password, $hashp))
            {
                return redirect()->route('rutarrr1');
            }
            else
            {
                return back()->withErrors(['password'=>'Contraseña no válida'])
                ->withInput(request(['email', 'password']));
            }
        }
        else
        {
            return back()->withErrors(['email'=>'Correo no válido'])
            ->withInput(request(['email']));
        }
    }
    */

    public function verificalogin(Request $request)
    {
        $data = $request->validate([
            'email' => 'required',
        ], [
            'email.required' => 'Introduce una dirección de correo o usuario',
        ]);

        $email = $data['email'];

        $usuario = User::where('email', $email)
            ->orWhere('username', $email)
            ->first();

        if ($usuario) {
            // ✅ Caso: el usuario tiene Google vinculado
            if ($usuario->google_id) {
                Auth::login($usuario);
                return redirect()->route('rutarrr1'); // 🚀 va directo al home
            }

            // ✅ Caso normal: correo/usuario + contraseña
            session(['email' => $usuario->email]);
            return redirect()->route('pass');
        }

        return back()->withErrors([
            'email' => 'No se ha podido encontrar tu cuenta de Eduka',
        ])->withInput();
    }


    public function verificapassword(Request $request)
    {
        $request->validate([
            'password' => 'required',
            //'g-recaptcha-response' => 'required',
        ], [
            'password.required' => 'Introduce una contraseña',
            //'g-recaptcha-response.required' => 'Completa el reCAPTCHA',
        ]);

        /*/ Verificar reCAPTCHA
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('services.recaptcha.secret_key'),
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip(),
        ]);

        //Si falla el reCAPTCHA
        if (! $response->json('success')) {
            return back()->withErrors(['g-recaptcha-response' => 'Falló la verificación de reCAPTCHA.'])->withInput();
        }
*/
        // Recuperar el correo desde sesión (al registrar su correo)
        $email = session('email');

        if (! $email) {
            return redirect()->route('login')->withErrors(['email' => 'Sesión expirada. Inicia nuevamente.']);
        }

        // Buscar al usuario
        $usuario = User::where('email', $email)->first();

        if (!$usuario) {
            return redirect()->route('login')->withErrors(['email' => 'El usuario no fue encontrado.']);
        }

        // Validar contraseña manualmente (ya que usas columna `password_hash`)
        if (!password_verify($request->password, $usuario->password_hash)) {
            return back()->withErrors([
                'password' => 'Contraseña incorrecta. Intenta nuevamente o usa "¿Olvidaste tu contraseña?"',
            ])->withInput();
        }

        // Iniciar sesión manualmente
        Auth::login($usuario);

        // Regenerar sesión
        $request->session()->regenerate();

        return redirect()->route('rutarrr1');
    }

    public function salir(Request $request)
    {
        // ✅ Obtiene el usuario autenticado antes de cerrar sesión
        // Esto es importante porque después de Auth::logout(), ya no podrás acceder a Auth::user()
        $usuario = Auth::user();

        // ✅ Si el usuario está autenticado, actualiza la fecha de su última sesión
        if ($usuario) {
            $usuario->ultima_sesion = now();  // Guarda la fecha y hora actual
            $usuario->save();                 // Guarda los cambios en la base de datos
        }

        // ✅ Cierra la sesión del usuario (lo desautentica)
        Auth::logout();

        // ✅ Invalida la sesión actual para evitar que se reutilice
        $request->session()->invalidate();

        // ✅ Regenera el token CSRF para prevenir ataques de falsificación de petición
        $request->session()->regenerateToken();

        // ✅ Redirige al usuario a la vista de login
        return redirect()->route('login');
    }
}
