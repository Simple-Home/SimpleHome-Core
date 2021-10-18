window.addEventListener("load", function () {
    $('body').on('click', 'a#notification-control-load', function (event) {
        var notificationList = $("#notifications-list");
        ajaxContentLoader(notificationList, $(this).data("url"), true, "POST")
        console.log("Loading Notifications Action");
        display_notifications();
        event.preventDefault();
    });

    $("#notifications").on('shown.bs.modal', function () {
        var notificationList = $("#notifications-list");
        ajaxContentLoader(notificationList, notificationList.data("url"), true, "GET")
        console.log("Loading Notifications");
    });

    display_notifications();
});
