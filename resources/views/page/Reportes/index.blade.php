@extends('layouts.layout')
@section('title', 'Reportes')

@section('extra-js')
@endsection
@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Inicio</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Gestión de Reportes</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-12 text-center">
                <h1 class="display-4 mb-4">Gestión de Reportes</h1>
                {{-- <a href="{{ route('reportes.create') }}" class="btn btn-primary2">Agregar Nuevo Socio</a> --}}
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="card border-primary mb-3" style="border-radius: 20px;padding: 10px">
                    <div class="table-responsive">
                        <table id="reportesTable" class="table table-striped table-hover dataTable">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th>UNIDAD</th>
                                    <th>SOCIO</th>
                                    <th>CONDUCTOR</th>
                                    <th>TIPO DE REPORTE</th>
                                    <th>FECHA</th>
                                    <th>ESTATUS</th>
                                    <th>ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reportes as $id => $reporte)
                                    <tr>
                                        <td>{{ $reporte['Unidad'] }}</td>
                                        <td>{{ $reporte['NombreSocio'] }}</td>
                                        <td>{{ $reporte['NombreConductor'] }}</td>
                                        <td>{{ $reporte['TipoReporte'] }}</td>
                                        <td>{{ $reporte['Fecha'] }}</td>
                                        <td>{{ $reporte['Activo'] ? 'Si' : 'No' }}</td>
                                        <td>
                                            {{-- <a href="{{ route('reportes.edit', ['reporte' => $id]) }}" class="btn btn-warning2 btn-sm">Editar</a> --}}
                                            <a href="{{ route('reportes.show', ['reporte' => $id]) }}"
                                             class="btn btn-info2 btn-sm">Ver</a>
                                            {{-- <form action="{{ route('reportes.destroy', $reporte['IDSocio']) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger2 btn-sm" onclick="return confirm('¿Estás seguro de eliminar este registro?')">Eliminar</button>
                                            </form> --}}
                                        </td>
                                        {{-- <td>
                                            <a href="#" class="btn btn-info2 btn-sm">Ver Detalles</a>
                                            <a href="#" class="btn btn-warning2 btn-sm">Editar</a>
                                            <a href="#" class="btn btn-danger2 btn-sm">Eliminar</a>
                                        </td> --}}
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('include.mensaje')
    @push('script')
        <script>
            $(document).ready(function() {
                //hacemos la tabla dinamica
                const tableSocios = jQuery('#reportesTable').DataTable({
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"
                    }
                });
            });
        </script>
    @endpush
@stop
