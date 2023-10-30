@extends('layouts.layout')
@section('title', 'Editar Socio')
@section('extra-js')

@endsection
@section('content')
<div class="container my-4">
  <div class="row">
    <div class="col-md-12">
      <div class="row">
        <div class="col text-center">
          <h1 class="h2">Editar Socio</h1>
        </div>
      </div>
      <hr>
      {{-- {{ Breadcrumbs::render() }} --}}
      @php
        //   dd($socio);
      @endphp
        {{ Form::open(['route' => ['socios.update',['socio' => $id]], 'method' => 'PUT']) }}
        @include('page.socios.form')
        <div class="text-center mb-3">
          <button type="submit" class="btn btn-success">Actualizar Socio</button>
        </div>
      {{Form::close()}}
    </div>
  </div>
</div>
@endsection