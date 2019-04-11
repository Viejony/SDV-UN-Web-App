/**
 * checkIPDirection: This function verifies that the IP Diorection is stored 
 * locally and then modifies the DOM to add a link to map_view.html.
 * 
 * @returns: sdv_IP_dir string
 **/
function checkIPDirection(){
    var sdv_IP_dir = localStorage.getItem("sdv_IP_dir");

    // IP Direction is defined and is not an empty string
    if(sdv_IP_dir != null && sdv_IP_dir != ""){
        // map_view_navbar_link is not in the html document
        if($("#map_view_navbar_link").attr("id") == undefined){
            $("#login_navbar_link").after('<a id="map_view_navbar_link" class="w3-bar-item w3-button w3-theme-white" href="map_view.html">Mapa</a>');
        }
        else{ // map_view_navbar_link is in the html document, but is hide
            $("#map_view_navbar_link").show();
        }
    }
    else{ // IP Direction is not defined and/or is an empty string
        //alert("Dirección IP no definida o incorrecta");

        // Hidding map_view_navbar_link
        if($("#map_view_navbar_link").attr("id") != undefined){
            $("#map_view_navbar_link").hide();
        }
        
    }
    return sdv_IP_dir;
}