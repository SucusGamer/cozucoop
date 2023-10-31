@extends('layouts.layout')
@section('title', 'Crear Usuario')
@section('extra-js')

@endsection
@section('content')

<div class="container my-4">
  <div class="row">
    <div class="col-md-12">
      <div class="row">
        <div class="col text-center">
          <h1 class="h2">Crear Usuario</h1>
        </div>
      </div>
      <hr>
      {{-- {{ Breadcrumbs::render() }} --}}
      {{Form::open(['route' => 'usuarios.store', 'method' => 'POST'])}}
        @include('page.usuarios.form')
        <div class="text-center mb-3">
          <button type="submit" class="btn btn-success">Crear Usuario</button>
        </div>
      {{Form::close()}}
    </div>
  </div>
</div>


@endsection
