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

function hashCode(str) {
    if (str == undefined) {
        return false;
    }

    var hash = 0;
    if (str.length == 0) return hash;
    for (i = 0; i < str.length; i++) {
        char = str.charCodeAt(i);
        hash = ((hash << 5) - hash) + char;
        hash = hash & hash; // Convert to 32bit integer
    }
    return hash;
}

function ajaxContentLoader(target, sourceUrl, loadingSpinner = true, method = 'POST', replace = false) {
    if (localStorage.getItem(hashCode(sourceUrl))) {
        const SECONDS = 1000 * 5;
        const anSecondsAgo = Date.now() - SECONDS;
        if (localStorage.getItem(hashCode(sourceUrl)) < anSecondsAgo) {
            console.log("[ajaxLoader]-sameOldRequestDeleted")
            localStorage.removeItem(hashCode(sourceUrl));
        } else {
            console.log("[ajaxLoader]-sameRequestAlreadyInProgress")
            return;
        }
    }
    console.log("[ajaxLoader]-loading from:", sourceUrl, "loading to:", target)
    localStorage.setItem(hashCode(sourceUrl), Date.now());

    var initialHtmlContent = target.html();

    return $.ajax({
        start_time: new Date().getTime(),
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: method,
        url: sourceUrl,
        beforeSend: function () {
            if (loadingSpinner !== false) {
                switch (loadingSpinner) {
                    case "small":
                        target.html(
                            '<div class="d-flex h-100"><div class="text-center m-auto"><div class="spinner-border-sm text-primary" role="status"><span class="sr-only">Loading...</span></div></div></div>'
                        );
                        break;

                    default:
                        target.html(
                            '<div class="d-flex h-100"><div class="text-center m-auto"><div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div></div></div>'
                        );
                        break;
                }
            }
        },
        success: function (msg) {
            newBody = msg;
            if (msg == "true" || msg == "false") {
                newBody = initialHtmlContent;
            }
            if (replace) {
                target.replaceWith(newBody);
            } else {
                target.html(newBody);
            }
            console.log('[ajaxLoader]-loadTime:', new Date().getTime() - this.start_time, 'ms');
        },
        error: function (jqXHR, exception) {
            if (jqXHR.status === 0) {
                console.log('[ajaxLoader]-exception:', exception);
                msg = 'Not connect.\n Verify Network.';
            } else if (jqXHR.status == 404) {
                msg = 'Requested page not found. [404]';
            }
            else if (jqXHR.status == 419) {
                refreshCSRF("https:" + "process.env.MIX_AP_BASE_URL" + "system/refresh-csrf", function () {
                    ajaxContentLoader(target, sourceUrl, loadingSpinner, method);
                });
                msg = 'SCFR Token Mismatch';
            }
            else if (jqXHR.status == 500) {
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
            console.log('[ajaxLoader]-exception:', jqXHR);
            console.log('[ajaxLoader]-loadTime:', new Date().getTime() - this.start_time, 'ms');
        },
        complete: function () {
            localStorage.removeItem(hashCode(sourceUrl));
        },
        timeout: 3000,
    });
}

function display_c() {
    var refresh = 30000; // Refresh rate in milliseconds seconds
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
    //Add Check if user is not wisible
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
            console.log('[notificationChecker]-loadTime:', new Date().getTime() - this.start_time, 'ms');
        },
        error: function (jqXHR, exception) {
            console.log('[notificationChecker]-loadTime:', new Date().getTime() - this.start_time, 'ms');
            console.log('[notificationChecker]-exception:', exception)
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

function deleteRow(btn) {
    var row = btn.parentNode.parentNode;
    row.parentNode.removeChild(row);
}

/*
if ($(window).width() < 768) {

} else if ($(window).width() >= 768 && $(window).width() <= 992) {

} else if ($(window).width() > 992 && $(window).width() <= 1200) {

} else {

}
*/