function removeItem( uid ) {
    confirmar = confirm("¿Estas seguro de eliminar este registro?"); 
    if (confirmar) {

        $.ajax({
            type: "POST",
            url: "patientDel.php",
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
            url: "patientState.php",
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



$(document).ready( function () {
    
   $("#pa_vacuna").click(function(){
       var ch = $(this).is(':checked');
       if( ch ) {
           $("#pa_vacuna_otra").show(); 
       } else {
           $("#pa_vacuna_otra").hide(); 
       }
   });
   
   $("#pa_antemedico").click(function(){
       var ch = $(this).is(':checked');
       if( ch ) {
           $("#pa_antemedico_otro").show(); 
       } else {
           $("#pa_antemedico_otro").hide(); 
       }
   });
   
   $("#pa_antequirurgico").click(function(){
       var ch = $(this).is(':checked');
       if( ch ) {
           $("#pa_antequirurgico_otro").show(); 
       } else {
           $("#pa_antequirurgico_otro").hide(); 
       }
   });
   
   $("#username").focusout( function() {
     
       var nu = $(this).val();
       var pt = $("input[name='tmppatient']").val();
       $.ajax({
            type: "POST",
            url: "../user/userVerify.php",
            data: "nu="+nu+"&pt="+pt,
            success: function( resp ){
                
                switch( resp ) {
                    case "1": $("#msgusername").html("El nombre de usuario ya existe seleccione otro."); $("#sendData").hide(); break;
                    case "2": $("#msgusername").html("Escriba un nombre de usuario válido."); $("#sendData").hide(); break;
                    default: $("#msgusername").html(""); $("#sendData").show(); break;
                }
                //alert(resp);
            }
        });
       
       
   } );
   
   $("label[id^='chk-']").click( function() {            
       var sCodeId = $(this).attr("id");
       var aCodeID = sCodeId.split("-");
       labelItem = aCodeID[1];
              
        if( typeof aCodeID[2] != 'undefined' ) {
            var $Chk = $('input[name=pa_'+labelItem+'_'+aCodeID[2]+']');
            
            if( $Chk.is(':checked') ) {
                $Chk.attr('checked', false);             
            } else {
                $Chk.attr('checked', true);             
            }
        } else {
            $Chk = $('input[name=pa_'+labelItem+']');
            if( $Chk.is(':checked') ) {
                $Chk.attr('checked', false);
                $('input[name=pa_'+labelItem+'_otra]').hide();
                $('input[name=pa_'+labelItem+'_otro]').hide();
            } else {
                $Chk.attr('checked', true);
                $('input[name=pa_'+labelItem+'_otra]').show();
                $('input[name=pa_'+labelItem+'_otro]').show();
            }
        }                                             
   } );
   
   
});


function showPopUp(myurl){ 
    window.open(myurl,'Office','width=500,height=400,menubar=NO,scrollbars=0,toolbar=NO,location=NO,directories=NO,resizable=1,top=0,left=0');
    return false;
}

function showCard ( item ) {
    var myurl = $('#trigCard_'+item).attr('href');
    //alert( $('#planCuentas').attr('href') );
    showPopUp(myurl);
}