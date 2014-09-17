@extends('layouts.default')
@section('title','Indikator - Keluaran')
@section('style')
@stop
@section('content')
<section class="wrapper">
	<div class="row">
		<div class="col-md-12">
			<div class="alert alert-block alert-danger fade in " id="alert-notify" style="display:none">
				<button data-dismiss="alert" class="close close-sm fa fa-times" type="button"></button>
			</div>
			<ul class="breadcrumbs-alt">
				<li>
                    <a href="{{ URL::to('data-rkpdesa') }}">RKPDesa</a>
                </li>
                <li>
                    <a class="" href="{{ URL::to('data-rkpdesa').'/'.$data->rkpdesa_id }}">Detail RKPDesa</a>
                </li>
                <li>
                    <a href="{{ URL::to('data-indikator-masukan').'/'.$data->rkpdesa->indikator_masukan_id }}">Masukan</a>
                </li>
                <li>
                    <a class="current" href="javascript:;">Keluaran</a>
                </li>
                <li>
                    <a href="{{ URL::to('data-indikator-hasil').'/'.$data->rkpdesa->indikator_hasil_id }}">Hasil</a>
                </li>
                <li>
                    <a href="{{ URL::to('data-indikator-manfaat').'/'.$data->rkpdesa->indikator_manfaat_id }}">Manfaat</a>
                </li>
			</ul>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<section class="panel">
				<header class="panel-heading">
					Indikator Keluaran : {{$data->rkpdesa->kegiatan}}<span class="tools pull-right">
					<a href="javascript:;" class="fa fa-chevron-down"></a>
					</span>
				</header>
				<div class="panel-body">
					
					{{ Form::open(['onsubmit' => 'return false', 'id' => 'myForm', 'class' => 'form-horizontal', 'role' => 'form']) }}
					{{ Form::hidden('id', $data->id,['id' => 'id','name' => 'id']) }}
					{{ Form::hidden('', 'update',['id' => 'cmd']) }}

					<div class="form-group">
						{{ Form::label('tolok_ukur', 'Tolok Ukur', ['class' => 'col-md-3 control-label']) }}
						<div class="col-md-6">
							{{ Form::textarea('tolok_ukur',isset($data->tolok_ukur) ? $data->tolok_ukur : '', ['class' => 'form-control','rows' => '3']) }}
						</div>
					</div>

                    <div class="form-group">
                        {{ Form::label('target', 'Target', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-2">
                            {{ Form::text('target',isset($data->target) ? $data->target : '', ['class' => 'form-control']) }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('satuan', 'Satuan', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-2">
                            {{ Form::text('satuan',isset($data->satuan) ? $data->satuan : '', ['class' => 'form-control']) }}
                        </div>
                    </div>

					<div class="form-group">
						<div class="col-md-6 col-md-offset-3">
							{{ Form::button('Simpan', ['class' => 'btn btn-primary','id' =>'btn-simpan','type' => 'submit']) }}
						</div>
					</div>
					{{ Form::close() }}
				</div>
			</section>
		</div>
	</div>
</section>
@stop
@section('scripts')
<script type="text/javascript">
var url = "{{URL::to('data-indikator-keluaran')}}"

// onReady
$(document).ready(function() {
	$("#li-perencanaan").attr("style", "display:block;");
	$("#a-perencanaan").addClass("active");
    $("#menu-rkpdesa").addClass("active");
	$("#mundur").attr('disabled', 'disabled');
	$("#alert-notify").hide();
	$("#tolok_ukur").focus();
});

// ajax update data
function UpdateData() {
    OpenSpinner();
    var id = $("#id").val()
    $.ajax({
        url: url+"/"+id,
        type: 'post',
        data: '_method=put&' + $("#myForm").serialize(),
    }).done(function(data) {
        CekAuth(data)
        $("#alert-notify").show();
        $("#alert-notify").html("");
        switch(data.Status){
            case "Sukses": resultSuccess(data);methodSaveData();;break;
            case "Warning": resultWarning(data);break;
            case "Validation": resultValidation(data);break;
        }

    }).fail(function() {ErrMsg()})
}

// method save data
function methodSaveData(){
    $("#alert-notify").fadeOut(3000);
    $("#tolok_ukur").focus();
    CloseSpinner();
}


// validasi
$(function() {
    $.validator.setDefaults({}),
    $("#myForm").validate({
        submitHandler: function(form) {
            if ("tambah" == $("#cmd").val()) {
                SimpanData();
            } else if ("update" == $("#cmd").val()) {
                UpdateData()
            }
        },
        errorElement: "label",
        errorPlacement: function(e, t) {
            var n = t.parent();
            var p = t.insertBefore('col-md-4')
            n.is(".form-group") ? e.appendTo(n) : e.appendTo(n.parent()),
            e.addClass("error control-label")
        },
        rules: {
                tolok_ukur: "required",
                target: "required",
                satuan: "required",
            },
            messages: {
                tolok_ukur : "Silahkan isi tolok ukur",
                target : "Silahkan isi target",
                satuan : "Silahkan isi satuan",
            }
    })
});
</script>
@stop