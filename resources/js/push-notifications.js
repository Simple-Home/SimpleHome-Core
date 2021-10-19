var startPermission = Notification.permission;
Notification.requestPermission(function (status) {
    console.log("NotificationsStatus: ", status);
    if (status === "granted" && startPermission !== "granted") {
        window.location.reload();
    }
});