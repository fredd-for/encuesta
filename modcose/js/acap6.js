$(document).ready( function() {    
    
    
    $("#input-1").blur( function () {                
        var t1 = $("#input-1").val(), t2 = $("#input-2").val();
        t1 = t1.replace(/,/g, "");
        t2 = t2.replace(/,/g, "");
        
        var tot = parseInt( t1 ) + parseInt( t2 );        
        tot = verifyNaN(tot) 
                
        $("#total").text(number_format(tot,0,'',','));
        
        if( tot > 0 ) {
            $("#msg2").hide();
        }
        
        //console.log( tot );
        if( $(this).val() == 0 || $(this).val() == ''  ) {
            $("#input-21, #input-22, #input-23, #input-24").val(0);
            $("#percent1").text(0);
        }                   
        $("#msg").hide();
    } );
    
    $("#input-2").blur( function () {           
        var t1 = $("#input-1").val(), t2 = $("#input-2").val();
        t1 = t1.replace(/,/g, "");
        t2 = t2.replace(/,/g, "");
        
        var tot = parseInt( t1 ) + parseInt( t2 );        
        tot = verifyNaN(tot) 
                
        $("#total").text(number_format(tot,0,'',','));  
        if( tot > 0 ) {
            $("#msg2").hide();
        }
        
        if( $(this).val() == 0 || $(this).val() == ''  ) {            
            $("#input-25, #input-26, #input-27, #input-28").val(0);
            $("#percent2").text(0);
        }
        
        $("#msg").hide();
        
    } );
        
    $("#input-21, #input-22, #input-23, #input-24").blur( function () { 
        var t1 = $("#input-21").val(), t2 = $("#input-22").val(), t3 = $("#input-23").val(), t4 = $("#input-24").val();
        t1 = t1.replace(/,/g, "");
        t2 = t2.replace(/,/g, "");
        t3 = t3.replace(/,/g, "");
        t4 = t4.replace(/,/g, "");
        
        var tot = parseInt( t1 ) + parseInt( t2 ) + parseInt( t3 ) + parseInt( t4 );
        tot = verifyNaN(tot);
        
        if( tot == 100 ) { $("#percent1").removeClass("labB2"); }
        
        if ( tot > 100 ) {
            //tot = tot - formatinteger($(this).val());
            //$(this).val(0);
        }                
        
        var compra1 = formatinteger($("#input-1").val());              
        if( compra1 == '' || compra1 == 0 ) {
            $(this).val(0);
            $("#percent1").text( 0 );            
        } else {
            
                $("#percent1").text( tot );
                if( tot == 100 ){
                    $("#msg").hide();
                }
            
        }
    });
        
        
    $("#input-25, #input-26, #input-27, #input-28").blur( function () { 
        var t1 = $("#input-25").val(), t2 = $("#input-26").val(), t3 = $("#input-27").val(), t4 = $("#input-28").val();
        t1 = t1.replace(/,/g, "");
        t2 = t2.replace(/,/g, "");
        t3 = t3.replace(/,/g, "");
        t4 = t4.replace(/,/g, "");
        
        var tot = parseInt( t1 ) + parseInt( t2 ) + parseInt( t3 ) + parseInt( t4 );
        tot = verifyNaN(tot);
         
        if( tot == 100 ) { $("#percent2").removeClass("labB2"); }
         /*
        if ( tot > 100 ) {
            tot = tot - formatinteger($(this).val());
            $(this).val(0);
        }  
        */
        
        var compra2 = $("#input-2").val();
        compra2 = compra2.replace(/,/g, "");
        compra2 = verifyNaN(compra2);
        
        if( compra2 == '' || compra2 == 0 ) {
            $(this).val(0);
            $("#percent2").text( 0 );            
        } else {
            
                $("#percent2").text( tot );
                if( tot == 100 ){
                    $("#msg").hide();
                }
            
        }
    
    });
    function verifyNaN(numero)
    {
       if (isNaN(numero)) 
         return 0;
       else
         return numero;
    }
    
    
    $("#sendData").click( function(){              
        //console.log("hola");
        var val1, val2, sw;
        val1 = formatinteger($("#input-1").val());
        var percent1 = $("#percent1").text();
        percent1 =  formatinteger( percent1 );
        
       
        if( val1 > 0 ) {
            if( percent1 == 100 ) {
                sw = true;
            } else {
                if( percent1 < 100 ) {
                    $("#msg").show();
                    $("#percent1").addClass("labB2");
                    $("#msg2").hide();
                    return false;
                } else {                   
                    $("#msg").show();
                    $("#percent1").addClass("labB2");
                    $("#msg2").hide();
                    return false;                   
                }
            }
        }
        val2 = formatinteger($("#input-2").val());
        var percent2 = $("#percent2").text();
        percent2 =  formatinteger( percent2 );
        
     
        if( val2 > 0 ) {
            if( percent2 == 100 ) {
                sw = true;
            } else {
                if( percent2 < 100 ) {
                    $("#msg").show();
                    $("#percent2").addClass("labB2");
                    $("#msg2").hide();
                    return false;
                } else {                   
                    $("#msg").show();
                    $("#percent2").addClass("labB2");
                    $("#msg2").hide();
                    return false;                   
                }
            }
        }
        
        // var total = formatinteger($("#total").text());
        // if( total > 0 ) {            
        //     return true;
        // } else {
        //     $("#msg2").show();
        //     return false;
        // }
        
        
        
        
    } );
    
    // numero 1,225 = 1225
    function formatinteger( numero ) {
        numero = numero.replace(/,/g, "");
        numero = parseInt( numero );
        return verifyNaN(numero);        
    }
});

function saveUPD(inp){
if (inp==1) {
    
    $("#statusACAP1").html('<div class="bxSL"><img alt="Guardando" src="lib/load.gif">guardando</div>');
    var datos="input-1="+$("#input-1").val()+"&input-21="+$("#input-21").val()+"&input-22="+$("#input-22").val()+"&input-23="+$("#input-23").val()+"&input-24="+$("#input-24").val();
$.ajax({
            type:"POST",
            url: "acap6Upd.php",
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
            url: "acap6Upd.php",
            cache: false,
            data: "input-2="+$("#input-2").val()+"&input-25="+$("#input-25").val()+"&input-26="+$("#input-26").val()+"&input-27="+$("#input-27").val()+"&input-28="+$("#input-28").val(),
            success: function (data) {
                $("#statusACAP1").html('<div class="bxS"><img alt="Guardado" src="../lib/ico_chk.gif">guardado</div>');   
            },
            complete: function (data) {
                  $("#statusACAP1").fadeOut(1600, "linear");
            }
});  
};
}
