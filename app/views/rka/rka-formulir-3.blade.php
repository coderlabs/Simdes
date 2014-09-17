<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    {{ HTML::style('bs3/css/style.css') }}
</head>
<body>
<table class="table-list">
    <tr>
        <td class="col-md-1" rowspan="2" style="padding-bottom: 0px;padding-top: 0px;text-align: center">
            <img src="{{ URL::asset('img/logo_organisasi.png') }}" alt="" height="100">
        </td>
        <td class="col-md-7" style="padding-bottom: 0px;padding-top: 0px;"><p style="font-size: 12pt;"
                                                                              class="text-center"><strong>RENCANA KERJA
                    DAN ANGGARAN<br/>{{strtoupper($organisasi->nama)}}</strong></p></td>
        <td class="col-md-2 text-center" rowspan="2" style="padding-bottom: 0px;padding-top: 0px;"><strong>Formulir -
                1.2<br/> RKA DESA</strong></td>
    </tr>
    <tr>
        <td style="padding-bottom: 0px;padding-top: 0px;"><p style="font-size: 11pt" class="text-center"><strong>KABUPATEN
                    {{strtoupper($organisasi->kab)}}</strong><BR/>Tahun Anggaran
                : {{date('Y')}}</p></td>
    </tr>
    <table class="table-list" style="border-top: none !important;">
        <tr>
            <td class="col-md-2 no-border-right">Kewenangan</td>
            <td class="col-md-2 no-border-right">: &nbsp;1</td>
            <td class="col-md-7">
                Kewenangan berdasarkan hak asal-usul
            </td>
        </tr>
        <tr>
            <td class="col-md-2 no-border-right">Bidang Kewenangan</td>
            <td class="col-md-2 no-border-right">: &nbsp;1.1</td>
            <td class="col-md-7">
                Penyelenggaraan Pemerintahan Desa
            </td>
        </tr>
        <tr>
            <td class="col-md-2 no-border-right">Kecamatan</td>
            <td class="col-md-2 no-border-right">: &nbsp;{{$organisasi->kode_kec}}</td>
            <td class="col-md-7">
                {{$organisasi->kec}}
            </td>
        </tr>
        <tr>
            <td class="col-md-2 no-border-right">Organisasi</td>
            <td class="col-md-2 no-border-right">: &nbsp;{{$organisasi->kode_desa}}</td>
            <td class="col-md-7">
                {{$organisasi->desa}}
            </td>
        </tr>
    </table>
    <tr>
        <table class="table-list">
            <tr>
                <td colspan="7">
                    <p class="text-center"><strong>RINCIAN ANGGARAN BELANJA TIDAK LANGSUNG DESA</strong></p>
                </td>
            </tr>
            <tr>
                <td class="col-md-2" rowspan="2" style="text-align: center">Kode Rekening</td>
                <td class="col-md-3" rowspan="2" style="text-align: center">Uraian</td>
                <td class="col-md-6" style="text-align: center" colspan="4">Tahun n</td>
                <td class="col-md-1" rowspan="2" style="text-align: center">Tahun n + 1</td>
            </tr>
            <tr>
                <td class="col-md-1" style="text-align: center">Volume</td>
                <td class="col-md-1" style="text-align: center">Satuan</td>
                <td class="col-md-2" style="text-align: center">Harga Satuan</td>
                <td class="col-md-2" style="text-align: center">Jumlah</td>
            </tr>

            <tr>
                <td class="" style="text-align: center">1</td>
                <td class="" style="text-align: center">2</td>
                <td class="" style="text-align: center">3</td>
                <td class="" style="text-align: center">4</td>
                <td class="" style="text-align: center">5</td>
                <td class="" style="text-align: center">6=(3x5)</td>
                <td class="" style="text-align: center">7</td>
            </tr>

            <tr>
                <td class="" style="text-align: left"><strong>2</strong></td>
                <td class="" style="text-align: left" colspan="6"><strong>Belanja</strong></td>
            </tr>
            @foreach ($belanja as $data)
            @if(!empty($data->rincian_obyek_id))
            <tr>
                <td>{{$data->kelompok->kode_rekening}}</td>
                <td colspan="6">{{$data->kelompok->kelompok}}</td>
            </tr>
            <tr>
                <td>{{$data->jenis->kode_rekening}}</td>
                <td colspan="6">{{$data->jenis->jenis}}</td>
            </tr>
            <tr>
                <td>{{$data->obyek->kode_rekening}}</td>
                <td colspan="6">{{$data->obyek->obyek}}</td>
            </tr>
            <tr>
                <td>{{$data->rincianObyek->kode_rekening}}</td>
                <td>{{$data->rincianObyek->rincian_obyek}}</td>
                <td style="text-align: center">{{$data->volume_1}}{{($data->volume_2 > 0) ? '/'.$data->volume_2 : ''
                    }}{{($data->volume_3 > 0) ? '/'.$data->volume_3 : '' }}
                </td>
                <td style="text-align: center">{{$data->satuan_1}}{{(!empty($data->satuan_2)) ? '/'.$data->satuan_2 : ''
                    }}{{(!empty($data->satuan_3)) ? '/'.$data->satuan_3 : '' }}
                </td>
                <td style="text-align: right">{{number_format($data->satuan_harga, 2, ',', '.')}}</td>
                <td style="text-align: right">{{number_format($data->jumlah, 2, ',', '.')}}</td>
                <td class="text-center">--</td>
            </tr>
            @elseif(!empty($data->obyek_id))
            <tr>
                <td>{{$data->kelompok->kode_rekening}}</td>
                <td colspan="6">{{$data->kelompok->kelompok}}</td>
            </tr>
            <tr>
                <td>{{$data->jenis->kode_rekening}}</td>
                <td colspan="6">{{$data->jenis->jenis}}</td>
            </tr>
            <tr>
                <td>{{$data->obyek->kode_rekening}}</td>
                <td>{{$data->obyek->obyek}}</td>
                <td style="text-align: center">{{$data->volume_1}}{{($data->volume_2 > 0) ? '/'.$data->volume_2 : ''
                    }}{{($data->volume_3 > 0) ? '/'.$data->volume_3 : '' }}
                </td>
                <td style="text-align: center">{{$data->satuan_1}}{{(!empty($data->satuan_2)) ? '/'.$data->satuan_2 : ''
                    }}{{(!empty($data->satuan_3)) ? '/'.$data->satuan_3 : '' }}
                </td>
                <td style="text-align: right">{{number_format($data->satuan_harga, 2, ',', '.')}}</td>
                <td style="text-align: right">{{number_format($data->jumlah, 2, ',', '.')}}</td>
                <td class="text-center">--</td>
            </tr>

            @elseif(!empty($data->jenis_id))
            <tr>
                <td>{{$data->kelompok->kode_rekening}}</td>
                <td colspan="6">{{$data->kelompok->kelompok}}</td>
            </tr>
            <tr>
                <td>{{$data->jenis->kode_rekening}}</td>
                <td>{{$data->jenis->jenis}}</td>
                <td style="text-align: center">{{$data->volume_1}}{{($data->volume_2 > 0) ? '/'.$data->volume_2 : ''
                    }}{{($data->volume_3 > 0) ? '/'.$data->volume_3 : '' }}
                </td>
                <td style="text-align: center">{{$data->satuan_1}}{{(!empty($data->satuan_2)) ? '/'.$data->satuan_2 : ''
                    }}{{(!empty($data->satuan_3)) ? '/'.$data->satuan_3 : '' }}
                </td>
                <td style="text-align: right">{{number_format($data->satuan_harga, 2, ',', '.')}}</td>
                <td style="text-align: right">{{number_format($data->jumlah, 2, ',', '.')}}</td>
                <td class="text-center">--</td>
            </tr>
            @elseif(!empty($data->kelompok_id))
            <tr>
                <td style="text-align: left">{{$data->kelompok->kode_rekening}}</td>
                <td style="text-align: left">{{$data->kelompok->kelompok}}</td>
                <td style="text-align: center">{{$data->volume_1}}{{($data->volume_2 > 0) ? '/'.$data->volume_2 : ''
                    }}{{($data->volume_3 > 0) ? '/'.$data->volume_3 : '' }}
                </td>
                <td style="text-align: center">{{$data->satuan_1}}{{(!empty($data->satuan_2)) ? '/'.$data->satuan_2 : ''
                    }}{{(!empty($data->satuan_3)) ? '/'.$data->satuan_3 : '' }}
                </td>
                <td style="text-align: right">{{number_format($data->satuan_harga, 2, ',', '.')}}</td>
                <td style="text-align: right">{{number_format($data->jumlah, 2, ',', '.')}}</td>
                <td class="text-center">--</td>
            </tr>
            @endif

            @endforeach
            <tr>
                <td class="" colspan="5" style="text-align: right"><strong>Jumlah keseluruhan Belanja</strong></td>
                <td class="" style="text-align: right"><strong>{{number_format($jml_pendapatan, 2, ',', '.')}}</strong>
                <td class="text-center">--</td>
            </tr>
        </table>
    </tr>
</table>
<table class="table-list">
    <tr>
        <td class="col-md-8" style="text-align: left">
            Keterangan :<br/>
            - Tanggal Pembahasan<br/>
            - Catatan hasil pembahasan
            <br/>
            <br/>
            <br/>
            <br/>
            <br/>
            <br/>
            <br/>
        </td>
        <td class="col-md-4 text-center">
            {{$organisasi->kab}}, {{$tgl}}<br/>
            Kepala {{$organisasi->desa}}
            <br/>
            <br/>
            <br/>
            <br/>
            <br/>
            <br/>
            <br/>
            <strong><u>{{$kades}}</u></strong>
        </td>
    </tr>
</table>
<table class="table-list">
    <tr>
        <td colspan="4">
            Dibahas dan ditanda tangani dalam Musyawarah Desa oleh :
        </td>
    </tr>
    <tr>
        <td class="col-md-1" style="text-align: center">No</td>
        <td class="col-md-4" style="text-align: center">Nama Lengkap</td>
        <td class="col-md-4" style="text-align: center">Jabatan</td>
        <td class="col-md-3" style="text-align: center">Tanda Tangan</td>
    </tr>
    @for ($i=1;$i < 6; $i++)
    <tr>
        <td class="text-center">&nbsp;{{$i}}</td>
        <td class="">&nbsp;</td>
        <td class="">&nbsp;</td>
        <td class="">&nbsp;</td>
    </tr>
    @endfor
</table>

</body>
</html>