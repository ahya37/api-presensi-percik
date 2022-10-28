<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\Exportable;
use App\Exports\Sheet\InvoicesPerMonthSheet;

class InvoiceExport implements WithMultipleSheets
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;

    protected $pengguna;
    protected $start;
    protected $endd;

    public function __construct($pengguna, $start, $end)
    {
        $this->pengguna = $pengguna;
        $this->start = $start;
        $this->end = $end;
    }

    public function sheets(): array
    {
        $sheets = [];

        // for ($month = 1; $month <= 12; $month++) {
        //     $sheets[] = new InvoicesPerMonthSheet($this->year, $month);
        // }
        $pengguna = $this->pengguna;
        $start = $this->start;
        $end   = $this->end;

        foreach ($pengguna as $value) {
            $sheets[] = new InvoicesPerMonthSheet($value->id,$value->nik,$value->name, $start, $end);
        }

        return $sheets;
    }


    // public function collection()
    // {
    //     //
    // }
}
