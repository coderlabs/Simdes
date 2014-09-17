/**
 * Created by Edi Santoso on 5/10/14.
 */

var token = "&_token=" + $("input[name=_token]").val();
// onReady
$(document).ready(function () {
    $("#li-penganggaran").attr("style", "display:block;");
    $("#a-penganggaran").addClass("active");
    $("#menu-pendapatan").addClass("active");
    $("#mundur").attr('disabled', 'disabled');
    $("#alert-notify").hide();
    $("#satuan_harga").number(true, '', '', '.');
    $("#jumlah").number(true, '', '', '.');
    $("#jenis_id").attr('disabled', 'disabled');
    $("#obyek_id").attr('disabled', 'disabled');
    $("#rincian_obyek_id").attr('disabled', 'disabled');
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
        $("#datalist").append("<tr><td colspan='" + $("thead > tr > th").length + "'>Data kosong.</td></tr>");
    } else {
        $.each(obj[6], function (index, val) {
            var vol_1 = val.volume_1;
            var vol_2 = (val.volume_2.length > 0) ? "/" + val.volume_2 : "";
            var vol_3 = (val.volume_3.length > 0) ? "/" + val.volume_3 : "";
            var volume = toRp(vol_1) + vol_2 + vol_3;
            var sat_1 = val.satuan_1;
            var sat_2 = (val.satuan_2.length > 0) ? "/" + val.satuan_2 : "";
            var sat_3 = (val.satuan_3.length > 0) ? "/" + val.satuan_3 : "";
            var satuan = sat_1 + sat_2 + sat_3;
            // proses rka
            var normal =
                "<button title='Edit' class='btn btn-sm btn-default fa fa-edit' onclick='EditData(" + val.id + ")'></button>" +
                "<button title='Hapus' class='btn btn-sm btn-danger fa fa-trash-o' onclick='HapusData(" + val.id + ")'></button>";
            var is_rka = "<button title='rka Desa' class='btn btn-sm btn-default fa fa-check-square' onclick='setRKA(" + val.id + ")'></button>";
            var setRKA = (val.is_rka == 1) ? "" : is_rka;
            var setDPA = (val.is_dpa == 1) ? "" : normal;
            $("#datalist").append(
                "<tr><td>" + val.tahun +
                "</td><td>" + val.pendapatan +
                "</td><td>" + volume +
                "</td><td>" + satuan +
                "</td><td class='text-right'>" + toRp(val.satuan_harga) +
                "</td><td class='text-right'>" + toRp(val.jumlah) +
                "</td><td class='text-right'>" +
                "<div class='btn-toolbar'>" +
                "<a title='Pelaksanaan Pendapatan' href='" + url + '/' + val.id + "' title='Edit' class='btn btn-sm btn-default fa fa-cogs' ></a>" + setRKA + setDPA +
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
// set rka pendapatan
function setRKA(id) {
    OpenSpinner();
    $.ajax({
        url: url_set_rka,
        type: 'POST',
        data: "id=" + id + token
    }).done(function (data) {
        CekAuth(data);
        $("#alert-notify").show().html("");
        switch (data.Status) {
            case "Sukses":
                resultSuccess(data);
                break;
            case "Warning":
                resultWarning(data);
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
        error: function (data) {
            ErrMsg()
        }
    });
}
function dataSuccess(data) {
    TombolTambah();
    getJenis(data.kelompok_id);
    getObyek(data.jenis_id);
    getRincianObyek(data.obyek_id);
    // set remove attr
    $("#jenis_id").removeAttr('disabled');
    $("#obyek_id").removeAttr('disabled');
    $("#rincian_obyek_id").removeAttr('disabled');
    setTimeout(function () {
        $("#cmd").val('update');
        $("#btnSimpan").text("Update");
        $("#id").val(data.id);
        $("#tahun").val(data.tahun);
        $("#kelompok_id").val(data.kelompok_id);
        $("#jenis_id").val(data.jenis_id);
        $("#obyek_id").val(data.obyek_id);
        $("#rincian_obyek_id").val(data.rincian_obyek_id);
        $("#volume_1").val(data.volume_1);
        $("#satuan_1").val(data.satuan_1);
        $("#volume_2").val(data.volume_2);
        $("#satuan_2").val(data.satuan_2);
        $("#volume_3").val(data.volume_3);
        $("#satuan_3").val(data.satuan_3);
        $("#satuan_harga").val(data.satuan_harga);
        $("option:selected").attr('selected', 'selected');
    }, 1500);
    CloseLoading();
}
function UpdateData() {
    OpenSpinner();
    $("#btnSimpan").attr('disabled', 'disabled');
    var id = $("#id").val()
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
    }).fail(function (data) {
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
                    $('#alert-notify').removeClass('alert-success').addClass('alert-danger').append("<ul style='margin-bottom: 0px;'>" + data[i] + "</ul>");
                }
            } else {
                $("#alert-notify").removeClass('alert-danger').addClass('alert-success').append("<ul>" + data[1] + "</ul>").fadeOut(1000);
                $("#datalist").html("");
                TampilData($("#current_page").val());
                CloseLoading();
            }
            $("#modalHapus").modal('hide');
        },
        error: function (data) {
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
    $("#volume_2").val("");
    $("#satuan_2").val("");
    $("#volume_3").val("");
    $("#satuan_3").val("");
    // hide
    $("#myForm").hide();
    $("#alert-notify").fadeOut(3000);
    // replace text, attr
    $("#cmd").val('tambah');
    $("label.error").hide();
    $("#btn-simpan").text("Simpan").removeAttr('disabled');
    $("#tahun").val("").removeClass('error');
    $("#kelompok_id").val("").html("").removeClass('error');
    $("#volume_1").val("").removeClass('error');
    $("#satuan_1").val("").removeClass('error');
    $("#satuan_harga").val("").removeClass('error');
    $("#jenis_id").html("");
    $("#obyek_id").html("");
    $("#rincian_obyek_id").html("");
    // show
    $("#form-cari").show();
    $("#form-option").show();
    $("#tab-content").show();
    // ajax data
    TampilData(1);
}
function TombolTambah() {
    // set control
    // ajax data
    getKelompok();
    // hide
    $("#form-option").hide();
    $("#tab-content").hide();
    $("#form-cari").hide();
    // show
    $("#myForm").show();
    // focused
    $("#tahun").val(getTahun()).focus();
}
// ajax get data kelompok dropdown
function getKelompok() {
    var akun_id = 1;
    $.ajax({
        type: "post",
        url: "ajax-data-kelompok",
        data: "akun_id=" + akun_id + token,
        success: function (data) {
            switch (data.Status) {
                case "Warning":
                    resultWarning(data);
                    break;
                case "Logout":
                    CekAuth(data);
                    break;
                default:
                    resultDataKelompok(data);
            }
        },
        error: function () {
            ErrMsg()
        }
    });
}
function resultDataKelompok(data) {
    $("#kelompok_id").html("").append("<option value=''>Pilih Kelompok</option>");
    $.each(data, function (index, val) {
        $("#kelompok_id").append("<option value='" + val.id + "'>" + val.kelompok + "</option>")
    });
}
$(function () {
    $("#kelompok_id").change(function () {
        var kelompok_id = $("#kelompok_id").val();
        $("#jenis_id").removeAttr('disabled');
        getJenis(kelompok_id);
    })
});
$(function () {
    $("#jenis_id").change(function () {
        var jenis_id = $("#jenis_id").val();
        $("#obyek_id").removeAttr('disabled');
        getObyek(jenis_id);
    })
});
$(function () {
    $("#obyek_id").change(function () {
        var obyek_id = $("#obyek_id").val();
        $("#rincian_obyek_id").removeAttr('disabled');
        getRincianObyek(obyek_id);
    })
});
// ajax get data akun dropdown
function getAkun() {
    $.ajax({
        type: "get",
        url: "ajax-data-akun",
        success: function (data) {
            switch (data.Status) {
                case "Warning":
                    resultWarning(data);
                    break;
                case "Logout":
                    CekAuth(data);
                    break;
                default:
                    resulDataAkun(data);
            }
        },
        error: function () {
            ErrMsg()
        }
    });
}
function resulDataAkun(data) {
    $.each(data, function (index, val) {
        $("#akun_id").append("<option value='" + val.id + "'>" + val.akun + "</option>")
    });
}
// ajax get data jenis dropdown
function getJenis(kelompok_id) {
    $("#jenis_id").html("");
    $.ajax({
        type: "post",
        url: "ajax-data-jenis",
        data: "kelompok_id=" + kelompok_id + token,
        success: function (data) {
            switch (data.Status) {
                case "Warning":
                    resultWarning(data);
                    break;
                case "Logout":
                    CekAuth(data);
                    break;
                default:
                    resultDataJenis(data);
            }
        },
        error: function () {
            ErrMsg()
        }
    });
}
function resultDataJenis(data) {
    if (data.length < 1) {
        $("#jenis_id").attr('disabled', 'disabled').html("").append("<option value=''>Data Kosong</option>");
        $("#obyek_id").attr('disabled', 'disabled').html("").append("<option value=''>Data Kosong</option>");
        $("#rincian_obyek_id").attr('disabled', 'disabled').html("").append("<option value=''>Data Kosong</option>");
    }
    $("#jenis_id").html("").append("<option value=''>Pilih Jenis</option>");
    $.each(data, function (index, val) {
        $("#jenis_id").append("<option value='" + val.id + "'>" + val.jenis + "</option>")
    });
}
// ajax get data obyek dropdown
function getObyek(jenis_id) {
    $("#obyek_id").html("");
    $.ajax({
        type: "post",
        url: "ajax-data-obyek",
        data: "jenis_id=" + jenis_id + token,
        success: function (data) {
            switch (data.Status) {
                case "Warning":
                    resultWarning(data);
                    break;
                case "Logout":
                    CekAuth(data);
                    break;
                default:
                    resultDataObyek(data);
            }
        },
        error: function () {
            ErrMsg()
        }
    });
}
function resultDataObyek(data) {
    if (data.length < 1) {
        $("#obyek_id").attr('disabled', 'disabled').html("").append("<option value=''>Data Kosong</option>");
        $("#rincian_obyek_id").attr('disabled', 'disabled').html("").append("<option value=''>Data Kosong</option>");
    }
    $("#obyek_id").html("").append("<option value=''>Pilih Obyek</option>");
    $.each(data, function (index, val) {
        $("#obyek_id").append("<option value='" + val.id + "'>" + val.obyek + "</option>")
    });
}
// ajax get data rincian obyek dropdown
function getRincianObyek(obyek_id) {
    $("#rincian_obyek_id").html("");
    $.ajax({
        type: "post",
        url: "ajax-data-rincian-obyek",
        data: "obyek_id=" + obyek_id + token,
        success: function (data) {
            switch (data.Status) {
                case "Warning":
                    resultWarning(data);
                    break;
                case "Logout":
                    CekAuth(data);
                    break;
                default:
                    resultDataRincianObyek(data);
            }
        },
        error: function () {
            ErrMsg()
        }
    });
}
function resultDataRincianObyek(data) {
    if (data.length < 1) {
        $("#rincian_obyek_id").attr('disabled', 'disabled').html("").append("<option value=''>Data Kosong</option>");
    }
    $("#rincian_obyek_id").html("").append("<option value=''>Pilih Rincian Obyek</option>");
    $.each(data, function (index, val) {
        $("#rincian_obyek_id").append("<option value='" + val.id + "'>" + val.rincian_obyek + "</option>")
    });
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
            var p = t.insertBefore('col-md-4')
            n.is(".form-group") ? e.appendTo(n) : e.appendTo(n.parent()),
                e.addClass("error control-label")
        },
        rules: {
            tahun: 'required',
            kelompok_id: 'required',
            volume_1: 'required',
            satuan_1: 'required',
            satuan_harga: 'required'
        },
        messages: {
            tahun: "Silahkan isi tahun ",
            kelompok_id: "Silahkan pilih kelompok ",
            volume_1: "Silahkan isi volume 1 ",
            satuan_1: "Silahkan isi satuan 1 ",
            satuan_harga: "Silahkan isi satuan harga"
        }
    })
});
