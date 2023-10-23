@extends('layouts.layout')
@section('title', 'Crear Socio')
@section('extra-js')

@endsection
@section('content')

<div class="container my-4">
  <div class="row">
    <div class="col-md-12">
      <div class="row">
        <div class="col">
          <h1 class="h3">Crear Socio</h1>
        </div>
      </div>
      <hr>
      {{-- {{ Breadcrumbs::render() }} --}}
      {{Form::open(['route' => 'socios.store', 'method' => 'POST'])}}
        @include('page.socios.form')
        <div class="text-center mb-3">
          <button type="submit" class="btn btn-success">Crear Socio</button>
        </div>
      {{Form::close()}}
    </div>
  </div>
</div>


@endsection