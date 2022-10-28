<table>
    <tr>
        <th colspan="5">
            <blockquote><strong>Laporan Absensi {{date('d-m-Y', strtotime($start))}} - {{date('d-m-Y', strtotime($end))}}</strong></blockquote>
        </th>
    </tr>
</table>
<table cellspacing='0' class="table" border="1">
    @foreach ($data as $item)
    <tr>
        <th></th>
    </tr>
    <tr>
        <th style="padding: 3" colspan="5"><strong>ID:{{$item['nik']}}, NAMA:{{$item['name']}}, Shift:{{$item['shift_name']}}</strong></th>
        <th align="left">
            {{-- <span style="margin-left: 2"><strong> TAHAPAN TUGAS</strong></span> --}}
        </th>
        {{-- <th><span style="margin-left: 2; margin-right:2"><strong>UPLOAD FOTO</strong> </span></th> --}}
        {{-- <th align="right"><span style="margin-left: 2; margin-right:2"><strong>NILAI</strong> </span></th> --}}
    </tr>
    @php
        $startDate = new DateTime($start);
        $endDate = new DateTime($end);
        $date = [];

        for ($i = $startDate; $i <= $endDate; $i->modify('+1 days')) { 
            $date[] =[
                'date' => $i->format('d'),
                'defaultDate' => $i->format('Y-m-d')
            ];
        }
    @endphp
               <tr>
                    <th>Tanggal</th>
                    <th>Jam Masuk</th>
                    <th>Jam Keluar</th>
                    <th>Jam Kerja</th>
                    <th>Overtime</th>
               </tr>
               @foreach ($date as  $dates)
               @php
                   $day = $dates['defaultDate'];
                   $nik         = $item['nik'];
                   // GET ABSENSI BERDASARKAN TGL DAN NIK
                   $absensi    = $absensiModel->getReportAbsenWhereDate($nik, $day);
                   $jam_kerja  = date_diff(date_create($absensi->jam_keluar ?? '00:00:00'), date_create($absensi->jam_masuk ?? '00:00:00'));
                   $count_jam_kerja        = $jam_kerja->h .':'.$jam_kerja->i.':'.$jam_kerja->s;
                //    $jam        = $jam*60;
                //    $menit      = $jam_kerja->i;
                //    $total      = $jam + $menit;
                //    $sisa       = $total / 10;
               @endphp
               <tr>
                   <th align="left">{{$dates['date']}}</th>
                   <th>{{$absensi->jam_masuk ?? ''}}</th>
                   <th>{{$absensi->jam_keluar ?? ''}}</th>
                   <th>{{$count_jam_kerja ?? '00:00:00'}}</th>
                   <th></th>
                   <th></th>
                </tr>
                @endforeach
    @endforeach
    {{-- @foreach ($data as $item)
        <tr>
            <th colspan="3" align="left">
                <span style="margin-left: 15"><strong> {{ $item['nomor'] }} . {{ $item['nama'] }} </strong></span>
            </th>
        </tr>
        @foreach ($item['tugas'] as $row)
            <tr>
                <td>{{ $row->nomor }}</td>
                <td>{{ $row->nama }}</td>
                <td>{{ $row->require_image == 'Y' ? 'Wajib' : 'Tidak Wajib' }}</td>
                <td align="right">
                    <span style="margin-right: 5">{{ $row->nilai_point }}</span>
                </td>
            </tr>
        @endforeach
    @endforeach --}}
</table>
