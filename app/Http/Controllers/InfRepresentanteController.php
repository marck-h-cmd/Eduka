<?php

namespace App\Http\Controllers;

use App\Models\InfEstudianteRepresentante;
use App\Models\InfRepresentante;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Models\Usuario;
use App\Mail\EnviarCredencialesRepresentante;
use App\Models\InfEstudiante;

class InfRepresentanteController extends Controller
{
    public function exportarPDF()
    {
        // Obtener todos los representantes sin paginar (o lo que necesites)
        $representante = InfRepresentante::all();

        $pdf = Pdf::loadView('ceinformacion.representantes.pdf', compact('representante'))->setPaper('A4', 'portrait');

        // Mostrar en navegador
        return $pdf->stream('representantes_legales.pdf');

        // para descargarlo inmediatamente
        //return $pdf->download('representantes_legales.pdf');
    }

    const PAGINATION = 10;

    public function create($idEstudiante)
    {
        $estudiante = InfEstudiante::findOrFail($idEstudiante);
        return view('ceinformacion.estudiantes.nuevo.datosRepresentante', compact('estudiante'));
    }

    public function index(Request $request)
    {
        $buscarpor = $request->get('buscarpor');
        $representante = InfRepresentante::where('dni', 'like', '%' . $buscarpor . '%')->orwhere('apellidoPaterno', 'like', '%' . $buscarpor . '%')->paginate($this::PAGINATION);

        if ($request->ajax()) {
            return view('ceinformacion.representantes.representante', compact('representante'))->render();
        }

        return view('ceinformacion.representantes.registrar', compact('representante', 'buscarpor'));
    }


    public function store(Request $request)
    {

        try {
            DB::beginTransaction();

            $estudiante_id = $request->input('idEstudiante');
            $idEstudian = $request->input('idEstudiante');

            // REPRESENTANTE 1
            $representante1_id = $request->input('idRepresentante1');


            if (!$representante1_id) {
                $existente1 = InfRepresentante::where('dni', $request->dniRepresentante1)->first();

                if ($existente1) {
                    $representante1_id = $existente1->representante_id;
                } else {
                    $nuevo1 = InfRepresentante::create([
                        'dni' => $request->dniRepresentante1,
                        'nombres' => $request->nombreRepresentante1,
                        'apellidoPaterno' => $request->apellidoPaternoRepresentante1,
                        'apellidoMaterno' => $request->apellidoMaternoRepresentante1,
                        'telefono' => $request->celularRepresentante1,
                        'telefono_alternativo' => $request->celularAlternativoRepresentante1,
                        'email' => $request->correoRepresentante1,
                        'ocupacion' => $request->ocupacionRepresentante1,
                        'direccion' => $request->direccionRepresentante1,
                        'parentesco' => $request->parentescoRepresentante1,
                        'fecha_registro' => now()
                    ]);
                    $representante1_id = $nuevo1->representante_id;
                }
            }

            // Asociación representante 1
            InfEstudianteRepresentante::updateOrCreate(
                [
                    'estudiante_id' => $estudiante_id,
                    'representante_id' => $representante1_id,
                ],
                [
                    'es_principal' => 1,
                    'viveConEstudiante' => 'Si',
                ]
            );

            // Asegurarse que el representante ya existe en BD, Porque tomaremos sus datos
            $AnadirUsuario = $representante1_id;
            $usuarioExistente = Usuario::where('representante_id', $representante1_id)->first();


            if (!$usuarioExistente) {
                $passwordPlano = Str::random(8); //creamos una contraseña aleatoria

                //creamos al usuario en la tabla correspondiente (Usuarios)
                Usuario::create([
                    'username' => $request->correoRepresentante1,
                    'password_hash' => Hash::make($passwordPlano),
                    'nombres' => $request->nombreRepresentante1,
                    'apellidos' => $request->apellidoPaternoRepresentante1 . ' ' . $request->apellidoMaternoRepresentante1,
                    'email' => $request->correoRepresentante1,
                    'rol' => 'Representante',
                    'estado' => 'Activo',
                    'cambio_password_requerido' => 1,
                    'representante_id' => $AnadirUsuario,
                ]);

                // Enviar correo con credenciales usando el Mailable
                Mail::to($request->correoRepresentante1)
                    //Llamamos a la clase que envía el correo, definido corresctamente
                    ->send(new EnviarCredencialesRepresentante(
                        $request->nombreRepresentante1,
                        $request->correoRepresentante1,
                        $passwordPlano
                    ));
            }


            // REPRESENTANTE 2
            $representante2_id = $request->input('idRepresentante2');

            if (!$representante2_id) {
                $existente2 = InfRepresentante::where('dni', $request->dniRepresentante2)->first();

                if ($existente2) {
                    $representante2_id = $existente2->representante_id;
                } else {
                    $nuevo2 = InfRepresentante::create([
                        'dni' => $request->dniRepresentante2,
                        'nombres' => $request->nombreRepresentante2,
                        'apellidoPaterno' => $request->apellidoPaternoRepresentante2,
                        'apellidoMaterno' => $request->apellidoMaternoRepresentante2,
                        'telefono' => $request->celularRepresentante2,
                        'telefono_alternativo' => $request->celularAlternativoRepresentante2,
                        'email' => $request->correoRepresentante2,
                        'ocupacion' => $request->ocupacionRepresentante2,
                        'direccion' => $request->direccionRepresentante2,
                        'parentesco' => $request->parentescoRepresentante2,
                        'fecha_registro' => now()
                    ]);
                    $representante2_id = $nuevo2->representante_id;
                }
            }

            // Asociación representante 2
            InfEstudianteRepresentante::updateOrCreate(
                [
                    'estudiante_id' => $idEstudian,
                    'representante_id' => $representante2_id,
                ],
                [
                    'es_principal' => 0,
                    'viveConEstudiante' => 'Si',
                ]
            );

            //Vamos a crear el usuario al Representante principal, para que pueda acceder al sistema
            //Para ello, recuperamos sus datos.
            // Verificamos si ya tiene un usuario registrado
            //Antes nos aseguramos que el usuario no exista, pues, si ya existe, podrá desde una misma cuenta, ver a todos sus representados


            // Enviamos el correo al representante1 con sus credenciales ESTO SI NO CREARAMOS EL MAILABLE
            /*Mail::raw("Estimado/a {$request->nombreRepresentante1},\n\n" .
                    "Su acceso al sistema Eduka ha sido generado correctamente.\n\n" .
                    "📧 Usuario: {$request->correoRepresentante1}\n" .
                    "🔐 Contraseña temporal: {$passwordPlano}\n\n" .
                    "Le recomendamos cambiar su contraseña al iniciar sesión.\n\n" .
                    "Saludos,\nEquipo Eduka", function ($message) use ($request) {
                    $message->to($request->correoRepresentante1)
                        ->subject('Acceso al sistema Eduka');
                });
                */

            DB::commit();

            return redirect()->route('estudiante.index')
                ->with('success', 'Los Representantes se asignaron correctamente al estudiante.');
        } catch (\Exception $e) {
            DB::rollBack();

            // Mostrar error en pantalla directamente (para desarrollo)
            return back()
                ->withInput()
                ->withErrors(['error_general' => 'Error al guardar: ' . $e->getMessage()]);
        }
    }


    public function edit($dni)
    {
        $infRepresentante = InfRepresentante::findOrFail($dni);
        return view('ceinformacion.estudianteRepresentante.registrar', compact('infRepresentante'));
    }

    public function buscarPorDni(Request $request)
    {
        $dni = $request->input('dni');

        $representante = InfRepresentante::where('dni', $dni)->first();

        if ($representante) {
            return response()->json([
                'success' => true,
                'representante' => $representante
            ]);
        } else {
            return response()->json([
                'success' => false,

            ]);
        }
    }

    public function asignarRepresentante(Request $request)
    {
        $estudianteRepresentante = new InfEstudianteRepresentante();

        $estudianteRepresentante->estudiante_id = $request->input('idEstudiante');
        $estudianteRepresentante->representante_id = $request->input('idRepresentante');

        $estudianteRepresentante->save();

        return redirect()->route('registrarestudiante.index')
            ->with([
                'success' => 'Estudiante registrado y asignado a su Representante Legal satisfactoriamente'
            ]);
    }
}
