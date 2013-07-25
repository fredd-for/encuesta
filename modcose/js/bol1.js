$(document).ready( function(){
    
    $("#sendData").click( function (){
        /*
        if( confirm(" ¿Esta seguro de finalizar el llenado de formularios? " ) ) {
            return true;
        } else {
            return false;
        }
        */
       
        var chkIsChecked = document.getElementById("chkconforme").checked;
        
        if( chkIsChecked ){
            return true;
        } else {
            return false;
        }
                
    });
} );

