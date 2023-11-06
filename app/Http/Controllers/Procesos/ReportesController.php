<?php

namespace App\Http\Controllers\Procesos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kreait\Firebase\Factory;

class ReportesController extends Controller
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
        $usuarios = $this->selectUsuario();
        $reportesArray = $this->reportesData($reportes, $usuarios);
        return view('page.reportes.index')->with([
            'reportes' => $reportesArray,
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
        $reporte = $this->connect()->collection('Reportes')->document($id)->snapshot()->data();
        // dd($reporte);
        //hacemos lo mismo que hicimos en el index
        $usuarios = $this->selectUsuario();
        $reporte['NombreSocio'] = $usuarios[$reporte['IDSocio']]['Usuario'];
        $reporte['NombreConductor'] = $usuarios[$reporte['IDConductor']]['Usuario'];
        //ahora a FalloDoc le quitamos todo lo que esté antes del /

        
        

        return view('page.reportes.show')->with([
            'reporte' => $reporte,
            'id' => $id,
        ]);
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
        // dd(request()->all());
        $reporte = $this->connect()->collection('Reportes')->document($id);
        $reporte->update([
            ['path' => 'Activo', 'value' => false]
        ]);
        $falloDocRef = $reporte->snapshot()->get('FalloDoc');
        $falloDocId = $falloDocRef->id();
        
        //también actualizamos fallos
        $fallo = $this->connect()->collection('Fallos')->document($falloDocId);
        $fallo->update([
            ['path' => 'Activo', 'value' => false]
        ]);

        return redirect()->route('reportes.index')->with('message', 'Reporte actualizado correctamente')->with('status', 'success');
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

    function selectUsuario()
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

    function reportesData($reportes, $usuarios)
    {
        $reportesArray = [];
        foreach ($reportes as $reporte) {
            $reporteData = $reporte->data();
            $reporteData['NombreSocio'] = $usuarios[$reporteData['IDSocio']]['Usuario'];
            $reporteData['NombreConductor'] = $usuarios[$reporteData['IDConductor']]['Usuario'];
            $reportesArray[$reporte->id()] = $reporteData;
        }
        return $reportesArray;
    }
}
