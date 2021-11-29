function refreshCSRF(url, callback = null) {
    return $.ajax({
        url: url,
        method: 'GET',
        success: function (response) {
            if (response.token != null) {
                console.log("[csrf]-refreshing");
                $('meta[name="csrf-token"]').attr('content', response.token);
            }
            if (callback) callback();
        }
    });
}