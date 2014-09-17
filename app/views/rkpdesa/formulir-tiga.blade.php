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
            REKAPITULASI PERENCANAAN PEMBANGUNAN DESA BERDASARKAN RKP-DESA TAHUN {{date('Y')}}
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
                <th class="text-center" rowspan="2">No</th>
                <th class="text-center col-md-2" rowspan="2">Jenis Kegiatan</th>
                <th class="text-center col-md-1" rowspan="2">Tujuan Kegiatan</th>
                <th class="text-center col-md-1" rowspan="2">Lokasi</th>
                <th class="text-center col-md-1" rowspan="2">Sasaran</th>
                <th class="text-center col-md-1" rowspan="2">Target</th>
                <th class="text-center col-md-1" colspan="4">Sifat</th>
                <th class="text-center col-md-1" rowspan="2">Waktu Pelaksanaan</th>
                <th class="text-center col-md-2" colspan="2">Biaya</th>
                <th class="text-center col-md-1" rowspan="2">Penanggung Jawab</th>
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
                <th class="text-center">1</th>
                <th class="text-center">2</th>
                <th class="text-center">3</th>
                <th class="text-center">4</th>
                <th class="text-center">5</th>
                <th class="text-center">6</th>
                <th class="text-center">7</th>
                <th class="text-center">8</th>
                <th class="text-center">9</th>
                <th class="text-center">10</th>
                <th class="text-center">11</th>
                <th class="text-center">12</th>
                <th class="text-center">13</th>
                <th class="text-center">14</th>
                <th class="text-center">15</th>
            </tr>
            <tr>
                <td class="text-center no-border-bottom">I</td>
                <td class="text-left no-border-bottom">
                    <u>APBN</u>
                </td>
                <td class="text-center no-border-bottom"></td>
                <td class="text-center no-border-bottom"></td>
                <td class="text-center no-border-bottom"></td>
                <td class="text-center no-border-bottom"></td>
                <td class="text-center no-border-bottom"></td>
                <td class="text-center no-border-bottom"></td>
                <td class="text-center no-border-bottom"></td>
                <td class="text-center no-border-bottom"></td>
                <td class="text-center no-border-bottom"></td>
                <td class="text-center no-border-bottom"></td>
                <td class="text-center no-border-bottom"></td>
                <td class="text-center no-border-bottom"></td>
                <td class="text-center no-border-bottom"></td>
            </tr>
            <?php $no = 1 ?>
            @foreach($apbn as $data)
            <tr style="vertical-align: top">
                <td class="text-center"></td>
                <td>
                    {{$no++.'. '.$data->kegiatan}}
                </td>
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
                <td>{{$data->sumber_dana}}</td>
                <td>{{$data->pejabatDesa->nama}}</td>
                <td></td>
            </tr>
            @endforeach
            <tr>
                <td class="text-center no-border-bottom">II</td>
                <td class="text-left no-border-bottom">
                    <u>APBD Provinsi</u>
                </td>
                <td class="text-center no-border-bottom"></td>
                <td class="text-center no-border-bottom"></td>
                <td class="text-center no-border-bottom"></td>
                <td class="text-center no-border-bottom"></td>
                <td class="text-center no-border-bottom"></td>
                <td class="text-center no-border-bottom"></td>
                <td class="text-center no-border-bottom"></td>
                <td class="text-center no-border-bottom"></td>
                <td class="text-center no-border-bottom"></td>
                <td class="text-center no-border-bottom"></td>
                <td class="text-center no-border-bottom"></td>
                <td class="text-center no-border-bottom"></td>
                <td class="text-center no-border-bottom"></td>
            </tr>
            @foreach($apbdProv as $data)
            <?php $n2=1?>
            <tr style="vertical-align: top">
                <td class="text-center"></td>
                <td>
                    {{$n2++.'. '.$data->kegiatan}}
                </td>
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
                <td>{{$data->sumber_dana}}</td>
                <td>{{$data->pejabatDesa->nama}}</td>
                <td></td>
            </tr>
            @endforeach
            <tr>
                <td class="text-center no-border-bottom">III</td>
                <td class="text-left no-border-bottom">
                    <u>APBD Kab/Kota</u>
                </td>
                <td class="text-center no-border-bottom"></td>
                <td class="text-center no-border-bottom"></td>
                <td class="text-center no-border-bottom"></td>
                <td class="text-center no-border-bottom"></td>
                <td class="text-center no-border-bottom"></td>
                <td class="text-center no-border-bottom"></td>
                <td class="text-center no-border-bottom"></td>
                <td class="text-center no-border-bottom"></td>
                <td class="text-center no-border-bottom"></td>
                <td class="text-center no-border-bottom"></td>
                <td class="text-center no-border-bottom"></td>
                <td class="text-center no-border-bottom"></td>
                <td class="text-center no-border-bottom"></td>
            </tr>
            @foreach($apbdKab as $data)
            <?php $n3=1?>
            <tr style="vertical-align: top">
                <td class="text-center"></td>
                <td>
                    {{$n3++.'. '.$data->kegiatan}}
                </td>
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
                <td>{{$data->sumber_dana}}</td>
                <td>{{$data->pejabatDesa->nama}}</td>
                <td></td>
            </tr>
            @endforeach
            <tr>
                <td class="text-center no-border-bottom">IV</td>
                <td class="text-left no-border-bottom">
                    <u>APBDesa</u>
                </td>
                <td class="text-center no-border-bottom"></td>
                <td class="text-center no-border-bottom"></td>
                <td class="text-center no-border-bottom"></td>
                <td class="text-center no-border-bottom"></td>
                <td class="text-center no-border-bottom"></td>
                <td class="text-center no-border-bottom"></td>
                <td class="text-center no-border-bottom"></td>
                <td class="text-center no-border-bottom"></td>
                <td class="text-center no-border-bottom"></td>
                <td class="text-center no-border-bottom"></td>
                <td class="text-center no-border-bottom"></td>
                <td class="text-center no-border-bottom"></td>
                <td class="text-center no-border-bottom"></td>
            </tr>
            <?php $n4=1?>
            @foreach($apbDesa as $data)
            <tr style="vertical-align: top">
                <td class="text-center"></td>
                <td>
                    {{$n4++.'. '.$data->kegiatan}}
                </td>
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
                <td>{{$data->sumber_dana}}</td>
                <td>{{$data->pejabatDesa->nama}}</td>
                <td></td>
            </tr>
            @endforeach
            @if(!count($swasta) > 0)
            <tr>
                <td class="text-center">V</td>
                <td class="text-left">
                    <u>Swasta</u>
                </td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
            </tr>
            @else
            <tr>
                <td class="text-center no-border-bottom">V</td>
                <td class="text-left no-border-bottom">
                    <u>Swasta</u>
                </td>
                <td class="text-center no-border-bottom no-border-top"></td>
                <td class="text-center no-border-bottom no-border-top"></td>
                <td class="text-center no-border-bottom no-border-top"></td>
                <td class="text-center no-border-bottom no-border-top"></td>
                <td class="text-center no-border-bottom no-border-top"></td>
                <td class="text-center no-border-bottom no-border-top"></td>
                <td class="text-center no-border-bottom no-border-top"></td>
                <td class="text-center no-border-bottom no-border-top"></td>
                <td class="text-center no-border-bottom no-border-top"></td>
                <td class="text-center no-border-bottom no-border-top"></td>
                <td class="text-center no-border-bottom no-border-top"></td>
                <td class="text-center no-border-bottom no-border-top"></td>
                <td class="text-center no-border-bottom no-border-top"></td>
            </tr>
            @endif
            @foreach($swasta as $data)
            <?php $n5=1?>
            <tr style="vertical-align: top">
                <td class="text-center"></td>
                <td>
                    {{$n5++.'. '.$data->kegiatan}}
                </td>
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
                <td>{{$data->sumber_dana}}</td>
                <td>{{$data->pejabatDesa->nama}}</td>
                <td></td>
            </tr>
            @endforeach
        </table>
    </tr>
</table>
<div class="" style="font-size:10pt;text-align: justify;float: left;position: absolute">
    <br />
    <strong><u>Keterangan :</u></strong>
    <br />
    1. Diisi oleh Kabupaten tentang Himpunan Program/Kegiatan Masuk Desa sejumlah .... lembar
    <br />
    2. Lembar 1 : Arsip Kecamatan
    <br />
    3. Lembar 2 : Dikirim ke Kabupaten/Kota(PMD, Bappeda dan DPRD Kab/Kota)
    <br />
    4. Lembar 3 : Dikirim ke Provinsi (PMD, Bappeda dan DPRD Provinsi)
    <br />
    5. Lembar 4 : Dikirim ke Pusat (Depdagri/Ditjen PMD dan Bappenas)
    <br />
    <br />
    <br />
</div>
<div class="text-ttd-right">
    {{$organisasi->kab.', '.$tgl}}
    <br />
    Camat
    <br />
    {{isset($organisasi->kec) ? strtoupper($organisasi->kec) : 'Belum diset'}}
    <br />
    <br />
    <br />
    <br />
    <br />
    <strong><u>{{isset($camat) ? $camat['nama'] : 'Belum diset'}}</u></strong>
    <br/>
    NIP : {{isset($camat) ? $camat['nip'] : 'Belum diset'}}
</div>
</body>
</html>
