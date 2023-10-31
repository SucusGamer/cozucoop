@extends('layouts.layout')
@section('title', 'Conductores')

@section('extra-js')
@endsection
@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Inicio</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Gestión de Conductores</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-12 text-center">
                <h1 class="display-4 mb-4">Gestión de Conductores</h1>
                <a href="{{ route('conductores.create') }}" class="btn btn-primary2">Agregar Nuevo Conductor</a>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="table-responsive">
                    <table id="conductoresTable" class="table table-striped table-hover dataTable">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th>ID</th>
                                <th>NOMBRE</th>
                                <th>APELLIDOS</th>
                                <th>TELEFONO</th>
                                <th>ACTIVO</th>
                                <th>ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($conductores as $id => $conductor)
                            <tr>
                                <td>{{ $conductor['IDConductor'] }}</td>
                                <td>{{ $conductor['Nombre'] }}</td>
                                <td>{{ $conductor['Apellidos'] }}</td>
                                <td>{{ $conductor['Telefono'] }}</td>
                                <td>{{ $conductor['Activo'] ? 'Si' : 'No' }}</td>
                                <td>
                                    <a href="{{ route('conductores.edit', ['conductore' => $id]) }}" class="btn btn-warning2 btn-sm">Editar</a>
                                    {{-- <a href="{{ route('socios.show', $socio['IDSocio']) }}" class="btn btn-info2 btn-sm">Ver</a> --}}
                                    {{-- <form action="{{ route('socios.destroy', $socio['IDSocio']) }}" method="POST" class="d-inline">
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
    @include('include.mensaje')
    @push('script')
        <script>
            $(document).ready(function() {
                //hacemos la tabla dinamica
                const tableSocios = jQuery('#conductoresTable').DataTable({
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"
                    }
                });
            });
        </script>
    @endpush
@stop
