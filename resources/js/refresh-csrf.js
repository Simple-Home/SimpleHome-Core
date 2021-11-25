function refreshCSRF(url) {
    $.ajax({
        url: url,
        method: 'get',
    }).then(function (response) {
        if (response.token != null) {
            console.log("[csrf]-refreshing");
            $('meta[name="csrf-token"]').attr('content', response.token);
        }
    });
}