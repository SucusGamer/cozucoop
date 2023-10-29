@extends('layouts.layout')
@section('title', 'Mototaxis')

@section('extra-js')
@endsection
@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Inicio</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Gestión de Mototaxis</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-12 text-center">
                <h1 class="display-4 mb-4">Gestión de Mototaxis</h1>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="table-responsive">
                    <table id="movimientosTable" class="table table-striped table-hover dataTable">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th>UNIDAD</th>
                                <th>SOCIO</th>
                                <th>CONDUCTOR</th>
                                <th>ESTATUS</th>
                                <th>ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @foreach ($socios as $id => $socio)
                               <tr>
                                    <td>{{ $socio['id'] }}</td>
                                    <td>{{ $socio['nombre'] }}</td>
                                    <td>{{ $socio['apellidos'] }}</td>
                                    <td>{{ $socio['telefono'] }}</td>
                                    <td>{{ $socio['usuario'] }}</td>
                                    <td>{{ Carbon\Carbon::parse($socio['created_at'])->format('d/m/Y') }}</td>
                                    <td></td>
                                    <td>
                                    <a href="#" class="btn btn-info2 btn-sm">Ver Detalles</a>
                                    <a href="#" class="btn btn-warning2 btn-sm">Editar</a>
                                    <a href="#" class="btn btn-danger2 btn-sm">Eliminar</a>
                                </td>
                                </tr>
                            @endforeach --}}
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
                const tableSocios = jQuery('#movimientosTable').DataTable({
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"
                    }
                });
            });
        </script>
    @endpush
@stop
