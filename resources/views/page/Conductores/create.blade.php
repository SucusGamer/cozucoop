@extends('layouts.layout')
@section('title', 'Crear Conductor')
@section('extra-js')

@endsection
@section('content')

<div class="container my-4">
  <div class="row">
    <div class="col-md-12">
      <div class="row">
        <div class="col text-center">
          <h1 class="h2">Crear Conductor</h1>
        </div>
      </div>
      <hr>
      {{-- {{ Breadcrumbs::render() }} --}}
      {{Form::open(['route' => 'conductores.store', 'method' => 'POST'])}}
        @include('page.conductores.form')
        <div class="text-center mb-3">
          <button type="submit" class="btn btn-success">Crear Conductor</button>
        </div>
      {{Form::close()}}
    </div>
  </div>
</div>


@endsection
