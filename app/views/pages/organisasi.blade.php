@extends('layouts.default')
@section('title','Data Umum Desa')
@section('style')
@stop
@section('content')
<section class="wrapper">
	<div class="row">
		<div class="col-md-12">
					<div class="alert alert-block alert-danger fade in " id="alert-notify" style="display:none">
						<button data-dismiss="alert" class="close close-sm fa fa-times" type="button"></button>
					</div>
			<!--form akun start-->
			<section class="panel">
				<header class="panel-heading">
					Organisasi <span class="tools pull-right">
					<a href="javascript:;" class="fa fa-chevron-down"></a>
					</span>
				</header>
				<div class="panel-body">

					{{ Form::open(['onsubmit' => 'return false', 'id' => 'myForm', 'class' => 'form-horizontal', 'role' => 'form']) }}
					{{ Form::hidden('', $organisasi->id,['id' => 'id','name' => 'id']) }}
					{{ Form::hidden('', Input::old(''),['id' => 'last_page']) }}
					{{ Form::hidden('', Input::old(''),['id' => 'cmd']) }}
					{{ Form::hidden('', Input::old(''),['id' => 'current_page']) }}

					<div class="form-group">
						{{ Form::label('nama', 'Nama Instansi', ['class' => 'col-md-3 control-label']) }}
						<div class="col-md-6">
							{{ Form::text('nama',isset($organisasi->nama) ? $organisasi->nama : '', ['class' => 'form-control tooltips',
                            "data-original-title" => "Wajib diisi<br/> Nama Instansi Desa <br/> Contoh : Desa Jenggolo Manik "
                            ,"data-placement" => "top","data-html" => "true"]) }}
						</div>
					</div>

					<div class="form-group">
						{{ Form::label('provinsi', 'Provinsi', ['class' => 'col-md-3 control-label']) }}
						<div class="col-md-4">
							{{ Form::select('kode_prov',['' => 'Pilih Provinsi'],isset($organisasi->kode_prov) ? $organisasi->kode_prov : '', ['class' => 'form-control tooltips',
                            "data-original-title" => "Wajib dipilih<br/> Pilih Provinsi"
                            ,"data-placement" => "top","data-html" => "true",'id' => 'kode_prov']) }}
						</div>
					</div>

					<div class="form-group">
						{{ Form::label('kode_kab', 'Kabupaten / Kota', ['class' => 'col-md-3 control-label']) }}
						<div class="col-md-4">
							{{ Form::select('kode_kab',['' => 'Pilih Kabupaten/Kota'],isset($organisasi->kode_kab) ? $organisasi->kode_kab : '', ['class' => 'form-control tooltips',
                            "data-original-title" => "Wajib dipilih<br/> Pilih Kabupaten/Kota, jika Tidak tersedia silahkan hubungi info@simdes-bbpmd.com","data-placement" => "top",
                            "data-html" => "true",'disabled' => 'disabled']) }}
						</div>
					</div>

                    <div class="form-group">
                        {{ Form::label('kode_kec', 'Kode Kecamatan', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-6">
                            {{ Form::text('kode_kec',isset($organisasi->kode_kec) ? $organisasi->kode_kec : '', ['class' => 'form-control tooltips',
                            "data-original-title" => "Wajib diisi<br/> Kode Kecamatan sesuai dengan masing - masing kecamatan"
                            ,"data-placement" => "top","data-html" => "true"]) }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('kec', 'Kecamatan', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-6">
                            {{ Form::text('kec',isset($organisasi->kec) ? $organisasi->kec : '', ['class' => 'form-control tooltips',
                            "data-original-title" => "Wajib diisi<br/> Nama Kecamatan sesuai dengan masing - masing kecamatan"
                            ,"data-placement" => "top","data-html" => "true"]) }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('kode_desa', 'Kode Desa', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-6">
                            {{ Form::text('kode_desa',isset($organisasi->kode_desa) ? $organisasi->kode_desa : '', ['class' => 'form-control tooltips',
                            "data-original-title" => "Wajib diisi<br/> Kode Desa sesuai dengan kode masing - masing desa"
                            ,"data-placement" => "top","data-html" => "true"]) }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label('desa', 'Desa', ['class' => 'col-md-3 control-label']) }}
                        <div class="col-md-6">
                            {{ Form::text('desa',isset($organisasi->desa) ? $organisasi->desa : '', ['class' => 'form-control tooltips',
                            "data-original-title" => "Wajib diisi<br/> Nama Desa sesuai dengan masing - masing desa<br/> Isikan tanpa ada kata 'Desa'"
                            ,"data-placement" => "top","data-html" => "true"]) }}
                        </div>
                    </div>

					<div class="form-group">
						{{ Form::label('alamat', 'Alamat Instansi', ['class' => 'col-md-3 control-label']) }}
						<div class="col-md-6">
							{{ Form::text('alamat',isset($organisasi->alamat) ? $organisasi->alamat : '', ['class' => 'form-control tooltips',
                            "data-original-title" => "Wajib diisi<br/> Alamat Instansi sesuai dengan masing - masing desa<br/> Isikan tanpa ada kata 'Desa'"
                            ,"data-placement" => "top","data-html" => "true"]) }}
						</div>
					</div>

					<div class="form-group">
						{{ Form::label('no_telp', 'No Telepon', ['class' => 'col-md-3 control-label']) }}
						<div class="col-md-6">
							{{ Form::text('no_telp',isset($organisasi->no_telp) ? $organisasi->no_telp : '', ['class' => 'form-control tooltips',
                            "data-original-title" => "Wajib diisi<br/> No telepon Instansi<br/> Jika tidak ada isikan dengan nomer HP/kontak yang bisa duhubungi"
                            ,"data-placement" => "top","data-html" => "true"]) }}
						</div>
					</div>

					<div class="form-group">
						{{ Form::label('email', 'Email', ['class' => 'col-md-3 control-label']) }}
						<div class="col-md-6">
							{{ Form::text('email',isset($organisasi->email) ? $organisasi->email : '', ['class' => 'form-control tooltips',
                            "data-original-title" => "Wajib diisi<br/> Email yang valid dan aktif<br/>Secara otomatis terisi dengan email Administrator waktu mendaftar."
                            ,"data-placement" => "top","data-html" => "true"]) }}
						</div>
					</div>

					<div class="form-group">
						{{ Form::label('fax', 'No Fax', ['class' => 'col-md-3 control-label']) }}
						<div class="col-md-6">
							{{ Form::text('fax',isset($organisasi->fax) ? $organisasi->fax : '', ['class' => 'form-control tooltips',
                            "data-original-title" => "Tidak wajib diisi<br/> No Fax Instansi"
                            ,"data-placement" => "top","data-html" => "true"]) }}
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-6 col-md-offset-3">
							{{ Form::button('Simpan', ['class' => 'btn btn-primary','id' =>'btnSimpan','onclick' => 'SimpanData()','type' => 'submit']) }}
						</div>
					</div>
					{{ Form::close() }}
				</div>
			</section>
			<!--form akun end-->
		</div>
	</div>
</section>
@stop
@section('scripts')
<script type="text/javascript">
    var token = "&_token=" + $("input[name=_token]").val();
// onReady
$(document).ready(function() {
    $("#li-pengaturan").attr("style", "display:block;");
    $("#a-pengaturan").addClass("active");
    $("#menu-organisasi").addClass("active");
    $("#mundur").attr('disabled', 'disabled');
    $("#alert-notify").hide();
    $("#nama").focus();

	getProv();

});

function setProv(){
    // set jika sudah disimpan
    setTimeout(function() {
    	@if ("" != $organisasi->kode_prov)
    	$("#kode_prov").val({{$organisasi->kode_prov}});
    	@endif
    	@if ("" != $organisasi->kode_kab)
    	$("#kode_kab").removeAttr('disabled');
    	getKab({{$organisasi->kode_prov}})
    	@endif
    }, 500);
}

// ajax get prov
function getProv() {
    $.ajax({
        type: "get",
        url: "ajax-prov",
        success: function(data) {
            CekAuth(data);
            $.each(data, function(index, val) {
                $("#kode_prov").append("<option value='" + val.kode_prov + "'>" + val.prov + "</option>")
            });
            setProv();
        },
        error: function(data) {}
    });
}
 $(function(){
        $("#kode_prov").change(function(event) {
          $.ajax({
          type: "post",
          url: "{{ URL::to('ajax-kab/"+$(this).val()+"') }}",
          cache: false,
          data:token,
          success: function(data){
            if (data == ""){
              $("#kode_kab").attr("disabled","disabled").html("").append("<option value=''> Pilih Kabupaten/Kota</option>")
            } else {
              $("#kode_kab").removeAttr('disabled').html("").append("<option value=''> Pilih Kabupaten/Kota</option>");
              $.each(data, function(index, val) {
                  $("#kode_kab").append("<option value='"+val.kode_kab+"'>"+ val.kab +"</option>")
              });
            }
          },
          error: function(data){
          }
        });
        });
      });



// ajax get kab
function getKab(kode_prov) {
    $.ajax({
        type: "post",
        url: "{{ URL::to('ajax-kab') }}/"+ kode_prov,
        cache: false,
        data:token,
        success: function(data) {
            CekAuth(data);
            $("#kode_kab").removeAttr('disabled');
            $.each(data, function(index, val) {
                $("#kode_kab").append("<option value='" + val.kode_kab + "'>" + val.kab + "</option>")
            });
            $("#kode_kab").val({{$organisasi->kode_kab}});
        },
        error: function(data) {}
    })
}

function SimpanData() {
    OpenSpinner();
    var id = $("#id").val();
    $.ajax({
        url: "{{ URL::to('organisasi')}}/{{ $organisasi->id }}",
        type: 'post',
        data: '_method=put&' + $("#myForm").serialize()
    }).done(function(data) {
        CekAuth(data);
        $("#alert-notify").show().html("");
        var data = json2array(data);
        if (data[0] == "Warning") {
            ErrorSpinner();
            for (var i = 1; i < data.length; i++) {
                $("#alert-notify").removeClass('alert-success').addClass('alert-danger').append("<ul style='margin-bottom: 0px;'>" + data[i] + "</ul>");
            }
        } else {
            CloseSpinner();
            $("#datalist").html("");
            $("#alert-notify").removeClass('alert-danger').addClass('alert-success').append("<ul style='margin-bottom: 0px;'>" + data[1] + "</ul>").fadeOut(5000);
        }
    }).fail(function(data) {}).always(function(data) {});
}
</script>
@stop