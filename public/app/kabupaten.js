var token = "&_token=" + $("input[name=_token]").val();
// onReady
$(document).ready(function() {
	$("#li-master").attr("style", "display:block;");
	$("#menu-kab").addClass("active");
	$("#mundur").attr('disabled', 'disabled');
	$("#alert-notify").hide();
	TampilData(1);

	// ketika ada event enter untuk pencarian
	$("#cari").keypress(function(event) {
		if (event.which == 13) {
			event.preventDefault();
			TampilData(1);
		}
	});

	$("#btn-tambah").click(function(event) {
		TombolTambah();
	});
});

// ajax get prov
function getProv() {
    $.ajax({
        type: "get",
        url: "ajax-prov",
        success: function(data) {
            CekAuth(data)
            $.each(data, function(index, val) {
                $("#kode_provinsi").append("<option value='" + val.kode_prov + "'>" + val.prov + "</option>")
            });
        },
        error: function(data) {}
    });
}

// ajax menampilkan data
function TampilData(page) {
	OpenLoading();
	var term = $("#cari").val();
	$.ajax({
		type: "post",
		url: "master-kabupaten/read?page=" + page,
		cache: false,
		data: 'term=' + term + token,
		success: function(data) {
			CekAuth(data)
			var obj = json2array(data)
			// info page
			$("#infopage").text(obj[4] + " - " + obj[5] + " dari " + obj[0])
			// set page & lastpage
			$("#current_page").val(obj[2])
			$("#last_page").val(obj[3])
			// set navigasi
			$("#maju").attr('onclick', 'Maju(' + obj[2] + ')')
			$("#mundur").attr('onclick', 'Mundur(' + obj[2] + ')')
			// disable navigasi
			if (obj[2] == obj[3]) {
				$("#maju").attr('disabled', 'disabled');
			} else {
				$("#maju").removeAttr('disabled');
			}
			if (obj[2] > 1) {
				$("#mundur").removeAttr('disabled');
			}
			// kosongkan datalist
			$("#datalist").html("")
			if (obj[6].length == 0) {
				$("#datalist").append("<tr><td colspan='2'>Data kosong.</td></tr>");
			} else {
				$.each(obj[6], function(index, val) {
					$("#datalist").append(
						"<tr><td>" + val.prov + "</td><td>" + val.kode_kab +"</td><td>" + val.status +" "+ val.kab +"</td><td>" + val.zona_waktu +"</td><td class='text-right'><div class='btn-toolbar'><button  title='Edit' class='btn btn-sm btn-default fa fa-edit' onclick='EditData(" + val.id + ")'></button><button title='Hapus' class='btn btn-sm btn-danger fa fa-trash-o' onclick='HapusData(" + val.id + ")'></a></div></td></tr>"
					)
				});
			}
			CloseLoading();
			$("#cari").focus();

		},
		error: function(data) {
			ErrMsg()
		}
	});
}

// Ajax simpan data
function SimpanData() {
	OpenSpinner();
	$("#btnSimpan").attr('disabled', 'disabled');
	$.ajax({
		url: "master-kabupaten",
		type: 'POST',
		data: $("#myForm").serialize(),
	})
		.done(function(data) {
			CekAuth(data)
			$("#alert-notify").show();
			$("#alert-notify").html("");
			var data = json2array(data)
			if (data[0] == "Warning") {
				ErrorSpinner();
				$("#btnSimpan").removeAttr('disabled');
				for (var i = 1; i < data.length; i++) {
					$("#alert-notify").removeClass('alert-success');
					$("#alert-notify").addClass('alert-danger');
					$('#alert-notify').append("<ul style='margin-bottom: 0px;'>" + data[i] + "</ul>");
				};

			} else {
				CloseSpinner();
				$("#btnSimpan").removeAttr('disabled');
				$("#datalist").html("");
				$("#alert-notify").removeClass('alert-danger');
				$("#alert-notify").addClass('alert-success');
				$('#alert-notify').append("<ul style='margin-bottom: 0px;'>" + data[1] + "</ul>");
				TombolBatal();
			};

		})
		.fail(function(data) {
			ErrMsg()
		})
		.always(function(data) {

		});
}

// navigasi maju ke halaman selanjutnya
function Maju(page) {
	$("#maju").attr('disabled', 'disabled');
	$("#mundur").attr('disabled', 'disabled');
	var last_page = $("#last_page").val();
	var current_page = $("#current_page").val();
	page = page + eval(1)
	if (page == last_page) {
		$("#maju").attr('disabled', 'disabled');
	} else {
		$("#maju").removeAttr('disabled');
	}
	TampilData(page);
}

// navigasi mundur ke halaman sebelumnya
function Mundur(page) {
	$("#maju").attr('disabled', 'disabled');
	$("#mundur").attr('disabled', 'disabled');
	page = page - eval(1)
	if (page == 1) {
		$("#mundur").attr('disabled', 'disabled');
		$("#maju").removeAttr('disabled');
	} else {
		$("#mundur").removeAttr('disabled');
	}
	TampilData(page);
}

function EditData(id) {
	OpenLoading();
	$.ajax({
		type: "get",
		url: "master-kabupaten/" + id + "/edit",
		cache: false,
		data: 'id=' + id,
		success: function(data) {
			CekAuth(data)
			var val = json2array(data)
			setTimeout(function() {
				$("#cmd").val('update');
				$("#btnSimpan").text("Update");
				$("#id").val(data.id);
                $("#kode_provinsi").val(data.kode_provinsi);
                $("#kode_kabupaten").val(data.kode_kabupaten);
                $("#kabupaten").val(data.kabupaten);
                $("#status").val(data.status);
                $("#zona_waktu").val(data.zona_waktu);
                $("#seo").val(data.seo);
			}, 300);
			TombolTambah();
			CloseLoading();
		},
		error: function(data) {
			ErrMsg()
		}
	});
}

function UpdateData() {
	OpenSpinner();
	$("#btnSimpan").attr('disabled', 'disabled');
	var id = $("#id").val()
	$.ajax({
		url: "master-kabupaten/" + id,
		type: 'post',
		data: '_method=put&' + $("#myForm").serialize(),
	})
		.done(function(data) {
			CekAuth(data)
			$("#alert-notify").show();
			$("#alert-notify").html("");
			var data = json2array(data)
			if (data[0] == "Warning") {
				ErrorSpinner();
				$("#btnSimpan").removeAttr('disabled');
				for (var i = 1; i < data.length; i++) {
					$("#alert-notify").removeClass('alert-success');
					$("#alert-notify").addClass('alert-danger');
					$('#alert-notify').append("<ul style='margin-bottom: 0px;'>" + data[i] + "</ul>");
				};
			} else {
				CloseSpinner();
				$("#btnSimpan").removeAttr('disabled');
				$("#datalist").html("");
				$("#alert-notify").removeClass('alert-danger');
				$("#alert-notify").addClass('alert-success');
				$('#alert-notify').append("<ul style='margin-bottom: 0px;'>" + data[1] + "</ul>");
				TombolBatal();
			};

		})
		.fail(function(data) {
			ErrMsg()
		})
		.always(function(data) {

		});
}


function HapusData(id) {
	$("#modalHapus").modal('show');
	$('#id_hapus').val(id);
}

function AksiHapus() {
	var id = $('#id_hapus').val();
	$.ajax({
		type: "post",
		url: "master-kabupaten/" + id,
		cache: false,
		data:'_method=delete',
		success: function(data) {
			CekAuth(data)
			var data = json2array(data)
			$("#alert-notify").text("");
			$("#alert-notify").show();
			if("Warning" == data[0]){
				for (var i = 1; i < data.length; i++) {
					$("#alert-notify").removeClass('alert-success');
					$("#alert-notify").addClass('alert-danger');
					$('#alert-notify').append("<ul style='margin-bottom: 0px;'>" + data[i] + "</ul>");
				};
			} else {
				$("#alert-notify").removeClass('alert-danger');
				$("#alert-notify").addClass('alert-success');
				$('#alert-notify').append("<ul>" + data[1] + "</ul>");
				$("#alert-notify").fadeOut(1000);
				$("#datalist").html("");
				TampilData($("#current_page").val());
			}
			$("#modalHapus").modal('hide');
		},
		error: function(data) {
			ErrMsg()
		}
	});

}

// refresh
function Refresh(){
	$("#cari").val("");
    $("#alert-notify").hide();
    TampilData(1);
}

function TombolBatal() {
	// kosongkan data
	$("#id").val("");
	$("#kode_provinsi").html("");
	$("#kode_kabupaten").val("");
	$("#kabupaten").val("");
	$("#status").val("");
	$("#zona_waktu").val("");
	$("#seo").val("");
	// hide
	$("#myForm").hide();
	$("#alert-notify").fadeOut(2000);
	// replace text, attr
	$("#btnSimpan").text("Simpan");
	$("#cmd").val('tambah');
	$("label.error").hide();
	$("#kode_provinsi").removeClass('error');
	$("#kode_kabupaten").removeClass('error');
	$("#kabupaten").removeClass('error');
	$("#status").removeClass('error');
	$("#zona_waktu").removeClass('error');
	$("#seo").removeClass('error');
	
	// show
	$("#form-cari").show();
	$("#form-option").show();
	$("#tab-content").show();
	// ajax data
	TampilData($("#current_page").val());
}

function TombolTambah() {
	getProv();
	// hide
	$("#form-option").hide();
	$("#tab-content").hide();
	$("#form-cari").hide();
	// show
	$("#myForm").show();
	// focused
	$("#kode_provinsi").focus();
}


//Validasi
$(function() {
    $.validator.setDefaults({}),
    $("#myForm").validate({
        submitHandler: function(form) {
            if ("tambah" == $("#cmd").val()) {
                SimpanData()
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
                kode_provinsi: "required",
                kode_kabupaten: "required",
                kabupaten: "required",
                status: "required",
                zona_waktu: "required",
                seo: "required",
            },
            messages: {
                kode_provinsi: "Silahkan isi kode provinsi.",
                kode_kabupaten: "Silahkan isi kode kabupaten.",
                kabupaten: "Silahkan isi kabupaten.",
                status: "Silahkan isi status.",
                zona_waktu: "Silahkan isi zona waktu.",
                seo: "Silahkan isi seo.",
            }
    })
});