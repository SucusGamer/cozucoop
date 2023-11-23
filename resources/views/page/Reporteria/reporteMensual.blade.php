<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>REPORTE MENSUAL</title>
    <style>
        * {
            padding: 0;
            margin: 0;
        }
        /* th, td {
            width: 25%;
            text-align: center;
           padding: 0.6em;
        }
        caption {
           padding: 0.6em;
        } */
        body {
            font-family: helvetica;
            font-size: 12px;
            color: black;
            text-align: center;
            border-spacing: 0;
            border-collapse: collapse;
            margin: 25;
        }

        .page-break {
            page-break-after: always;
        }

        .ancho {
            width: 100%;
            text-align: center;
        }

        .cabecera {
            width: 100%;
            text-align: center;
            padding: 10px;
        }

        .cabecera .logo img {
            width: 100%;
            max-width: 150px;
            height: 100px;
            height: 100%;
            max-height: 100px;
            margin: auto;
        }

        .info-empresa,
        .logo,
        .info-compra {
            margin: auto;
            text-align: center;
            width: 33.33%;
        }

        .cabecera .info-empresa h3,
        .cabecera .info-compra h3,
        .cabecera .info-compra p {
            letter-spacing: 1px;
            margin-bottom: 2px;
        }
        .resumen-table {
            width: 50%;
            border-collapse: collapse;
            margin: auto;
        }

        .resumen-table th,
        .resumen-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .resumen-table th {
            background-color: #f2f2f2;
            text-align: right;
        }
        
    </style>
</head>
<body>
    <table class="cabecera ancho">
        <td class="logo">
            <img src="{{ $logo }}" alt="Logo">
        </td>

        <td class="info-empresa">
            <h3>COZUCOOP</h3>
            <p>R.F.C: XXXXXXXXX</p>
        </td>
        <td class="info-compra">
            <p><strong>Fecha de Emisión </strong> {{ \Carbon\Carbon::now()->isoFormat('LL') }}</p>
        </td>
    </table>
    <table class="ancho">
        <tr>
            <td>
                
                <h3><strong>REPORTE MENSUAL DE TURNOS</strong></h3>
                <h3><strong>{{$fecha}}</strong></h3>
            </td>
        </tr>
    </table>
    <table class="articulos-table" style="width: 100%; border-collapse: collapse;">
        @php
            $prevFecha = null;
        @endphp
        @foreach ($datosTurnos as $fecha => $turnos)
            <tr style="font-weight: bold;">
                <td colspan="5" style="text-align: center; padding: 5px; margin-top: 0px;">
                    {{ $fecha }}
                </td>
            </tr>
            <thead>
                <tr style="font-weight: bold; text-align: center; border: 1px solid black;">
                    <th>Turno</th>
                    <th>Nombre de Usuario</th>
                    <th>Unidad</th>
                    <th>Tipo</th>
                    <th>Hora</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($turnos as $turnoNombre => $usuarios)
                    @foreach ($usuarios as $nombreUsuario => $acciones)
                        @foreach ($acciones as $accion)
                            <tr style="text-align: center; border: 1px solid black;">
                                <td>{{ $turnoNombre }}</td>
                                <td>{{ $nombreUsuario }}</td>
                                <td>{{ $accion['unidad'] }}</td>
                                <td>{{ $accion['tipo'] }}</td>
                                {{-- Como hora se muestra la fecha y la hora entonces se separa para mostrar solo la hora --}}
                                <td>{{ \Carbon\Carbon::createFromFormat('d/m/Y H:i', $accion['hora'])->format('h:iA') }}</td>


                            </tr>
                        @endforeach
                    @endforeach
                @endforeach
            </tbody>
            @php
                $prevFecha = $fecha;
            @endphp
        @endforeach

    </table>
    <table class="articulos-table" style="width: 100%; border-collapse: collapse; margin-top: 20px;">
        <tr>
            <th>Total de Horas Trabajadas {{ $infoExtra['Mensual']['TotalHorasTrabajadas'] }}</th>
            <th>Total de Turnos Mañana {{ $infoExtra['Mensual']['Mañana'] }}</th>
            <th>Total de Turnos Tarde {{ $infoExtra['Mensual']['Tarde'] }}</th>
            <th>Total de Turnos Completo {{ $infoExtra['Mensual']['Completo'] }}</th>
        </tr>
    </table>
</body>
</html>
