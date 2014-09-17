<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    {{ HTML::style('bs3/css/style.css') }}
</head>
<body class="landscape">
<table class="table-text" style="padding-bottom: 20px">
    <tr>
        <td colspan="3" style="font-family: Arial;font-size: 11pt; padding-bottom: 10px">
            PEMERINGKATAN USULAN KEGIATAN PERENCANAAN PEMBANGUNAN DESA BERDASARKAN RPJM-DESA, TAHUN
            &nbsp;&nbsp;&nbsp;{{date('Y')}}&nbsp;&nbsp;&nbsp;s.d&nbsp;&nbsp;&nbsp;{{date('Y')+6}}
        </td>
    </tr>
    <tr style="font-family: Arial;font-size: 11pt;">
        <td class="col-md-2 no-border-right">DESA</td>
        <td class="col-md-8">: &nbsp;{{isset($organisasi->desa) ? strtoupper($organisasi->desa) : 'Belum diset'}}
        </td>
    </tr>
    <tr style="font-family: Arial;font-size: 11pt;">
        <td class="col-md-2 no-border-right">KECAMATAN</td>
        <td class="col-md-8">: &nbsp;{{isset($organisasi->kec) ? strtoupper($organisasi->kec) : 'Belum diset'}}
        </td>
    </tr>
    <tr style="font-family: Arial;font-size: 11pt;">
        <td class="col-md-2 no-border-right">KABUPATEN</td>
        <td class="col-md-8">: &nbsp;{{isset($organisasi->kab)? strtoupper($organisasi->kab) : 'Belum diset'}}
        </td>
    </tr>
    <tr style="font-family: Arial;font-size: 11pt;">
        <td class="col-md-2 no-border-right">PROVINSI</td>
        <td class="col-md-8">: &nbsp;{{isset($organisasi->prov)? strtoupper($organisasi->prov) : 'Belum diset'}}
        </td>
    </tr>
</table>
<table class="table-list">
    <tr>
        <table class="table-list">
            <tr>
                <th class="text-center col-md-1" rowspan="2">No</th>
                <th class="text-center col-md-3" rowspan="2">Masalah</th>
                <th class="text-center col-md-5" colspan="5">Kriteria dan Nilai Pembobotan</th>
                <th class="text-center col-md-1" rowspan="2">Jumlah Nilai</th>
                <th class="text-center col-md-1" rowspan="2">Urutan Peringkat</th>
                <th class="text-center col-md-1" rowspan="2">Ket</th>
            </tr>
            <tr>
                <th class="text-center col-md-1">Dirasakan oleh orang banyak</th>
                <th class="text-center col-md-1">Sangat parah</th>
                <th class="text-center col-md-1">Menghambat peningkatan Pendapatan</th>
                <th class="text-center col-md-1">Sering terjadi</th>
                <th class="text-center col-md-1">Kriteria Lainnya</th>
            </tr>
            <tr>
                <th class="text-center" >1</th>
                <th class="text-center" >2</th>
                <th class="text-center" >3</th>
                <th class="text-center" >4</th>
                <th class="text-center" >5</th>
                <th class="text-center" >6</th>
                <th class="text-center" >7</th>
                <th class="text-center" >8</th>
                <th class="text-center" >9</th>
                <th class="text-center" >10</th>
            </tr>
            <?php $no = 1 ?>
            @foreach($masalah as $data)
            <tr style="vertical-align: top">
                <td class="text-center" >{{$no++}}</td>
                <td class="text-left" >{{$data->masalah}}</td>
                <td class="text-center" >{{$data->pemetaan->pemetaan_1}}</td>
                <td class="text-center" >{{$data->pemetaan->pemetaan_2}}</td>
                <td class="text-center" >{{$data->pemetaan->pemetaan_3}}</td>
                <td class="text-center" >{{$data->pemetaan->pemetaan_4}}</td>
                <td class="text-center" ></td>
                <td class="text-center" >{{$data->pemetaan->jumlah}}</td>
                <td class="text-center" ></td>
                <td class="text-center" ></td>
            </tr>
            @endforeach
        </table>
    </tr>
</table>
    <div class="text-ttd-right">
        Kepala Desa<br/>
        {{isset($organisasi->desa) ? strtoupper($organisasi->desa) : 'Belum diset'}}
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <strong><u>{{isset($kades) ? $kades : 'Belum diset'}}</u></strong>
    </div>
</body>
</html>
