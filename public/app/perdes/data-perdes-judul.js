/**
 * Created by Edi Santoso on 6/16/2014.
 * @email : edicyber@gmail.com
 */
var token = "&_token=" + $("input[name=_token]").val();
// onReady
$(document).ready(function () {
    $("#li-perangkat").attr("style", "display:block;");
    $("#a-perangkat").addClass("active");
    $("#menu-perdes").addClass("active");
    $("#mundur").attr('disabled', 'disabled');
    $("#alert-notify").hide();
    TampilData(1);
    // ketika ada event enter untuk pencarian
    $("#cari").keypress(function (event) {
        if (event.which == 13) {
            event.preventDefault();
            TampilData(1);
        }
    });
    $("#btn-tambah").click(function (event) {
        TombolTambah();
    });
    $("#btn-batal").click(function (event) {
        TombolBatal();
    });
});
// ajax menampilkan data
function TampilData(page) {
    OpenLoading();
    var term = $("#cari").val();
    $.ajax({
        type: "post",
        url: url + "/read?page=" + page,
        cache: false,
        data: 'term=' + term + token,
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
    if (obj[6].length == 0) {
        $("#datalist").append("<tr><td colspan='" + $("tbody > tr > th").length + "'>Data kosong.</td></tr>");
    } else {
        $.each(obj[6], function (index, val) {
            $("#datalist").append(
                "<tr><td>" + val.jenis + "</td>" +
                "<td>" + val.judul + "</td>" +
                "<td>" + val.nomor + "</td>" +
                "<td><div class='btn-toolbar text-right'>" +
                "<a href='" + url + "/" + val.id + "' title='Detail Perdes' class='btn btn-default fa fa-list'></a>" +
                "<button title='Edit' class='btn btn-default fa fa-edit' onclick='EditData(" + val.id + ")'></button>" +
                "<button title='Hapus' class='btn btn-danger fa fa-trash-o' onclick='HapusData(" + val.id + ")'></button>" +
                "</div>" +
                "</td></tr>"
            )
        });
        methodPagination(obj);
    }
    CloseLoading();
    $("#cari").focus();
}
function SimpanData() {
    OpenSpinner();
    $.ajax({
        url: url,
        type: 'POST',
        data: $("#myForm").serialize()
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
        $("#jenis").val(data.jenis);
        $("#judul").val(data.judul);
        $("#tempat").val(data.tempat);
        $("#tanggal").val(data.tanggal);
        $("#tanggal_pengundangan").val(data.tanggal_pengundangan);
        $("#pengundangan").val(data.pengundangan);
        $("#perdes_id").val(data.perdes_id);
        $("#nomor").val(data.nomor);
        $("#tahun").val(data.tahun);
        $("option:selected").attr('selected', 'selected');
    }, 1500);
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
function TombolBatal() {
    // kosongkan
    $("#id").val("");
    // hide
    $("#myForm").hide();
    $("#alert-notify").fadeOut(3000);
    // set atribut
    $("#cmd").val('tambah');
    $("label.error").hide();
    // remove class error
    $("#jenis").val("").removeClass('error');
    $("#judul").val("").removeClass('error');
    $("#tempat").val("").removeClass('error');
    $("#tanggal").val("").removeClass('error');
    $("#tanggal_pengundangan").val("").removeClass('error');
    $("#pengundangan").val("").removeClass('error');
    $("#perdes_id").val("").removeClass('error');
    $("#nomor").val("").removeClass('error');
    $("#tahun").val("").removeClass('error');
    // show
    $("#form-cari").show();
    $("#form-option").show();
    $("#tab-content").show();
    // ajax data
    TampilData(1);
}
function TombolTambah() {
    // kosongkan data html
    // set ajax data
    // hide
    $("#form-option").hide();
    $("#tab-content").hide();
    $("#form-cari").hide();
    // show
    $("#myForm").show();
    // focused
    $("#jenis").focus();
}
//Validasi
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
            n.is(".form-group") ? e.appendTo(n) : e.appendTo(n.parent());
            e.addClass("error control-label")
        },
        rules: {
            jenis: 'required',
            judul: 'required',
            tempat: 'required',
            tanggal: 'required',
            nomor: 'required',
            tahun: 'required',
            tanggal_pengundangan: 'required',
            pengundangan: 'required'
        },
        messages: {
            jenis: "Silahkan pilih jenis peraturan",
            judul: "Silahkan isi judul",
            nomor: "Silahkan isi nomor",
            tempat: "Silahkan isi tempat",
            tanggal: "Silahkan isi tanggal",
            tahun: "Silahkan isi tahun",
            tanggal_pengundangan: "Silahkan pilih isi tanggal pengundangan",
            pengundangan: "Silahkan isi pengundangan"
        }
    })
});
