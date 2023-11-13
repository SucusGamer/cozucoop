@extends('layouts.layout')
@section('title', 'Usuarios')

@section('extra-js')
@endsection
@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col-12">
                {{ Breadcrumbs::render() }}
            </div>
        </div>

        <div class="row">
            <div class="col-12 text-center">
                <h1 class="display-4 mb-4">Gestión de Usuarios</h1>
                <a href="{{ route('usuarios.create') }}" class="btn btn-primary2">Agregar Nuevo Usuario</a>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="card border-primary mb-3" style="border-radius: 20px;padding: 10px">
                    <div class="table-responsive">
                        <table id="sociosTable" class="table table-striped table-hover dataTable">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th>NOMBRE</th>
                                    <th>USUARIO</th>
                                    <th>CORREO</th>
                                    <th>TIPO</th>
                                    <th>ESTATUS</th>
                                    <th>ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($usuarios as $id => $usuario)
                                    <tr>
                                        <td>
                                            {{ isset($usuario['Nombre']) && isset($usuario['Apellidos']) ? $usuario['Nombre'] . ' ' . $usuario['Apellidos'] : 'Sin descripción' }}
                                        </td>
                                        <td>{{ $usuario['Usuario'] }}</td>
                                        <td>{{ $usuario['Correo'] }}</td>
                                        <td>{{ isset($usuario['Tipo']) ? $usuario['Tipo'] : 'Sin descripción' }}</td>
                                        <td>{{ isset($usuario['Estatus']) ? $usuario['Estatus'] : 'Sin descripción' }}</td>
                                        <td>
                                            <a href="{{ route('usuarios.edit', ['usuario' => $id]) }}"
                                                class="btn btn-warning2 btn-sm">Editar</a>
                                            {{-- @if ($usuario['Estatus'] == 1) --}}
                                            {{Form::open(['route' => ['usuarios.destroy',['usuario' => $id]], 'method' => 'DELETE', 'class' => 'd-inline'])}}
                                                <button type="submit" class="btn btn-danger2 btn-sm delete">Eliminar</button>
                                            {{Form::close()}}
                                            {{-- @endif --}}
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
