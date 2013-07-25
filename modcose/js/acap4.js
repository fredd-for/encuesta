$(document).ready( function(){
    
    $("#input-11, #input-12").blur( function() {        
        var v1,v2;
        v1 = formatinteger( $("#input-11").val() );
        v2 = formatinteger( $("#input-12").val() );       
        tot = v1 + v2;                        
        $("#totalA").text(number_format(tot,0,'',','));                
    } );
    
    
    $("#input-21, #input-22").blur( function() {        
        var v1,v2;
        v1 = formatinteger( $("#input-21").val() );
        v2 = formatinteger( $("#input-22").val() );       
        tot = v1 + v2;                        
        $("#totalB").text(number_format(tot,0,'',','));                
    } );
        
    $("#input-31, #input-32").blur( function() {        
        var v1,v2;
        v1 = formatinteger( $("#input-31").val() );
        v2 = formatinteger( $("#input-32").val() );       
        tot = v1 + v2;                        
        $("#totalC").text(number_format(tot,0,'',','));                
    } );
    
    // numero 1,225 = 1225
    function formatinteger( numero ) {
        numero = numero.replace(/,/g, "");
        numero = parseInt( numero );
        return verifyNaN(numero);        
    }
        
    function verifyNaN(numero){
       if (isNaN(numero)) 
         return 0;
       else
         return numero;
    }
    
} );
function saveUPD(inp){
if (inp==1) {
    
    $("#statusACAP1").html('<div class="bxSL"><img alt="Guardando" src="lib/load.gif">guardando</div>');
    var datos="pack=1&input-11="+$("#input-11").val()+"&input-21="+$("#input-21").val()+"&input-31="+$("#input-31").val();
$.ajax({
            type:"POST",
            url: "acap4Upd.php",
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
if (inp==2) {
      $("#statusACAP1").html('<div class="bxSL"><img alt="Guardando" src="lib/load.gif">guardando</div>');
  $.ajax({
            type:"POST",
            url: "acap4Upd.php",
            cache: false,
            data: "pack=2&input-12="+$("#input-12").val()+"&input-22="+$("#input-22").val()+"&input-32="+$("#input-32").val(),
            success: function (data) {
                $("#statusACAP1").html('<div class="bxS"><img alt="Guardado" src="../lib/ico_chk.gif">guardado</div>');   
            },
            complete: function (data) {
                  $("#statusACAP1").fadeOut(1600, "linear");
            }
});  
};
}
