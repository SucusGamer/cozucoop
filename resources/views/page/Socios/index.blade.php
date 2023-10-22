@extends('layouts.layout')

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
            <a href="#" class="btn btn-primary2">Crear Nuevo Socio</a>
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
                            <th>TELEFONO</th>
                            <th>USUARIO</th>
                            <th>FECHA DE REGISTRO</th>
                            <th>ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>John Doe</td>
                            <td>1234567890</td>
                            <td>S001</td>
                            <td>2023-10-19</td>
                            <td>
                                <a href="#" class="btn btn-info2 btn-sm">Ver Detalles</a>
                                <a href="#" class="btn btn-warning2 btn-sm">Editar</a>
                                <a href="#" class="btn btn-danger2 btn-sm">Eliminar</a>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Jane Smith</td>
                            <td>1234567890</td>
                            <td>S002</td>
                            <td>2023-10-20</td>
                            <td>
                                <a href="#" class="btn btn-info2 btn-sm">Ver Detalles</a>
                                <a href="#" class="btn btn-warning2 btn-sm">Editar</a>
                                <a href="#" class="btn btn-danger2 btn-sm">Eliminar</a>
                            </td>
                        </tr>
                        <!-- Agrega más filas según sea necesario -->
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
