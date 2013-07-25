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
    
    $("#A1, #A2, #A3, #A4, #A5, #A6").blur( function(){
        var a1, a2, a3, a4, a5, a6, tot;
        a1 = formatinteger( $("#A1").val() );
        a2 = formatinteger( $("#A2").val() );
        a3 = formatinteger( $("#A3").val() );
        a4 = formatinteger( $("#A4").val() );
        a5 = formatinteger( $("#A5").val() );
        a6 = formatinteger( $("#A6").val() );
        
        tot = a1 + a2 + a3 + a4 + a5 + a6;        
        $("#perH").text( number_format(tot,0,'',',') )
                
        if( this.id == 'A6' ) {
            if( a6 > 0 ) {
                $("#otrosdetalle").show();
            } else {
                $("#otrosdetalle").hide();
            }
        }
        
        $("#txtotros").hide();
        $("#msg2").hide();
        $("#msg").hide();
    });
    
    $("#A7").click( function(){
        $("#txtotros").hide();
    } );
    
    $("#sendData").click( function() {
        var a6 = formatinteger( $("#A6").val() );
        if( a6 > 0 ) {
            var txtotros = $("#A7").val();
            if( txtotros == '' ) {
                $("#txtotros").show();
                return false;
            }
        }
        
        var a1 = formatinteger( $("#perH").text() );
        if( a1 == 0 ) {
            $("#msg2").show();
            return false;            
        }
        
        a1 = formatinteger( $("#A1").val() );
        if( a1 == 0 ) {
            $("#msg").show();
            return false;            
        }                        
        
    } );
    
});


function saveUPD(inp){
    
    var datos = "", sw=0;    
    switch( inp ) {
        case 1:
        case 2: sw = 1; break;
    }
    
    if( sw == 1 ) {
        $.ajax({
            type:"POST",
            url: "acap2bUpd.php",
            cache: false,
            data: $(".formA").serialize(), 
            success: function (data) {
                $("#statusACAP1").html('<div class="bxS"><img alt="Guardado" src="../lib/ico_chk.gif">guardado</div>');   
            },
            complete: function (data) {
                  $("#statusACAP1").fadeOut(1600, "linear");
            }
        });
    }
        
}