
<table class="ancho">
    <tr>
        <td colspan="5" style="text-align: center; font-weight:bold; padding:5px">
            <p><strong>REPORTE MENSUAL</strong></p>
            <p><strong>{{$fecha}}</strong></p>

        </td>
    </tr>
</table>
@php
    // Obtener las fechas y ordenarlas
    $fechasOrdenadas = array_keys($datosTurnos);
    sort($fechasOrdenadas);
@endphp
<table class="articulos-table" style="width: 100%; border-collapse: collapse;">
    @php
        $prevFecha = null;
    @endphp
        @foreach ($fechasOrdenadas as $fecha)
        @php
            $turnos = $datosTurnos[$fecha];
        @endphp
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