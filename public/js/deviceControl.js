
function deviceControl(hostname, property, feature, newValue){

    $.ajax({
        method: "GET",
        url: "/properties/control/" + property,
        data: {
           "feature": feature,
           "value": newValue
        },
        success: function(data){
           window.location.reload();
           console.log(data);
        },
        error: function(data){
           console.log(data);
        }
    });

}
