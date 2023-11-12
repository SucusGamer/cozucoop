@extends('layouts.layout')
@section('title', 'Crear Usuario')
@section('extra-js')

@endsection
@section('content')

<div class="container my-4">
  <div class="row">
    <div class="col-md-12">
      <hr>
      {{-- {{ Breadcrumbs::render() }} --}}
      {{Form::open(['route' => 'usuarios.store','id' => 'basicForm', 'method' => 'POST'])}}
        @include('page.usuarios.form')
        <div class="text-center mb-3">
          <button type="submit" class="btn btn-primary2 enviar">Crear Usuario</button>
        </div>
      {{Form::close()}}
    </div>
  </div>
</div>


@endsection
