@extends('layouts.layout')
@section('title', 'Editar Conductor')
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
        {{ Form::open(['route' => ['conductores.update',['conductore' => $id]], 'method' => 'PUT']) }}
        @include('page.conductores.form')
        <div class="text-center mb-3">
          <button type="submit" class="btn btn-primary2">Actualizar Conductor</button>
        </div>
      {{Form::close()}}
    </div>
  </div>
</div>
@endsection
