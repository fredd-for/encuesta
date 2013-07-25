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
    
    
    
    $("#A1, #A2, #A3").blur( function() {
        var a1, a2, a3, tot;
        a1 = formatinteger( $("#A1").val() );
        a2 = formatinteger( $("#A2").val() );
        a3 = formatinteger( $("#A3").val() );
        
        
        tot = a1 + a2 + a3;                
        $("#costo1").text( number_format(tot,0,'',',') );
        
        $("#msg").hide();
        $("#msg2").hide();
        
    } );
    
    $("#A4").click( function () {
        $("#msg").hide();
        $("#msg2").hide();
    } );
    
    $("#sendData").click( function() {
        var a1, a2;
        a1 = formatinteger( $("#costo1").text() );
        a2 = formatinteger( $("#A4").val() );
        if( a1 == 0  ){
            $("#msg").show();        
            return false;
        }
        
        if( a2 == 0 ) {            
            $("#msg2").show();
            return false;
        }
    });
        
});

function saveUPD(inp){
    
    var sw=0;    
    switch( inp ) {
        case 1: sw = 1; break;
    }
    
    if( sw == 1 ) {
        $.ajax({
            type:"POST",
            url: "acap12Upd.php",
            cache: false,
            data: $(".formA").serialize(), 
            success: function (data) {
                $("#statusACAP1").html('<div class="bxS"><img alt="Guardado" src="../lib/ico_chk.gif">guardado</div>');   
            },
            complete: function (data) {
                  $("#statusACAP1").fadeOut(1600);
            }
        });
    }       
}