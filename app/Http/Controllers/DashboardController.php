<?php

namespace App\Http\Controllers;

use App\Exports\ReporteDiarioExport;
use Carbon\Carbon;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Kreait\Firebase\Factory;
use Maatwebsite\Excel\Facades\Excel;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function connect()
    {
        $factory = (new Factory)
            ->withServiceAccount(base_path(env('FIREBASE_CREDENTIALS')));
        $firestore = $factory->createFirestore();
        $database = $firestore->database();

        return $database;
    }
    public function index()
    {
        $reportes = $this->connect()->collection('Reportes')->documents();
        $prueba = $this->calcularInformacionTurnos();
        dd($prueba);
        // Obtener la información de usuarios
        $usuarios = $this->selectUsuarios();
        // Obtener fallos activos
        $reportesActivos = $this->getReportes($reportes, $usuarios);


        // dd($informacionUnidades);
        return view('page.dashboard')->with([
            'reportes' => $reportesActivos,
        ]);
    }

    public function getInfoTurnos()
    {
        $turnos = $this->getTurnosWithUserDataByDate();
        $turnosMananaArray = [];
        $turnosTardeArray = [];
        $turnosCompletoArray = [];
        foreach ($turnos as $turno) {
            if ($turno['Turno'] == 'Mañana') {
                $turnosMananaArray[] = $turno;
            } elseif ($turno['Turno'] == 'Tarde') {
                $turnosTardeArray[] = $turno;
            } elseif ($turno['Turno'] == 'Completo') {
                $turnosCompletoArray[] = $turno;
            }
        }
        $turnosUnidadesManana = [];
        $turnosUnidadesTarde = [];
        $turnosUnidadesCompleto = [];
        foreach ($turnosMananaArray as $turno) {
            $turnosUnidadesManana[] = [
                'Turno' => $turno['Turno'],
                'Unidad' => $turno['Unidad'],
                'Conductor' => $turno['NombreUsuario'],
            ];
        }

        //como hay entrada y salida se repiten las unidades entonces se eliminan los repetidos
        $turnosUnidadesManana = array_unique($turnosUnidadesManana, SORT_REGULAR);

        foreach ($turnosTardeArray as $turno) {
            $turnosUnidadesTarde[] = [
                'Turno' => $turno['Turno'],
                'Unidad' => $turno['Unidad'],
                'Conductor' => $turno['NombreUsuario'],
            ];
        }
        $turnosUnidadesTarde = array_unique($turnosUnidadesTarde, SORT_REGULAR);
        foreach ($turnosCompletoArray as $turno) {
            $turnosUnidadesCompleto[] = [
                'Turno' => $turno['Turno'],
                'Unidad' => $turno['Unidad'],
                'CambioUnidad' => $turno['CambioUnidad'],
                'Conductor' => $turno['NombreUsuario'],
            ];
        }

        $turnosUnidadesCompleto = array_unique($turnosUnidadesCompleto, SORT_REGULAR);

        //ahora juntamos todos en un mismo array, no necesitamos poner el turno porque ya sabemos que es completo
        $turnosArray = array_merge($turnosUnidadesManana, $turnosUnidadesTarde, $turnosUnidadesCompleto);


        return $turnosArray;
    }

    
    public function getTurnosWithUserDataByDate()
    {
        $fecha = Carbon::now()->format('d/m/Y');
        $turnos = $this->connect()->collection('Turno')->where('Fecha', '=', $fecha)->documents();
        $usuarios = $this->connect()->collection('Usuarios')->documents();
        $usuariosArray =  $this->getUsuariosArray($usuarios);
        $turnosArray = $this->getTurnosArray($turnos, $usuariosArray);
        
        return $turnosArray;
    }
    public function getTurnosWithUserDataByMonth()
    {
        //y necesitamos saber el primer día del mes y el último
        $primerDiaMes = Carbon::now()->startOfMonth()->format('d/m/Y');
        $ultimoDiaMes = Carbon::now()->endOfMonth()->format('d/m/Y');
        //ahora hacemos la consulta
        $turnos = $this->connect()->collection('Turno')->where('Fecha', '>=', $primerDiaMes)->where('Fecha', '<=', $ultimoDiaMes)->documents();
        $usuarios = $this->connect()->collection('Usuarios')->documents();
        $usuariosArray =  $this->getUsuariosArray($usuarios);
        $turnosArray = $this->getTurnosArray($turnos, $usuariosArray);

        return $turnosArray;
    }
    public function calcularInformacionTurnos()
    {
        $turnos = $this->getTurnosWithUserDataByMonth();
        $totalHorasTrabajadas = 0;
        $turnosTrabajados = [
            'Mañana' => 0,
            'Tarde' => 0,
            'Completo' => 0,
        ];

        foreach ($turnos as $turno) {
            // Si el turno tiene hora de entrada y salida
            if (isset($turno['Hora']) && isset($turno['Tipo']) && $turno['Tipo'] === 'Salida') {
                $horaEntrada = Carbon::createFromFormat('d/m/Y h:iA', $turno['Fecha'] . ' ' . $turno['Hora']);
                $horaSalida = Carbon::now(); // Establecer la hora actual por defecto si no hay hora de salida
                $indiceEntrada = array_search($turno, $turnos) - 1;

                // Buscar la entrada correspondiente al mismo usuario y unidad
                for ($i = $indiceEntrada; $i >= 0; $i--) {
                    if (
                        isset($turnos[$i]['Hora'])
                        && isset($turnos[$i]['Tipo'])
                        && $turnos[$i]['Tipo'] === 'Entrada'
                        && $turnos[$i]['IDConductor'] === $turno['IDConductor']
                        && $turnos[$i]['Unidad'] === $turno['Unidad']
                    ) {
                        $horaEntrada = Carbon::createFromFormat('d/m/Y h:iA', $turnos[$i]['Fecha'] . ' ' . $turnos[$i]['Hora']);
                        break;
                    }
                }

                $horasTrabajadas = $horaEntrada->diffInHours($horaSalida);
                $totalHorasTrabajadas += $horasTrabajadas;

                // Cuenta los turnos por tipo
                switch ($turno['Turno']) {
                    case 'Mañana':
                        $turnosTrabajados['Mañana']++;
                        break;
                    case 'Tarde':
                        $turnosTrabajados['Tarde']++;
                        break;
                    case 'Completo':
                        $turnosTrabajados['Completo']++;
                        break;
                    default:
                        break;
                }
            }
        }

        return [
            'totalHorasTrabajadas' => $totalHorasTrabajadas,
            'turnosTrabajados' => $turnosTrabajados,
        ];
    }


    public function getUsuariosArray($usuarios)
    {
        $usuariosArray = [];

        foreach ($usuarios as $usuario) {
            $usuariosArray[$usuario->data()['IDUsuario']] = $usuario->data();
        }

        return $usuariosArray;
    }

    public function getTurnosArray($turnos, $usuariosArray)
    {
        $turnosArray = [];

        foreach ($turnos as $turno) {
            $turnoData = $turno->data();
            $turnoData['NombreUsuario'] = $usuariosArray[$turnoData['IDConductor']]['Usuario'];
            $turnosArray[] = $turnoData;
        }
        return $turnosArray;
    }

    public function reporteDiarioAction(Request $request)
    {
        // dd($request->all());
        switch ($request->input('action')) {
            case 'Exportar Excel':
                $turnos = new ReporteDiarioExport();
                return Excel::download($turnos, 'ReporteDiario' . date('d-m-Y') . '.xlsx');
                break;

            case 'Exportar PDF':
                $turnos = $this->getInfoTurnos();
                $fecha = date('d-m-Y');

                if (empty($turnos)) {
                    return redirect()->route('dashboard')->with('message', 'No se pudo generar el reporte ya que no hay datos que se puedan generar')->with('status', false);
                } else {
                    $logo = public_path('images/logo.png');
                    //lo pasa a base 64

                    $pdf = PDF::loadView('page.reporteria.reporteDiario', [
                        'turnos' => $turnos,
                        'fecha' => $fecha,
                        'logo' => $logo,
                    ]);

                    return $pdf->stream();
                }
                break;

            default:
                # code...
                break;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    function getReportes($fallos, $usuarios)
    {
        $fallosActivos = [];
        foreach ($fallos as $fallo) {
            if ($fallo->data()['Activo']) {
                $falloData = $fallo->data();
                $falloData['NombreSocio'] = $usuarios[$falloData['IDSocio']]['Usuario'];
                $falloData['NombreConductor'] = $usuarios[$falloData['IDConductor']]['Usuario'];
                $fallosActivos[$fallo->id()] = $falloData;
            }
        }
        return $fallosActivos;
    }


    function selectUsuarios()
    {
        $usuarios = $this->connect()->collection('Usuarios')->documents();
        $usuariosArray = [];
        foreach ($usuarios as $usuario) {
            $usuariosArray[$usuario['IDUsuario']] = [
                'Usuario' => $usuario['Usuario']
            ];
        }
        return $usuariosArray;
    }
}
