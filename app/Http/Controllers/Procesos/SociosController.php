<?php

namespace App\Http\Controllers\Procesos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kreait\Firebase\Factory;

class SociosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function connect()
    {
        $firebase = (new Factory)
            ->withServiceAccount(base_path(env('FIREBASE_CREDETIALS')))
            ->withDatabaseUri(env('FIREBASE_DATABASE_URL'));

        return $firebase->createDatabase();
    }
    public function index()
    {
        $socios = $this->connect()->getReference('socios')->getSnapshot()->getValue();
        return view('page.socios.index')->with([
            'socios' => $socios
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('page.socios.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->connect()->getReference('socios')->push(
            [
                'id' => $this->connect()->getReference('socios')->getSnapshot()->numChildren() + 1,
                'nombre' => $request->nombre,
                'apellidos' => $request->apellidos,
                'usuario' => $request->usuario,
                'contrasena' => $request->contrasena,
                'telefono' => $request->telefono,
                'created_at' => date('d-m-Y H:i:s'),
                'updated_at' => date('d-m-Y H:i:s'),
            ]
        );

        // dd($request->except(['_token']));

        return redirect()->route('socios.index')->with('success', 'Socio creado correctamente');
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
}
