<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    {{ HTML::style('bs3/css/style.css') }}
</head>
<body>
<table class="table">
    <tr>
        <td class="col-md-1" style="padding-bottom: 0px;padding-top: 0px;text-align: center">
            <img src="{{ URL::asset('img/Pancasila.png') }}" alt="" height="100">
        </td>
    </tr>
    <tr>
        <td class="col-md-1" style="font-size: 14pt;text-align: center">
            <strong><u>PEMERINTAH DESA {{strtoupper($desa)}}</u></strong>
        </td>
    </tr>
    <tr>
        <td class="col-md-1" style="font-size: 12pt;text-align: center;">
            <strong>
                <br />
                PERATURAN DESA {{strtoupper($desa)}}<br />
                NOMOR : {{$data->nomor}}<br />
                <br />
                TENTANG<br />
                {{strtoupper($data->judul)}}<br />
                <br />
                <br />
                DENGAN RAHMAT TUHAN YANG MAHA ESA<br />
                <br />
                <br />

                KEPALA DESA {{strtoupper($desa)}}
                <br />
                <br />
            </strong>

        </td>
    </tr>
    <tr>
        <table class="table" style="font-size: 11pt; text-align: right;">
            <tr>
                <td class="col-md-2" rowspan="{{count($data->konsideran)+1}}" style="vertical-align: top">
                    Menimbang
                </td>
                <td class="col-md-1" rowspan="{{count($data->konsideran)+1}}"
                    style="vertical-align: top;   text-align: left">:
                </td>
            </tr>
            <?php $no = 'a'; ?>
            @foreach($data->konsideran as $value)
            <tr>
                <td style="vertical-align: top">{{$no++}}.</td>
                <td style="text-align: justify">{{$value->konsideran}}</td>
            </tr>
            @endforeach
            <tr>
                <td class="col-md-2" rowspan="{{count($data->konsideran)+1}}" style="vertical-align: top">
                    Mengingat
                </td>
                <td class="col-md-1" rowspan="{{count($data->konsideran)+1}}"
                    style="vertical-align: top;text-align: left">:
                </td>
            </tr>
            <?php $no = '1'; ?>
            @foreach($data->dasarHukum as $value)
            <tr>
                <td style="vertical-align: top">{{$no++}}.</td>
                <td style="text-align: justify">{{$value->dasar_hukum}}</td>
            </tr>
            @endforeach
        </table>
    </tr>
    <tr>
        <table class="table" style="font-size: 11pt; text-align: right;">
            <tr>
                <td class="col-md-1 text-center" style="font-size: 11pt; text-align: center;">
                    <br />
                    <br />
                    Dengan Persetujuan Bersama
                    <strong>
                        <br />
                        BADAN PERMUSYAWARATAN DESA<br />
                        dan<br />
                        KEPALA DESA {{strtoupper($desa)}}<br />
                        <br />
                        <br />
                        MEMUTUSKAN :<br />
                        <br />
                        TENTANG<br />
                        {{strtoupper($data->judul)}}<br />
                        <br />
                        BAB I
                        <br />
                        KETENTUAN UMUM
                        <br />
                    </strong>
                    Pasal 1
                    <br />
                </td>
            </tr>
        </table>
    </tr>
    <tr>
        <td style="text-align: justify">
            Dalam Peraturan Desa ini yang dimaksud dengan :
        </td>
    </tr>
    <br/>
    <tr>
        <td class="col-md-1" style="vertical-align: top;text-align: center">1.</td>
        <td class="col-md-11">
            Pemerintahan Desa adalah pemerintahan desa {{$desa}} dan Badan  Permusyawaratan Desa (BPD) {{$desa}}
        </td>
    </tr>
</table>

</body>
</html>
