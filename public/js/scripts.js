//left side accordion
$(function () {
    $('#nav-accordion').dcAccordion({
        eventType: 'click',
        autoClose: true,
        saveState: true,
        disableLink: false,
        speed: 'slow',
        showCount: false,
        autoExpand: false,
        classExpand: 'dcjq-current-parent'
    });
});
var Script = function () {

    //  menu auto scrolling
    jQuery('#sidebar .sub-menu > a').click(function () {
        var o = ($(this).offset());
        diff = 80 - o.top;
        if (diff > 0)
            $("#sidebar").scrollTo("-=" + Math.abs(diff), 500);
        else
            $("#sidebar").scrollTo("+=" + Math.abs(diff), 500);
    });
    // toggle bar
    $(function () {
        var wd;
        wd = $(window).width();
        function responsiveView() {
            var newd = $(window).width();
            if (newd == wd) {
                return true;
            } else {
                wd = newd;
            }
            var wSize = $(window).width();
            if (wSize <= 768) {
                $('#sidebar').addClass('hide-left-bar');
            } else {
                $('#sidebar').removeClass('hide-left-bar');
            }
        }

        $(window).on('load', responsiveView);
        $(window).on('resize', responsiveView);
    });
    $('.sidebar-toggle-box .fa-bars').click(function (e) {
        $('#sidebar').toggleClass('hide-left-bar');
        $('#main-content').toggleClass('merge-left');
        e.stopPropagation();
        if ($('#container').hasClass('open-right-panel')) {
            $('#container').removeClass('open-right-panel')
        }
        if ($('.right-sidebar').hasClass('open-right-bar')) {
            $('.right-sidebar').removeClass('open-right-bar')
        }
        if ($('.header').hasClass('merge-header')) {
            $('.header').removeClass('merge-header')
        }
    });
    $('.toggle-right-box .fa-bars').click(function (e) {
        $('#container').toggleClass('open-right-panel');
        $('.right-sidebar').toggleClass('open-right-bar');
        $('.header').toggleClass('merge-header');
        e.stopPropagation();
    });
    $('.header,#main-content,#sidebar').click(function () {
        if ($('#container').hasClass('open-right-panel')) {
            $('#container').removeClass('open-right-panel')
        }
        if ($('.right-sidebar').hasClass('open-right-bar')) {
            $('.right-sidebar').removeClass('open-right-bar')
        }
        if ($('.header').hasClass('merge-header')) {
            $('.header').removeClass('merge-header')
        }
    });
    // custom scroll bar
    $("#sidebar").niceScroll({
        styler: "fb",
        cursorcolor: "#1FB5AD",
        cursorwidth: '3',
        cursorborderradius: '10px',
        background: '#404040',
        spacebarenabled: false,
        cursorborder: ''
    });
    $(".right-sidebar").niceScroll({
        styler: "fb",
        cursorcolor: "#1FB5AD",
        cursorwidth: '3',
        cursorborderradius: '10px',
        background: '#404040',
        spacebarenabled: false,
        cursorborder: ''
    });
    // widget tools
    jQuery('.panel .tools .fa-chevron-down').click(function () {
        var el = jQuery(this).parents(".panel").children(".panel-body");
        if (jQuery(this).hasClass("fa-chevron-down")) {
            jQuery(this).removeClass("fa-chevron-down").addClass("fa-chevron-up");
            el.slideUp(200);
        } else {
            jQuery(this).removeClass("fa-chevron-up").addClass("fa-chevron-down");
            el.slideDown(200);
        }
    });
    jQuery('.panel .tools .fa-times').click(function () {
        jQuery(this).parents(".panel").parent().remove();
    });
    // tool tips
    $('.tooltips').tooltip();
    // popovers
    $('.popovers').popover();
//    notification pie chart
//    $(function() {
//         $('.notification-pie-chart').easyPieChart({
//             onStep: function(from, to, percent) {
//                 $(this.el).find('.percent').text(Math.round(percent));
//             },
//             barColor: "#39b6ac",
//             lineWidth: 3,
//             size:50,
//             trackColor: "#efefef",
//             scaleColor:"#cccccc"
//
//         });
//
//    });
//
//
//         $(function() {
//
//             var datatPie = [30,50];
//    // DONUT
//             $.plot($(".target-sell"), datatPie,
//                 {
//                     series: {
//                         pie: {
//                             innerRadius: 0.6,
//                             show: true,
//                             label: {
//                                 show: false
//
//                             },
//                             stroke: {
//                                 width:.01,
//                                 color: '#fff'
//
//                             }
//                         }
//
//
//
//                     },
//
//                     legend: {
//                         show: true
//                     },
//                     grid: {
//                         hoverable: true,
//                         clickable: true
//                     },
//
//                     colors: ["#ff6d60", "#cbcdd9"]
//                 });
//         });
//
//    $(function() {
//         $('.pc-epie-chart').easyPieChart({
//             onStep: function(from, to, percent) {
//                 $(this.el).find('.percent').text(Math.round(percent));
//             },
//             barColor: "#5bc6f0",
//             lineWidth: 3,
//             size:50,
//             trackColor: "#32323a",
//             scaleColor:"#cccccc"
//
//         });
//
//    });
//
//
//
//    $(function() {
//         $(".d-pending").sparkline([3,1], {
//             type: 'pie',
//             width: '40',
//             height: '40',
//             sliceColors: ['#e1e1e1','#8175c9']
//         });
//    });
//
//
//
//    // SPARKLINE
//         $(function () {
//             var sparkLine = function () {
//                 $(".sparkline").each(function(){
//                     var $data = $(this).data();
//                     ($data.type == 'pie') && $data.sliceColors && ($data.sliceColors = eval($data.sliceColors));
//                     ($data.type == 'bar') && $data.stackedBarColor && ($data.stackedBarColor = eval($data.stackedBarColor));
//
//                     $data.valueSpots = {'0:': $data.spotColor};
//                     $(this).sparkline( $data.data || "html", $data);
//
//
//                     if($(this).data("compositeData")){
//                         $spdata = $(this).data("compositeConfig");
//                         $spdata.composite = true;
//                         $spdata.minSpotColor = false;
//                         $spdata.maxSpotColor = false;
//                         $spdata.valueSpots = {'0:': $spdata.spotColor};
//                         $(this).sparkline($(this).data("compositeData"), $spdata);
//                     };
//                 });
//             };
//
//             var sparkResize;
//             $(window).resize(function (e) {
//                 clearTimeout(sparkResize);
//                 sparkResize = setTimeout(function () {
//                     sparkLine(true)
//                 }, 500);
//             });
//             sparkLine(false);
//         });
    /*==Collapsible==*/
    $(function () {
        $('.widget-head').click(function (e) {
            var widgetElem = $(this).children('.widget-collapse').children('i');
            $(this)
                .next('.widget-container')
                .slideToggle('slow');
            if ($(widgetElem).hasClass('ico-minus')) {
                $(widgetElem).removeClass('ico-minus');
                $(widgetElem).addClass('ico-plus');
            } else {
                $(widgetElem).removeClass('ico-plus');
                $(widgetElem).addClass('ico-minus');
            }
            e.preventDefault();
        });
    });
}();
/**
 *   Custom Javascript
 *
 *   @Codename = SIMDES 2014
 *   @Author   = Edi Santoso
 *   @Email    = edicyber@gmail.com
 */

// Json to Array
function json2array(json) {
    var result = [];
    var keys = Object.keys(json);
    keys.forEach(function (key) {
        result.push(json[key]);
    });
    return result;
}
// jika ada tidak memiliki authentikasi
function CekAuth(data) {
    var val = json2array(data);
    if (val[0] == "Logout") {
        $("#alert-notify").show().html("");
        ErrorSpinner();
        $("#alert-notify").removeClass('alert-success').addClass('alert-danger').append("<ul style='margin-bottom: 0px;'>" + val[1] + "</ul>");
        setTimeout(function () {
            window.location.assign("login")
        }, 300);
    }
}
// to rupiah
function toRp(angka) {
    var rev = parseInt(angka, 10).toString().split('').reverse().join('');
    var rev2 = '';
    for (var i = 0; i < rev.length; i++) {
        rev2 += rev[i];
        if ((i + 1) % 3 === 0 && i !== (rev.length - 1)) {
            rev2 += '.';
        }
    }
    return rev2.split('').reverse().join('');
}
// under maintenace
function UnderMaintenance() {
    $("#spinner").fadeIn(200);
    $(".spinner").parent().append("<span id='spinnermsg' style='position: fixed; margin: 4em -4em 4em -120px; color: rgb(239, 241, 138);'>Maaf Halaman ini belum siap atau belum tersedia</span>");
}
// spinner
function OpenSpinner() {
    // rewrite attr disabled in btn-simpan
    $("#btn-simpan").attr('disabled', 'disabled');
    $("#spinner").fadeIn('slow');
}
function CloseSpinner() {
    // remove attr disabled pada btn-tambah
    $("#btn-simpan").removeAttr('disabled');
    $("#spinner").fadeOut('slow');
}
function ErrorSpinner() {
    $(".spinner").addClass("error").parent().append("<span id='spinnermsg' style='position: fixed; margin: 4.5em -4.3em; color: rgb(241, 141, 5);'>Gagal memuat halaman.</span>");
    ;
    setTimeout(function () {
        $("#spinnermsg").remove();
        $(".spinner").removeClass("error");
        $("#spinner").fadeOut('slow');
    }, 1000)
}
// loading
function OpenLoading() {
    $("#maju").attr('disabled','disabled');
    $("#mundur").attr('disabled','disabled');
    $("#awal").attr('disabled','disabled');
    $("#akhir").attr('disabled','disabled');
    $("#refreshing-lg").fadeIn('slow');
    $("#refreshing-xs").fadeIn('slow');
}
function CloseLoading() {
    $("#refreshing-lg").fadeOut('slow');
    $("#refreshing-xs").fadeOut('slow');
}
// convert tanggal
function TglDMY(inputFormat) {
    var d = new Date(inputFormat);
    return [d.getDate(), TglBulan(d.getMonth() + 1), d.getFullYear()].join(' ');
}
// auto input tanggal
function TglYMD(inputFormat) {
    var d = new Date;
    return [d.getFullYear(), d.getMonth() + 1, d.getDate()].join('-');
}
// tanggal dengan bulan
function TglBulan(bulan) {
    switch (bulan) {
        case 1:
            return "Januari";
            break;
        case 2:
            return "Februari";
            break;
        case 3:
            return "Maret";
            break;
        case 4:
            return "April";
            break;
        case 5:
            return "Mei";
            break;
        case 6:
            return "Juni";
            break;
        case 7:
            return "Juli";
            break;
        case 8:
            return "Agustus";
            break;
        case 9:
            return "September";
            break;
        case 10:
            return "Oktober";
            break;
        case 11:
            return "November";
            break;
        case 12:
            return "Desember";
            break;
    }
}
function tglIndo(tgl) {
    var date = tgl.split('-');
    return date[2] + ' ' + TglBulan(eval(date[1])) + ' ' + date[0];
}
// error message
function ErrMsg() {
    // remove attr disabled pada btn-tambah
    $("#btn-simpan").removeAttr('disabled');
    ErrorSpinner();
    $("#alert-notify").text("Ada kesalahan, refresh halaman browser anda! Silahkan ulangi lagi aksi terakhir anda!")
        .show()
        .removeClass('alert-success')
        .addClass('alert-danger');
}
// result warning
function resultWarning(data) {
    // remove attr disabled pada btn-tambah
    $("#btn-simpan").removeAttr('disabled');
    ErrorSpinner();
    $("#alert-notify")
        .html("")
        .show()
        .removeClass('alert-success')
        .addClass('alert-danger')
        .append("<ul style='margin-bottom: 0px;'><button data-dismiss='alert' class='close close-sm fa fa-times' type='button'></button>" + data.msg + "</ul>");
    if ("Logout" == data.Action) {
        Auth();
    }
    $("#alert-notify").fadeOut(5000);
}
// result validation error message
function resultValidation(data) {
    // remove attr disabled pada btn-tambah
    $("#btn-simpan").removeAttr('disabled');
    ErrorSpinner();
    $("#alert-notify").html("").show().removeClass('alert-success').addClass('alert-danger');
    var data = json2array(data.validation);
    for (var i = 0; i < data.length; i++) {
        $("#alert-notify")
            .removeClass('alert-success')
            .addClass('alert-danger')
            .append("<ul style='margin-bottom: 0px;'>" + data[i] + "</ul>");
    }
    $("#alert-notify").fadeOut(5000);
}
// result success error message
function resultSuccess(data) {
    // remove attr disabled pada btn-tambah
    $("#btn-simpan").removeAttr('disabled');
    CloseSpinner();
    $("#datalist").html("");
    $("#alert-notify").removeClass('alert-danger')
        .addClass('alert-success')
        .append("<ul style='margin-bottom: 0px;'>" + data.msg + "</ul>")
        .fadeOut(5000);
    TampilData($("#current_page").val());
}
function Auth() {
    setTimeout(function () {
        window.location.assign("logout")
    }, 3000);
}