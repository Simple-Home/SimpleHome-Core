function iOS() {
    return [
        'iPad Simulator',
        'iPhone Simulator',
        'iPod Simulator',
        'iPad',
        'iPhone',
        'iPod'
    ].includes(navigator.platform)
        // iPad on iOS 13 detection
        || (navigator.userAgent.includes("Mac") && "ontouchend" in document);
}

function isMobile() {
    try {
        document.createEvent("TouchEvent");
        return true;
    } catch (e) {
        return false;
    }
}

function ajaxContentLoader(target, sourceUrl, loadingSpinner = true, method = 'POST') {
    console.log("loading from: ", sourceUrl, "loading to: ", target)
    $.ajax({
        start_time: new Date().getTime(),
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: method,
        url: sourceUrl,
        beforeSend: function () {
            if (loadingSpinner) {
                target.html(
                    '<div class="d-flex h-100"><div class="text-center m-auto"><div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div></div></div>'
                );
            }
        },
        success: function (msg) {
            target.html(msg);
            console.log((new Date().getTime() - this.start_time) + ' ms');
        },
        error: function (jqXHR, exception) {
            if (jqXHR.status === 0) {
                msg = 'Not connect.\n Verify Network.';
            } else if (jqXHR.status == 404) {
                msg = 'Requested page not found. [404]';
            } else if (jqXHR.status == 500) {
                msg = 'Internal Server Error [500].';
            } else if (jqXHR.status == 405) {
                msg = 'Method not alowed [405].';
            } else if (exception === 'parsererror') {
                msg = 'Requested JSON parse failed.';
            } else if (exception === 'timeout') {
                msg = 'Time out error.';
            } else if (exception === 'abort') {
                msg = 'Ajax request aborted.';
            } else {
                msg = 'Uncaught Error.\n' + jqXHR.responseText;
            }
            target.html("Unable to load\n" + msg);
            console.log((new Date().getTime() - this.start_time) + ' ms');
        },
        timeout: 3000,
    });
}

function display_c() {
    var refresh = 30000; // Refresh rate in milli seconds
    mytime = setTimeout('display_ct()', refresh)
}

function display_ct() {
    var x = new Date()
    var x1 = x.getMonth() + 1 + "/" + x.getDate() + "/" + x.getFullYear();
    x1 = x1 + " - " + x.getHours() + ":" + x.getMinutes();
    document.getElementById('ct').innerHTML = x1;
    display_c();
}

function display_notifications() {
    $.ajax({
        start_time: new Date().getTime(),
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'GET',
        url: $('#notification-button').data("url"),
        success: function (msg) {
            if (msg > 0) {
                if (!$(".notification-badge").is(":visible")) {
                    $(".notification-badge").addClass("d-inline");
                    $(".notification-badge").addClass("d-md-inline");
                }
                if (msg < 99) {
                    $("#notification-count").html(msg);
                } else {
                    $("#notification-count").html("99+");
                }
                console.log(msg);
            } else {
                if ($(".notification-badge").is(":visible")) {
                    $(".notification-badge").hide();
                    $(".notification-badge").removeClass("d-inline");
                    $(".notification-badge").removeClass("d-md-inline");
                }
            }
            console.log((new Date().getTime() - this.start_time) + ' ms');
        },
        error: function (jqXHR, exception) {
            console.log((new Date().getTime() - this.start_time) + ' ms');
        },
        timeout: 3000,
    });
    display_notifications_deamon();
}

function display_notifications_deamon() {
    var refresh = 30000; // Refresh rate in milli seconds
    notificationsRefresh = setTimeout('display_notifications()', refresh)
}

var timer = null;
function rangeDeamon() {
    var valueInput = $(".range-value");
    setRange(valueInput);
}

function setRange(inpurtTarget) {
    $.ajax({
        type: 'POST',
        url: inpurtTarget.data("url").replace('value', inpurtTarget.val()),
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (msg) { },
        error: function () {
            //timeout
        },
        timeout: 3000,
    });
}

/*
if ($(window).width() < 768) {

} else if ($(window).width() >= 768 && $(window).width() <= 992) {

} else if ($(window).width() > 992 && $(window).width() <= 1200) {

} else {

}
*/