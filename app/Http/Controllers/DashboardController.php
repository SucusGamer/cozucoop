<?php

namespace App\Http\Controllers;

use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Kreait\Firebase\Factory;

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

    public function getInfoTurnos(){
        $turnos = $this->getTurnosWithUserData();
        $turnosMananaArray = [];
        $turnosTardeArray = [];
        $turnosCompletoArray = [];
        foreach ($turnos as $turno) {
            if($turno['Turno'] == 'Mañana'){
                $turnosMananaArray[] = $turno;
            }elseif($turno['Turno'] == 'Tarde'){
                $turnosTardeArray[] = $turno;
            }elseif($turno['Turno'] == 'Completo'){
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

    public function getTurnosWithUserData()
    {
        $turnos = $this->connect()->collection('Turno')->documents();
        $usuarios = $this->connect()->collection('Usuarios')->documents();

        $usuariosArray =  $this->getUsuariosArray($usuarios);
        // dd($usuariosArray);
        $turnosArray = $this->getTurnosArray($turnos, $usuariosArray);

        return $turnosArray;
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

    public function reporteDiarioAction(Request $request){
        // dd($request->all());
        switch ($request->input('action')) {
            case 'Exportar Excel':
                # code...
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
