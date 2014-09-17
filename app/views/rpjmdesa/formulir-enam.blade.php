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
            INDIKASI PERENCANAAN POGRAM PEMBANGUNAN DESA DARI RPJM-DESA
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
                <th class="text-center col-md-1">No</th>
                <th class="text-center col-md-3">Indikasi Program</th>
                <th class="text-center col-md-2">Lokasi Garapan</th>
                <th class="text-center col-md-2">Perkiraan Sasaran</th>
                <th class="text-center col-md-4">Keterangan</th>
            </tr>
            <tr>
                <th class="text-center" >1</th>
                <th class="text-center" >2</th>
                <th class="text-center" >3</th>
                <th class="text-center" >4</th>
                <th class="text-center" >5</th>
            </tr>
            <?php $no = 1 ?>
            @foreach($program as $data)
            <tr style="vertical-align: top">
                <td class="text-center" >{{$no++}}</td>
                <td class="text-left">{{$data->program}}</td>
                <td class="text-left">{{$data->lokasi}}</td>
                <td class="text-left">{{$data->sasaran}}</td>
                <td class="text-left">{{$data->sumber_dana}}</td>
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
