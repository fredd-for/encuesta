$(document).ready( function(){     

});

function removeItem( uid ) {
    confirmar = confirm("¿Estas seguro de eliminar este registro?"); 
    if (confirmar) {

        $.ajax({
            type: "POST",
            url: "userDel.php",
            data: "uid="+uid,
            beforeSend: function(){
              $("#process_"+uid).append('<img src="lib/load.gif" border="0">');
            },
            success: function( resp ){
                if( resp != '' ) {
                    $("#item_"+uid).fadeOut();
                }                    
                $("#process_"+uid).hide();
            }
        });


    }
}


function changeState(uid, state){     
   

        $.ajax({
            type: "POST",
            url: "userState.php",
            data: "uid="+uid+"&state="+state,
            beforeSend: function(){
              $("#process_"+uid).append('<img src="../../lib/load.gif" border="0">');
            },
            success: function( resp ){
                if( resp != '' ) {
                    $("#state_"+uid).html(resp);
                }                    
                $("#process_"+uid).hide();
            }
        });


    
}