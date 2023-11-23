@extends('layouts.layout')

@section('title', 'Inicio')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 mt-2">
            <h1 class="text-center">Dashboard</h1>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12 mb-4">
            <h2 class="text-center">Reportes</h2>
        </div>

        @if(count($reportes) > 0)
            @foreach($reportes as $id => $reporte)
                <div class="col-md-4 mb-4">
                    <div class="card border-success mb-3 report-card" style="border-radius: 15px;padding: 10px">
                        <div class="card-body">
                            <h5 class="card-title">{{ $reporte['TipoReporte'] }}</h5>
                            <span class="badge bg-success">Activo</span>
                            <p class="card-text">{{ $reporte['Descripcion'] }}</p>

                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><i class="fas fa-user me-2"></i> Socio: {{ $reporte['NombreSocio'] }}</li>
                                <li class="list-group-item"><i class="fas fa-user-tie me-2"></i> Conductor: {{ $reporte['NombreConductor'] }}</li>
                                <li class="list-group-item"><i class="fas fa-bus me-2"></i> Unidad: {{ $reporte['Unidad'] }}</li>
                                <li class="list-group-item"><i class="far fa-calendar me-2"></i> Fecha: {{ $reporte['Fecha'] }}</li>
                            </ul>

                            {{-- <div class="text-center mt-3">
                                <a href="#" class="btn btn-primary">Ver Detalles</a>
                            </div> --}}
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-md-12 mb-4">
                <div class="card border-success mb-3" style="border-radius: 15px;padding: 10px">
                    <div class="card-body">
                        <h5 class="card-title">Todo en orden</h5>
                        <p class="card-text">No hay reportes disponibles en este momento.</p>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Resumen de Actividad Reciente
                </div>
                <div class="card-body">
                    <canvas id="grafico"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Resumen de Actividad Reciente
                </div>
                <div class="card-body">
                    <canvas id="grafico2"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6 mt-4">
            <div class="card">
                <div class="card-header">
                    Resumen de Actividad Reciente
                </div>
                <div class="card-body">
                    <canvas id="grafico3"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6 mt-4">
            <div class="card">
                <div class="card-header">
                    Resumen de Actividad Reciente
                </div>
                <div class="card-body">
                    <canvas id="grafico4"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Generar Reporte Diario
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        {!! Form::open([
                            'route' => 'reporteria.diario',
                            'method' => 'POST',
                            'id' => 'formValidate',
                        ]) !!}
                        {!! Form::submit('Exportar Excel', ['class' => 'btn btn-info', 'name' => 'action']) !!}
                        {!! Form::submit('Exportar PDF', ['class' => 'btn btn-danger', 'name' => 'action']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Generar Reporte Mensual
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        {!! Form::open([
                            'route' => 'reporteria.mensual',
                            'method' => 'POST',
                            'id' => 'formValidate',
                        ]) !!}
                        {!! Form::submit('Exportar Excel', ['class' => 'btn btn-info', 'name' => 'action']) !!}
                        {!! Form::submit('Exportar PDF', ['class' => 'btn btn-danger', 'name' => 'action']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>


@include('include.mensaje')

</div>
@push('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('js/charts.js') }}"></script>



@endpush
@stop
