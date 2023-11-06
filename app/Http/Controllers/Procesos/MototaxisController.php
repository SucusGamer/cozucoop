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
        $mototaxis = $this->connect()->collection('Mototaxis')->documents();
        $usuarios = $this->selectUsuario();

        $mototaxisArray = $this->mototaxisData($mototaxis, $usuarios);
        //sacamos lo que necesitamos de mototaxis
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
        $usuarios = $this->selectUsuarios();
        // dd($numeroMototaxi);
        return view('page.mototaxis.create')->with([
            'usuarios' => $usuarios,
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
            'Unidad' => $request->unidad,
            'IDConductor' => $request->conductor,
            'IDSocio' => $request->socio,
            //como viene con 1 o 0, lo convertimos a booleano
            'Activo' => (bool)$request->activo,
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
        $usuarios = $this->selectUsuarios();
        return view('page.mototaxis.edit')->with([
            'mototaxi' => $mototaxi,
            'usuarios' => $usuarios,
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
            ['path' => 'Unidad', 'value' => $request->unidad],
            ['path' => 'IDConductor', 'value' => $request->conductor],
            ['path' => 'IDSocio', 'value' => $request->socio],
            ['path' => 'Activo', 'value' => (bool)$request->activo],
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

    function selectUsuarios()
    {
        $usuarios = $this->connect()->collection('Usuarios')->documents();
        $usuariosArray = [];
        foreach ($usuarios as $usuario) {
            $usuariosArray[$usuario['IDUsuario']] = $usuario['Usuario'];
        }
        return $usuariosArray;
    }

    //hacemos una función para buscar cuál es el número de mototaxi más alto y así si por ejemplo es 6, el siguiente será el 7
    public function getUnidadMax()
    {
        try{
            $mototaxis = $this->connect()->collection('Mototaxis')->documents();
            $mototaxisArray = [];
            foreach ($mototaxis as $mototaxi) {
                $mototaxisArray[$mototaxi['Unidad']] = $mototaxi['Unidad'];
            }
            $max = max($mototaxisArray);
            $UnidadID = $max + 1;
            
            return response()->json(['UnidadID' => $UnidadID]);
            dd($UnidadID);

        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }

    function mototaxisData($mototaxis, $usuarios)
    {
        
        $mototaxisArray = [];
        foreach ($mototaxis as $mototaxi) {
            $mototaxiData = $mototaxi->data();
            $mototaxiData['NombreSocio'] = $usuarios[$mototaxiData['IDSocio']]['Usuario'];
            $mototaxiData['NombreConductor'] = $usuarios[$mototaxiData['IDConductor']]['Usuario'];
            $mototaxisArray[$mototaxi->id()] = $mototaxiData;
        }
        return $mototaxisArray;
    }

}
