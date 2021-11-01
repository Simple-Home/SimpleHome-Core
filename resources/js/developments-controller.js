console.log("Loading JS Controller for -> Developments Namme Space")
window.addEventListener("load", function () {
    var loadingAnimation = false;
    url = $("div#ajax-loader").data("url");
    ajaxContentLoader($("div#ajax-loader"), url,
        loadingAnimation, "GET");
});

$('body').on('click', 'button.token-edit', function (e) {
    map = null;
    url = $(this).data("url");
    console.log(url);

    form = $('#tokenCreation');
    formContent = form.find('.modal-body');
    formContent.html("<div class=\"spinner-border text-primary\" role=\"status\"></div>");

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'GET',
        url: url,
        success: function (msg) {
            formContent.replaceWith(msg);
            form.modal('show');
        }
    });
});