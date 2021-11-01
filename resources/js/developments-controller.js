console.log("Loading JS Controller for -> Developments Namme Space")
window.addEventListener("load", function () {
    var loadingAnimation = false;
    url = $("div#ajax-loader").data("url");
    ajaxContentLoader($("div#ajax-loader"), url,
        loadingAnimation, "GET");
});