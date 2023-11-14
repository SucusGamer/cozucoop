<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte Diario</title>
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
                
                <h3><strong>REPORTE DIARIO DE TURNOS</strong></h3>
                <h3><strong>{{$fecha}}</strong></h3>
            </td>
        </tr>
    </table>
    <table class="articulos-table" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr  style="font-weight: bold; text-align: center; border: 1px solid black;">
                <th>Turnos Utilizados</th>
                <th>Mototaxi</th>
                <th>Conductor</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($turnos as $turno)
            
                <tr style="text-align: center; border: 1px solid black;">
                    <td>{{ $turno['Turno'] }}</td>
                    @if ($turno['Turno'] == 'Completo')
                    <td>{{ $turno['Unidad']. ', ' .$turno['CambioUnidad'] }}</td> 
                    @else
                    <td>{{ $turno['Unidad'] }}</td>
                    @endif
                    <td>{{ $turno['Conductor'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
