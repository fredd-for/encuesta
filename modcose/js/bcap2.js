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
    
    $("#rbtn_inversion2").click( function(){             
        $("#noopcion").show();
    } );
    
    $("#rbtn_inversion1").click( function(){             
        $("#noopcion").hide();
    } );
    
    $("#chk_3").click( function(){    
        
        if( (this).checked ) {
            $("#inversionotros").show();
        } else {
            $("#inversionotros").hide();
        }
        $("#msg1").hide();
    } );
    
    $("#chk_1, #chk_2").click( function(){ 
        $("#msg1").hide();
    });
    
    $("#rbtn_certi1").click( function (){
        $("#siotrasambiental").show();     
        $("#msg2").hide();
    } );
    
    $("#rbtn_certi2").click( function (){
        $("#siotrasambiental").hide();        
        $("#msg2").hide();
    } );
    
    
    $("#certiambiental").click(function(){
        $("#msg2").hide();
    });
    
    
    $("#addcertificacion").click( function( event ){                    
        
        event.preventDefault();        
        var nextrow = formatinteger( $("#maxrow").val() ) + 1;        
        $("#maxrow").val( nextrow );
        
        $("#tablecertificacion > tbody").append("<tr id=\"row_"+nextrow+"\"><td align=\"center\"><input name=\"inputA_"+nextrow+"\" type=\"text\" id=\"inputA_"+nextrow+"\" size=\"30\" class=\"inpC2\" ></td> <td align=\"center\"><input name=\"inputB_"+nextrow+"\" type=\"text\" id=\"inputB_"+nextrow+"\" size=\"10\" maxlength=\"4\" class=\"integer inpC2\" ></td><td align=\"center\"><input name=\"inputC_"+nextrow+"\" type=\"text\" id=\"inputC_"+nextrow+"\" size=\"30\" class=\"inpC2\" ></td><td width=\"10%\" align=\"center\"><a href=\"#\" class=\"lnkCls\" id=\"delcerti_"+nextrow+"\" onclick=\"delRow("+nextrow+");return false;\" >eliminar</a></td></tr>");        
    } );           
    
    $("#sendData").click( function(){
        
        var chk = document.getElementById("rbtn_inversion2").checked; // gastos ambientales "no"
        if( chk ) {
            var chk1 = document.getElementById("chk_1").checked;
            var chk2 = document.getElementById("chk_2").checked;
            var chk3 = document.getElementById("chk_3").checked;
            if( chk1 || chk2 || chk3  ){ 
                $("#msg1").hide(); 
                if( chk3 ) {
                    if( $("#inversionotros").val() == '' ) { $("#msg1").show(); $('body').scrollTo('#inversionotros', 500); return false; }
                }
            } else { 
                $('body').scrollTo('#chk_1', 500);
                $("#msg1").show(); 
                return false;
            }                        
        }
        
        
        var chkB = document.getElementById("rbtn_certi1").checked;
        if( chkB ) {        
            
            if( $("#certiambiental").val() == '' ) { $("#msg2").show(); return false; } else { $("#msg2").hide();  }
        }
        
    } );
    
});

function delRow( numero ) {       
    
    //var evento = this.event;
    //event.preventDefault();
    var co = confirm( "¿Esta seguro de eliminar este registro?" );
    if( co ) {                
        $.ajax( {
            url: "bcap2Del.php",
            data: "uid="+numero,
            type: "POST",
            success: function( ) {            
                $("#row_"+numero).hide();
                $("#row_"+numero).remove();                                
            }
        });
    }    
    //evento.preventDefault();
    //console.log(  );
    return false;        
}