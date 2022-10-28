<?php

namespace App\Exports\Sheet;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\Exportable;
use App\Invoice;
use App\Pengguna;
use App\AbsensiModel;
use DB;

class NewAbsensiPerDateExport implements FromCollection, WithTitle,WithHeadings,WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;
    
    private $id;
    private $nik;
    private $name;
    private $start;
    private $end;

    public function __construct(int $id, int $nik, string $name, string $start, string $end)
    {
        $this->id = $id;
        $this->nik = $nik;
        $this->name = $name;
        $this->start = $start;
        $this->end = $end;
    }

    public function collection()
    {
        // return Pengguna::select('nik','name')
        //     ->where('name', $this->name)
        //     ->where('id', $this->id)
        //     ->first();
        // return AbsensiModel::select('clock_in')->where('nik', $this->nik)->get();

        return DB::table('time_attendance')
                ->select(
                    DB::raw('DATE_FORMAT(attendance_date, "%d-%m-%Y")'),
                    DB::raw('DATE_FORMAT(clock_in, "%H:%i:%s")'),
                    DB::raw('DATE_FORMAT(clock_out, "%H:%i:%s")'),
                    DB::raw('DATE_FORMAT(clock_out, "%H:%i:%s")'),
                    'overtime'
                    )
                ->where('nik', $this->nik)
                ->whereBetween('attendance_date',[$this->start, $this->end])->get();
    }

    public function headings(): array
    {
        return [
            'TANGGAL',
            'JAM MASUK',
            'JAM KELUAR',
            'OVERTIME',
        ];
    }

    public function registerEvents(): array
    {
        
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A1:D1')->applyFromArray([
                    'font' => [
                        'bold' => true
                    ]
                ]);
            }
        ];
    }

    
    public function title(): string
    {
        return $this->name;
    }
}
