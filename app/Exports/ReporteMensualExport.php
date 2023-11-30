<?php

namespace App\Exports;

use App\Http\Controllers\DashboardController;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Illuminate\Contracts\View\View;

class ReporteMensualExport implements FromView, ShouldAutoSize, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public $mes;

    public function __construct($mes)
    {
        $this->mes = $mes;
    }
    public function view(): View
    {
        //llamamos al controlador de Dashboard
        $dashboard = new DashboardController();
        //obtenemos los reportes
        $turnos = $dashboard->OrdenarTurnos($this->mes);
        
        //si no hay datos que mostrar
        $fecha = date('d/m/Y');
        $infoExtra = $dashboard->GenerarReporteMensual()->original; // Obtén el contenido JSON de la respuesta


        return view('exports.reporteMensual', [
            'datosTurnos' => $turnos,
            'fecha' => $fecha,
            'infoExtra' => $infoExtra
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }
}
