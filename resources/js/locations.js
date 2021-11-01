console.log("Loading JS Controller for -> Locations Namme Space")
window.addEventListener("load", function () {
    var loadingAnimation = true;
    url = $("div#ajax-loader").data("url");
    ajaxContentLoader($("div#ajax-loader"), url,
        loadingAnimation, "GET");


});

$(document).on('submit', 'form#search', function (event) {
    var loadingAnimation = true;

    therm = $("form#search").find('input[name="search"]').val();
    url = $("form#search").attr("action");
    url = url + "/" + encodeURIComponent(therm);

    ajaxContentLoader($("div#ajax-loader"), url,
        loadingAnimation, "GET");

    event.preventDefault();
});