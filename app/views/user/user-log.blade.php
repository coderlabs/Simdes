@extends('layouts.default')
@section('title','Aktifitas User')
@section('style')
@stop
@section('content')
<section class="wrapper">
	<div class="row">
		<div class="col-md-12">
			<div class="alert alert-block alert-danger fade in " id="alert-notify" style="display:none">
				<button data-dismiss="alert" class="close close-sm fa fa-times" type="button"></button>
			</div>
			<section class="panel">
				<header class="panel-heading wht-bg">
					<h4 class="gen-case">Aktifitas User
					<form id="form-cari" action="#" class="pull-right src-position">
						<div class="input-append">
							<input id="cari" type="text" class="form-control tooltips " placeholder="Cari : Deskripsi" onfocus="this.select()" data-original-title="Ketikan data yang ingin dicari, kemudian tekan [Enter]" data-placement="top" >
						</div>
					</form>
					</h4>
				</header>
				<div class="panel-body minimal">
					<div id="form-option" class="mail-option">
						{{ Form::token() }}
						{{ Form::hidden('', '',['id' => 'last_page']) }}
						{{ Form::hidden('', '',['id' => 'current_page']) }}

						<ul class="inbox-pagination">
							<li><span id="infopage"></span></li>
							<button  id="mundur" disabled="disabled" class="btn btn-white"><i class="fa fa-chevron-left"></i></button>
							<button id="btn-refresh" data-original-title="Refresh" data-placement="top" class="btn btn-white tooltips"><i class=" fa fa-refresh"></i></button>
							<button  id="maju"  disabled="disabled" class="btn btn-white"><i class="fa  fa-chevron-right"></i></button>
						</ul>
					</div>
					<div id="tab-content" class="table-inbox-wrap">
						<table class="table table-hover">
							<thead>
								<tr>
									<th class="col-md-2">Nama</th>
									<th class="col-md-1">Jenis</th>
									<th class="col-md-7">Deskripsi</th>
									<th class="col-md-2">Waktu</th>
								</tr>
							</thead>
						<tbody id="datalist"></tbody>
					</table>
				</div>
			</div>
		</section>
		<!--form akun end-->
	</div>
</div>
</section>
@stop
@section('scripts')
<script type="text/javascript">

var url = "{{URL::to('user-log')}}";
var token = "&_token=" + $("input[name=_token]").val();

// onReady
$(document).ready(function() {
	$("#li-pengaturan").attr("style", "display:block;");
	$("#a-pengaturan").addClass("active");
	$("#menu-user-log").addClass("active");
	$("#mundur").attr('disabled', 'disabled');
	TampilData(1);

	// ketika ada event enter untuk pencarian
	$("#cari").keypress(function(event) {
		if (event.which == 13) {
			event.preventDefault();
			TampilData(1);
		}
	});

});

// ajax menampilkan data
function TampilData(page) {
	OpenLoading();
	var param = $("#cari").val();
	$.ajax({
		type: "post",
		url: url + "/read?page=" + page,
		cache: false,
		data: 'param=' + param + token,
		success: function(data) {
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
		error: function(data) {
			ErrMsg()
		}
	});
}

function resultData(data) {
	var obj = json2array(data)
	$("#datalist").html("")
	if (obj[6].length == 0) {
		$("#datalist").append("<tr><td colspan='" + $("tbody > tr > th").length + "'>Data kosong.</td></tr>");
	} else {
		$.each(obj[6], function(index, val) {
			$("#datalist").append(
				"<tr><td>" + val.nama +
				"</td><td>" + val.jenis +
				"</td><td>" + val.deskripsi +
				"</td><td>" + val.created_at+
				"</td></tr>"
			)
		});
		methodPagination(obj);
	}
	CloseLoading();
	$("#cari").focus();
}

</script>
{{ HTML::script('app/main-script.js') }}
@stop