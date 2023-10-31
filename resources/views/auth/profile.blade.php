@extends('layouts.layout')

@section('content')
<div class="container">
    @if(Session::has('message'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            {{ Session::get('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ $error }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endforeach
    @endif

    @if(Session::has('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ Session::get('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-lg-4">
            <h4 class="mb-4">Información de Perfil</h4>
            <p class="text-justify mb-3">
                Actualiza la información de perfil y la dirección de correo electrónico de tu cuenta.
                Cuando cambies tu correo electrónico, necesitarás verificarlo para evitar que la cuenta se bloquee.
            </p>
        </div>

        <div class="col-lg-8 text-center pt-0">
            <div class="card py-4 mb-5 mt-md-3 rounded shadow-lg">
                {!! Form::model($user, ['method'=>'PATCH', 'action'=> ['App\Http\Controllers\Auth\ProfileController@update',$user->uid]]) !!}
                
                <div class="form-group px-3 mb-3">
                    {!! Form::label('displayName', 'Nombre', ['class' => 'form-label text-start']) !!}
                    {!! Form::text('displayName', null, ['class'=>'form-control'])!!}

                    {!! Form::label('email', 'Correo Electrónico', ['class' => 'form-label pt-3 text-start']) !!}
                    {!! Form::email('email', null, ['class'=>'form-control'])!!}
                </div>

                <div class="form-group row mb-0 me-4">
                    <div class="col-md-8 offset-md-4 text-end">
                        {!! Form::submit('Guardar', ['class'=>'btn btn-primary']) !!}
                    </div>
                </div>

                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <hr class="border border-grey">

    <div class="row justify-content-center pt-5">
        <div class="col-lg-4">
            <h4 class="mb-4">Actualizar Contraseña</h4>
            <p class="text-justify">
                Asegúrate de que tu cuenta utilice una contraseña larga y aleatoria para mantenerla segura.
            </p>
        </div>

        <div class="col-lg-8 text-center pt-0">
            <div class="card py-4 mb-5 mt-md-3 rounded shadow-lg">
                {!! Form::open() !!}
                <div class="form-group px-3 mb-3">
                    {!! Form::label('new_password', 'Nueva Contraseña:', ['class' => 'form-label text-start']) !!}
                    {!! Form::password('new_password', ['class'=>'form-control'])!!}
                </div>

                <div class="form-group px-3 mb-3">
                    {!! Form::label('new_confirm_password', 'Confirmar Contraseña:', ['class' => 'form-label text-start']) !!}
                    {!! Form::password('new_confirm_password', ['class'=>'form-control'])!!}
                </div>

                <div class="form-group row mb-0 me-4">
                    <div class="col-md-8 offset-md-4 text-end">
                        {!! Form::submit('Guardar', ['class'=>'btn btn-primary']) !!}
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <hr class="border border-grey">

    <div class="row justify-content-center pt-5">
        <div class="col-lg-4">
            <h4 class="mb-4">Eliminar Cuenta</h4>
            <p class="text-justify">
                Elimina permanentemente tu cuenta.
            </p>
        </div>

        <div class="col-lg-8 pt-0">
            <div class="card py-4 mb-5 mt-md-3 rounded shadow-lg">
                <div class="text-left px-3">
                    Una vez que tu cuenta sea eliminada, todos sus recursos y datos serán eliminados de forma permanente. Antes de eliminar tu cuenta, por favor descarga cualquier dato o información que desees conservar.
                </div>
                {!! Form::open(['method'=>'DELETE', 'action' =>['App\Http\Controllers\Auth\ProfileController@destroy',$user->uid]]) !!}
                <div class="form-group row mb-0 mr-4 pt-4 px-3">
                    <div class="col-md-8 offset-md-4 text-start">
                        {!! Form::submit('Eliminar Cuenta', ['class'=>'btn btn-danger pl-3']) !!}
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

</div>
@endsection
