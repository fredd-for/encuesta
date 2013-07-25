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
    
    $("#A1, #A2").blur( function(){
        var a1, a2, tot;
        a1 = formatinteger( $("#A1").val() );
        a2 = formatinteger( $("#A2").val() );        
        
        tot = a1 + a2;        
        $("#perH").text( number_format(tot,0,'',',') );                
    });
    
        
    $("#sendData").click( function() {       
    } );
    
});