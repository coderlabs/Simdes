/**
 * Created by Edi Santoso on 5/18/2014.
 * @email : edicyber@gmail.com
 */

var token = "&_token=" + $("input[name=_token]").val();
// onReady
$(document).ready(function () {
    $("#li-struktur").attr("style", "display:block;");
    $("#a-struktur").addClass("active");
    $("#menu-akun").addClass("active");
    $("#mundur").attr('disabled', 'disabled');
    $("#alert-notify").hide();
    var current_page = $("#current_page").val();
    var to = $("#to").val();
    var total = $("#total").val();
    if(total == 0){
        $("#infopage").text('0 - ' + to + ' dari ' + total);
    } else {
        $("#infopage").text(current_page + ' - ' + to + ' dari ' + total);
    }
    // handle pagination
    if (total > 10) {
        $("#mundur").attr('disabled', 'disabled');
        $("#maju").removeAttr('disabled');
        $("#akhir").removeAttr('disabled');
    }
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
        error: function () {
            ErrMsg();
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
                "<tr><td>" + val.kode_rekening + "</td>" +
                "<td>" + val.kelompok.kelompok + "</td>" +
                "<td>" + val.jenis + "</td>" +
                "<td><div class='btn-toolbar'>" +
                "<button title='Edit' class='btn btn-sm btn-default' onclick='EditData(" + val.id + ")'><i class='fa fa-edit' ></i></button>" +
                "<button title='Hapus' class='btn btn-sm btn-danger ' onclick='HapusData(" + val.id + ")'><i class='fa fa-trash-o' ></i></button>" +
                "</div>" +
                "</td></tr>"
            )
        });
        methodPagination(obj);
    }
    CloseLoading();
    $("#cari").focus();
}
// Ajax simpan data visi
function SimpanData() {
    OpenSpinner();
    $.ajax({
        url: url,
        type: 'POST',
        data: $("#myForm").serialize(),
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
    TombolTambah();
    // set ajax
    setTimeout(function () {
        // set atribut
        $("#cmd").val('update');
        $("#btnSimpan").text("Update");
        // inject data
        $("#id").val(data.id);
        $("#kode_rekening").val(data.kode_rekening);
        $("#kelompok_id").val(data.kelompok_id);
        $("#kelompok").val(data.kelompok);
        $("#jenis").val(data.jenis);
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
        data: '_method=put&' + $("#myForm").serialize(),
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
// refresh
function Refresh() {
    $("#cari").val("");
    $("#alert-notify").hide();
    TampilData(1);
}
function TombolBatal() {
    // kosongkan
    $("#id").val("");
    // hide
    $("#myForm").hide();
    $("#alert-notify").fadeOut(3000);
    // set atribute
    $("#cmd").val('tambah');
    $("label.error").hide();
    $("#btn-simpan").text("Simpan").removeAttr('disabled');
    // remove class error
    $("#kode_rekening").val("").removeClass('error');
    $("#kelompok").val("").removeClass('error');
    $("#jenis ").html("").removeClass('error');
    // show
    $("#form-cari").show();
    $("#form-option").show();
    $("#tab-content").show();
    // ajax data
    TampilData(1);
}
function TombolTambah() {
    getKelompok();
    // kosongkan data html
    // set ajax data
    // hide
    $("#form-option").hide();
    $("#tab-content").hide();
    $("#form-cari").hide();
    // show
    $("#myForm").show();
    // focused
    $("#kelompok").focus();
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
            var p = t.insertBefore('col-md-4');
            n.is(".form-group") ? e.appendTo(n) : e.appendTo(n.parent()),
                e.addClass("error control-label")
        },
        rules: {
            kode_rekening: 'required',
            kelompok: 'required',
            jenis: 'required'
        },
        messages: {
            kode_rekening: "Silahkan isi kode rekening",
            kelompok: "Silahkan pilih Kelompok terlebih dahulu",
            jenis: "Silahkan isi jenis"
        }
    })
});
// ajax get akun dropdown
function getKelompok() {
    $.ajax({
        type: "get",
        url: url_kelompok,
        success: function (data) {
            CekAuth(data);
            $("#kelompok").html("").append("<option value=''>Pilih Kelompok</option>")
            $.each(data, function (index, val) {
                $("#kelompok").append("<option value='" + val.id + '|' + val.kode_rekening + "'>" + val.kelompok + "</option>")
            });
        },
        error: function (data) {}
    });
}
$(function () {
    $("#kelompok").change(function () {
        var data = $(this).val();
        var myArr = data.split('|');
        setTimeout(function () {
            $("#kelompok_id").val(myArr[0]);
            $("#kode_rekening").val(myArr[1] + ".").focus();
        }, 500);
        $("#kode_rekening").focus();
    });
});

