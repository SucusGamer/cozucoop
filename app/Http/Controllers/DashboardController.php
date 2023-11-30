<?php

namespace App\Http\Controllers;

use App\Exports\ReporteDiarioExport;
use App\Exports\ReporteMensualExport;
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
    public function getTurnosWithUserDataByMonth($mes = null)
    {
        // Obtener el primer y último día del mes en base a $mes
        $mes = $mes ?? Carbon::now()->format('m');
        $primerDiaMes = Carbon::createFromFormat('m', $mes)->startOfMonth();
        $ultimoDiaMes = Carbon::createFromFormat('m', $mes)->endOfMonth();
        
        $primerDiaMesFormat = $primerDiaMes->format('d/m/Y');
        $ultimoDiaMesFormat = $ultimoDiaMes->format('d/m/Y');
        //no se como se hace un where entre fechas en firestore así que lo hago con un where y un foreach
        $turnos = $this->connect()->collection('Turno')
            ->where('Fecha', '>=', $primerDiaMesFormat)
            ->where('Fecha', '<=', $ultimoDiaMesFormat)
            ->documents();

        dd($turnos);
        $usuarios = $this->connect()->collection('Usuarios')->documents();
        $usuariosArray =  $this->getUsuariosArray($usuarios);
        $turnosArray = $this->getTurnosArray($turnos, $usuariosArray);

        return $turnosArray;
    }

    public function OrdenarTurnos($mes = null)
    {
        // dd($mes);
        $turnos = $this->getTurnosWithUserDataByMonth($mes);
        $turnosSimplificados = [];

        foreach ($turnos as $turno) {
            $fecha = $turno['Fecha'];
            $turnoNombre = $turno['Turno'];
            $nombreUsuario = $turno['NombreUsuario'];

            // Verificar y asignar las estructuras si no existen
            $turnosSimplificados[$fecha] ??= [];
            $turnosSimplificados[$fecha][$turnoNombre] ??= [];
            $turnosSimplificados[$fecha][$turnoNombre][$nombreUsuario] ??= [];

            // Agregar la información al usuario en el turno
            $turnosSimplificados[$fecha][$turnoNombre][$nombreUsuario][] = [
                'unidad' => $turno['Unidad'],
                'cambioUnidad' => $turno['CambioUnidad'],
                'tipo' => $turno['Tipo'],
                //la hora se guarda en formato 24 horas. Cuando se haga el createFromFormat se debe poner el formato 24 horas
                'hora' => Carbon::createFromFormat('d/m/Y h:iA', $turno['Fecha'] . ' ' . $turno['Hora'])->format('d/m/Y H:i'),
            ];
        }

        // Ordenar los turnos por entrada y salida
        foreach ($turnosSimplificados as &$fechaTurnos) {
            foreach ($fechaTurnos as &$turnoUsuarios) {
                foreach ($turnoUsuarios as &$usuarioAcciones) {
                    usort($usuarioAcciones, function ($a, $b) {
                        if ($a['tipo'] === 'Entrada' && $b['tipo'] === 'Salida') {
                            return -1; // Entrada antes que salida
                        } elseif ($a['tipo'] === 'Salida' && $b['tipo'] === 'Entrada') {
                            return 1; // Salida después de entrada
                        } else {
                            return 0; // Misma categoría (Entrada o Salida)
                        }
                    });
                }
            }
        }

        return $turnosSimplificados;
    }

    public function ObtenerUsuariosMasActivos()
    {
        $turnosSimplificados = $this->OrdenarTurnos();
        $usuariosTurnos = [];

        foreach ($turnosSimplificados as $fecha => $turnos) {
            foreach ($turnos as $turnoNombre => $usuarios) {
                foreach ($usuarios as $nombreUsuario => $acciones) {
                    if (!isset($usuariosTurnos[$nombreUsuario])) {
                        $usuariosTurnos[$nombreUsuario] = 0;
                    }
                    $usuariosTurnos[$nombreUsuario]++;
                }
            }
        }

        arsort($usuariosTurnos); // Ordenar los usuarios por la cantidad de turnos, de mayor a menor

        $topUsuarios = array_slice($usuariosTurnos, 0, 3, true); // Obtener los tres usuarios con más turnos
        return response()->json($topUsuarios);
    }


    public function GenerarReporteMensual()
    {
        $reporte = [
            'Mensual' => [
                'TotalHorasTrabajadas' => 0,
                'TotalTurnos' => 0,
                'Mañana' => 0,
                'Tarde' => 0,
                'Completo' => 0,
            ],
        ];
        $datosTurnos = $this->OrdenarTurnos();
        foreach ($datosTurnos as $fecha => $turnos) {
            foreach ($turnos as $turno => $usuarios) {
                foreach ($usuarios as $usuario => $acciones) {
                    $entradas = array_filter($acciones, function ($accion) {
                        return $accion['tipo'] === 'Entrada';
                    });
                    $salidas = array_filter($acciones, function ($accion) {
                        return $accion['tipo'] === 'Salida';
                    });

                    $horasTrabajadas = 0;

                    if (count($entradas) > 0 && count($salidas) > 0) {
                        foreach ($entradas as $entrada) {
                            $horaEntrada = Carbon::createFromFormat('d/m/Y H:i', $entrada['hora']);
                            foreach ($salidas as $salida) {
                                $horaSalida = Carbon::createFromFormat('d/m/Y H:i', $salida['hora']);
                                if ($horaSalida > $horaEntrada) {
                                    $horasTrabajadas += $horaSalida->diffInMinutes($horaEntrada) / 60;
                                    $horasTrabajadas = round($horasTrabajadas, 2);
                                }
                            }
                        }
                    }

                    if ($horasTrabajadas > 0) {
                        $reporte['Mensual']['TotalHorasTrabajadas'] += $horasTrabajadas;
                        $reporte['Mensual']['TotalTurnos']++;

                        switch ($turno) {
                            case 'Mañana':
                                $reporte['Mensual']['Mañana']++;
                                break;
                            case 'Tarde':
                                $reporte['Mensual']['Tarde']++;
                                break;
                            case 'Completo':
                                $reporte['Mensual']['Completo']++;
                                break;
                        }
                    }
                }
            }
        }

        //lo pasamos en respuesta json
        return response()->json($reporte);
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
                    return redirect()->route('dashboard.index')->with('message', 'No se pudo generar el reporte ya que no hay datos que se puedan generar')->with('status', false);
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

    public function reporteMensualAction(Request $request)
    {
        // dd($request->all());
        switch ($request->input('action')) {
            case 'Exportar Excel':
                $turnos = new ReporteMensualExport();
                return Excel::download($turnos, 'ReporteMensual ' . date('d-m-Y') . '.xlsx');
                break;

            case 'Exportar PDF':
                $mes = $request->input('mes');
                $turnos = $this->OrdenarTurnos($mes);
                // dd($turnos);
                $fecha = date('d-m-Y');
                $infoExtra = $this->GenerarReporteMensual()->original; // Obtén el contenido JSON de la respuesta


                if (empty($turnos)) {
                    return redirect()->route('dashboard.index')->with('message', 'No se pudo generar el reporte ya que no hay datos que se puedan generar')->with('status', false);
                } else {
                    $logo = public_path('images/logo.png');
                    //lo pasa a base 64

                    $pdf = PDF::loadView('page.reporteria.reporteMensual', [
                        'datosTurnos' => $turnos,
                        'fecha' => $fecha,
                        'logo' => $logo,
                        'infoExtra' => $infoExtra,

                    ]);

                    return $pdf->stream();
                }
                break;

            default:
                # code...
                break;
        }
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
