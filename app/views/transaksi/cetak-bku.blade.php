<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    {{ HTML::style('bs3/css/style.css') }}
</head>
<body class="portrait">
<table class="table-text" style="padding-bottom: 20px">
    <tr style="text-align: center;font-family: Arial;font-size: 12pt; padding-bottom: 10px">
        @for($i=0;$i<6;$i++)
        <td>&nbsp; </td>
        @endfor
        <td class="col-md-10">
            <strong>
            BUKU KAS PEMBANTU<br/>
            PERINCIAN OBYEK PENERIMAAN<br/>
            DESA {{isset($organisasi->desa) ? strtoupper($organisasi->desa) : 'Belum diset'}}
            KECAMATAN {{isset($organisasi->kec) ? strtoupper($organisasi->kec) : 'Belum diset'}} <br/>
            TAHUN ANGGARAN  {{date('Y')}}
            </strong>
        </td>
    </tr>

</table>
<table class="table-list">
    <tr>
        <table class="table-list">
            <tr>
                <th class="text-center col-md-1">No</th>
                <th class="text-center col-md-2">NOMOR BKU PENERIMAAN</th>
                <th class="text-center col-md-2">TANGGAL SETOR</th>
                <th class="text-center col-md-5">NOMOR STS DAN BUKTI PENERIMAAN</th>
                <th class="text-center col-md-3">JUMLAH<BR/> (Rp)</th>
            </tr>
            <tr>
                <td class="text-center">1</td>
                <td class="text-center">2</td>
                <td class="text-center">3</td>
                <td class="text-center">4</td>
                <td class="text-center">5</td>
            </tr>
            <?php $no = 1; ?>
            @foreach ($pendapatan as $data)
            <tr style="vertical-align: top">
                <td class="text-center">{{$no++}}</td>
                <td class="">{{$data->no_bukti}}</td>
                <td class="">{{dateIndonesia($data->tanggal)}}</td>
                <td class="">{{$data->no_bku_sts}}</td>
                <td class="text-right">{{number_format($data->jumlah, 2, ',', '.')}}</td>
            </tr>
            @endforeach
            <tr>
                <td class="text-left" colspan="4">Jumlah bulan ini</td>
                <td class="text-right">{{number_format($jml_bln_ini, 2, ',', '.')}}</td>
            </tr>
            <tr>
                <td class="text-left" colspan="4">Jumlah s/d bulan lalu</td>
                <td class="text-right">{{number_format($jml_sampai_bln_lalu, 2, ',', '.')}}</td>
            </tr>
            <tr>
                <td class="text-left" colspan="4">Jumlah s/d bulan ini</td>
                <td class="text-right">{{number_format($jml_sampai_bln_ini, 2, ',', '.')}}</td>
            </tr>
        </table>
    </tr>
</table>
    <div class="text-ttd-left" style="margin-left: -100px;">
        <br/>
        MENGETAHUI<br/>
        KEPALA DESA {{isset($organisasi->desa) ? strtoupper($organisasi->desa) : 'Belum diset'}}
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <strong><u>{{isset($kades) ? $kades : 'Belum diset'}}</u></strong>
    </div>
    <div class="text-ttd-right">
               <br/>
               {{$organisasi->kab}}, {{$tgl}}<br/>
               BENDAHARA DESA
               <br/>
               <br/>
               <br/>
               <br/>
               <br/>
               <strong><u>{{isset($bendahara) ? $bendahara : 'Belum diset'}}</u></strong>
    </div>

    <?php
        function dateIndonesia($date)
            {
                $BulanIndo = array("01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12");

                $tahun = substr($date, 0, 4);
                $bulan = substr($date, 5, 2);
                $tgl = substr($date, 8, 2);

                $result = $tgl . "/" . $BulanIndo[(int)$bulan - 1] . "/" . $tahun;

                return ($result);
            }
    ?>

</body>
</html>
