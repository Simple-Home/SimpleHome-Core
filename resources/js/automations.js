console.log("Loading JS Controller for -> Automation Namme Space")
window.addEventListener("load", function () {
    var loadingAnimation = true;
    if ($("div.carousel-item").length) {

        //Initial Load
        var automationType = localStorage.getItem("automationType");
        if (automationType) {
            url = $("div.carousel-item[data-automation-type='" + automationType + "']").data("url");
        } else {
            //First Load Ever no room selected in Memory
            url = $("div.carousel-item").first().data("url");
            automationType = url.split('/').reverse()[1];
            console.log("automationType", automationType);
            localStorage.setItem('automationType', automationType);
        }

        $(".subnavigation").removeClass("active");
        $("div.nav-link[data-automation-type='" + automationType + "']")
            .addClass("active");
        $("div.carousel-item[data-automation-type='" + automationType + "']")
            .addClass("active");

        ajaxContentLoader($("div.carousel-item[data-automation-type='" + automationType + "']"), url,
            loadingAnimation);

        $('#carouselExampleSlidesOnly').on('slid.bs.carousel', function (e) {
            loadingAnimation = false;
            //Load Thinks
            targetObj = $(e.relatedTarget);
            url = targetObj.data("url");

            //Menu Handling
            $(".subnavigation").removeClass("active");
            thisObj = $("div.nav-link[data-automation-type='" + url.split('/').reverse()[1] + "']");
            thisObj.addClass("active");

            //Load load content from URL
            ajaxContentLoader(targetObj, url, loadingAnimation);

            localStorage.lastAutomationType = url.split('/').reverse()[1];
            console.log("savingAutomationType", localStorage.lastAutomationType);
            loadingAnimation = true;
        });
    }

    $('div.subnavigation ').click(function (event) {
        loadingAnimation = false;

        //Load Thinks
        targetObj = $(this);
        url = targetObj.data("url");
        automationType = url.split('/').reverse()[1];
        localStorage.setItem('lastAutomationType', url.split('/').reverse()[1]);
        console.log("savingAutoamtionType", localStorage.lastAutomationType);

        //Menu Handling
        $(".subnavigation").removeClass("active");
        $("div.carousel-item").removeClass("active");
        $("div.nav-link[data-automation-type='" + automationType + "']").addClass("active");
        $("div.carousel-item[data-automation-type='" + automationType + "']").addClass("active");

        //Load load content from URL
        ajaxContentLoader($("div.carousel-item[data-automation-type='" + automationType + "']"), url,
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