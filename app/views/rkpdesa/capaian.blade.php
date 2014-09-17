@extends('layouts.default')
@section('title','Indikator Capaian Program RKPDesa')
@section('style')
@stop
@section('content')
<section class="wrapper">
	<div class="row">
		<div class="col-md-12">
			<ul class="breadcrumbs-alt">
				<li>
					<a class="" href="{{ URL::to('/') }}">Dashboard</a>
				</li>
				<li>
					<a href="{{ URL::to('rkpdesa') }}">RKPDesa</a>
				</li>
				<li>
					
					<a class="current" href="javascript:;">Indikator</a>
				</li>
			</ul>`
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<section class="panel" >
				<header class="panel-heading">
					Informasi RKPDesa <span class="tools pull-right">
					<a href="javascript:;" class="fa fa-chevron-down tooltips" title="" data-placement="left" data-toggle="tooltip" type="button" data-original-title="melihat/menyembunyikan informasi RKPDesa"></a>
					</span>
				</header>
				<div class="panel-body" style="display: none;">
					<table class="table table-bordered table-hover">
				
						<tr>
							<td class="active">Tahun</td>
							<td >{{ $rkpdesa->tahun }}</td>
						</tr>
						<tr>
							<td class="active">Program</td>
							<td>{{ $rkpdesa->kegiatan->program->program }}</td>
						</tr>
						<tr>
							<td class="active">Kegiatan</td>
							<td>{{ $rkpdesa->kegiatan->kegiatan }}</td>
						</tr>
						<tr>
							<td class="active">Lokasi</td>
							<td>{{ $rkpdesa->lokasi }}</td>
						</tr>
						<tr>
							<td class="active">Waktu</td>
							<td>{{ $rkpdesa->waktu }}</td>
						</tr>
						<tr>
							<td class="active">Sasaran</td>
							<td>{{ $rkpdesa->sasaran }}</td>
						</tr>
						<tr>
							<td class="active">Status</td>
							<td>{{ $rkpdesa->status }}</td>
						</tr>
						<tr>
							<td class="active">Pagu Anggaran</td>
							<td>{{ number_format( $rkpdesa->pagu_anggaran, 0 , '' , '.' ) }}</td>
						</tr>
						<tr>
							<td class="active">Sumber Dana</td>
							<td>{{ $rkpdesa->sumberDana->sumber_dana }}</td>
						</tr>
						<tr>
							<td class="active">Indikator</td>
							<td>{{ isset($rkpdesa->capaian->indikator) ? $rkpdesa->capaian->indikator : 'Belum di set' }}</td>
						</tr>
						<tr>
							<td class="active">Tolok Ukur</td>
							<td>{{ isset($rkpdesa->capaian->tolok_ukur) ? $rkpdesa->capaian->tolok_ukur : 'Belum di set' }}</td>
						</tr>
						<tr>
							<td class="active">Target</td>
							<td>{{ isset($rkpdesa->capaian->target) ? $rkpdesa->capaian->target : 'Belum di set' }}</td>
						</tr>
						<tr>
							<td class="active">Satuan</td>
							<td>{{ isset($rkpdesa->capaian->satuan) ? $rkpdesa->capaian->satuan : 'Belum di set' }}</td>
						</tr>
						<tr>
							<td class="active">Uraian</td>
							<td>{{ isset($rkpdesa->capaian->uraian) ? $rkpdesa->capaian->uraian : 'Belum di set' }}</td>
						</tr>
						<tr>
							<td class="active">Sudah RKA</td>
							<td>
								@if (1 === $rkpdesa->is_rka)
								    Sudah
								@else
								    Belum
								@endif
							</td>
						</tr>
						<tr>
							<td class="active">Sudah DPA</td>
							<td>
								@if (1 === $rkpdesa->is_dpa)
								    Sudah
								@else
								    Belum
								@endif
							</td>
						</tr>
						<tr>
							<td class="active">Petugas Input Data</td>
							<td>{{ $rkpdesa->user->name }}</td>
						</tr>
						
					</table>
				</div>
			</section>
			<section class="panel">
				<header class="panel-heading">
					Indikator Masukan <span class="tools pull-right">
					
					<a href="javascript:;" class="fa fa-chevron-down"></a>
					</span>
				</header>
				<div class="panel-body">
					<div class="alert alert-block alert-danger fade in " id="alert-notify" style="display:none">
						<button data-dismiss="alert" class="close close-sm fa fa-times" type="button"></button>
					</div>
					
					{{ Form::open(['onsubmit' => 'return false', 'id' => 'myForm', 'class' => 'form-horizontal', 'role' => 'form']) }}
					{{ Form::hidden('id', Input::old('id'),['id' => 'id','name' => 'id']) }}
					{{ Form::hidden('', Input::old(''),['id' => 'last_page']) }}
					{{ Form::hidden('', Input::old(''),['id' => 'cmd']) }}
					{{ Form::hidden('', Input::old(''),['id' => 'current_page']) }}

					<div class="form-group">
						{{ Form::label('indikator', 'Indikator', ['class' => 'col-md-3 control-label']) }}
						<div class="col-md-4">
							{{ Form::select('indikator',['' => 'Pilih Indikator','Masukan' => "Masukan", "Keluaran" => "Keluaran",'Hasil' => "Hasil", "Manfaat" => "Manfaat",'Dampak' => 'Dampak'],isset($rkpdesa->capaian->indikator) ? $rkpdesa->capaian->indikator : '', ['class' => 'form-control']) }}
						</div>
					</div>

					<div class="form-group">
						{{ Form::label('tolok_ukur', 'Tolok Ukur', ['class' => 'col-md-3 control-label']) }}
						<div class="col-md-6">
							{{ Form::text('tolok_ukur', isset($rkpdesa->capaian->tolok_ukur) ? $rkpdesa->capaian->tolok_ukur : '', ['class' => 'form-control']) }}
						</div>
					</div>

					<div class="form-group">
						{{ Form::label('target', 'Target', ['class' => 'col-md-3 control-label']) }}
						<div class="col-md-6">
							{{ Form::text('target',isset($rkpdesa->capaian->target) ? $rkpdesa->capaian->target : '', ['class' => 'form-control']) }}
						</div>
					</div>

					<div class="form-group">
						{{ Form::label('satuan', 'Satuan', ['class' => 'col-md-3 control-label']) }}
						<div class="col-md-2">
							{{ Form::text('satuan',isset($rkpdesa->capaian->satuan) ? $rkpdesa->capaian->satuan : '', ['class' => 'form-control']) }}
						</div>
					</div>

					<div class="form-group">
						{{ Form::label('uraian', 'Uraian', ['class' => 'col-md-3 control-label']) }}
						<div class="col-md-6">
							{{ Form::textarea('uraian',isset($rkpdesa->capaian->uraian) ? $rkpdesa->capaian->uraian : '', ['class' => 'form-control','rows' => '2']) }}
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-6 col-md-offset-3">
							{{ Form::button('Simpan', ['class' => 'btn btn-primary','id' =>'btnSimpan','onclick' => 'SimpanData()']) }}
						</div>
					</div>
					{{ Form::close() }}
			</div>
		</section>
		<section class="panel">
				<header class="panel-heading">
					Indikator Keluaran <span class="tools pull-right">
					
					<a href="javascript:;" class="fa fa-chevron-down"></a>
					</span>
				</header>
				<div class="panel-body">
					<div class="alert alert-block alert-danger fade in " id="alert-notify" style="display:none">
						<button data-dismiss="alert" class="close close-sm fa fa-times" type="button"></button>
					</div>
					
					{{ Form::open(['onsubmit' => 'return false', 'id' => 'myForm', 'class' => 'form-horizontal', 'role' => 'form']) }}
					{{ Form::hidden('id', Input::old('id'),['id' => 'id','name' => 'id']) }}
					{{ Form::hidden('', Input::old(''),['id' => 'last_page']) }}
					{{ Form::hidden('', Input::old(''),['id' => 'cmd']) }}
					{{ Form::hidden('', Input::old(''),['id' => 'current_page']) }}

					<div class="form-group">
						{{ Form::label('indikator', 'Indikator', ['class' => 'col-md-3 control-label']) }}
						<div class="col-md-4">
							{{ Form::select('indikator',['' => 'Pilih Indikator','Masukan' => "Masukan", "Keluaran" => "Keluaran",'Hasil' => "Hasil", "Manfaat" => "Manfaat",'Dampak' => 'Dampak'],isset($rkpdesa->capaian->indikator) ? $rkpdesa->capaian->indikator : '', ['class' => 'form-control']) }}
						</div>
					</div>

					<div class="form-group">
						{{ Form::label('tolok_ukur', 'Tolok Ukur', ['class' => 'col-md-3 control-label']) }}
						<div class="col-md-6">
							{{ Form::text('tolok_ukur', isset($rkpdesa->capaian->tolok_ukur) ? $rkpdesa->capaian->tolok_ukur : '', ['class' => 'form-control']) }}
						</div>
					</div>

					<div class="form-group">
						{{ Form::label('target', 'Target', ['class' => 'col-md-3 control-label']) }}
						<div class="col-md-6">
							{{ Form::text('target',isset($rkpdesa->capaian->target) ? $rkpdesa->capaian->target : '', ['class' => 'form-control']) }}
						</div>
					</div>

					<div class="form-group">
						{{ Form::label('satuan', 'Satuan', ['class' => 'col-md-3 control-label']) }}
						<div class="col-md-2">
							{{ Form::text('satuan',isset($rkpdesa->capaian->satuan) ? $rkpdesa->capaian->satuan : '', ['class' => 'form-control']) }}
						</div>
					</div>

					<div class="form-group">
						{{ Form::label('uraian', 'Uraian', ['class' => 'col-md-3 control-label']) }}
						<div class="col-md-6">
							{{ Form::textarea('uraian',isset($rkpdesa->capaian->uraian) ? $rkpdesa->capaian->uraian : '', ['class' => 'form-control','rows' => '2']) }}
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-6 col-md-offset-3">
							{{ Form::button('Simpan', ['class' => 'btn btn-primary','id' =>'btnSimpan','onclick' => 'SimpanData()']) }}
						</div>
					</div>
					{{ Form::close() }}
			</div>
		</section>
		<section class="panel">
				<header class="panel-heading">
					Indikator Hasil <span class="tools pull-right">
					
					<a href="javascript:;" class="fa fa-chevron-down"></a>
					</span>
				</header>
				<div class="panel-body">
					<div class="alert alert-block alert-danger fade in " id="alert-notify" style="display:none">
						<button data-dismiss="alert" class="close close-sm fa fa-times" type="button"></button>
					</div>
					
					{{ Form::open(['onsubmit' => 'return false', 'id' => 'myForm', 'class' => 'form-horizontal', 'role' => 'form']) }}
					{{ Form::hidden('id', Input::old('id'),['id' => 'id','name' => 'id']) }}
					{{ Form::hidden('', Input::old(''),['id' => 'last_page']) }}
					{{ Form::hidden('', Input::old(''),['id' => 'cmd']) }}
					{{ Form::hidden('', Input::old(''),['id' => 'current_page']) }}

					<div class="form-group">
						{{ Form::label('indikator', 'Indikator', ['class' => 'col-md-3 control-label']) }}
						<div class="col-md-4">
							{{ Form::select('indikator',['' => 'Pilih Indikator','Masukan' => "Masukan", "Keluaran" => "Keluaran",'Hasil' => "Hasil", "Manfaat" => "Manfaat",'Dampak' => 'Dampak'],isset($rkpdesa->capaian->indikator) ? $rkpdesa->capaian->indikator : '', ['class' => 'form-control']) }}
						</div>
					</div>

					<div class="form-group">
						{{ Form::label('tolok_ukur', 'Tolok Ukur', ['class' => 'col-md-3 control-label']) }}
						<div class="col-md-6">
							{{ Form::text('tolok_ukur', isset($rkpdesa->capaian->tolok_ukur) ? $rkpdesa->capaian->tolok_ukur : '', ['class' => 'form-control']) }}
						</div>
					</div>

					<div class="form-group">
						{{ Form::label('target', 'Target', ['class' => 'col-md-3 control-label']) }}
						<div class="col-md-6">
							{{ Form::text('target',isset($rkpdesa->capaian->target) ? $rkpdesa->capaian->target : '', ['class' => 'form-control']) }}
						</div>
					</div>

					<div class="form-group">
						{{ Form::label('satuan', 'Satuan', ['class' => 'col-md-3 control-label']) }}
						<div class="col-md-2">
							{{ Form::text('satuan',isset($rkpdesa->capaian->satuan) ? $rkpdesa->capaian->satuan : '', ['class' => 'form-control']) }}
						</div>
					</div>

					<div class="form-group">
						{{ Form::label('uraian', 'Uraian', ['class' => 'col-md-3 control-label']) }}
						<div class="col-md-6">
							{{ Form::textarea('uraian',isset($rkpdesa->capaian->uraian) ? $rkpdesa->capaian->uraian : '', ['class' => 'form-control','rows' => '2']) }}
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-6 col-md-offset-3">
							{{ Form::button('Simpan', ['class' => 'btn btn-primary','id' =>'btnSimpan','onclick' => 'SimpanData()']) }}
						</div>
					</div>
					{{ Form::close() }}
			</div>
		</section>
		<section class="panel">
				<header class="panel-heading">
					Indikator Manfaat <span class="tools pull-right">
					
					<a href="javascript:;" class="fa fa-chevron-down"></a>
					</span>
				</header>
				<div class="panel-body">
					<div class="alert alert-block alert-danger fade in " id="alert-notify" style="display:none">
						<button data-dismiss="alert" class="close close-sm fa fa-times" type="button"></button>
					</div>
					
					{{ Form::open(['onsubmit' => 'return false', 'id' => 'myForm', 'class' => 'form-horizontal', 'role' => 'form']) }}
					{{ Form::hidden('id', Input::old('id'),['id' => 'id','name' => 'id']) }}
					{{ Form::hidden('', Input::old(''),['id' => 'last_page']) }}
					{{ Form::hidden('', Input::old(''),['id' => 'cmd']) }}
					{{ Form::hidden('', Input::old(''),['id' => 'current_page']) }}

					<div class="form-group">
						{{ Form::label('indikator', 'Indikator', ['class' => 'col-md-3 control-label']) }}
						<div class="col-md-4">
							{{ Form::select('indikator',['' => 'Pilih Indikator','Masukan' => "Masukan", "Keluaran" => "Keluaran",'Hasil' => "Hasil", "Manfaat" => "Manfaat",'Dampak' => 'Dampak'],isset($rkpdesa->capaian->indikator) ? $rkpdesa->capaian->indikator : '', ['class' => 'form-control']) }}
						</div>
					</div>

					<div class="form-group">
						{{ Form::label('tolok_ukur', 'Tolok Ukur', ['class' => 'col-md-3 control-label']) }}
						<div class="col-md-6">
							{{ Form::text('tolok_ukur', isset($rkpdesa->capaian->tolok_ukur) ? $rkpdesa->capaian->tolok_ukur : '', ['class' => 'form-control']) }}
						</div>
					</div>

					<div class="form-group">
						{{ Form::label('target', 'Target', ['class' => 'col-md-3 control-label']) }}
						<div class="col-md-6">
							{{ Form::text('target',isset($rkpdesa->capaian->target) ? $rkpdesa->capaian->target : '', ['class' => 'form-control']) }}
						</div>
					</div>

					<div class="form-group">
						{{ Form::label('satuan', 'Satuan', ['class' => 'col-md-3 control-label']) }}
						<div class="col-md-2">
							{{ Form::text('satuan',isset($rkpdesa->capaian->satuan) ? $rkpdesa->capaian->satuan : '', ['class' => 'form-control']) }}
						</div>
					</div>

					<div class="form-group">
						{{ Form::label('uraian', 'Uraian', ['class' => 'col-md-3 control-label']) }}
						<div class="col-md-6">
							{{ Form::textarea('uraian',isset($rkpdesa->capaian->uraian) ? $rkpdesa->capaian->uraian : '', ['class' => 'form-control','rows' => '2']) }}
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-6 col-md-offset-3">
							{{ Form::button('Simpan', ['class' => 'btn btn-primary','id' =>'btnSimpan','onclick' => 'SimpanData()']) }}
						</div>
					</div>
					{{ Form::close() }}
			</div>
		</section>
		<section class="panel">
				<header class="panel-heading">
					Indikator Dampak <span class="tools pull-right">
					
					<a href="javascript:;" class="fa fa-chevron-down"></a>
					</span>
				</header>
				<div class="panel-body">
					<div class="alert alert-block alert-danger fade in " id="alert-notify" style="display:none">
						<button data-dismiss="alert" class="close close-sm fa fa-times" type="button"></button>
					</div>
					
					{{ Form::open(['onsubmit' => 'return false', 'id' => 'myForm', 'class' => 'form-horizontal', 'role' => 'form']) }}
					{{ Form::hidden('id', Input::old('id'),['id' => 'id','name' => 'id']) }}
					{{ Form::hidden('', Input::old(''),['id' => 'last_page']) }}
					{{ Form::hidden('', Input::old(''),['id' => 'cmd']) }}
					{{ Form::hidden('', Input::old(''),['id' => 'current_page']) }}

					<div class="form-group">
						{{ Form::label('indikator', 'Indikator', ['class' => 'col-md-3 control-label']) }}
						<div class="col-md-4">
							{{ Form::select('indikator',['' => 'Pilih Indikator','Masukan' => "Masukan", "Keluaran" => "Keluaran",'Hasil' => "Hasil", "Manfaat" => "Manfaat",'Dampak' => 'Dampak'],isset($rkpdesa->capaian->indikator) ? $rkpdesa->capaian->indikator : '', ['class' => 'form-control']) }}
						</div>
					</div>

					<div class="form-group">
						{{ Form::label('tolok_ukur', 'Tolok Ukur', ['class' => 'col-md-3 control-label']) }}
						<div class="col-md-6">
							{{ Form::text('tolok_ukur', isset($rkpdesa->capaian->tolok_ukur) ? $rkpdesa->capaian->tolok_ukur : '', ['class' => 'form-control']) }}
						</div>
					</div>

					<div class="form-group">
						{{ Form::label('target', 'Target', ['class' => 'col-md-3 control-label']) }}
						<div class="col-md-6">
							{{ Form::text('target',isset($rkpdesa->capaian->target) ? $rkpdesa->capaian->target : '', ['class' => 'form-control']) }}
						</div>
					</div>

					<div class="form-group">
						{{ Form::label('satuan', 'Satuan', ['class' => 'col-md-3 control-label']) }}
						<div class="col-md-2">
							{{ Form::text('satuan',isset($rkpdesa->capaian->satuan) ? $rkpdesa->capaian->satuan : '', ['class' => 'form-control']) }}
						</div>
					</div>

					<div class="form-group">
						{{ Form::label('uraian', 'Uraian', ['class' => 'col-md-3 control-label']) }}
						<div class="col-md-6">
							{{ Form::textarea('uraian',isset($rkpdesa->capaian->uraian) ? $rkpdesa->capaian->uraian : '', ['class' => 'form-control','rows' => '2']) }}
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-6 col-md-offset-3">
							{{ Form::button('Simpan', ['class' => 'btn btn-primary','id' =>'btnSimpan','onclick' => 'SimpanData()']) }}
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
// onReady
$(document).ready(function() {
    $("#li-perangkat").attr("style", "display:block;");
    $("#menu-rkpdesa").addClass("active");
    $("#mundur").attr('disabled', 'disabled');
    $("#alert-notify").hide();
    $("#indikator").focus();
    
});

function SimpanData() {
    // OpenSpinner();
    var id = $("#id").val()
    $.ajax({
        url: "{{ URL::to('capaian-indikator')}}/{{ $rkpdesa->id }}",
        type: 'post',
        data: '_method=put&' + $("#myForm").serialize(),
    }).done(function(data) {
        CekAuth(data)
        $("#alert-notify").show();
        $("#alert-notify").html("");
        var data = json2array(data)
        if (data[0] == "Warning") {
            // ErrorSpinner();
            for (var i = 1; i < data.length; i++) {
                $("#alert-notify").removeClass('alert-success');
                $("#alert-notify").addClass('alert-danger');
                $('#alert-notify').append("<ul style='margin-bottom: 0px;'>" + data[i] + "</ul>");
            };
        } else {
            // CloseSpinner();
            $("#datalist").html("");
            $("#alert-notify").removeClass('alert-danger');
            $("#alert-notify").addClass('alert-success');
            $('#alert-notify').append("<ul style='margin-bottom: 0px;'>" + data[1] + "</ul>");
            // redirect to rkpdesa
        };
    }).fail(function(data) {}).always(function(data) {});
}
</script>
@stop