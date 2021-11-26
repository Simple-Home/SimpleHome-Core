const app = null;

var startPermission = Notification.permission;
Notification.requestPermission(function (status) {
    console.log("[notifications]-status:", status);
    if (status === "granted" && startPermission !== "granted") {
        window.location.reload();
    }
});

if (Notification.permission === "granted") {

}

