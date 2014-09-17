/**
 * File ini harus diinclude secara global
 * todo : optimasi file js dengan menggabungkan menjadi satu file
 *
 * Created by Edi Santoso on 6/7/2014.
 * @email : edicyber@gmail.com
 */

// set datepicker
$(".default-date-picker").on('changeDate', function () { $("#default-date-picker").datepicker("hide") });
// listing #maju onclick
$(function () {
    $("#maju").click(function () {
        var last_page = $("#last_page").val();
        var current_page = $("#current_page").val();
        var page = eval(current_page) + eval(1);
        if (page == last_page) {
            $("#maju").attr('disabled', 'disabled');
            $("#akhir").attr('disabled', 'disabled');
        } else {
            $("#maju").removeAttr('disabled');
            $("#akhir").removeAttr('disabled');
        }
        TampilData(page);
    });
});
// listing #mundur onclick
$(function () {
    $("#mundur").click(function () {
        var last_page = $("#last_page").val();
        var current_page = $("#current_page").val();
        var page = eval(current_page) - eval(1);
        if (page == 1) {
            $("#mundur").attr('disabled', 'disabled');
            $("#awal").attr('disabled', 'disabled');
            $("#maju").removeAttr('disabled');
        } else {
            $("#mundur").removeAttr('disabled');
            $("#awal").removeAttr('disabled');
        }
        TampilData(page);
    });
});
// list data akhir#click
$(function () {
    $("#akhir").click(function () {
        //$("#maju").attr('disabled', 'disabled');
        //$("#mundur").attr('disabled', 'disabled');
        var last_page = $("#last_page").val();
        var current_page = $("#current_page").val();
        var page = eval(current_page) + eval(1);
        if (page == last_page) {
            $("#maju").attr('disabled', 'disabled');
            $("#akhir").attr('disabled', 'disabled');
        } else {
            $("#maju").removeAttr('disabled');
            $("#akhir").removeAttr('disabled');
        }
        TampilData(last_page);
    });
});
// list data awal#click
$(function () {
    $("#awal").click(function () {
        //$("#maju").attr('disabled', 'disabled');
        //$("#mundur").attr('disabled', 'disabled');
        var last_page = $("#last_page").val();
        var current_page = $("#current_page").val();
        var page = eval(current_page) - eval(1);
        if (page == 1) {
            $("#mundur").attr('disabled', 'disabled');
            $("#maju").removeAttr('disabled');
        } else {
            $("#mundur").removeAttr('disabled');
            $("#awal").removeAttr('disabled');
        }
        TampilData(1);
        $("#mundur").attr('disabled', 'disabled');
        $("#awal").attr('disabled', 'disabled');
    });
});
// method pagination
function methodPagination(obj) {
    $("#infopage").text(obj[4] + " - " + obj[5] + " dari " + obj[0]);
    $("#current_page").val(obj[2]);
    $("#last_page").val(obj[3]);
    if (obj[2] == obj[3]) {
        $("#maju").attr('disabled', 'disabled');
        $("#akhir").attr('disabled', 'disabled');
    } else {
        $("#maju").removeAttr('disabled');
        $("#akhir").removeAttr('disabled');
    }
    if (obj[2] > 1) {
        $("#mundur").removeAttr('disabled');
        $("#awal").removeAttr('disabled');
    }
}
// refresh atau mengembalikan data ke halaman pertama
// ketika pencarian data atau terdapat pesan error
$(function () {
    $("#btn-refresh").click(function () {
        $("#cari").val("");
        $("#alert-notify").hide();
        TampilData(1);
    });
});
// validate untuk inputan number only
// @todo:fungsi sudah digantikan dengan jquery number
function validate(evt) {
    var theEvent = evt || window.event;
    var key = theEvent.keyCode || theEvent.which;
    key = String.fromCharCode(key);
    var regex = /^[0-9._\b._\W._\T._\t]+$/;
    if (!regex.test(key)) {
        theEvent.returnValue = false;
        if (theEvent.preventDefault) theEvent.preventDefault();
    }
}
// validate untuk inputan nominal
// @todo:fungsi sudah digantikan dengan jquery number
function nominal(evt) {
    var theEvent = evt || window.event;
    var key = theEvent.keyCode || theEvent.which;
    key = String.fromCharCode(key);
    var regex = /^[0-9_\b_\T_\t]+$/;
    if (!regex.test(key)) {
        theEvent.returnValue = false;
        if (theEvent.preventDefault) theEvent.preventDefault();
    }
}
// get tahun sekarang
function getTahun() {
    var today = new Date();
    var year = today.getFullYear();
    return year;
}
