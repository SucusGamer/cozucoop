<?php

namespace App\Exports;

use App\Http\Controllers\DashboardController;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Illuminate\Contracts\View\View;

class ReporteDiarioExport implements FromView, ShouldAutoSize, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        //llamamos al controlador de Dashboard
        $dashboard = new DashboardController();
        //obtenemos los reportes
        $turnos = $dashboard->getInfoTurnos();
        $fecha = date('d-m-Y');

        return view('exports.reporteDiario', [
            'reportes' => $turnos,
            'fecha' => $fecha,
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
