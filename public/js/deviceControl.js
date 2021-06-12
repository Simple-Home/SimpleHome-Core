/** BEGIN: Config **/
function getCsrf(){
    return $('meta[name="csrfToken"]').attr('content');
}
/* END: Config **/

function deviceControl(hostname, property, deviceFunction, newValue){

    $.ajax({
        method: "GET",
        url: "/api/v2/device/" + hostname + "/" + property + "/" + deviceFunction + "/" + newValue,
        data: {
           "_token": getCsrf(),
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
