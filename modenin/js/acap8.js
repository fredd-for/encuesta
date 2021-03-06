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
    
    $("#A1, #A2, #A3, #A4").blur( function(){
        var a1, a2, a3, a4, cm, pc;
        
        a1 = formatinteger( $("#A1").val() );
        a2 = formatinteger( $("#A2").val() );
        a3 = formatinteger( $("#A3").val() );
        a4 = formatinteger( $("#A4").val() );
        
        
        cm = a1 +a2 + a3 + a4;
        $("#costo1").text( number_format(cm,0,'',',') );
                
        if( this.id == 'A4'  ) {            
            if( a4 > 0 ) {
                $("#otrosingresos").show();
            } else {
                $("#otrosingresos").hide();
                $("#A5").val("");
            }
        }     
        
        $("#msg").hide();
    } );
    
    $("#A5").click( function(){
        $("#msg").hide();
    });
    
    $("#sendData").click( function() {
        var a4, desc;
        
        a4 = formatinteger( $("#A4").val() );
        if( a4 > 0 ){
            desc = $("#A5").val();
            if( desc == '' ) {
                $("#msg").show();
                return false;
            }
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
            url: "acap8Upd.php",
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