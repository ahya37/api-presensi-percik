<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class AbsensiExportExcel implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $data;
    private $absensiModel;
    private $start;
    private $end;

    public function __construct($data, $absensiModel, $start, $end)
    {
        $this->data = $data;
        $this->absensiModel = $absensiModel;
        $this->start = $start;
        $this->end   = $end;
    }

    public function view() : View
    {
        $data = $this->data;
        $absensiModel = $this->absensiModel;
        $start = $this->start;
        $end   = $this->end;
        
        return view('report.absensi', ['data' => $data,'absensiModel' => $absensiModel, 'start' => $start, 'end' => $end]);
    }

    // public function collection()
    // {
    //     //
    // }
}
