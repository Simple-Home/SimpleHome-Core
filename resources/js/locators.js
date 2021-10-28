window.addEventListener("load", function () {
    var locatorsList = $("#locators-list");
    ajaxContentLoader(locatorsList, locatorsList.data("url"), false, "GET")
    console.log("Loading Locators");
});
