$(document).ready( function() {    
                
    // numero 1,225 = 1225
    function formatinteger( numero ) {
        numero = numero.replace(/,/g, "");
        numero = parseInt( numero );
        return verifyNaN(numero);        
    }
    
    function verifyNaN(numero) {
       if (isNaN(numero)) 
         return 0;
       else
         return numero;
    }        
    
    $("#rbtn_inversion2").click( function(){             
        $("#noopcion").show();
    } );
    
    $("#rbtn_inversion1").click( function(){             
        $("#noopcion").hide();
    } );
    
    $("#chk_1, #chk_2").click( function(){ 
        $("#msg1").hide();
    });
    
    $("#chk_3").click( function(){    
        
        if( (this).checked ) {
            $("#inversionotros").show();
        } else {
            $("#inversionotros").hide();
        }
        $("#msg1").hide();
    } );
    
    $("#inversionotros").click( function() {
        $("#msg1").hide();
    } );
    
    
    $("#certiambiental").click( function() {
        $("#msg2").hide();
    } );
    
    $("#otrasambiental").click( function() {
        $("#msg3").hide();
    } );
            
    
    $("#rbtn_certi1").click( function (){
        $("#sicertificacion").show();
        $("#msg2").hide();
        
    } );
    
    $("#rbtn_certi2").click( function (){
        $("#sicertificacion").hide();        
        $("#msg2").hide();
    } );
    
    
    $("#rbtn_aga1").click( function (){
        $("#siotrasambiental").show();
        $("#msg3").hide();
    } );
    
    $("#rbtn_aga2").click( function (){
        $("#siotrasambiental").hide();        
        $("#msg3").hide();
    } );
    
    $("#sendData").click( function (){
        var chkIsChecked = document.getElementById("chk_3").checked;                
                
        if( chkIsChecked ) {
            var otro1 = $("#inversionotros").val();
            if( otro1 == '' ){
                $("#msg1").show();
                $('body').scrollTo("#inversionotros", 500);
                return false;
            } else {
                $("#msg1").hide();
            }
        }
        
        var rbtn_certi1 = document.getElementById("rbtn_certi1").checked;
        if( rbtn_certi1 ) {
            var otro2 = $("#certiambiental").val();
            if( otro2 == '' ){
                $("#msg2").show();
                $('body').scrollTo("#certiambiental", 500);
                return false;
            } else {
                $("#msg2").hide();
            }
        }        
                
        var aga1 = document.getElementById("rbtn_aga1").checked;
        if( aga1 ) {
            var otro3 = $("#otrasambiental").val();
            if( otro3 == '' ){
                $("#msg3").show();
                $('body').scrollTo("#otrasambiental", 500);
                return false;
            } else {
                $("#msg3").hide();
                return true;
            }
        }
                                                
    });
    
    
    
});