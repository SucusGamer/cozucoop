@extends('layouts.layout')
@section('title', 'Editar Conductor')
@section('extra-js')

@endsection
@section('content')
<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-11">

      <div class="row">
        <div class="col">
          <h1 class="h3">Reporte: {{ $reporte['TipoReporte'] }}</h1>
        </div>
      </div>
      <hr>

      {{-- {{ Breadcrumbs::render('notaries.show', $notary) }} --}}

      <div class="row">
        <div class="col-md-12">
            <div class="d-grid gap-2 d-md-block">
                @if ($reporte['Activo'])
                {{ Form::open(['route' => ['reportes.update',['reporte' => $id]], 'method' => 'PUT']) }}
                  <button type="submit" class="btn btn-warning" style="color: white">Revisado</button>
                {{ Form::close() }}
                @endif
            </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12 my-4">
            <table class="table table-bordered table-striped table-hover">
                <tbody>
                    <tr>
                        <td>Unidad</td>
                        <td>{{ $reporte['Unidad'] }}</td>
                    </tr>
                    <tr>
                        <td>Socio</td>
                        <td>{{ $reporte['NombreSocio'] }}</td>
                    </tr>
                    <tr>
                        <td>Conductor</td>
                        <td>{{ $reporte['NombreConductor'] }}</td>
                    </tr>
                    <tr>
                        <td>Tipo de Reporte</td>
                        <td>{{ $reporte['TipoReporte'] }}</td>
                    </tr>
                    <tr>
                        <td>Descripción</td>
                        <td>{{ $reporte['Descripcion'] }}</td>
                    </tr>
                    <tr>
                        <td>Fecha</td>
                        <td>{{ $reporte['Fecha'] }}</td>
                    </tr>
                    <tr>
                        <td>Estatus</td>
                        <td>{{ $reporte['Activo'] ? 'Si' : 'No' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
      </div>

    </div>
</div>
</div>
@endsection
