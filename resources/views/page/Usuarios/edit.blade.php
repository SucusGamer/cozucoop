@extends('layouts.layout')
@section('title', 'Editar Usuario')
@section('extra-js')

@endsection
@section('content')
<div class="container my-4 texto-sombra fade-in">
  <div class="row">
    <div class="col-md-12">
      <hr>
      {{-- {{ Breadcrumbs::render() }} --}}
      <div class="col-12">
          {{ Breadcrumbs::render('usuarios.edit', $id, old('back_to') ?? url()->previous()) }}
      </div>
      @php
        //   dd($socio);
      @endphp
        {{ Form::open(['route' => ['usuarios.update',['usuario' => $id]], 'method' => 'PUT', 'id' => 'basicForm']) }}
        @include('page.usuarios.form')
        <div class="text-center mb-3">
          <button type="submit" class="btn btn-warning enviar" style="font-weight: bold;">Actualizar Socio</button>
        </div>
      {{Form::close()}}
    </div>
  </div>
</div>
@endsection
