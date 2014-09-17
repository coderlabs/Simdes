@extends('layouts.default')
@section('title','Detail Materi Pokok - Perdes')
@section('style')
@stop
@section('content')
<section class="wrapper">
    <div class="row">
        <div class="col-md-12">
            <ul class="breadcrumbs-alt">
                <li>
                    <a class="" href="{{ URL::to('data-perdes-materi-pokok').'/'.$data->perdes_id}}">Materi Pokok</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel">
                <header class="panel-heading wht-bg">
                    <h4 class="gen-case">Detil Materi Pokok
                    </h4>
                </header>
                <div class="panel-body minimal">
                    <div id="form-option" class="mail-option">
                        <button id="btn-tambah" data-original-title="Tambah" data-placement="top"
                                class="btn btn-primary tooltips" onclick="TombolTambah()">Tambah
                        </button>
                        <button id="btn-refresh" data-original-title="Refresh" data-placement="top"
                                class="btn btn-white tooltips"><i class=" fa fa-refresh"></i>
                        </button>
                    </div>
                    <table class="table table-bordered">
                        <tr>
                            <td class="active">Bab</td>
                            <td class="col-md-10" colspan="2">{{isset($data->bab) ? $data->bab : '[Belum diset]'}}</td>
                        </tr>
                        <tr>
                            <td class="active">Judul</td>
                            <td colspan="2">{{isset($data->judul) ? $data->judul : '[Belum diset]'}}</td>
                        </tr>
                        <tr>
                            <td class="active">Pasal</td>
                            <td colspan="2">{{isset($data->pasal) ? $data->pasal : '[Belum diset]'}}</td>
                        </tr>

                        <tbody id="datalist">
                        <tr>
                            <td class="active" rowspan="{{(isset($data->poin[0])) ? count($poin) : ''}}">Butir</td>
                            <td>{{(isset($data->poin[0])) ? $poin[0]->poin : ''}}</td>
                            <td class="col-md-2 text-right">
                                @if((isset($data->poin[0])) ? count($poin) : '0' > 0)
                                <div class="btn-toolbar">
                                    <button class="btn btn-default fa fa-edit"
                                            onclick="EditData({{(isset($data->poin[0])) ? $poin[0]->id : ''}})"></button>
                                    <button class="btn btn-danger fa fa-trash-o"
                                            onclick="HapusData({{(isset($data->poin[0])) ? $poin[0]->id:''}})"></button>
                                </div>
                                @endif
                            </td>
                        </tr>
                        @for($i=1; $i < count($poin); $i++)
                        <tr>
                            <td>{{$poin[$i]->poin}}</td>
                            <td class="col-md-2 text-right">
                                <div class="btn-toolbar">
                                    <button class="btn btn-default fa fa-edit"
                                            onclick="EditData({{$poin[$i]->id}})"></button>
                                    <button class="btn btn-danger fa fa-trash-o"
                                            onclick="HapusData({{$poin[$i]->id}})"></button>
                                </div>
                            </td>
                        </tr>
                        @endfor
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Modal Tambah-->
<div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Tambah Butir</h4>
            </div>
            <div class="modal-body">
                {{ Form::open(['onsubmit' => 'return false', 'id' => 'myForm', 'class' => 'form-horizontal', 'role'
                => 'form']) }}
                {{ Form::hidden('', 'tambah',['id' => 'cmd']) }}
                {{ Form::hidden('materi_pokok_id', $data->id,['id' => 'materi_pokok_id']) }}
                {{ Form::hidden('id', '',['id' => 'id']) }}

                <div class="form-group">
                    {{ Form::label('poin', 'Butir', ['class' => 'col-md-3 control-label']) }}
                    <div class="col-md-6">
                        {{ Form::textarea('poin','', ['class' => 'form-control','rows' => '3']) }}
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="submit">Simpan</button>
                <button data-dismiss="modal" class="btn btn-default" type="button">Batal</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
<!-- Modal Hapus-->
<div class="modal fade" id="modalHapus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Hapus Data</h4>
            </div>
            <div class="modal-body">
                Yakin akan menghapus data ini?
                {{ Form::hidden('id_hapus', Input::old('id_hapus'),array('id' => 'id_hapus','name' => 'id_hapus')) }}
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-default" type="button">Batal</button>
                <button class="btn btn-warning" type="button" onclick="AksiHapus();"> Hapus</button>
            </div>
        </div>
    </div>
</div>
<!-- modal hapus-->

@stop
@section('scripts')
<script type="text/javascript">
var url = "{{ URL::to('data-perdes-materi-pokok-poin')}}";
var token = "&_token=" + $("input[name=_token]").val();
var materi_pokok_id = "&materi_pokok_id=" + $("input[name=materi_pokok_id]").val();
// onReady
$(document).ready(function () {
    $("#li-perangkat").attr("style", "display:block;");
    $("#menu-perdes").addClass("active");
    $("#a-perangkat").addClass("active");
    $('#modalTambah').on('show.bs.modal', function () {
        setTimeout(function () {
            $("#poin").focus();
        }, 500)
    })
});
// ajax menampilkan data
function TampilData(page) {
    OpenLoading();
    var term = $("#cari").val();
    $.ajax({
        type: "post",
        url: url + "/read?page=" + page,
        cache: false,
        data: 'term=' + term + token + materi_pokok_id,
        success: function (data) {
            switch (data.Status) {
                case "Warning":
                    resultWarning(data);
                    break;
                case "Logout":
                    CekAuth(data);
                    break;
                default:
                    resultData(data);
            }
        },
        error: function (data) {
            ErrMsg()
        }
    });
}
function resultData(data) {
    var obj = json2array(data);
    $("#datalist").html("");
    var count = obj[6].length + 1;
    if (obj[6].length == 0) {
        $("#datalist").append("<tr><td colspan='" + $("tbody > tr > th").length + "'>Data kosong.</td></tr>");
    } else {
        $("#datalist").append(
            "<tr><td class='active' rowspan='" + (count - 1 ) + "'>Butir</td>" +
            "<td>" + obj[6][0].poin + "</td>" +
            "<td class='col-md-2 text-right'><div class='btn-toolbar'>" +
            "<button title='Edit' class='btn btn-default fa fa-edit' onclick='EditData(" + obj[6][0].id + ")'></button>" +
            "<button title='Hapus' class='btn btn-danger fa fa-trash-o' onclick='HapusData(" + obj[6][0].id + ")'></button>" +
            "</div>" +
            "</td></tr>"
        );
        for (var i = 1; i < count - 1; i++) {
            $("#datalist").append(
                "<tr><td>" + obj[6][i].poin + "</td>" +
                "<td class='col-md-2 text-right'><div class='btn-toolbar text-right'>" +
                "<button title='Edit' class='btn btn-default fa fa-edit' onclick='EditData(" + obj[6][i].id + ")'></button>" +
                "<button title='Hapus' class='btn btn-danger fa fa-trash-o' onclick='HapusData(" + obj[6][i].id + ")'></button>" +
                "</div>" +
                "</td></tr>"
            )
        }
    }
    CloseLoading();
    $("#cari").focus();
}
function TombolBatal() {
    $("#modalTambah").modal('hide');
    TampilData();
}
function TombolTambah() {
//    $("#datalist").html("");
    $("#modalTambah").modal('show');
    // kosongkan
    $("#id").val("");
    // hide
    $("#alert-notify").fadeOut(3000);
    // set atribut
    $("#cmd").val('tambah');
    $("label.error").hide();
    // remove class error
    $("#poin").val("").removeClass('error');
}
function SimpanData() {
    OpenSpinner();
    $.ajax({
        url: url,
        type: 'POST',
        data: $("#myForm").serialize(),
    }).done(function (data) {
        $("#alert-notify").show().html("");
        switch (data.Status) {
            case "Sukses":
                resultSuccess(data);
                TombolBatal();
                break;
            case "Warning":
                resultWarning(data);
                break;
            case "Logout":
                CekAuth(data);
                break;
            case "Validation":
                resultValidation(data);
                break;
        }
    }).fail(function (data) {
        ErrMsg()
    })
}
function EditData(id) {
    OpenLoading();
    $.ajax({
        type: "get",
        url: url + "/" + id + "/edit",
        cache: false,
        data: 'id=' + id + token,
        success: function (data) {
            switch (data.Status) {
                case "Warning":
                    resultWarning(data);
                    break;
                case "Logout":
                    CekAuth(data);
                    break;
                default:
                    dataSuccess(data);
            }
        },
        error: function () {
            ErrMsg()
        }
    });
}
function dataSuccess(data) {
    // siapkan ajax
    TombolTambah();
    setTimeout(function () {
        // set atribut
        $("#cmd").val('update');
        $("#btnSimpan").text("Update");
        // inject data
        $("#id").val(data.id);
        $("#materi_pokok_id").val(data.materi_pokok_id);
        $("#poin").val(data.poin);
    }, 500);
    CloseLoading();
}
function UpdateData() {
    OpenSpinner();
    $("#btnSimpan").attr('disabled', 'disabled');
    var id = $("#id").val();
    $.ajax({
        url: url + "/" + id,
        type: 'post',
        data: '_method=put&' + $("#myForm").serialize()
    }).done(function (data) {
        CekAuth(data);
        $("#alert-notify").show().html("");
        switch (data.Status) {
            case "Sukses":
                resultSuccess(data);
                TombolBatal();
                break;
            case "Warning":
                resultWarning(data);
                break;
            case "Validation":
                resultValidation(data);
                break;
        }
    }).fail(function () {
        ErrMsg()
    })
}
function HapusData(id) {
    $("#modalHapus").modal('show');
    $('#id_hapus').val(id);
}
function AksiHapus() {
    OpenLoading();
    var id = $('#id_hapus').val();
    $.ajax({
        type: "post",
        url: url + "/" + id,
        cache: false,
        data: '_method=delete' + token,
        success: function (data) {
            CekAuth(data);
            var data = json2array(data);
            $("#alert-notify").text("").show();
            if ("Warning" == data[0]) {
                for (var i = 1; i < data.length; i++) {
                    $("#alert-notify").removeClass('alert-success').addClass('alert-danger').append("<ul style='margin-bottom: 0px;'>" + data[i] + "</ul>");
                }
            } else {
                $("#alert-notify").removeClass('alert-danger').addClass('alert-success').append("<ul>" + data[1] + "</ul>").fadeOut(1000);
                $("#datalist").html("");
                TampilData($("#current_page").val());
                CloseLoading();
            }
            $("#modalHapus").modal('hide');
        },
        error: function () {
            ErrMsg()
        }
    });
}
$(function () {
    $("#myForm").validate({
        submitHandler: function (form) {
            if ("tambah" == $("#cmd").val()) {
                SimpanData()
            } else if ("update" == $("#cmd").val()) {
                UpdateData()
            }
        },
        errorElement: "label",
        errorPlacement: function (e, t) {
            var n = t.parent();
            var p = t.insertBefore('col-md-4');
            n.is(".form-group") ? e.appendTo(n) : e.appendTo(n.parent()),
                e.addClass("error control-label")
        },
        rules: {
            poin: 'required',
        },
        messages: {
            poin: "Silahkan isi butir",
        }
    })
});
</script>
{{ HTML::script('app/main-script.js') }}
@stop
