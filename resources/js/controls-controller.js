function ajax_chart(chart, dataRoute) {
    var data = data || {};
    $.ajax({
        dataType: "json",
        start_time: new Date().getTime(),
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        type: 'GET',
        url: dataRoute,
        success: function(json) {
            chart.data = json;
            chart.update();
            console.log((new Date().getTime() - this.start_time) + ' ms');
        },
        error: function() {
            console.log((new Date().getTime() - this.start_time) + ' ms');
        },
        timeout: 3000,
    });
}

window.addEventListener("load", function() {
    console.log("Loading JS Controller for -> Controls Name Space")


});