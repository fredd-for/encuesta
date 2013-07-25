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
    
    function activofijo(fila){
        var b1, b2, b3, b4, b5, totb;
        b1 = formatinteger( $("#input-1"+fila).val() );
        b2 = formatinteger( $("#input-2"+fila).val() );
        b3 = formatinteger( $("#input-3"+fila).val() );
        b4 = formatinteger( $("#input-4"+fila).val() );
        b5 = formatinteger( $("#input-5"+fila).val() );
        totb = b1 + b2 + b3 + b5 - b4;
        return totb;                        
    }
    
    
    function totactivofijo(){
        var b1, b2, b3, b4, b5, totb;
        b1 = formatinteger( $("#tot_1").text() );
        b2 = formatinteger( $("#tot_2").text() );
        b3 = formatinteger( $("#tot_3").text() );
        b4 = formatinteger( $("#tot_4").text() );
        b5 = formatinteger( $("#tot_5").text() );
        totb = b1 + b2 + b3 + b5 - b4;      
        $("#tot_6").text( number_format(totb,0,'',',') );        
    }
    
    $("#input-11, #input-12, #input-13, #input-14, #input-15, #input-16, #input-17, #input-18").blur( function() {
        var a1, a2, a3, a4, a5, a6, a7, a8, tot, totb;
        a1 = formatinteger( $("#input-11").val() );
        a2 = formatinteger( $("#input-12").val() );
        a3 = formatinteger( $("#input-13").val() );
        a4 = formatinteger( $("#input-14").val() );
        a5 = formatinteger( $("#input-15").val() );
        a6 = formatinteger( $("#input-16").val() );
        a7 = formatinteger( $("#input-17").val() );
        a8 = formatinteger( $("#input-18").val() );
        
        tot = a1 + a2 + a3 + a4 + a5 + a6 + a7 + a8;                
        $("#tot_1").text( number_format(tot,0,'',',') );
        
        if( this.id == 'input-11' ) {            
            totb = activofijo(1);
            $("#af_1").text( number_format(totb,0,'',',') );            
        }
        
        if( this.id == 'input-12' ) {            
            totb = activofijo(2);
            $("#af_2").text( number_format(totb,0,'',',') );            
        }
        
        if( this.id == 'input-13' ) {            
            totb = activofijo(3);
            $("#af_3").text( number_format(totb,0,'',',') );            
        }
        
        if( this.id == 'input-14' ) {            
            totb = activofijo(4);
            $("#af_4").text( number_format(totb,0,'',',') );            
        }
        
        if( this.id == 'input-15' ) {            
            totb = activofijo(5);
            $("#af_5").text( number_format(totb,0,'',',') );            
        }
        
        if( this.id == 'input-16' ) {            
            totb = activofijo(6);
            $("#af_6").text( number_format(totb,0,'',',') );            
        }
        
        if( this.id == 'input-17' ) {            
            totb = activofijo(7);
            $("#af_7").text( number_format(totb,0,'',',') );            
        }
        
        if( this.id == 'input-18' ) {            
            totb = activofijo(8);
            $("#af_8").text( number_format(totb,0,'',',') );
            
            var b1, b2, b3, b4, b5;
            b1 = formatinteger( $("#input-28").val() );
            b2 = formatinteger( $("#input-38").val() );
            b3 = formatinteger( $("#input-48").val() );
            b4 = formatinteger( $("#input-58").val() );
            b5 = formatinteger( $("#input-78").val() );
                        
            if( a8 > 0 || b1 > 0 || b2 > 0 || b3 > 0 || b4 > 0 || b5 > 0 ){
                $("#otroactivo").show();
            } else {
                $("#otroactivo").hide();
            }
        }
        
        totactivofijo();
        $("#msg").hide();
        $("#msg2").hide();
        
    } );
    
    $("#input-otro").click( function () {
        $("#msg").hide();
        $("#msg2").hide();
    } );
    
    $("#input-21, #input-22, #input-23, #input-24, #input-25, #input-26, #input-27, #input-28").blur( function() {
        var a1, a2, a3, a4, a5, a6, a7, a8, tot;
        a1 = formatinteger( $("#input-21").val() );
        a2 = formatinteger( $("#input-22").val() );
        a3 = formatinteger( $("#input-23").val() );
        a4 = formatinteger( $("#input-24").val() );
        a5 = formatinteger( $("#input-25").val() );
        a6 = formatinteger( $("#input-26").val() );
        a7 = formatinteger( $("#input-27").val() );
        a8 = formatinteger( $("#input-28").val() );
        
        tot = a1 + a2 + a3 + a4 + a5 + a6 + a7 + a8;                
        $("#tot_2").text( number_format(tot,0,'',',') );
        
        if( this.id == 'input-21' ) {            
            totb = activofijo(1);
            $("#af_1").text( number_format(totb,0,'',',') );            
        }
        
        if( this.id == 'input-22' ) {            
            totb = activofijo(2);
            $("#af_2").text( number_format(totb,0,'',',') );            
        }
        
        if( this.id == 'input-23' ) {            
            totb = activofijo(3);
            $("#af_3").text( number_format(totb,0,'',',') );            
        }
        
        if( this.id == 'input-24' ) {            
            totb = activofijo(4);
            $("#af_4").text( number_format(totb,0,'',',') );            
        }
        
        if( this.id == 'input-25' ) {            
            totb = activofijo(5);
            $("#af_5").text( number_format(totb,0,'',',') );            
        }
        
        if( this.id == 'input-26' ) {            
            totb = activofijo(6);
            $("#af_6").text( number_format(totb,0,'',',') );            
        }
        
        if( this.id == 'input-27' ) {            
            totb = activofijo(7);
            $("#af_7").text( number_format(totb,0,'',',') );            
        }
        
        if( this.id == 'input-28' ) {            
            totb = activofijo(8);
            $("#af_8").text( number_format(totb,0,'',',') );
            
            var b1, b2, b3, b4, b5;
            b1 = formatinteger( $("#input-18").val() );
            b2 = formatinteger( $("#input-38").val() );
            b3 = formatinteger( $("#input-48").val() );
            b4 = formatinteger( $("#input-58").val() );
            b5 = formatinteger( $("#input-78").val() );
                        
            if( a8 > 0 || b1 > 0 || b2 > 0 || b3 > 0 || b4 > 0 || b5 > 0 ){
                $("#otroactivo").show();
            } else {
                $("#otroactivo").hide();
            }
        }
        
        totactivofijo();
        $("#msg").hide();
        $("#msg2").hide();
    } );
    
    
    $("#input-31, #input-32, #input-33, #input-34, #input-35, #input-36, #input-37, #input-38").blur( function() {
        var a1, a2, a3, a4, a5, a6, a7, a8, tot;
        a1 = formatinteger( $("#input-31").val() );
        a2 = formatinteger( $("#input-32").val() );
        a3 = formatinteger( $("#input-33").val() );
        a4 = formatinteger( $("#input-34").val() );
        a5 = formatinteger( $("#input-35").val() );
        a6 = formatinteger( $("#input-36").val() );
        a7 = formatinteger( $("#input-37").val() );
        a8 = formatinteger( $("#input-38").val() );
        
        tot = a1 + a2 + a3 + a4 + a5 + a6 + a7 + a8;                
        $("#tot_3").text( number_format(tot,0,'',',') );
        
        if( this.id == 'input-31' ) {            
            totb = activofijo(1);
            $("#af_1").text( number_format(totb,0,'',',') );            
        }
        
        if( this.id == 'input-32' ) {            
            totb = activofijo(2);
            $("#af_2").text( number_format(totb,0,'',',') );            
        }
        
        if( this.id == 'input-33' ) {            
            totb = activofijo(3);
            $("#af_3").text( number_format(totb,0,'',',') );            
        }
        
        if( this.id == 'input-34' ) {            
            totb = activofijo(4);
            $("#af_4").text( number_format(totb,0,'',',') );            
        }
        
        if( this.id == 'input-35' ) {            
            totb = activofijo(5);
            $("#af_5").text( number_format(totb,0,'',',') );            
        }
        
        if( this.id == 'input-36' ) {            
            totb = activofijo(6);
            $("#af_6").text( number_format(totb,0,'',',') );            
        }
        
        if( this.id == 'input-37' ) {            
            totb = activofijo(7);
            $("#af_7").text( number_format(totb,0,'',',') );            
        }
        
        if( this.id == 'input-38' ) {            
            totb = activofijo(8);
            $("#af_8").text( number_format(totb,0,'',',') );
            
            var b1, b2, b3, b4, b5;
            b1 = formatinteger( $("#input-28").val() );
            b2 = formatinteger( $("#input-18").val() );
            b3 = formatinteger( $("#input-48").val() );
            b4 = formatinteger( $("#input-58").val() );
            b5 = formatinteger( $("#input-78").val() );
                        
            if( a8 > 0 || b1 > 0 || b2 > 0 || b3 > 0 || b4 > 0 || b5 > 0 ){
                $("#otroactivo").show();
            } else {
                $("#otroactivo").hide();
            }
        }
        
        totactivofijo();
        $("#msg").hide();
        $("#msg2").hide();
    } );
    
    $("#input-41, #input-42, #input-43, #input-44, #input-45, #input-46, #input-47, #input-48").blur( function() {
        var a1, a2, a3, a4, a5, a6, a7, a8, tot;
        a1 = formatinteger( $("#input-41").val() );
        a2 = formatinteger( $("#input-42").val() );
        a3 = formatinteger( $("#input-43").val() );
        a4 = formatinteger( $("#input-44").val() );
        a5 = formatinteger( $("#input-45").val() );
        a6 = formatinteger( $("#input-46").val() );
        a7 = formatinteger( $("#input-47").val() );
        a8 = formatinteger( $("#input-48").val() );
        
        tot = a1 + a2 + a3 + a4 + a5 + a6 + a7 + a8;                
        $("#tot_4").text( number_format(tot,0,'',',') );
        
        if( this.id == 'input-41' ) {            
            totb = activofijo(1);
            $("#af_1").text( number_format(totb,0,'',',') );            
        }
        
        if( this.id == 'input-42' ) {            
            totb = activofijo(2);
            $("#af_2").text( number_format(totb,0,'',',') );            
        }
        
        if( this.id == 'input-43' ) {            
            totb = activofijo(3);
            $("#af_3").text( number_format(totb,0,'',',') );            
        }
        
        if( this.id == 'input-44' ) {            
            totb = activofijo(4);
            $("#af_4").text( number_format(totb,0,'',',') );            
        }
        
        if( this.id == 'input-45' ) {            
            totb = activofijo(5);
            $("#af_5").text( number_format(totb,0,'',',') );            
        }
        
        if( this.id == 'input-46' ) {            
            totb = activofijo(6);
            $("#af_6").text( number_format(totb,0,'',',') );            
        }
        
        if( this.id == 'input-47' ) {            
            totb = activofijo(7);
            $("#af_7").text( number_format(totb,0,'',',') );            
        }
        
        if( this.id == 'input-48' ) {            
            totb = activofijo(8);
            $("#af_8").text( number_format(totb,0,'',',') );
            
            var b1, b2, b3, b4, b5;
            b1 = formatinteger( $("#input-28").val() );
            b2 = formatinteger( $("#input-38").val() );
            b3 = formatinteger( $("#input-18").val() );
            b4 = formatinteger( $("#input-58").val() );
            b5 = formatinteger( $("#input-78").val() );
                        
            if( a8 > 0 || b1 > 0 || b2 > 0 || b3 > 0 || b4 > 0 || b5 > 0 ){
                $("#otroactivo").show();
            } else {
                $("#otroactivo").hide();
            }
        }
        
        totactivofijo();
        $("#msg").hide();
        $("#msg2").hide();
    } );
    
    $("#input-51, #input-52, #input-53, #input-54, #input-55, #input-56, #input-57, #input-58").blur( function() {
        var a1, a2, a3, a4, a5, a6, a7, a8, tot;
        a1 = formatinteger( $("#input-51").val() );
        a2 = formatinteger( $("#input-52").val() );
        a3 = formatinteger( $("#input-53").val() );
        a4 = formatinteger( $("#input-54").val() );
        a5 = formatinteger( $("#input-55").val() );
        a6 = formatinteger( $("#input-56").val() );
        a7 = formatinteger( $("#input-57").val() );
        a8 = formatinteger( $("#input-58").val() );
        
        tot = a1 + a2 + a3 + a4 + a5 + a6 + a7 + a8;                
        $("#tot_5").text( number_format(tot,0,'',',') ); 
        
        if( this.id == 'input-51' ) {            
            totb = activofijo(1);
            $("#af_1").text( number_format(totb,0,'',',') );            
        }
        
        if( this.id == 'input-52' ) {            
            totb = activofijo(2);
            $("#af_2").text( number_format(totb,0,'',',') );            
        }
        
        if( this.id == 'input-53' ) {            
            totb = activofijo(3);
            $("#af_3").text( number_format(totb,0,'',',') );            
        }
        
        if( this.id == 'input-54' ) {            
            totb = activofijo(4);
            $("#af_4").text( number_format(totb,0,'',',') );            
        }
        
        if( this.id == 'input-55' ) {            
            totb = activofijo(5);
            $("#af_5").text( number_format(totb,0,'',',') );            
        }
        
        if( this.id == 'input-56' ) {            
            totb = activofijo(6);
            $("#af_6").text( number_format(totb,0,'',',') );            
        }
        
        if( this.id == 'input-57' ) {            
            totb = activofijo(7);
            $("#af_7").text( number_format(totb,0,'',',') );            
        }
        
        if( this.id == 'input-58' ) {            
            totb = activofijo(8);
            $("#af_8").text( number_format(totb,0,'',',') );            
            
            var b1, b2, b3, b4, b5;
            b1 = formatinteger( $("#input-28").val() );
            b2 = formatinteger( $("#input-38").val() );
            b3 = formatinteger( $("#input-48").val() );
            b4 = formatinteger( $("#input-18").val() );
            b5 = formatinteger( $("#input-78").val() );
                        
            if( a8 > 0 || b1 > 0 || b2 > 0 || b3 > 0 || b4 > 0 || b5 > 0 ){
                $("#otroactivo").show();
            } else {
                $("#otroactivo").hide();
            }
        }
                
        totactivofijo();
        $("#msg").hide();
        $("#msg2").hide();
    } );        
    
    
    $("#input-71, #input-72, #input-73, #input-74, #input-75, #input-76, #input-77, #input-78").blur( function() {
        var a1, a2, a3, a4, a5, a6, a7, a8, tot;
        a1 = formatinteger( $("#input-71").val() );
        a2 = formatinteger( $("#input-72").val() );
        a3 = formatinteger( $("#input-73").val() );
        a4 = formatinteger( $("#input-74").val() );
        a5 = formatinteger( $("#input-75").val() );
        a6 = formatinteger( $("#input-76").val() );
        a7 = formatinteger( $("#input-77").val() );
        a8 = formatinteger( $("#input-78").val() );
        
        tot = a1 + a2 + a3 + a4 + a5 + a6 + a7 + a8;                
        $("#tot_7").text( number_format(tot,0,'',',') );
        
        if( this.id == 'input-78' ) {                                  
            var b1, b2, b3, b4, b5;
            b1 = formatinteger( $("#input-28").val() );
            b2 = formatinteger( $("#input-38").val() );
            b3 = formatinteger( $("#input-48").val() );
            b4 = formatinteger( $("#input-58").val() );
            b5 = formatinteger( $("#input-18").val() );
                        
            if( a8 > 0 || b1 > 0 || b2 > 0 || b3 > 0 || b4 > 0 || b5 > 0 ){
                $("#otroactivo").show();
            } else {
                $("#otroactivo").hide();
            }
        }
        
        $("#msg").hide();
        $("#msg2").hide();
        
    } );
               
    $("#sendData").click( function() {
                
        var b1, b2, b3, b4, b5, b6, b7;
        
        b1 = formatinteger( $("#input-18").val() );
        b2 = formatinteger( $("#input-28").val() );
        b3 = formatinteger( $("#input-38").val() );
        b4 = formatinteger( $("#input-48").val() );
        b5 = formatinteger( $("#input-58").val() );
        b6 = formatinteger( $("#input-78").val() );
        
        if( b1 != 0 || b2 != 0 || b3 != 0 || b4 != 0 || b5 != 0 || b6 != 0 ){                 
            b7 = $("#input-otro").val();
            if( b7 == '' ) {
                $("#msg2").show();
                return false;
            }                        
        }
                
        b1 = formatinteger( $("#tot_1").text() );
        b2 = formatinteger( $("#tot_2").text() );
        b3 = formatinteger( $("#tot_3").text() );
        b4 = formatinteger( $("#tot_4").text() );
        b5 = formatinteger( $("#tot_5").text() );
        b6 = formatinteger( $("#tot_6").text() );
        b7 = formatinteger( $("#tot_7").text() );

        if( b1 == 0 && b2 == 0 && b3 == 0 && b4 == 0 && b5 == 0 && b6 == 0 && b7 == 0 ){       
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
            url: "acap11Upd.php",
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