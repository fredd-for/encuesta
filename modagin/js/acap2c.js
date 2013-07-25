$(document).ready( function() {  
    
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
    
    $("#A1, #A2, #A3").blur( function(){
        var a1, a2, a3, tot;
        a1 = formatinteger( $("#A1").val() );
        a2 = formatinteger( $("#A2").val() );
        a3 = formatinteger( $("#A3").val() );        
        
        tot = a1 + a2 + a3;        
        $("#perH").text( number_format(tot,0,'',',') );
        
        if( this.id == 'A3' ) {
            if( a3 > 0 ) {
                $("#otrosdetalle").show();
            } else {
                $("#otrosdetalle").hide();
            }
        }
        
        $("#txtotros").hide();
        $("#msg").hide();
    });
    
    $("#A7").click( function(){
        $("#txtotros").hide();
    } );
    
    $("#sendData").click( function() {
        var a6 = formatinteger( $("#A3").val() );
        if( a6 > 0 ) {
            var txtotros = $("#A7").val();
            if( txtotros == '' ) {
                $("#txtotros").show();
                return false;
            }
        }        
        a6 = formatinteger( $("#perH").text() );
        if( a6 == 0 ) {
            $("#msg").show();
            return false;
        }
    } );
});