<?php

namespace App\Http\Controllers\Procesos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kreait\Firebase\Factory;

class ConductoresController extends Controller
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
    public function auth()
    {
        $factory = (new Factory)
            ->withServiceAccount(base_path(env('FIREBASE_CREDENTIALS')));
        $auth = $factory->createAuth();

        return $auth;
    }


    public function index()
    {
        $conductores = $this->connect()->collection('Conductores')->documents();
        //sacamos lo que necesitamos de conductores
        foreach ($conductores as $conductor) {
            $conductoresArray[$conductor->id()] = $conductor->data();
        }
        return view('page.conductores.index')->with([
            'conductores' => $conductoresArray,
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
        return view('page.conductores.create')->with([
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
        $conductor = $this->connect()->collection('Conductores')->newDocument();
        $conductor->set([
            'IDConductor' => $request->conductor,
            'Nombre' => $request->nombre,
            'Apellidos' => $request->apellidos,
            'Telefono' => $request->telefono,
            'IDSocio' => $request->socio,
            'Activo' => true
        ]);

        return redirect()->route('conductores.index')->with('message', 'Conductor creado correctamente')->with('status', 'success');
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
        $conductor = $this->connect()->collection('Conductores')->document($id)->snapshot()->data();
        $usuarios = $this->selectUsuarios();
        return view('page.conductores.edit')->with([
            'conductor' => $conductor,
            'usuarios' => $usuarios,
            'id' => $id
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
        // dd(request()->all());
        $conductor = $this->connect()->collection('Conductores')->document($id);
        $conductor->update([
            ['path' => 'IDConductor', 'value' => $request->conductor],
            ['path' => 'Nombre', 'value' => $request->nombre],
            ['path' => 'Apellidos', 'value' => $request->apellidos],
            ['path' => 'Telefono', 'value' => $request->telefono],
            ['path' => 'IDSocio', 'value' => $request->socio],
        ]);

        return redirect()->route('conductores.index')->with('message', 'Conductor actualizado correctamente')->with('status', 'success');
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

    function selectUsuarios()
    {
        $usuarios = $this->connect()->collection('Usuarios')->documents();
        $usuariosArray = [];
        foreach ($usuarios as $usuario) {
            $usuariosArray[$usuario['IDUsuario']] = $usuario['Usuario'];
        }
        return $usuariosArray;
    }
}
