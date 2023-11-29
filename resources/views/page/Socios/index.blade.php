@extends('layouts.layout')
@section('title', 'Socios')

@section('extra-js')
@endsection
@section('content')
    <div class="container my-5 texto-sombra fade-in">
        <div class="row">
            <div class="col-12">
                {{ Breadcrumbs::render() }}
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="card border-primary mb-3" style="border-radius: 20px;padding: 4px">
                    <div class="col-12 text-center">
                        <h1 class="display-4 mb-4">Gestión de Socios</h1>
                        {{-- <a href="{{ route('socios.create') }}" class="btn btn-primary2">Agregar Nuevo Socio</a> --}}
                    </div>
                    <div class="table-responsive">
                        <table id="sociosTable" class="table table-striped table-hover dataTable">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th>NOMBRE</th>
                                    <th>APELLIDOS</th>
                                    <th>USUARIO</th>
                                    <th>TELEFONO</th>
                                    <th>ESTATUS</th>
                                    {{-- <th>ACCIONES</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($socios as $id => $socio)
                                    <tr>
                                        <td>{{ $socio['Nombre'] }}</td>
                                        <td>{{ $socio['Apellidos'] }}</td>
                                        <td>{{ $socio['Usuario'] }}</td>
                                        <td>{{ $socio['Telefono'] }}</td>
                                        <td>
                                            <span class="badge {{ $socio['Estatus'] ? 'bg-success' : 'bg-danger' }}">
                                                {{ $socio['Estatus'] ? 'Activo' : 'Inactivo' }}
                                            </span>
                                        </td>
                                        {{-- <td>
                                            <a href="{{ route('socios.edit', ['socio' => $id]) }}" class="btn btn-warning2 btn-sm">Editar</a>
                                            <a href="{{ route('socios.show', $socio['IDSocio']) }}" class="btn btn-info2 btn-sm">Ver</a>
                                        </td> --}}
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
                const tableSocios = jQuery('#sociosTable').DataTable({
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"
                    }
                });
            });
        </script>
    @endpush
@stop
