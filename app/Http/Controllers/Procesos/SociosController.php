<?php

namespace App\Http\Controllers\Procesos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Kreait\Firebase\Auth;

class SociosController extends Controller
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
    public function getFirebaseUsers()
    {
        $auth = $this->auth();

        try {
            $users = $auth->listUsers($defaultMaxResults = 1000, $defaultBatchSize = 1000);
            return iterator_to_array($users);
        } catch (\Exception $e) {
            // Maneja cualquier error que pueda ocurrir al recuperar los usuarios
            return [];
        }
    }

    public function index()
    {

        $socios = $this->connect()->collection('Socios')->documents();
        //sacamos lo que necesitamos de socios
        foreach ($socios as $socio) {
            $sociosArray[$socio->id()] = $socio->data();
        }
        // dd($sociosArray);

        //ahora buscamos en auth
        $usuarios = $this->getFirebaseUsers();
        // dd($usuarios);
        
        //ahora sacamos sus datos y los ponemos en un array
        $usuariosArray = [];
        foreach ($usuarios as $usuario) {
            $usuariosArray[$usuario->uid] = $usuario->displayName;
        }

        // dd($usuariosArray);


        //
        // $socios = $this->connect()->getReference('socios')->getSnapshot()->getValue();

        return view('page.socios.index')->with([
            'socios' => $sociosArray,
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
        return view('page.socios.create')->with([
            'usuarios' => $usuarios
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
        $socios = $this->connect()->collection('Socios')->newDocument();
        $socios->set([
            'Nombre' => $request->nombre,
            'Apellidos' => $request->apellidos,
            'Telefono' => $request->telefono,
            'Usuario' => $request->nombreUsuario,
            'IDSocio' => $request->usuario,
            'Activo' => true
        ]);

        return redirect()->route('socios.index')->with('message', 'Socio creado correctamente')->with('status', 'success');
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
        // dd($id);
        $socio = $this->connect()->collection('Socios')->document($id)->snapshot()->data();
        // dd($socio);
        $usuarios = $this->selectUsuarios();
        return view('page.socios.edit')->with([
            'socio' => $socio,
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
        $socios = $this->connect()->collection('Socios')->document($id);
        $socios->set([
            'Nombre' => $request->nombre,
            'Apellidos' => $request->apellidos,
            'Telefono' => $request->telefono,
            'Usuario' => $request->nombreUsuario,
            'IDSocio' => $request->usuario,
            'Activo' => true
        ]);

        return redirect()->route('socios.index')->with('message', 'Socio actualizado correctamente')->with('status', 'success');
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
        $usuarios = $this->getFirebaseUsers();
        // dd($usuarios);
        $usuariosArray = [];
        foreach ($usuarios as $usuario) {
            $usuariosArray[$usuario->uid] = $usuario->displayName;
        }
        return $usuariosArray;
    }
}
