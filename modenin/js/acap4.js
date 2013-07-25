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
    
    $("#A1, #A2, #A3, #A4, #A5, #A6, #A7, #A8, #A9, #A10, #A11, #A12, #A13, #A14, #A15, #A16, #A17, #A18").blur( function(){
        var a1, a2, a3, a4, a5, a6, a7, a8, a9, a10, a11, a12,  a13, a14, a15,  a16, a17, a18, tot;
        a1 = formatinteger( $("#A1").val() );
        a2 = formatinteger( $("#A2").val() );
        a3 = formatinteger( $("#A3").val() );
        a4 = formatinteger( $("#A4").val() );
        a5 = formatinteger( $("#A5").val() );
        a6 = formatinteger( $("#A6").val() );
        a7 = formatinteger( $("#A7").val() );
        a8 = formatinteger( $("#A8").val() );
        a9 = formatinteger( $("#A9").val() );
        a10 = formatinteger( $("#A10").val() );
        a11 = formatinteger( $("#A11").val() );
        a12 = formatinteger( $("#A12").val() );
        a13 = formatinteger( $("#A13").val() );
        a14 = formatinteger( $("#A14").val() );
        a15 = formatinteger( $("#A15").val() );
        a16 = formatinteger( $("#A16").val() );
        a17 = formatinteger( $("#A17").val() );
        a18 = formatinteger( $("#A18").val() );
        
        tot = a1 + a2 + a3 + a4 + a5 + a6 + a7 + a8 + a9 + a10 + a11 + a12 + a13 + a14 + a15 + a16 + a17 + a18;        
        $("#perH").text( number_format(tot,0,'',',') );           
        
        if( this.id == "A18" ) {
            $("#msg1").hide();
            //console.log( this.value );            
            //$("#idotros").css('display','table-row'); 
            var otrosval = formatinteger( this.value );
            if( otrosval > 0 ) {
                $("#idotros").show();
            } else {
                $("#idotros").hide();
                $("#otrosdescrip").val("");
            }            
        }        
        $("#msg2").hide();
    });
    
    $("#otrosdescrip").click( function(){
        $("#msg1").hide();
        $("#msg2").hide();
    } );
    
    $("#sendData").click( function() {
        var otrosval = formatinteger( $("#A18").val() );
        if( otrosval > 0 ) {            
            var desc = $("#otrosdescrip").val();            
            if( desc == '' ) {
                $("#msg1").show();
                return false;
            }            
        }
        
        var tot = formatinteger( $("#perH").text() );
        if( tot == 0 ) {                       
            $("#msg2").show();
            return false;                        
        }
    } );
    
});

function saveUPD(inp){
    
    var datos = "", sw=0;    
    switch( inp ) {
        case 1:
        case 2:        
        case 3: sw = 1; break;
    }
    
    if( sw == 1 ) {
        $.ajax({
            type:"POST",
            url: "acap4Upd.php",
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