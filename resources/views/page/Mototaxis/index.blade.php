@extends('layouts.layout')
@section('title', 'Mototaxis')

@section('extra-js')
@endsection
@section('content')
    <div class="container my-5 texto-sombra fade-in">
        <div class="row">
            <div class="col-12">
                {{ Breadcrumbs::render() }}
            </div>
        </div>

        <div class="row">

        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="card border-primary mb-3" style="border-radius: 20px;padding: 4px">
                    <div class="col-12 text-center">
                        <h1 class="display-4 mb-4">Gestión de Mototaxis</h1>
                        <a href="{{ route('mototaxis.create') }}" class="btn btn-primary" style="font-weight: bold">Agregar Nueva Unidad</a>
                    </div>
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
                                @foreach ($mototaxis as $id => $mototaxi)
                                   <tr>
                                        <td>{{ $mototaxi['Unidad'] }}</td>
                                        <td>{{ $mototaxi['NombreSocio'] }}</td>
                                        <td>{{ $mototaxi['NombreConductor'] }}</td>
                                        <td>
                                            <span class="badge {{ $mototaxi['Estatus'] ? 'bg-success' : 'bg-danger' }}">
                                                {{ $mototaxi['Estatus'] ? 'Activo' : 'Inactivo' }}
                                            </span>
                                        </td>
                                        <td>
                                        <a href="{{ route('mototaxis.edit', ['mototaxi' => $id]) }}" class="btn btn-warning btn-sm" style="font-weight: bold;">Editar</a>
                                        {{-- {{Form::open(['route' => ['mototaxis.destroy',['mototaxi' => $id]], 'method' => 'DELETE', 'class' => 'd-inline'])}}
                                            <button type="submit" class="btn btn-danger2 btn-sm delete">Eliminar</button>
                                        {{Form::close()}} --}}
                                    </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
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
                const tableSocios = jQuery('#movimientosTable').DataTable({
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"
                    }
                });
            });
        </script>
    @endpush
@stop
