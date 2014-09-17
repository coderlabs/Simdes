/**
 * Created by Edi Santoso on 6/7/2014.
 * @email : edicyber@gmail.com
 */

var checkin = $('#start').datepicker({
    onRender: function (date) {
        return date.valueOf() < now.valueOf() ? 'disabled' : '';
    }
}).on('changeDate', function (ev) {
    if (ev.date.valueOf() > checkout.date.valueOf()) {
        var newDate = new Date(ev.date);
        newDate.setDate(newDate.getDate() + 1);
        checkout.setValue(newDate);
    }
    checkin.hide();
    $('#end')[0].focus();
}).data('datepicker');
var checkout = $('#end').datepicker({
    onRender: function (date) {
        return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
    }
}).on('changeDate', function (ev) {
    checkout.hide();
    // jalankan perintah pencarian data berdasarkan tanggal
    TampilData(1);
    //alert(start+' '+ end);
}).data('datepicker');
var token = "&_token=" + $("input[name=_token]").val();
var current_page = $("#current_page").val();
// onReady
$(document).ready(function () {
    $("#li-penatausahaan-pengeluaran").attr("style", "display:block;");
    $("#a-penatausahaan-pengeluaran").addClass("active");
    $("#menu-bku-belanja").addClass("active");
    $("#mundur").attr('disabled', 'disabled');
    $("#alert-notify").hide();
    $("#jumlah").number(true, '', '', '.');
    $("#realisasi").number(true, '', '', '.');
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
    var start = $("#start").val();
    var end = $("#end").val();
    var term = $("#cari").val();
    $.ajax({
        type: "post",
        url: url + "/read?page=" + page,
        cache: false,
        data: 'start=' + start + '&end=' + end + '&term=' + term + token,
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
                "<tr><td>" + TglDMY(val.tanggal) +
                "</td><td>" + val.no_bku_trsk +
                "</td><td>" + val.penerima +
                "</td><td>" + val.uraian +
                "</td><td class='text-right'>" + toRp(val.jumlah) +
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
    setTimeout(function () {
        $("#cmd").val('update');
        $("#btnSimpan").text("Update");
        $("#id").val(data.id);
        $("#no_bukti").val(data.no_bukti);
        $("#tanggal").val(data.tanggal);
        $("#penerima").val(data.penerima);
        $("#uraian").val(data.uraian);
        $("#jumlah").val(data.jumlah);
        $("#realisasi").val(data.realisasi);
        $("#pendapatan_id").val(data.pendapatan_id);
        $("#pendapatan").val(data.pendapatan);
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
    }).error(function (data) {
        ErrMsg();
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
        error: function (data) {
            ErrMsg()
        }
    });
}
$(function () {
    $("#btn-cetak").click(function () {
        var start = $("#start").val();
        var end = $("#end").val();

        window.location.assign(url_cetak_bku + '/start=' + start + '&end=' + end)
    });
});
function TombolBatal() {
    // kosongkan
    $("#id").val("");
    // hide
    $("#myForm").hide();
    $("#alert-notify").fadeOut(3000);
    // replace text, attr
    $("#cmd").val('tambah');
    $("label.error").hide();
    $("#no_bukti").val("").removeClass('error');
    $("#pendapatan_id").val("").removeClass('error');
    $("#tanggal").val("").removeClass('error');
    $("#penerima").val("").removeClass('error');
    $("#pendapatan").val("").removeClass('error');
    $("#uraian").val("").removeClass('error');
    $("#jumlah").val("").removeClass('error');
    $("#pejabat_desa_id").html("").removeClass("error");
    // show
    $("#form-cari").show();
    $("#form-option").show();
    $("#tab-content").show();
    // ajax data
    TampilData(1);
}
function TombolTambah() {
    // set control, kosongkan dropdown
    // ajax data
    getPejabatDesa();
    $("#tanggal").val(TglYMD());
    // hide
    $("#form-option").hide();
    $("#tab-content").hide();
    $("#form-cari").hide();
    // show
    $("#myForm").show();
    // focused
    setTimeout(function () {
        var data = $("#pendapatan_id").val();
        var array = data.split('|');
        var realisasi = array[1];
        $("#realisasi").val(realisasi);
    }, 500);
    $("#pendapatan").focus();
}
// ajax get data akun dropdown
function getPejabatDesa() {
    $.ajax({
        type: "get",
        url: "ajax-pejabat-desa",
        success: function (data) {
            switch (data.Status) {
                case "Warning":
                    resultWarning(data);
                    break;
                case "Logout":
                    CekAuth(data);
                    break;
                default:
                    resulPejabatDesa(data);
            }
        },
        error: function () {
            ErrMsg()
        }
    });
}
function resulPejabatDesa(data) {
    $.each(data, function (index, val) {
        $("#pejabat_desa_id").append("<option value='" + val.id + "'>" + val.pejabat_desa + "</option>")
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
            var p = t.insertBefore('col-md-4');
            n.is(".form-group") ? e.appendTo(n) : e.appendTo(n.parent()),
                e.addClass("error control-label")
        },
        rules: {
            no_bukti: {
                required: true,
                maxlength: 5,
                minlength: 5
            },
            tanggal: 'required',
            pejabat_desa_id: 'required',
            pendapatan: 'required',
            jumlah: 'required'
        },
        messages: {
            no_bukti: {
                required: "Wajib diisi",
                maxlength: "No bukti maksimal 5 digit angka",
                minlength: "No bukti minimal 5 digit angka",
            },
            tanggal: "Silahkan isi tanggal",
            pejabat_desa_id: "Silahkan pilih penerima",
            pendapatan: "Autocomplete : keyword minimal 2 huruf.",
            jumlah: "Silahkan isi jumlah"
        }
    })
});
// set posting pendapatan
function Posting(id) {
    OpenSpinner();
    $.ajax({
        url: url_posting_pendapatan,
        type: 'POST',
        data: "id=" + id + token
    }).done(function (data) {
        CekAuth(data);
        $("#alert-notify").show().html("");
        switch (data.Status) {
            case "Sukses":
                resultSuccess(data);
                TampilData($("#current_page").val());
                break;
            case "Warning":
                resultWarning(data);
                TampilData($("#current_page").val());
                break;
        }
    }).fail(function (data) {
        ErrMsg()
    })
}