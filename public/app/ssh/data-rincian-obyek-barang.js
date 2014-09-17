/**
 * Created by Edi Santoso on 5/24/2014.
 * @email : edicyber@gmail.com
 */

var token = "&_token=" + $("input[name=_token]").val();
// onReady
$(document).ready(function () {
    $("#li-master").attr("style", "display:block;");
    $("#a-master").addClass("active");
    $("#menu-ssh").addClass("active");
    $("#mundur").attr('disabled', 'disabled');
    $("#alert-notify").hide();
    $("#harga").number(true, '', '', '.');
    var current_page = $("#current_page").val();
    var to = $("#to").val();
    var total = $("#total").val();
    if (total == 0) {
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
                "<tr><td>" + val.kode_rekening + "</td>" +
                "<td>" + val.obyek.obyek + "</td>" +
                "<td>" + val.rincian_obyek + "</td>" +
                "<td>" + val.satuan + "</td>" +
                "<td class='text-right'>" + toRp(val.harga) + "</td>" +
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
    getKelompokBarang(data.kelas);
    getJenisBarang(data.kelompok);
    getObyekBarang(data.jenis);
    $("#kelompok").removeAttr('disabled');
    $("#jenis").removeAttr('disabled');
    $("#obyek").removeAttr('disabled');
    setTimeout(function () {
        // set atribute
        $("#cmd").val('update');
        $("#btnSimpan").text("Update");
        // inject data
        $("#id").val(data.id);
        $("#kelas").val(data.kelas);
        $("#kelompok").val(data.kelompok);
        $("#jenis").val(data.jenis);
        $("#obyek").val(data.obyek);
        $("#kode_rekening").val(data.kode_rekening);
        $("#obyek_id").val(data.obyek_id);
        $("#rincian_obyek").val(data.rincian_obyek);
        $("#spesifikasi").val(data.spesifikasi);
        $("#harga").val(data.harga);
        $("#satuan").val(data.satuan);
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
            $("#alert-notify").html("").show();
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
    // set atribut
    $("#cmd").val('tambah');
    $("label.error").hide();
    $("#btn-simpan").text("Simpan").removeAttr('disabled');
    // remove class error
    $("#kelas").html("").removeClass('error');
    $("#kelompok").html("").removeClass('error');
    $("#jenis").html("").removeClass('error');
    $("#obyek").html("").removeClass('error');
    $("#kode_rekening").val("").removeClass('error');
    $("#obyek_id").val("").removeClass('error');
    $("#rincian_obyek").val("").removeClass('error');
    $("#spesifikasi").val("").removeClass('error');
    $("#harga").val("").removeClass('error');
    $("#satuan").val("").removeClass('error');
    // show
    $("#form-cari").show();
    $("#form-option").show();
    $("#tab-content").show();
    // ajax data
    TampilData(1);
}
function TombolTambah() {
    // set ajax data
    getKelasBarang();
    // hide
    $("#form-option").hide();
    $("#tab-content").hide();
    $("#form-cari").hide();
    // show
    $("#myForm").show();
    // focused
    $("#kelas").focus();
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
            kelas: 'required',
            kelompok: 'required',
            jenis: 'required',
            obyek: 'required',
            kode_rekening: 'required',
            rincian_obyek: 'required',
            spesifikasi: 'required',
            harga: 'required'
        },
        messages: {
            kelas: "Silahkan pilih kelas barang.",
            kelompok: "Silahkan pilih kelompok barang.",
            jenis: "Silahkan pilih jenis barang.",
            obyek: "Silahkan pilih obyek barang.",
            kode_rekening: "Silahkan isi kode rekening",
            rincian_obyek: "Silahkan isi nama barang",
            spesifikasi: "Silahkan isi satuan",
            harga: "Silahkan isi harga"
        }
    })
});
// method ajax dropdown
function getKelasBarang() {
    $.ajax({
        type: "get",
        url: url_kelas_barang,
        success: function (data) {
            $("#kelas").html("").append("<option value=''>Pilih Kelas Barang</option>");
            $.each(data, function (index, val) {
                $("#kelas").append("<option value='" + val.id + "'>" + val.kelas + "</option>")
            });
        },
        error: function (data) {}
    });
}
$(function () {
    $("#kelas").change(function () {
        var kelas_id = $(this).val();
        $("#kelompok").removeAttr('disabled');
        getKelompokBarang(kelas_id);
    })
});
function getKelompokBarang(kelas_id) {
    $.ajax({
        type: "post",
        url: url_kelompok_barang,
        data: "kelas_id=" + kelas_id + token,
        success: function (data) {
            if (data == "") {
                $("#kelompok").html("").append("<option value=''>Data kosong</option>").attr('disabled', 'disabled');
                $("#jenis").html("").append("<option value=''>Data kosong</option>").attr('disabled', 'disabled');
                $("#obyek").html("").append("<option value=''>Data kosong</option>").attr('disabled', 'disabled');
            } else {
                $("#kelompok").removeAttr('disabled').html("").append("<option value=''>Pilih Kelompok Barang</option>");
            }
            $.each(data, function (index, val) {
                $("#kelompok").append("<option value='" + val.id + "'>" + val.kelompok + "</option>")
            });
        },
        error: function (data) {
        }
    });
}
$(function () {
    $("#kelompok").change(function () {
        var jenis_id = $(this).val();
        $("#jenis").removeAttr('disabled');
        getJenisBarang(jenis_id);
    })
});
function getJenisBarang(kelompok_id) {
    $.ajax({
        type: "post",
        url: url_jenis_barang,
        data: "kelompok_id=" + kelompok_id + token,
        success: function (data) {
            if (data == "") {
                $("#jenis").html("").append("<option value=''>Data kosong</option>").attr('disabled', 'disabled');
                $("#obyek").html("").append("<option value=''>Data kosong</option>").attr('disabled', 'disabled');
            } else {
                $("#jenis").removeAttr('disabled').html("").append("<option value=''>Pilih Jenis Barang</option>");
            }
            $.each(data, function (index, val) {
                $("#jenis").append("<option value='" + val.id + "'>" + val.jenis + "</option>")
            });
        },
        error: function (data) {
        }
    });
}
$(function () {
    $("#jenis").change(function () {
        var jenis_id = $(this).val();
        $("#obyek").removeAttr('disabled');
        getObyekBarang(jenis_id);
    })
});
function getObyekBarang(jenis_id) {
    $.ajax({
        type: "post",
        url: url_obyek_barang,
        data: "jenis_id=" + jenis_id + token,
        success: function (data) {
            if (data == "") {
                $("#obyek").html("").append("<option value=''>Data kosong</option>").attr('disabled', 'disabled');
            } else {
                $("#obyek").removeAttr('disabled').html("").append("<option value=''>Pilih Obyek Barang</option>");
            }
            $.each(data, function (index, val) {
                $("#obyek").append("<option value='" + val.id + '|' + val.kode_rekening + "'>" + val.obyek + "</option>")
            });
        },
        error: function (data) {
        }
    });
}
$(function () {
    $("#obyek").change(function (event) {
        var data = $(this).val();
        var myArr = data.split('|');
        setTimeout(function () {
            $("#obyek_id").val(myArr[0]);
            $("#kode_rekening").val(myArr[1] + ".");
        }, 500);
        $("#kode_rekening").focus();
    });
});
