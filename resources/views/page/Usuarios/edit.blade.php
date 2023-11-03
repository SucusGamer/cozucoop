@extends('layouts.layout')
@section('title', 'Editar Usuario')
@section('extra-js')

@endsection
@section('content')
<div class="container my-4">
  <div class="row">
    <div class="col-md-12">
      <hr>
      {{-- {{ Breadcrumbs::render() }} --}}
      @php
        //   dd($socio);
      @endphp
        {{ Form::open(['route' => ['usuarios.update',['usuario' => $id]], 'method' => 'PUT']) }}
        @include('page.usuarios.form')
        <div class="text-center mb-3">
          <button type="submit" class="btn btn-primary">Actualizar Socio</button>
        </div>
      {{Form::close()}}
    </div>
  </div>
</div>
@endsection
