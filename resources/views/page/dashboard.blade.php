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
            <h2 class="text-center">Fallos</h2>
        </div>
        
        @foreach($fallosActivos as $id => $fallo)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $fallo['TipoDeFallo'] }}</h5>
                        <span class="badge bg-success">Activo</span>
                        <p class="card-text">{{ $fallo['Descripcion'] }}</p>
                        
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><i class="fas fa-user"></i> Socio: {{ $fallo['NombreSocio'] }}</li>
                            <li class="list-group-item"><i class="fas fa-user-tie"></i> Conductor: {{ $fallo['NombreConductor'] }}</li>
                            <li class="list-group-item"><i class="fas fa-bus"></i> Unidad: {{ $fallo['Unidad'] }}</li>
                            <li class="list-group-item"><i class="far fa-calendar"></i> Fecha: {{ $fallo['Fecha'] }}</li>
                        </ul>

                        {{-- <div class="text-center mt-3">
                            <a href="#" class="btn btn-primary">Ver Detalles</a>
                        </div> --}}
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row mt-4">
        <div class="col-12 mb-4">
            <h2 class="text-center">Reportes</h2>
        </div>
    
        @foreach($reportes as $id => $reporte)
            <div class="col-md-4 mb-4">
                <div class="card shadow rounded">
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
    </div>



</div>
@stop
