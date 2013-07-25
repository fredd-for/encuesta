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
    
    $("#input-1").blur( function(){
        var v1;
        v1 = formatinteger( $(this).val() );
        if ( v1 > 0 ) {
            $("#input-2").val(0);
            $("#msg").hide();
        }
    } );
    
    $("#input-2").blur( function(){
        var v1;
        v1 = formatinteger( $(this).val() );
        if ( v1 > 0 ) {
            $("#input-1").val(0);
            $("#msg").hide();
        }
    } );
    
    $("#sendData").click( function (){
        var v1, v2;
        v1 = formatinteger( $("#input-1").val() );
        v2 = formatinteger( $("#input-2").val() );
        
        if ( v1 > 0 || v2 > 0 ) {
            return true;
        } else {
            $("#msg").show();
            return false;
        }
    });
        
});
function saveUPD(inp){
if (inp==1) {
    
    $("#statusACAP1").html('<div class="bxSL"><img alt="Guardando" src="lib/load.gif">guardando</div>');
    var datos="pack=1&input-1="+$("#input-1").val()+"&input-2="+$("#input-2").val();
$.ajax({
            type:"POST",
            url: "acap8Upd.php",
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