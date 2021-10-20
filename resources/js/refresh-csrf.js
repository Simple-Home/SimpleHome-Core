function refreshCSRF(url) {
    $.ajax({
        url: url,
        method: 'get',
    }).then(function (response) {
        if (response.token != null) {
            console.log("Refreshing CSRF Token!");
            $('meta[name="csrf-token"]').attr('content', response.token);
        }
    });
}