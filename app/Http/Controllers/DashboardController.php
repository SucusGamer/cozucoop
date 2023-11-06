<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        return view('page.dashboard')->with([
            'reportes' => $reportesActivos
        ]);
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
