console.log("Loading JS Controller for -> Locations Namme Space")
window.addEventListener("load", function () {
    var loadingAnimation = true;
    url = $("div#ajax-loader").data("url");
    ajaxContentLoader($("div#ajax-loader"), url,
        loadingAnimation, "GET");

});