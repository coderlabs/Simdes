@extends('layouts.default')
@section('title','Master Provinsi')
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
					<h4 class="gen-case">Master Kabupaten
					<form id="form-cari" action="#" class="pull-right src-position">
						<div class="input-append">
							<input id="cari" type="text" class="form-control  tooltips" placeholder="Cari : Nama kabupaten" onfocus="this.select()" data-original-title="Ketikan data yang ingin dicari, kemudian tekan [Enter]" data-placement="top" >
						</div>
					</form>
					</h4>
				</header>
				<div class="panel-body minimal">
					<div id="form-option" class="mail-option">
						<button id="btn-tambah" data-original-title="Tambah" data-placement="top" class="btn btn-primary tooltips">Tambah</button>
						<button id="btn-refresh" data-original-title="Refresh" data-placement="top" class="btn btn-white tooltips" onclick="Refresh()"><i class=" fa fa-refresh"></i></button>
						<ul class="inbox-pagination">
							<li><span  id="infopage"></span></li>
							<button  id="mundur" disabled="disabled" class="btn btn-white"><i class="fa fa-chevron-left"></i></button>
							<button  id="maju"  disabled="disabled" class="btn btn-white"><i class="fa  fa-chevron-right"></i></button>
						</ul>
					</div>
					
					{{ Form::open(['onsubmit' => 'return false', 'id' => 'myForm', 'class' => 'form-horizontal', 'role' => 'form','style' => 'display:none;']) }}
					{{ Form::hidden('id', Input::old('id'),['id' => 'id','name' => 'id']) }}
					{{ Form::hidden('', Input::old(''),['id' => 'last_page']) }}
					{{ Form::hidden('', 'tambah',['id' => 'cmd']) }}
					{{ Form::hidden('', Input::old(''),['id' => 'current_page']) }}
					<div class="form-group">
						{{ Form::label('kode_provinsi', 'Provinsi', ['class' => 'col-md-3 control-label']) }}
						<div class="col-md-4">
							{{ Form::select('kode_provinsi', ['' => 'Pilih Provinsi'],'',['class' => 'form-control']) }}
						</div>
					</div>
					<div class="form-group">
						{{ Form::label('kode_kabupaten', 'Kode Kabupaten', ['class' => 'col-md-3 control-label']) }}
						<div class="col-md-4">
							{{ Form::text('kode_kabupaten','', ['class' => 'form-control']) }}
						</div>
					</div>
					<div class="form-group">
						{{ Form::label('kabupaten', 'Kabupaten', ['class' => 'col-md-3 control-label']) }}
						<div class="col-md-4">
							{{ Form::text('kabupaten','', ['class' => 'form-control']) }}
						</div>
					</div>
					<div class="form-group">
						{{ Form::label('status', 'Status', ['class' => 'col-md-3 control-label']) }}
						<div class="col-md-4">
							{{ Form::select('status', 
							[
								'' => 'Pilih Status',
								'Kabupaten' => 'Kabupaten',
								'Kota' => 'Kota'
							],'',['class' => 'form-control']) }}
						</div>
					</div>
					<div class="form-group">
						{{ Form::label('zona_waktu', 'Zona Waktu', ['class' => 'col-md-3 control-label']) }}
						<div class="col-md-4">
							{{ Form::select('zona_waktu', 
							[
								'' => 'Pilih Zona Waktu',
								'WIT' => 'Waktu Indonesia TIMUR (WIT)',
								'WITA' => 'Waktu Indonesia Tengah (WITA)',
								'WIB' => 'Waktu Indonesia Barat (WIB)'
							],'',['class' => 'form-control']) }}
						</div>
					</div>
					<div class="form-group">
						{{ Form::label('seo', 'Seo', ['class' => 'col-md-3 control-label']) }}
						<div class="col-md-4">
							{{ Form::text('seo','', ['class' => 'form-control']) }}
						</div>
					</div>
					
					<div class="form-group form-action">
						<div class="col-md-6 col-md-offset-3">
							{{ Form::button('Simpan', ['class' => 'btn btn-primary','id' =>'btnSimpan','type' => 'submit']) }}
							{{ Form::button('Batal', ['class' => 'btn btn-default','id' =>'btnBatal','onclick' => 'TombolBatal()']) }}
						</div>
					</div>
					{{ Form::close() }}
					
					<div id="tab-content" class="table-inbox-wrap">
						<table class="table table-hover">
							<head>
								<tr class="">
									<th class="col-md-2">Provinsi</th>
									<th class="col-md-2">Kode Kabupaten</th>
									<th class="col-md-4">Kabupaten</th>
									<th class="col-md-2">Zona Waktu</th>
									<th class="col-md-2 text-right">Aksi</th>
								</tr>
							</head>
						<tbody id="datalist"></tbody>
					</table>
				</div>
			</div>
		</section>
	</div>
</div>
<!-- page end-->
</section>
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
{{ HTML::script('app/kabupaten.js') }}
@stop