
<table class="ancho">
    <tr>
        <td colspan="3" style="text-align: center; font-weight:bold; padding:5px">
            <p><strong>REPORTE DIARIO</strong></p>
        </td>
    </tr>
</table>

<table>
    <thead>
        <tr>
            <th style="text-align: center; font-weight:bold; padding:5px">Turnos Utilizados</th>
            <th style="text-align: center; font-weight:bold; padding:5px">Mototaxi</th>
            <th style="text-align: center; font-weight:bold; padding:5px">Conductor</th>
        </tr>
    </thead>
    <tbody>
        @foreach($reportes as $id => $reporte)
        <tr>
            <td style="text-align: center; font-weight:bold; padding:5px">{{ $reporte['Turno'] }}</td>
            @if($reporte['Turno'] == 'Completo')
            <td style="text-align: center; font-weight:bold; padding:5px">{{ $reporte['Unidad']. ', ' .$reporte['CambioUnidad'] }}</td>
            @else
            <td style="text-align: center; font-weight:bold; padding:5px">{{ $reporte['Unidad'] }}</td>
            @endif
            <td style="text-align: center; font-weight:bold; padding:5px">{{ $reporte['Conductor'] }}</td>
        </tr>
        @endforeach
</table>