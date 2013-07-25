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
    
    $("#mes_1, #mes_2, #mes_3, #mes_4, #mes_5, #mes_6, #mes_7, #mes_8, #mes_9, #mes_10, #mes_11, #mes_12").click(function(){
        $("#msg3").hide();
    });
    
    $("#input-1, #input-2, #input-3 ").blur( function(){
        var t1 , t2 , t3, tot;        
        t1 = formatinteger( $("#input-1").val() );
        t2 = formatinteger( $("#input-2").val() );
        t3 = formatinteger( $("#input-3").val() );        
        //console.log(t1+"---"+t2+"---"+t3);    
        tot = t1 + t2 + t3;                        
         
        $("#total2").text( number_format(tot,0,'',',') );
                
        // ---------        
        var ventasnacional, ventasexterno, totv;
        ventasnacional = formatinteger( $("#total2").text() );
        ventasexterno = formatinteger( $("#total3").val() );        
        totv = ventasnacional + ventasexterno;
        $("#total4").text( number_format(totv,0,'',',') );                                       
        // ---------
        
        if( totv > 0 ) {
            $("#msg2").hide();
        }
        if( t1 == 0 ) {
            $("#input-21").val(0);
            $("#input-22").val(0);
            $("#input-23").val(0);
            $("#input-24").val(0);
            $("#percent1").text(0);
        }
        
        if( t2 == 0 ) {
            $("#input-25").val(0);
            $("#input-26").val(0);
            $("#input-27").val(0);
            $("#input-28").val(0);
            $("#percent2").text(0);
        }
        
    } );
    
    //externo
    $("#total3").blur( function(){
        var ventasnacional, ventasexterno, totv;
        ventasnacional = formatinteger( $("#total2").text() );
        ventasexterno = formatinteger( $("#total3").val() );
        
        totv = ventasnacional + ventasexterno;
        $("#total4").text( number_format(totv,0,'',',')  );
        
        if( totv > 0 ) {
            $("#msg2").hide();
        }
        
    } );
    
    
    $("#input-21, #input-22, #input-23, #input-24 ").blur( function(){
        var v1, p1, p2, p3, p4, pt;
        v1 = formatinteger( $("#input-1").val() );
        if( v1 == 0 ) {
            $(this).val(0);             
        } else {
            p1 = formatinteger( $("#input-21").val() );
            p2 = formatinteger( $("#input-22").val() );
            p3 = formatinteger( $("#input-23").val() );
            p4 = formatinteger( $("#input-24").val() );
            
            pt = p1 + p2 + p3 + p4;
            
            if( pt == 100 ) { $("#percent1").removeClass("labB2"); }
            
            if( pt > 100 ) {
                //$(this).val(0);
                $("#percent1").text(pt);
            } else {
                $("#percent1").text(pt);
                if( pt == 100){
                    $("#msg").hide();
                }
            }
        }     
    });
    
    
    $("#input-25, #input-26, #input-27, #input-28 ").blur( function(){
        var v1, p1, p2, p3, p4, pt;
        v1 = formatinteger( $("#input-2").val() );
        if( v1 == 0 ) {
            $(this).val(0);
        } else {
            p1 = formatinteger( $("#input-25").val() );
            p2 = formatinteger( $("#input-26").val() );
            p3 = formatinteger( $("#input-27").val() );
            p4 = formatinteger( $("#input-28").val() );
            
            pt = p1 + p2 + p3 + p4;
            
            if( pt == 100 ) { $("#percent2").removeClass("labB2"); }
            if( pt > 100 ) {
                //$(this).val(0);
                $("#percent2").text(pt);
            } else {
                $("#percent2").text(pt);
                if( pt == 100){
                    $("#msg").hide();
                }
            }
        }     
    });
    
    $("#sendData").click( function(){
                        
        var v1, v2, percent1, percent2;
        v1 = formatinteger( $("#input-1").val() );        
        sw = false;
        
        if( v1 != 0 ) {        
            
            percent1 = formatinteger ( $("#percent1").text() );
                       
            if( percent1 == 100 ) {
                sw = true;
            } else {
                if( percent1 < 100 ) {
                    $("#msg").show();
                    $("#percent1").addClass("labB2");
                    
                    $("#msg1").hide();
                    return false;
                } else {                   
                    $("#msg").show();
                    $("#percent1").addClass("labB2");
                    $("#msg1").hide();
                    return false;                   
                }
            }                        
            
        } 
        
        v2 = formatinteger( $("#input-2").val() );                
        if( v2 != 0 ) {
            percent2 = formatinteger ( $("#percent2").text() );
            
            if( percent2 == 100 ) {
                sw = true;
            } else {
                if( percent2 < 100 ) {
                    $("#msg").show();
                    $("#percent2").addClass("labB2");
                    $("#msg1").hide();
                    return false;
                } else {                   
                    $("#msg").show();
                    $("#percent2").addClass("labB2");
                    $("#msg1").hide();
                    return false;                   
                }
            }
                       
        }                                                     
        
        var togen = formatinteger( $("#total4").text() );
        if( togen == 0 ) {            
            $("#msg2").show();
            return false;
        }
        
        var $chk, numchecked;        
        /*
        for( var j = 1; j<=12; j++ ) {
            chk = document.getElementById("mes_"+j).checked;
            if( chk ) {
                numchecked =  numchecked + 1;
            }
        }
        */
        $chk = $("input[id^='mes_']:checked");
        numchecked = $chk.length;
        
        if( numchecked > 0 ) {
            return true;
        } else {
            $("#msg3").show();
            return false;
        }
        
     
    });
    
    
});


function saveUPD(inp){
if (inp==1) {
    
    $("#statusACAP1").html('<div class="bxSL"><img alt="Guardando" src="lib/load.gif">guardando</div>');
    var datos="pack=1&input-1="+$("#input-1").val()+"&input-21="+$("#input-21").val()+"&input-22="+$("#input-22").val()+"&input-23="+$("#input-23").val()+"&input-24="+$("#input-24").val()+"&input-2="+$("#input-2").val()+"&input-25="+$("#input-25").val()+"&input-26="+$("#input-26").val()+"&input-27="+$("#input-27").val()+"&input-28="+$("#input-28").val();
$.ajax({
            type:"POST",
            url: "acap7Upd.php",
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
