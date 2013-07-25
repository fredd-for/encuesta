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
    
    $("#input-11, #input-12, #input-13, #input-14, #input-15, #input-16, #input-17").blur( function(){
        
        var v1, v2, v3, v4, v5, v6, v7, v8, tot;
        v1 = formatinteger($("#input-11").val());
        v2 = formatinteger($("#input-12").val());
        v3 = formatinteger($("#input-13").val());
        v4 = formatinteger($("#input-14").val());
        v5 = formatinteger($("#input-15").val());
        v6 = formatinteger($("#input-16").val());
        v7 = formatinteger($("#input-17").val());
        v8 = formatinteger($("#input-18").val());
        
        tot = v1 + v2 + v3 + v4 + v5 + v6 + v7 + v8;        
        $("#totalactivo").text( number_format(tot,0,'',',') );
        
        if( tot > 0 ){ $("#msg2").hide(); }
        
        $("#msg").hide();
        
    });
    
    $("#input-18").blur( function() {
        var v1, v2, v3, v4, v5, v6, v7, votro, tot;                
        v1 = formatinteger($("#input-11").val());
        v2 = formatinteger($("#input-12").val());
        v3 = formatinteger($("#input-13").val());
        v4 = formatinteger($("#input-14").val());
        v5 = formatinteger($("#input-15").val());
        v6 = formatinteger($("#input-16").val());
        v7 = formatinteger($("#input-17").val());
        
                        
        votro = formatinteger($(this).val());
        if( votro > 0 ) {
            $("#rowother").show();
            tot = v1 + v2 + v3 + v4 + v5 + v6 + v7 + votro;                   
        } else {
            $("#rowother").hide();
            $("#inputlit").val("");
            tot = v1 + v2 + v3 + v4 + v5 + v6 + v7;            
        }
        
        $("#totalactivo").text( number_format(tot,0,'',',') );
        
        if( tot > 0 ){ $("#msg2").hide(); }
        
        $("#msg").hide();
        
    });
    
    $("#sendData").click( function (){
        var v1, otros;
        v1 = formatinteger($("#input-18").val());
        
        if( v1 > 0 ) {
            otros = $("#inputlit").val();
            if( otros == ''  ) {
                $("#msg").show();                
                return false;
            }
        } else {            
            $("#msg").hide();            
        }
        
        var totact = $("#totalactivo").text();
        totact = formatinteger(totact);
        
        //console.log( totact )
        if( totact <= 0 ) {
            $("#msg2").show();
            return false;
        }        
        
    } );
    
});
function saveUPD(inp){
if (inp==1) {
    
    $("#statusACAP1").html('<div class="bxSL"><img alt="Guardando" src="lib/load.gif">guardando</div>');
    var datos="pack=1&input_11="+$("#input_11").val()+"&input_12="+$("#input_12").val()+"&input_13="+$("#input_13").val()+"&input_14="+$("#input_14").val()+"&input_15="+$("#input_15").val()+"&input_16="+$("#input_16").val()+"&input_17="+$("#input_17").val()+"&input_18="+$("#input_18").val()+"&inputlit="+$("#inputlit").val();
$.ajax({
            type:"POST",
            url: "acap9Upd.php",
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