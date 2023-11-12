<?php

namespace App\Http\Controllers\Procesos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kreait\Firebase\Exception\Auth\EmailExists;
use Kreait\Firebase\Factory;

class UsuariosController extends Controller
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

        $usuarios = $this->connect()->collection('Usuarios')->documents();
        //sacamos lo que necesitamos de usuarios
        foreach ($usuarios as $usuario) {
            $usuariosArray[$usuario->id()] = $usuario->data();
        }
        return view('page.usuarios.index')->with([
            'usuarios' => $usuariosArray,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('page.usuarios.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all()); //para ver que datos nos llegan
        //vamos a crear un usuario en auth
        try {
            $auth = $this->auth();
            $userProperties = [
                'email' => $request->correo,
                'emailVerified' => false,
                'password' => $request->contrasena,
                'displayName' => $request->usuario,
                'disabled' => false,
                
            ];
            $createdUser = $auth->createUser($userProperties);
            // dd($createdUser->uid);
            //ahora vamos a crear un documento en firestore
            $usuarios = $this->connect()->collection('Usuarios')->newDocument();
            $usuarios->set([
                'IDUsuario' => $createdUser->uid,
                'Nombre' => $request->nombre,
                'Apellidos' => $request->apellidos,
                'Telefono' => $request->telefono,
                'Usuario' => $request->usuario,
                'Correo' => $request->correo,
                'Contrasena' => $request->contrasena,
                'Tipo' => $request->tipo,
                'Estatus' => $request->estatus,
            ]);

            //si el usuario es de tipo Administrador, vamos a agregarle el claim de admin
            if ($request->tipo == 'Administrador') {
                $auth->setCustomUserClaims($createdUser->uid, ['admin' => true]);
            } else {
                $auth->setCustomUserClaims($createdUser->uid, ['admin' => false]);
            }
            return redirect()->route('usuarios.index')->with('message', 'Usuario creado correctamente')->with('status', 'success');
        } catch (EmailExists $e) {
            return redirect()->route('usuarios.index')->with('message', 'El correo ya existe')->with('status', false);
        }
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
        $usuario = $this->connect()->collection('Usuarios')->document($id)->snapshot()->data();
        // dd($usuario);
        return view('page.usuarios.edit')->with([
            'usuario' => $usuario,
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
        //como vamos a actualizar el usuario en auth, primero lo buscamos, en Auth
       
        $auth = $this->auth();
        //buscamos el usuario en firestore para sacar el uid
        $usuario = $this->connect()->collection('Usuarios')->document($id)->snapshot()->data();
        $user = $auth->getUser($usuario['IDUsuario']);
        if ($request->correo != $usuario['Correo']) {
            $auth->disableUser($user->uid);
            $userProperties = [
                'email' => $request->correo,
                'emailVerified' => false,
                // 'password' => $request->contrasena,
                'displayName' => $request->usuario,
                'disabled' => false,
            ];
            $updatedUser = $auth->updateUser($user->uid, $userProperties);
            $auth->enableUser($user->uid);
        } else {
            $userProperties = [
                'email' => $request->correo,
                'emailVerified' => false,
                // 'password' => $request->contrasena,
                'displayName' => $request->usuario,
                'disabled' => false,
            ];
            $updatedUser = $auth->updateUser($user->uid, $userProperties);
        }

        // $updatedUser = $auth->updateUser($id, $userProperties);
        //ahora vamos a actualizar el usuario en firestore
        $usuarios = $this->connect()->collection('Usuarios')->document($id);
        $usuarios->update([
            ['path' => 'Nombre', 'value' => $request->nombre],
            ['path' => 'Apellidos', 'value' => $request->apellidos],
            ['path' => 'Telefono', 'value' => $request->telefono],
            ['path' => 'Usuario', 'value' => $request->usuario],
            ['path' => 'Correo', 'value' => $request->correo],
            // ['path' => 'Contrasena', 'value' => $request->contrasena],
            ['path' => 'Tipo', 'value' => $request->tipo],
            ['path' => 'Estatus', 'value' => $request->estatus],
        ]);

        //si el estatus es 0, vamos a deshabilitar el usuario en auth
        if ($request->estatus == 0) {
            $auth->disableUser($user->uid);
        } else {
            $auth->enableUser($user->uid);
        }

        //si el usuario es de tipo Administrador, vamos a agregarle el claim de admin
        if ($request->tipo == 'Administrador') {
            $auth->setCustomUserClaims($user->uid, ['admin' => true]);
        } else {
            $auth->setCustomUserClaims($user->uid, ['admin' => false]);
        }
        
        return redirect()->route('usuarios.index')->with('message', 'Usuario actualizado correctamente')->with('status', 'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
                //buscamos el usuario en firestore para sacar el uid
                $usuario = $this->connect()->collection('Usuarios')->document($id)->snapshot()->data();
                $auth = $this->auth();
                //lo que vamos a hacer es deshabilitar el usuario en auth
                $user = $auth->getUser($usuario['IDUsuario']);
                $auth->disableUser($user->uid);
                //ahora vamos a cambiar el estado del usuario en firestore

                $usuarios = $this->connect()->collection('Usuarios')->document($id);
                $usuarios->update([
                    ['path' => 'Estatus', 'value' => '0'],
                ]);
                return redirect()->route('usuarios.index')->with('message', 'Usuario eliminado correctamente')->with('status', 'success');
    }
}
