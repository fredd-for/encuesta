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
    
    $("#input-11, #input-12, #input-13 ").blur( function(){
        var v1, v2, v3, tot;
        v1 = formatinteger( $("#input-11").val() );
        v2 = formatinteger( $("#input-12").val() );
        v3 = formatinteger( $("#input-13").val() );
        
        tot = v1 + v2 + v3;                
        $("#capitaltotal").text( number_format(tot,0,'',',') );  
        
        if( tot > 0 ) {
            $("#msg").hide();
        }
    } );
    
    $("#input-15").click( function() {
        $("#msg2").hide();
    } );
    
    
    $("#sendData").click( function (){
        var captot = $("#capitaltotal").text();
        var sw, sw2;
        captot = formatinteger( captot );        
        if( captot > 0 ){   
            $("#msg2").hide();
            sw = true;
        } else {
            $("#msg").show();
            return false;            
        }
        
        var patri = formatinteger( $("#input-15").val() );
        if(  patri > 0 ) {
            sw2 = true;
        } else {
            $("#msg2").show();
            return false;
        }
                                
    });
        
});
function saveUPD(inp){
if (inp==1) {
    
    $("#statusACAP1").html('<div class="bxSL"><img alt="Guardando" src="lib/load.gif">guardando</div>');
    var datos="pack=1&input-11="+$("#input-11").val()+"&input-12="+$("#input-12").val()+"&input-13="+$("#input-13").val()+"&input-15="+$("#input-15").val();
$.ajax({
            type:"POST",
            url: "acap10Upd.php",
            cache: false,
            data: datos, 
            success: function (data) {
                $("#statusACAP1").html('<div class="bxS"><img alt="Guardado" src="../lib/ico_chk.gif">guardado</div>');   
            },
            complete: function (data) {
                  $("#statusACAP1").fadeOut(1600, "linear");
            }
});
};
}