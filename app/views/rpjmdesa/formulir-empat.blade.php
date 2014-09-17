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
            RENCANA PEMBANGUNAN JANGKA MENENGAH DESA(RPJM-DESA)
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
        <td class="col-md-2 no-border-right">TAHUN</td>
        <td class="col-md-8">: &nbsp;{{date('Y')}}
        </td>
    </tr>
</table>
<table class="table-list">
    <tr>
        <table class="table-list">
            <tr>
                <th class="text-center col-md-1" rowspan="2">No</th>
                <th class="text-center col-md-2" colspan="2">Bidang/Jenis Kegiatan</th>
                <th class="text-center col-md-2" rowspan="2">Lokasi</th>
                <th class="text-center col-md-1" colspan="4">Sifat</th>
                <th class="text-center col-md-2" rowspan="2">Sasaran Manfaat</th>
                <th class="text-center col-md-1" rowspan="2">Waktu Pelaksanaan</th>
                <th class="text-center col-md-3" colspan="2">Biaya dan Sumber Pembiayaan</th>
                <th class="text-center col-md-1" rowspan="2">Ket</th>
            </tr>
            <tr>
                <td class="text-center">Bidang</td>
                <td class="text-center">Jenis</td>
                <td class="text-center">B</td>
                <td class="text-center">L</td>
                <td class="text-center">R</td>
                <td class="text-center">P</td>
                <td class="text-center col-md-1">Rp</td>
                <td class="text-center col-md-1">Sumber</td>
            </tr>
            <tr>
                <td class="text-center" ><strong>1</strong></td>
                <td class="text-center" ><strong>2</strong></td>
                <td class="text-center" ><strong>3</strong></td>
                <td class="text-center" ><strong>4</strong></td>
                <td class="text-center" ><strong>5</strong></td>
                <td class="text-center" ><strong>6</strong></td>
                <td class="text-center" ><strong>7</strong></td>
                <td class="text-center" ><strong>8</strong></td>
                <td class="text-center" ><strong>9</strong></td>
                <td class="text-center" ><strong>10</strong></td>
                <td class="text-center" ><strong>11</strong></td>
                <td class="text-center" ><strong>12</strong></td>
                <td class="text-center" ><strong>13</strong></td>
            </tr>
            <?php $no = 1 ?>
            @foreach ($program as $data)
            <tr style="vertical-align: top">
                <td class="text-center">{{$no++}}</td>
                <td class="">{{$data->program}}</td>
                <td class="">{{$data->tujuan}}</td>
                <td class="">{{$data->lokasi}}</td>

                @if ($data->sifat === 'Baru')
                    <td class="text-center">x</td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                @elseif ($data->sifat === 'Lanjutan')
                    <td class="text-center"></td>
                    <td class="text-center">x</td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                @elseif ($data->sifat === 'Rehab')
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                    <td class="text-center">x</td>
                    <td class="text-center"></td>
                @elseif ($data->sifat === 'Perluasan')
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                    <td class="text-center">x</td>
                @else
                    <td class="text-center">x</td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                @endif
                <td class="">{{$data->target}}</td>
                <td class="text-center">{{$data->waktu}}</td>
                <td class="text-right">{{number_format($data->pagu_anggaran, 2, ',', '.')}}</td>
                <td class="">{{$data->sumber_dana}}</td>
                <td class=""></td>
            </tr>
            @endforeach
        </table>
    </tr>
</table>
    <div class="text-ttd-left">
        {{$organisasi->kab}}, {{$tgl}}<br/>
        Diajukan oleh :<br/>
        Kepala {{isset($organisasi->desa) ? strtoupper($organisasi->desa) : 'Belum diset'}}
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <strong><u>{{isset($kades) ? $kades : 'Belum diset'}}</u></strong>
    </div>
    <div class="text-ttd-right"">
        <br/>
        <br/>
        LPM,LPMD atau sebutan lain
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        (.............................)
    </div>

</body>
</html>
