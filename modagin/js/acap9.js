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
    
    $("#A1, #A2, #A3, #A4, #A5").blur( function(){
        var a1, a2, a3, a4, a5, cm;
        
        a1 = formatinteger( $("#A1").val() );
        a2 = formatinteger( $("#A2").val() );
        a3 = formatinteger( $("#A3").val() );
        a4 = formatinteger( $("#A4").val() );
        a5 = formatinteger( $("#A5").val() );
                
        cm = a1 +a2 + a3 + a4 + a5;
        $("#ingreso").text( number_format(cm,0,'',',') );
        
        if( this.id == "A5" ) {            
            var b5 = formatinteger( $("#B5").val() );            
            if( a5 > 0 || b5 > 0 ) {
                $("#otrosnoeperativos").show();
            } else {
                $("#otrosnoeperativos").hide();
                $("#otrosdescrip").val("");
                
            }            
        }
                
        $("#msg").hide();                        
        $("#msg1").hide();
    } );
    
    $("#B1, #B2, #B3, #B4, #B5").blur( function(){
        var a1, a2, a3, a4, a5, cm;        
        a1 = formatinteger( $("#B1").val() );
        a2 = formatinteger( $("#B2").val() );
        a3 = formatinteger( $("#B3").val() );
        a4 = formatinteger( $("#B4").val() );
        a5 = formatinteger( $("#B5").val() );                
        cm = a1 +a2 + a3 + a4 + a5;
        $("#egreso").text( number_format(cm,0,'',',') );
        
        if( this.id == "B5" ) {
            var b5 = formatinteger( $("#A5").val() );            
            if( a5 > 0 || b5 > 0 ) {
                $("#otrosnoeperativos").show();
            } else {
                $("#otrosnoeperativos").hide();
                $("#otrosdescrip").val("");                
            }
        }        
        $("#msg").hide();
        $("#msg1").hide();
    } );
    
    
    
    
    $("#sendData").click( function() {
        var a5, b5, desc;
        
        a5 = formatinteger( $("#A5").val() );
        b5 = formatinteger( $("#B5").val() );
                
        if( a5 > 0 || b5 > 0 ) {
            desc = $("#otrosdescrip").val();
            if( desc == '' ) {
                $("#msg1").show();
                return false;
            }
        }
        
        a5 = formatinteger( $("#ingreso").text() );
        b5 = formatinteger( $("#egreso").text() );
        if( a5 == 0 && b5 == 0 ) {
            $("#msg").show();
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
            url: "acap9Upd.php",
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