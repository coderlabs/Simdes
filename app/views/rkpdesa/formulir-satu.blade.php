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
            RENCANA KERJA PEMERINTAH DESA (RKP-DESA) TAHUNAN LINGKUNGAN/DUSUN/KAMPUNG/RW/RT
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
        <td class="col-md-2 no-border-right">KABUPATEN/KOTA</td>
        <td class="col-md-8">: &nbsp;{{isset($organisasi->kab)? strtoupper($organisasi->kab) : 'Belum diset'}}
        </td>
    </tr>
</table>
<table class="table-list">
    <tr>
        <table class="table-list">
            <tr>
                <th class="text-center" rowspan="2">No</th>
                <th class="text-center col-md-2" rowspan="2">Jenis Kegiatan</th>
                <th class="text-center col-md-2" rowspan="2">Tujuan Kegiatan</th>
                <th class="text-center col-md-1" rowspan="2">Lokasi</th>
                <th class="text-center col-md-1" rowspan="2">Sasaran</th>
                <th class="text-center col-md-1" rowspan="2">Target</th>
                <th class="text-center col-md-1" colspan="4">Sifat</th>
                <th class="text-center col-md-1" rowspan="2">Waktu Pelaksanaan</th>
                <th class="text-center col-md-2" colspan="2">Biaya</th>
                <th class="text-center col-md-1" rowspan="2">Ket</th>
            </tr>
            <tr>
                <td class="text-center">B</td>
                <td class="text-center">L</td>
                <td class="text-center">R</td>
                <td class="text-center">P</td>
                <td class="text-center col-md-1">Rp</td>
                <td class="text-center col-md-1">Sumber</td>
            </tr>
            <tr>
                <td class="text-center"><strong>1</strong></td>
                <td class="text-center"><strong>2</strong></td>
                <td class="text-center"><strong>3</strong></td>
                <td class="text-center"><strong>4</strong></td>
                <td class="text-center"><strong>5</strong></td>
                <td class="text-center"><strong>6</strong></td>
                <td class="text-center"><strong>7</strong></td>
                <td class="text-center"><strong>8</strong></td>
                <td class="text-center"><strong>9</strong></td>
                <td class="text-center"><strong>10</strong></td>
                <td class="text-center"><strong>11</strong></td>
                <td class="text-center"><strong>12</strong></td>
                <td class="text-center"><strong>13</strong></td>
                <td class="text-center"><strong>14</strong></td>
            </tr>
            <?php $no = 1 ?>
            @foreach($program as $data)
            <tr style="vertical-align: top">
                <td class="text-center">{{$no++}}</td>
                <td>{{$data->kegiatan}}</td>
                <td>{{$data->tujuan}}</td>
                <td>{{$data->lokasi}}</td>
                <td>{{$data->sasaran}}</td>
                <td>{{$data->target}}</td>
                @if ($data->status === 'Baru')
                <td class="text-center">x</td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                @elseif ($data->status === 'Lanjutan')
                <td class="text-center"></td>
                <td class="text-center">x</td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                @elseif ($data->status === 'Rehab')
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center">x</td>
                <td class="text-center"></td>
                @elseif ($data->status === 'Perluasan')
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
                <td class="text-center">{{$data->waktu}}</td>
                <td class="text-right">{{number_format($data->pagu_anggaran, 2, ',', '.')}}</td>
                <td>{{$data->sumber_dana}}
                <td>
            </tr>
            @endforeach
        </table>
    </tr>
</table>
</body>
</html>
