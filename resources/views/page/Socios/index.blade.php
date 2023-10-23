@extends('layouts.layout')
@section('title', 'Socios')

@section('extra-js')
@endsection
@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Inicio</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Gestión de Socios</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-12 text-center">
            <h1 class="display-4 mb-4">Gestión de Socios</h1>
            <a href="{{ route('socios.create')}}" class="btn btn-primary2">Crear Nuevo Socio</a>
        </div>
    </div>

<div class="row mt-4">
        <div class="col-12">
            <div class="table-responsive">
                <table id="sociosTable" class="table table-striped table-hover dataTable">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>ID</th>
                            <th>NOMBRE</th>
                            <th>APELLIDOS</th>
                            <th>TELEFONO</th>
                            <th>USUARIO</th>
                            <th>FECHA DE REGISTRO</th>
                            <th>ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($socios as $id => $socio)
                        <tr>
                            <td>{{ $socio['id'] }}</td>
                            <td>{{ $socio['nombre'] }}</td>
                            <td>{{ $socio['apellidos'] }}</td>
                            <td>{{ $socio['telefono'] }}</td>
                            <td>{{ $socio['usuario'] }}</td>
                            <td>{{ Carbon\Carbon::parse($socio['created_at'])->format('d/m/Y') }}</td>
                            <td></td>
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
@push('script')
    <script>
        $(document).ready(function() {
            //hacemos la tabla dinamica
           const tableSocios = jQuery('#sociosTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"
                }
            });
        });
    </script>

@endpush
@stop
