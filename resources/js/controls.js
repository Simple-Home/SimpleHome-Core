console.log("Loading JS Controller for -> Control Namme Space")
window.addEventListener("load", function () {
    var loadingAnimation = true;
    if ($("div.carousel-item").length) {

        //Initial Load
        var lastRoom = localStorage.getItem("lastRoomId");
        if (lastRoom) {
            url = $("div.carousel-item[data-room-id='" + lastRoom + "']").data("url");
        } else {
            //First Load Ever no room selected in Memory
            url = $("div.carousel-item").first().data("url");
            lastRoom = url.split('/').reverse()[1];
            console.log("savingRoomId", lastRoom);
            localStorage.setItem('lastRoomId', lastRoom);
        }

        $(".subnavigation").removeClass("active");
        $("div.nav-link[data-room-id='" + lastRoom + "']")
            .addClass("active");
        $("div.carousel-item[data-room-id='" + lastRoom + "']").addClass(
            "active");
        ajaxContentLoader($("div.carousel-item[data-room-id='" + lastRoom + "']"), url,
            loadingAnimation);

        $('#carouselExampleSlidesOnly').on('slid.bs.carousel', function (e) {
            loadingAnimation = false;
            //Load Thinks
            targetObj = $(e.relatedTarget);
            url = targetObj.data("url");

            //Menu Handling
            $(".subnavigation").removeClass("active");
            thisObj = $("div.nav-link[data-room-id='" + url.split('/').reverse()[1] + "']");
            thisObj.addClass("active");

            //Load load content from URL
            ajaxContentLoader(targetObj, url, loadingAnimation);

            localStorage.lastRoomId = url.split('/').reverse()[1];
            console.log("savingRoomId", localStorage.lastRoomId);
            loadingAnimation = true;
        });
    }

    $('div.subnavigation ').click(function (event) {
        loadingAnimation = false;

        //Load Thinks
        targetObj = $(this);
        url = targetObj.data("url");
        roomId = url.split('/').reverse()[1];
        localStorage.setItem('lastRoomId', url.split('/').reverse()[1]);
        console.log("savingRoomId", localStorage.lastRoomId);

        //Menu Handling
        $(".subnavigation").removeClass("active");
        $("div.carousel-item").removeClass("active");
        $("div.nav-link[data-room-id='" + roomId + "']").addClass("active");
        $("div.carousel-item[data-room-id='" + roomId + "']").addClass("active");

        //Load load content from URL
        ajaxContentLoader($("div.carousel-item[data-room-id='" + roomId + "']"), url,
            loadingAnimation);
    });

    //Desktop Arow Control
    $(document).bind('keyup', function (e) {
        if (e.which == 39) {
            loadingAnimation = false;
            $('#carouselExampleSlidesOnly').carousel('next');
        } else if (e.which == 37) {
            loadingAnimation = false;
            $('#carouselExampleSlidesOnly').carousel('prev');
        }
    });
});

$('body').on('click', 'i.control-range', function (event) {
    navigator.vibrate([10]);
    var valueInput = $(".range-value");
    if ($(this).data('control-type') == "+") {
        var num = +valueInput.val() + 1;
    } else if ($(this).data('control-type') == "-") {
        var num = +valueInput.val() - 1;
    }

    if (num >= valueInput.attr('min') && num <= valueInput.attr('max')) {
        console.log(valueInput.attr('min'), valueInput.attr('max'))
        valueInput.val(num);
        clearTimeout(timer);
        timer = window.setTimeout(rangeDeamon, 2000);
    } else {
        console.log("Out Of Range");
    }
});

$('body').on('click', 'div.control-relay', function (event) {
    navigator.vibrate([10]);
    thisObj = $(this);
    thisObj.html("<div class=\"spinner-border text-primary\" role=\"status\"></div>");
    console.log(thisObj.data("url"));
    $.ajax({
        type: 'POST',
        url: thisObj.data("url"),
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (msg) {
            thisObj.html(msg.icon);
            thisObj.data("url", msg.url)
        },
        error: function () {
            //timeout
        },
        timeout: 3000,
    });
});


var lastLoad = new Date().getTime();
$("div#ajax-loader").click(function (event) {
    thisObj = $(this);

    localStorage.setItem('lastRoomId', thisObj.data("room-id"));


    if (thisObj.hasClass("active") && (new Date().getTime() - lastLoad) < 9000) {
        console.log((new Date().getTime() - lastLoad) + ' ms');
        return;
    }
    $("#" + thisObj.data("target-id")).html(
        '<div class="d-flex h-100"><div class="text-center m-auto"><div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div></div></div>'
    );
    console.log("Loading dynamic oontent");

    console.log(thisObj.data("url"));

    $(".subnavigation").removeClass("active");
    thisObj.addClass("active");

    $.ajax({
        start_time: new Date().getTime(),
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        url: thisObj.data("url"),
        success: function (msg) {
            $("#" + thisObj.data("target-id")).html(msg);
            console.log((new Date().getTime() - this.start_time) + ' ms');
        },
        error: function () {
            console.log((new Date().getTime() - this.start_time) + ' ms');
        },
        timeout: 3000,
    });
});