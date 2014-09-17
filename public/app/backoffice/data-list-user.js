/**
 * Created by Edi Santoso on 5/12/2014.
 */

var token = "&_token=" + $("input[name=_token]").val();
// onReady
$(document).ready(function () {
    $("#li-master").attr("style", "display:block;");
    $("#a-master").addClass("active");
    $("#list-user").addClass("active");
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
        error: function () {
            ErrMsg()
        }
    });
}
function resultData(data) {
    var obj = json2array(data);
    $("#datalist").html("");
    if (obj[6].length == 0) {
        $("#datalist").append("<tr><td colspan='6'>Data kosong.</td></tr>");
    } else {
        $.each(obj[6], function (index, val) {
            var is_demo = val.is_demo;
            var is_active = val.is_active;
            var btn_unset_demo = "<button title='Unset Demo' class='btn btn-sm btn-warning' onclick='unsetDemo(" + val.id + ")'><i class='fa fa-thumbs-o-down'></i></button>";
            var btn_set_demo = "<button title='Set Demo' class='btn btn-sm btn-info' onclick='setDemo(" + val.id + ")'><i class='fa fa-thumbs-o-up'></i></button>";
            var btn_unset_active = "<button title='Unset Active' class='btn btn-sm btn-success' onclick='unsetActive(" + val.id + ")'><i class='fa fa-unlock'></i></button>";
            ;
            var btn_set_active = "<button title='Set Active' class='btn btn-sm btn-danger' onclick='setActive(" + val.id + ")'><i class='fa fa-lock'></i></button>";
            ;
            var demo = (is_demo == 0) ? btn_set_demo : btn_unset_demo;
            var active = (is_active == 1) ? btn_set_active : btn_unset_active;
            var status = (is_demo == 0) ? 'Aktif' : 'Demo';
            var level;
            switch (eval(val.is_admin)) {
                case 1:
                    level = "Administrator";
                    break;
                case 2:
                    level = "Kepala Desa";
                    break;
                case 3:
                    level = "Sekretaris Desa";
                    break;
                case 4:
                    level = "Bendahara Desa";
                    break;
                case 5:
                    level = "Bendahara Pembantu Penerimaan";
                    break;
                case 6:
                    level = "Bendahara Pembantu Pengeluaran";
                    break;
                default:
                    level = "Guest";
            }
            $("#datalist").append(
                "<tr><td class='col-md-2'>" + val.name + "</td>" +
                "<td class='col-md-2'>" + val.email + "</td>" +
                "<td class='col-md-2'>" + status + "</td>" +
                "</td><td class='col-md-1'>" + level +
                "<td class='col-md-2'>" + val.organisasi.nama + "</td>" +
                "<td class='col-md-'><div class='btn-toolbar'>" +
                demo + active +
                "</div>" +
                "</td></tr>"
            )
        });
        methodPagination(obj);
    }
    CloseLoading();
    $("#cari").focus();
}
// set akun menjadi demo
function setDemo(id) {
    OpenSpinner();
    $.ajax({
        url: url_set_demo,
        type: 'POST',
        data: "id=" + id + token
    }).done(function (data) {
        CekAuth(data);
        $("#alert-notify").show().html("");
        switch (data.Status) {
            case "Sukses":
                resultSuccess(data);
                TampilData(1);
                break;
            case "Warning":
                resultWarning(data);
                break;
        }
    }).fail(function (data) {
        ErrMsg()
    })
}
// set akun menjadi tidak demo
function unsetDemo(id) {
    OpenSpinner();
    $.ajax({
        url: url_unset_demo,
        type: 'POST',
        data: "id=" + id + token
    }).done(function (data) {
        CekAuth(data);
        $("#alert-notify").show().html("");
        switch (data.Status) {
            case "Sukses":
                resultSuccess(data);
                TampilData(1);
                break;
            case "Warning":
                resultWarning(data);
                break;
        }
    }).fail(function (data) {
        ErrMsg()
    })
}
// set akun menjadi tidak demo
function setActive(id) {
    OpenSpinner();
    $.ajax({
        url: url_set_active,
        type: 'POST',
        data: "id=" + id + token
    }).done(function (data) {
        CekAuth(data);
        $("#alert-notify").show().html("");
        switch (data.Status) {
            case "Sukses":
                resultSuccess(data);
                TampilData(1);
                break;
            case "Warning":
                resultWarning(data);
                break;
        }
    }).fail(function (data) {
        ErrMsg()
    })
}
// set akun menjadi tidak demo
function unsetActive(id) {
    OpenSpinner();
    $.ajax({
        url: url_unset_active,
        type: 'POST',
        data: "id=" + id + token
    }).done(function (data) {
        CekAuth(data);
        $("#alert-notify").show().html("");
        switch (data.Status) {
            case "Sukses":
                resultSuccess(data);
                TampilData(1);
                break;
            case "Warning":
                resultWarning(data);
                break;
        }
    }).fail(function (data) {
        ErrMsg()
    })
}