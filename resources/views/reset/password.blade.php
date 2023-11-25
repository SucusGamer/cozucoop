@extends('layouts.layout')
@section('title', 'Olvidé mi contraseña')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-warning mb-3" style="border-radius:20px">
                <div class="card-header bg-transparent border-warning">Restablecer contraseña</div>
                <div class="card-body">

                    @if(Session::has('message'))
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        {{ Session::get('message') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    @if(Session::has('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ Session::get('error') }}
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

                    {!! Form::open(['method'=>'POST', 'action'=> 'App\Http\Controllers\Auth\ResetController@store']) !!}

                    <div class="mb-3">
                        {!! Form::label('email', 'Correo Electrónico:', ['class' => 'form-label']) !!}
                        {!! Form::email('email', null, ['class'=>'form-control'])!!}
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        {!! Form::submit('Enviar correo', ['class'=>'btn btn-warning btn-block']) !!}
                    </div>

                    {!! Form::close() !!}

                </div>

            </div>
        </div>
    </div>
</div>

@endsection
