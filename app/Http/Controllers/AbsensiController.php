<?php

namespace App\Http\Controllers;

use App\AbsensiModel;
use App\Pengguna;
use Illuminate\Http\Request;
use DB;
use Maatwebsite\Excel\Excel;
use App\Exports\AbsensiExportExcel;
use App\Exports\NewAbsensiExport;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    public $excel;
    public function __construct(Excel $excel)
    {
        $this->excel = $excel;
    }

    public function reportAbsen()
    {
        $start =  request('start');
        $end   = request('end');

        $sql = DB::table('user as a')
                ->select('a.nik','a.name','b.shift_name')
                ->join('office_shift as b','a.shift_id','=','b.id')
                ->where('a.nik', '!=','')
                ->where('a.nik', '!=','03')
                ->where('a.nik', '!=','06')
                ->where('a.nik', '!=','05')
                ->get();

        $data = [];

        foreach ($sql as $value) {
            
            $data[] = [
                'nik' => $value->nik,
                'name' => $value->name,
                'shift_name' => $value->shift_name,
            ];
        }

        $absensiModel = new AbsensiModel();

        return $this->excel->download(new AbsensiExportExcel($data,$absensiModel, $start, $end), $start.'&'.$end.'-Absensi.xls');
    }

    public function getReportAbsenWhereDate($nik, $day)
    {
        $absensi = DB::table('time_attendance')
            ->select(
                DB::raw("DATE_FORMAT(attendance_date, '%d') as date"),
                DB::raw("DATE_FORMAT(clock_in, '%H:%i:%s') as jam_masuk"),
                DB::raw("DATE_FORMAT(clock_out, '%H:%i:%s') as jam_keluar"))
            ->where('nik', $nik)
            ->whereDate('attendance_date','=', $day)
            ->get();
        return $absensi;
    }

    public function AbsensiMultiSheet()
    {
        $start =  request('start');
        $end   = request('end');

        $pengguna = Pengguna::select('id','nik','name')
                    ->where('nik', '!=','')
                    ->where('nik', '!=','03')
                    ->where('nik', '!=','06')
                    ->where('nik', '!=','05')
                    ->get();
        return (new NewAbsensiExport($pengguna, $start, $end))->download('Absensi-'.$start.'-'.$end.'.xlsx');
    }
}
