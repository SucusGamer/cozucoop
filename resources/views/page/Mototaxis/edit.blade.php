@extends('layouts.layout')
@section('title', 'Editar Mototaxi')
@section('extra-js')

@endsection
@section('content')
<div class="container my-4">
  <div class="row">
    <div class="col-md-12">
      <hr>
      {{-- {{ Breadcrumbs::render() }} --}}
        {{ Form::open(['route' => ['mototaxis.update',['mototaxi' => $id]], 'method' => 'PUT']) }}
        @include('page.mototaxis.form')
        <div class="text-center mb-3">
          <button type="submit" class="btn btn-primary2">Actualizar Mototaxi</button>
        </div>
      {{Form::close()}}
    </div>
  </div>
</div>
@endsection
