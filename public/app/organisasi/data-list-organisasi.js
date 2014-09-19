/**
 * Created by Edi Santoso on 5/12/2014.
 */

var token = "&_token=" + $("input[name=_token]").val();
// onReady
$(document).ready(function () {
    $("#li-master").attr("style", "display:block;");
    $("#a-master").addClass("active");
    $("#list-organisasi").addClass("active");
    $("#alert-notify").hide();
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
            var is_active = val.is_active;
            var btn_unset_active = "<button title='Unset Active' class='btn btn-sm btn-primary' onclick='unsetActive(" + val.id + ")'><i class='fa fa-unlock'></i></button>" +
                "<button title='Unset Active' class='btn btn-sm btn-white' onclick='sendMessage(" + val.id + ")'><i class='fa fa-envelope-o'></i></button>";
            var btn_set_active = "<button title='Set Active' class='btn btn-sm btn-danger' onclick='setActive(" + val.id + ")'><i class='fa fa-lock'></i></button>" +
                "<button title='Unset Active' class='btn btn-sm btn-white' onclick='sendMessage(" + val.id + ")'><i class='fa fa-envelope-o'></i></button>";
            var active = (is_active == 1) ? btn_unset_active : btn_set_active;
            var status = (is_active == 1) ? 'Aktif' : 'Tidak Aktif';
            $("#datalist").append(
                "<tr><td class='col-md-3'><a href='" + url_detil + '/' + val.id +
                "' data-original-title='Lihat detil' data-placement='top' class='tooltips'>" + val.desa + "</a></td>" +
                "<td class='col-md-2'>" + val.email + "</td>" +
                "<td class='col-md-2'>" + status + "</td>" +
                "<td class='col-md-3'>" + val.kab + "</td>" +
                "<td class='col-md-2'><div class='btn-toolbar'>" +
                active +
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