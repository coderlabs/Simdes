@extends('layouts.default')
@section('title','Pencairan Pendapatan')
@section('style')
@stop
@section('content')
<section class="wrapper">
    <!-- page start-->
    <div class="row">
        <div class="col-sm-12">
            <div class="alert alert-block alert-danger fade in " id="alert-notify" style="display:none">
                <button data-dismiss="alert" class="close close-sm fa fa-times" type="button"></button>
            </div>
            <section class="panel">
                <header class="panel-heading wht-bg">
                    <h4 class="gen-case">Pelaksanaan Pendapatan</h4>
                </header>
                <div class="panel-body minimal">
                    <div id="form-option" class="mail-option">

                        <ul class="inbox-pagination">
                            <button id="btn-bagi" data-original-title="Bagi Rata" data-placement="top"
                                    class="btn btn-primary tooltips">Bagi Rata
                            </button>
                            <button id="btn-reset" data-original-title="Reset" data-placement="top"
                                    class="btn btn-white tooltips">Reset
                            </button>
                            <a href="{{URL::to('data-pendapatan')}}" id="btn-back" data-original-title="Kembali"
                               data-placement="top"
                               class="btn btn-white tooltips">Kembali
                            </a>
                        </ul>
                    </div>

                    {{ Form::open(['onsubmit' => 'return false', 'id' => 'myForm', 'class' => 'form-horizontal', 'role'
                    => 'form']) }}
                    {{ Form::hidden('id', $data->id,['id' => 'id','name' => 'id']) }}


                    <div class="form-group">
                        {{ Form::label('jumlah', 'Jumlah Pendapatan', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-3">
                            {{ Form::text('jumlah',$data->jumlah, ['class' =>
                            'form-control','disabled' => 'disabled']) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('januari', 'Januari', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-3">
                            {{ Form::text('januari',(isset($data->januari) ? $data->januari : ''), ['class' =>
                            'form-control','autofocus' =>
                            'autofocus']) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('februari', 'Februari', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-3">
                            {{ Form::text('februari',(isset($data->februari) ? $data->februari : ''), ['class' =>
                            'form-control']) }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('maret', 'Maret', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-3">
                            {{ Form::text('maret',(isset($data->maret) ? $data->maret : ''), ['class' =>
                            'form-control']) }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('april', 'April', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-3">
                            {{ Form::text('april',(isset($data->januari) ? $data->januari : ''), ['class' =>
                            'form-control']) }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('mei', 'Mei', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-3">
                            {{ Form::text('mei',(isset($data->mei) ? $data->mei : ''), ['class' => 'form-control']) }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('juni', 'Juni', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-3">
                            {{ Form::text('juni',(isset($data->juni) ? $data->juni : ''), ['class' => 'form-control'])
                            }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('juli', 'Juli', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-3">
                            {{ Form::text('juli',(isset($data->juli) ? $data->juli : ''), ['class' => 'form-control'])
                            }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('agustus', 'Agustus', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-3">
                            {{ Form::text('agustus',(isset($data->agustus) ? $data->agustus : ''), ['class' =>
                            'form-control']) }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('september', 'September', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-3">
                            {{ Form::text('september',(isset($data->september) ? $data->september : ''), ['class' =>
                            'form-control']) }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('oktober', 'Oktober', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-3">
                            {{ Form::text('oktober',(isset($data->oktober) ? $data->oktober : ''), ['class' =>
                            'form-control']) }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('november', 'November', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-3">
                            {{ Form::text('november',(isset($data->november) ? $data->november : ''), ['class' =>
                            'form-control']) }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('desember', 'Desember', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-3">
                            {{ Form::text('desember',(isset($data->desember) ? $data->desember : ''), ['class' =>
                            'form-control']) }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('sisa', 'Sisa Belum dibagi', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-3">
                            {{ Form::text('sisa','', ['class' => 'form-control','disabled' => 'disabled']) }}
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                            {{ Form::button('Hitung', ['class' => 'btn btn-default','id' =>'btn-hitung']) }}
                            {{ Form::button('Simpan', ['class' => 'btn btn-primary','id' =>'btn-simpan','type' =>
                            'submit']) }}
                        </div>
                    </div>
                    {{ Form::close() }}

                </div>
            </section>
        </div>
    </div>
    <!-- page end-->
</section>

@stop
@section('scripts')
<script type="text/javascript">
    $(document).ready(function () {
        $("#li-penganggaran").attr("style", "display:block;");
        $("#a-penganggaran").addClass("active");
        $("#menu-pendapatan").addClass("active");
    });

    $(function () {
        $("#jumlah").number(true, '', '', '.');
        $("#sisa").number(true, '', '', '.');
        $("#januari").number(true, '', '', '.');
        $("#februari").number(true, '', '', '.');
        $("#maret").number(true, '', '', '.');
        $("#april").number(true, '', '', '.');
        $("#mei").number(true, '', '', '.');
        $("#juni").number(true, '', '', '.');
        $("#juli").number(true, '', '', '.');
        $("#agustus").number(true, '', '', '.');
        $("#september").number(true, '', '', '.');
        $("#oktober").number(true, '', '', '.');
        $("#november").number(true, '', '', '.');
        $("#desember").number(true, '', '', '.');

        $("#jml").number(true, '', '', '.');
        $("#tahap_satu").number(true, '', '', '.');
        $("#tahap_dua").number(true, '', '', '.');
        $("#tahap_tiga").number(true, '', '', '.');
        $("#tahap_empat").number(true, '', '', '.');

        $("#btn-bagi").click(function () {
            var jumlah = $("#jumlah").val();
            var hasil = eval(jumlah) / 12;
            hasil = Math.floor(hasil);
            $("#januari").val(hasil);
            $("#februari").val(hasil);
            $("#maret").val(hasil);
            $("#april").val(hasil);
            $("#mei").val(hasil);
            $("#juni").val(hasil);
            $("#juli").val(hasil);
            $("#agustus").val(hasil);
            $("#september").val(hasil);
            $("#oktober").val(hasil);
            $("#november").val(hasil);
            $("#desember").val(hasil);
        });

        $("#btn-pelaksanaan").click(function () {
            $("#modalPelaksanaan").modal('show');
        });

        $("#btn-reset").click(function () {
            var jumlah = $("#jumlah").val();
            var hasil = eval(jumlah) / 12;
            hasil = Math.floor(hasil);
            $("#januari").val("");
            $("#februari").val("");
            $("#maret").val("");
            $("#april").val("");
            $("#mei").val("");
            $("#juni").val("");
            $("#juli").val("");
            $("#agustus").val("");
            $("#september").val("");
            $("#oktober").val("");
            $("#november").val("");
            $("#desember").val("");
            $("#sisa").val("");
        });

        $("#btn-hitung").click(function () {
            var jumlah = ($("#jumlah").val().length > 1) ? $("#jumlah").val() : 0;
            var januari = ($("#januari").val().length > 1) ? $("#januari").val() : 0;
            var februari = ($("#februari").val().length > 1) ? $("#februari").val() : 0;
            var maret = ($("#maret").val().length > 1) ? $("#maret").val() : 0;
            var april = ($("#april").val().length > 1) ? $("#april").val() : 0;
            var mei = ($("#mei").val().length > 1) ? $("#mei").val() : 0;
            var juni = ($("#juni").val().length > 1) ? $("#juni").val() : 0;
            var juli = ($("#juli").val().length > 1) ? $("#juli").val() : 0;
            var agustus = ($("#agustus").val().length > 1) ? $("#agustus").val() : 0;
            var september = ($("#september").val().length > 1) ? $("#september").val() : 0;
            var oktober = ($("#oktober").val().length > 1) ? $("#oktober").val() : 0;
            var november = ($("#november").val().length > 1) ? $("#november").val() : 0;
            var desember = ($("#desember").val().length > 1) ? $("#desember").val() : 0;

            var sisa = jumlah - januari - februari - maret - april - mei - juni - juli - agustus - september - oktober - november - desember;
            $("#sisa").val(sisa);
        })
    })

    // Ajax simpan data visi
    function SimpanData() {
        var id = $("#id").val();
        OpenSpinner();
        $.ajax({
            url: '{{URL::to("data-histori-pendapatan")}}/' + id,
            type: 'POST',
            data: $("#myForm").serialize()
        }).done(function (data) {
            CekAuth(data);
            $("#alert-notify").show().html("");
            switch (data.Status) {
                case "Sukses":
                    resultSuccess(data);
                    setTimeout(function () {
                        window.location.assign("data-pendapatan")
                    }, 800);
                    break;
                case "Warning":
                    resultWarning(data);
                    break;
                case "Validation":
                    resultValidation(data);
                    break;
            }

        }).fail(function (data) {
            ErrMsg()
        })
    }

    //Validasi
    $(function () {
        $("#myForm").validate({
            submitHandler: function (form) {
                SimpanData()
            },
            errorElement: "label",
            errorPlacement: function (e, t) {
                var n = t.parent();
                var p = t.insertBefore('col-md-4')
                n.is(".form-group") ? e.appendTo(n) : e.appendTo(n.parent()),
                    e.addClass("error control-label")
            },
            rules: {
                januari: 'required',
                februari: 'required',
                maret: 'required',
                april: 'required',
                mei: 'required',
                juni: 'required',
                juli: 'required',
                agustus: 'required',
                september: 'required',
                oktober: 'required',
                november: 'required',
                desember: 'required'
            },
            messages: {
                januari: 'Silahkan isi bagian januari',
                februari: 'Silahkan isi bagian februari',
                maret: 'Silahkan isi bagian maret',
                april: 'Silahkan isi bagian april',
                mei: 'Silahkan isi bagian mei',
                juni: 'Silahkan isi bagian juni',
                juli: 'Silahkan isi bagian juli',
                agustus: 'Silahkan isi bagian agustus',
                september: 'Silahkan isi bagian september',
                oktober: 'Silahkan isi bagian oktober',
                november: 'Silahkan isi bagian november',
                desember: 'Silahkan isi bagian desember',
            }
        })
    });
</script>

{{ HTML::script('app/main-script.js') }}
@stop