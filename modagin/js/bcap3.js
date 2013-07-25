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
    // inversiones                     
    $("#chk_1").click( function (){
        
        var chkIsChecked = document.getElementById("chk_1").checked;
        if( chkIsChecked ) {
            document.getElementById("chk_2").checked = false;
            document.getElementById("chk_3").checked = false;            
        }       
        $("#msg1, #msg2").hide();
    } );
    
    $("#chk_2").click( function (){
        
        var chkIsChecked = document.getElementById("chk_2").checked;
        if( chkIsChecked ) {
            document.getElementById("chk_1").checked = false;
            document.getElementById("chk_3").checked = false;            
        }
        $("#msg1, #msg2").hide();
    } );    
    
    $("#chk_3").click( function (){
        
        var chkIsChecked = document.getElementById("chk_3").checked;
        if( chkIsChecked ) {
            document.getElementById("chk_1").checked = false;
            document.getElementById("chk_2").checked = false;            
        }
        $("#msg1, #msg2").hide();
    } );
    
    $("#rbtn_inversion1").click( function(){
        var chkIsChecked = document.getElementById("rbtn_inversion1").checked;
        if( chkIsChecked ) {
            $("#areanumpersonas").show();
        }
        $("#msg1, #msg2").hide();
    } );
    
    $("#rbtn_inversion2").click( function(){
        var chkIsChecked = document.getElementById("rbtn_inversion2").checked;
        if( chkIsChecked ) {
            $("#areanumpersonas").hide();
        }
        $("#msg1, #msg2").hide();
    } );
    
    $("#numpersonas").click( function(){
        $("#msg1, #msg2").hide();
    } );
    
    
    $("#sendData").click( function (){
        var chk1 = document.getElementById("chk_1").checked;
        var chk2 = document.getElementById("chk_2").checked;
        var chk3 = document.getElementById("chk_3").checked;        
        if( chk1 == false && chk2 == false && chk3 == false ) {
            $("#msg1").show();
            $('body').scrollTo('#chk_1', 500);
            return false;
        }
        
        chk1 = document.getElementById("rbtn_inversion1").checked;
        var num = formatinteger( $("#numpersonas").val() );
        
        if( chk1 == true && num == 0 ) {
            $("#msg2").show();
            $('body').scrollTo('#rbtn_inversion1', 500);
            return false;            
        }
        
    });
    
});