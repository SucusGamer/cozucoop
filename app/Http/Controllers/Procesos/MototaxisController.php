<?php

namespace App\Http\Controllers\Procesos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kreait\Firebase\Factory;

class MototaxisController extends Controller
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
        $mototaxisArray = $this->getMototaxisWithUserData();

        // dd($mototaxisArray);

        return view('page.mototaxis.index')->with([
            'mototaxis' => $mototaxisArray,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $socios = $this->selectSocios();
        $conductores = $this->selectConductores();
        // dd($numeroMototaxi);
        return view('page.mototaxis.create')->with([
            'socios' => $socios,
            'conductores' => $conductores,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd(request()->all());

        $conductor = $this->connect()->collection('Mototaxis')->newDocument();
        $conductor->set([
            'Unidad' => (int)$request->unidad,
            'IDConductor' => $request->conductor,
            'IDSocio' => $request->socio,
            'Estatus' => $request->estatus,
        ]);

        return redirect()->route('mototaxis.index')->with('message', 'Mototaxi creado correctamente')->with('status', 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $mototaxi = $this->connect()->collection('Mototaxis')->document($id)->snapshot()->data();
        // dd($mototaxi);
        $socios = $this->selectSocios();
        $conductores = $this->selectConductores();


        return view('page.mototaxis.edit')->with([
            'mototaxi' => $mototaxi,
            'socios' => $socios,
            'conductores' => $conductores,
            'id' => $id,
        ]);
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
        // dd(request()->activo);
        $mototaxi = $this->connect()->collection('Mototaxis')->document($id);
        $mototaxi->update([
            ['path' => 'Unidad', 'value' => (int)$request->unidad],
            ['path' => 'IDConductor', 'value' => $request->conductor],
            ['path' => 'IDSocio', 'value' => $request->socio],
            ['path' => 'Estatus', 'value' => $request->estatus],
        ]);

        return redirect()->route('mototaxis.index')->with('message', 'Mototaxi actualizado correctamente')->with('status', 'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $mototaxi = $this->connect()->collection('Mototaxis')->document($id);
        $mototaxi->delete();

        return redirect()->route('mototaxis.index')->with('message', 'Mototaxi eliminado correctamente')->with('status', 'success');
    }

    function selectSocios()
    {
        $socios = $this->connect()->collection('Usuarios')->where('Tipo', '=', 'Socio')->documents();
        $sociosArray = [];
        foreach ($socios as $socio) {
            $sociosArray[$socio['IDUsuario']] = $socio['Usuario'];
        }
        return $sociosArray;
    }

    //hacemos un where para que solo nos muestre los conductores
    function selectConductores()
    {
        $conductores = $this->connect()->collection('Usuarios')->where('Tipo', '=', 'Conductor')->documents();
        $conductoresArray = [];
        foreach ($conductores as $conductor) {
            $conductoresArray[$conductor['IDUsuario']] = $conductor['Usuario'];
        }
        return $conductoresArray;
    }

    //hacemos una función para buscar cuál es el número de mototaxi más alto y así si por ejemplo es 6, el siguiente será el 7
    public function getUnidadMax()
    {
        try {
            $mototaxis = $this->connect()->collection('Mototaxis')->documents();

            $mototaxisArray = [];
            foreach ($mototaxis as $mototaxi) {
                $mototaxisArray[] = $mototaxi['Unidad'];
            }

            // Verificar si hay elementos en el array antes de calcular el máximo
            if (count($mototaxisArray) > 0) {
                $max = max($mototaxisArray);
                $UnidadID = $max + 1;
            } else {
                // Si no hay mototaxis, el primer mototaxi será el 1
                $UnidadID = 1;
            }

            return response()->json(['UnidadID' => $UnidadID]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }

    protected function getMototaxisWithUserData()
    {
        $mototaxis = $this->connect()->collection('Mototaxis')->documents();
        $usuarios = $this->connect()->collection('Usuarios')->documents();

        $usuariosArray = $this->buildUsuariosArray($usuarios);
        $mototaxisArray = $this->buildMototaxisArray($mototaxis, $usuariosArray);

        return $mototaxisArray;
    }

    protected function buildUsuariosArray($usuarios)
    {
        $usuariosArray = [];

        foreach ($usuarios as $usuario) {
            $usuariosArray[$usuario->data()['IDUsuario']] = $usuario->data();
        }

        return $usuariosArray;
    }

    protected function buildMototaxisArray($mototaxis, $usuariosArray)
    {
        $mototaxisArray = [];

        foreach ($mototaxis as $mototaxi) {
            $mototaxiData = $mototaxi->data();

            $mototaxiData['NombreSocio'] = $usuariosArray[$mototaxiData['IDSocio']]['Usuario'];
            $mototaxiData['NombreConductor'] = $usuariosArray[$mototaxiData['IDConductor']]['Usuario'];

            $mototaxisArray[$mototaxi->id()] = $mototaxiData;
        }

        return $mototaxisArray;
    }
}
