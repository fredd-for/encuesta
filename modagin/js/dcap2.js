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

$("#A_1, #A_2, #A_3, #A_4").blur( function(){
    var a1, a2, a3, a4, tot;
    a1 = formatinteger( $("#A_1").val() );
    a2 = formatinteger( $("#A_2").val() );
    a3 = formatinteger( $("#A_3").val() );
    a4 = formatinteger( $("#A_4").val() );
    
    tot = a1 + a2 + a3 + a4;
    $("#total").text(number_format(tot,0,'',',')); 
} );

$("#pa_empresa, #pa_empresa, #pa_empresa, #pa_empresa").blur( function(){
    
} );

$("#sendData").click( function (){
    var a1, a2, a3, a4;
    a1 = formatinteger( $("#pa_empresa").val() );
    a2 = formatinteger( $("#pa_universidad").val() );
    a3 = formatinteger( $("#pa_nacional").val() );
    a4 = formatinteger( $("#pa_importado").val() );  
    
    if( a1 > 100 ) { $("#msg2").show(); return false; }
    if( a2 > 100 ) { $("#msg2").show(); return false; }
    if( a3 > 100 ) { $("#msg2").show(); return false; }
    if( a4 > 100 ) { $("#msg2").show(); return false; }
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
            url: "dcap2Upd.php",
            cache: false,
            data: $(".formA").serialize()+'&tabla='+inp,
            success: function (data) {
                $("#statusACAP1").html('<div class="bxS"><img alt="Guardado" src="../lib/ico_chk.gif">guardado</div>');   
            }
        });
                
        $("#statusACAP1").hide(1600);
    }
}