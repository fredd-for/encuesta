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
    
    $("#A1, #A2, #A3, #A4").blur( function(){
        var a1, a2, a3, a4, a5, tot, th, tm, thm;
        a1 = formatinteger( $("#A1").val() );
        a2 = formatinteger( $("#A2").val() );
        a3 = formatinteger( $("#A3").val() );
        a4 = formatinteger( $("#A4").val() );
        
        tot = a1 + a2 + a3 + a4;
                                
        a5 = formatinteger( $("#A5").val() );
        
        // --- restricciones ---
        tm = formatinteger( $("#perM").text() );    
        thm = tot + tm + a5;              
       
        if( thm > 5000 ) {
            $("#msg2").show();
            tot = tot -  formatinteger( this.value );
            this.value = 0;
        } else {
            $("#msg2").hide();  
        }
        // --- restricciones ---
        
        $("#perTH").text( number_format(tot,0,'',',') ); //tot hombre                
        th = a5 + tot;
        $("#perH").text( number_format(th,0,'',',') );
        
        $("#msg3").hide();
        $("#msg4").hide();
        $("#msg5").hide();
        
        var a6 = formatinteger( $("#A6").val() );
        th = th + a6;
        $("#perGH").text( number_format(th,0,'',',') );
                
    } );
    
    
    $("#A5").blur( function (){        
        var a5, tot, tm;
        tot = formatinteger( $("#perTH").text() );
        a5 = formatinteger( this.value );        
        tot = tot + a5;
                
        // --- restricciones ---
        tm = formatinteger( $("#perM").text() );  //tot mujeres      
        thm = tot + tm;
        if( thm > 5000 ) {
            $("#msg2").show();
            tot = tot -  formatinteger( this.value );
            this.value = 0;
        } else {
            $("#msg2").hide();  
        }
        
        $("#perH").text( number_format(tot,0,'',',') );
        
        
        $("#msg3").hide();
        $("#msg4").hide();
        $("#msg5").hide();
        
        var a6 = formatinteger( $("#A6").val() );
        tot = tot + a6;
        $("#perGH").text( number_format(tot,0,'',',') );
        
    } );
    
    $("#B1, #B2, #B3, #B4").blur( function(){
        var a1, a2, a3, a4, a5, tot, th, tm, thm;
        a1 = formatinteger( $("#B1").val() );
        a2 = formatinteger( $("#B2").val() );
        a3 = formatinteger( $("#B3").val() );
        a4 = formatinteger( $("#B4").val() );
        
        tot = a1 + a2 + a3 + a4;
        a5 = formatinteger( $("#B5").val() );
        
        // --- restricciones ---
        tm = formatinteger( $("#perH").text() );        
        thm = tot + tm + a5;
        if( thm > 5000 ) {
            $("#msg2").show();
            tot = tot -  formatinteger( this.value );
            this.value = 0;
        } else {
            $("#msg2").hide();  
        }
        // --- restricciones ---
                
        $("#perTM").text( number_format(tot,0,'',',') );                
        th = a5 + tot;
        $("#perM").text( number_format(th,0,'',',') );
        
        $("#msg3").hide();
        $("#msg4").hide();
        $("#msg5").hide();
        
        var a6 = formatinteger( $("#B6").val() );
        th = th + a6;
        $("#perGM").text( number_format(th,0,'',',') );
        
    } );
    
    
    $("#B5").blur( function (){     
        var a5, tot, th, thm;
        tot = formatinteger( $("#perTM").text() );
        a5 = formatinteger( this.value );        
        tot = tot + a5;
        
        //restricciones
        th = formatinteger( $("#perH").text() );  //tot hombres      
        thm = tot + th;
        //console.log( a5+"____"+tot+"____"+th );
        if( thm > 5000 ) {
            $("#msg2").show();
            
            tot = tot -  formatinteger( this.value );
            this.value = 0;
        } else {
            $("#msg2").hide();  
        }
        
        $("#perM").text( number_format(tot,0,'',',') );
        
        $("#msg3").hide();
        $("#msg4").hide();
        $("#msg5").hide();
                
        var a6 = formatinteger( $("#B6").val() );
        tot = tot + a6;
        $("#perGM").text( number_format(tot,0,'',',') );
        
    } );
    
    $("#A6").blur( function(){
        var a6 = formatinteger( this.value );
        var tot = formatinteger( $("#perH").text() );
        tot = tot + a6;
        $("#perGH").text( number_format(tot,0,'',',') );
    });
    
    $("#B6").blur( function(){
        var a6 = formatinteger( this.value );
        var tot = formatinteger( $("#perM").text() );
        tot = tot + a6;
        $("#perGM").text( number_format(tot,0,'',',') );
    });
    
    $("#C1, #C2, #C3, #C4").blur( function(){
        var a1, a2, a3, a4, a5, tot, th;
        a1 = formatinteger( $("#C1").val() );
        a2 = formatinteger( $("#C2").val() );
        a3 = formatinteger( $("#C3").val() );
        a4 = formatinteger( $("#C4").val() );
        
        tot = a1 + a2 + a3 + a4;
        
        $("#perTS").text( number_format(tot,0,'',',') );
        
        a5 = formatinteger( $("#C5").val() );
        th = a5 + tot;
        $("#perS").text( number_format(th,0,'',',') );
        
        $("#msg3").hide();
        $("#msg4").hide();
        $("#msg5").hide();
                
        $("#perGS").text( number_format(th,0,'',',') );
    } );
    
    $("#C5").blur( function (){     
        var a5, tot;
        tot = formatinteger( $("#perTS").text() );
        a5 = formatinteger( this.value );        
        tot = tot + a5;
        $("#perS").text( number_format(tot,0,'',',') );
        
        $("#msg3").hide();
        $("#msg4").hide();
        $("#msg5").hide();
                
        $("#perGS").text( number_format(tot,0,'',',') );
    } );
    
    
    
    $("#sendData").click( function(){
        var tot, tot1, tot2, apoyo1, apoyo2, sw;
        tot1 = formatinteger( $("#perH").text() );        
        apoyo1 = formatinteger( $("#A6").val() );
        
        tot2 = formatinteger( $("#perM").text() );        
        apoyo2 = formatinteger( $("#B6").val() );
        
        tot = tot1 + tot2 + apoyo1 + apoyo2;
        
        if( tot > 0 ) {
            sw = true;
            $("#msg").hide();
        } else {
            $("#msg").show();
            return false;
        }
        
        // correspondencia persona - salario
        
        var a1, b1, c1, ab1, sw1, sw2, sw3, sw4, sw5, sw6, sw7, sw8, sw9, sw10, sw11;
        a1 = formatinteger( $("#A1").val() );
        b1 = formatinteger( $("#B1").val() );
        ab1 = a1 + b1;
        if( ab1 > 0 ){
            c1 = formatinteger( $("#C1").val() );
            if( c1 == 0 ){
                $("#msg3").show();
                return false;
            } else {
                sw1 = true;
            }
        }
                
        a1 = formatinteger( $("#A2").val() );
        b1 = formatinteger( $("#B2").val() );
        ab1 = a1 + b1;
        if( ab1 > 0 ){
            c1 = formatinteger( $("#C2").val() );
            if( c1 == 0 ){
                $("#msg3").show();
                return false;
            } else {
                sw2 = true;
            }
        }
        
        a1 = formatinteger( $("#A3").val() );
        b1 = formatinteger( $("#B3").val() );
        ab1 = a1 + b1;
        if( ab1 > 0 ){
            c1 = formatinteger( $("#C3").val() );
            if( c1 == 0 ){
                $("#msg3").show();
                return false;
            } else {
                sw3 = true;
            }
        }
        
        a1 = formatinteger( $("#A4").val() );
        b1 = formatinteger( $("#B4").val() );
        ab1 = a1 + b1;
        if( ab1 > 0 ){
            c1 = formatinteger( $("#C4").val() );
            if( c1 == 0 ){
                $("#msg3").show();
                return false;
            } else {
                sw4 = true;
            }
        }
        
        a1 = formatinteger( $("#A5").val() );
        b1 = formatinteger( $("#B5").val() );
        ab1 = a1 + b1;
        if( ab1 > 0 ){
            c1 = formatinteger( $("#C5").val() );
            if( c1 == 0 ){
                $("#msg3").show();
                return false;
            } else {
                sw5 = true;
            }
        }
        
        // correspondencia salario - persona
        c1 = formatinteger( $("#C1").val() );        
        if( c1 > 0 ){
            a1 = formatinteger( $("#A1").val() );
            b1 = formatinteger( $("#B1").val() );
            ab1 = a1 + b1;            
            if( ab1 == 0 ){
                $("#msg4").show();
                return false;
            } else {
                sw7 = true;
            }
        }
        
        c1 = formatinteger( $("#C2").val() );        
        if( c1 > 0 ){
            a1 = formatinteger( $("#A2").val() );
            b1 = formatinteger( $("#B2").val() );
            ab1 = a1 + b1;            
            if( ab1 == 0 ){
                $("#msg4").show();
                return false;
            } else {
                sw8 = true;
            }
        }
        
        c1 = formatinteger( $("#C3").val() );        
        if( c1 > 0 ){
            a1 = formatinteger( $("#A3").val() );
            b1 = formatinteger( $("#B3").val() );
            ab1 = a1 + b1;            
            if( ab1 == 0 ){
                $("#msg4").show();
                return false;
            } else {
                sw9 = true;
            }
        }
        
        c1 = formatinteger( $("#C4").val() );        
        if( c1 > 0 ){
            a1 = formatinteger( $("#A4").val() );
            b1 = formatinteger( $("#B4").val() );
            ab1 = a1 + b1;            
            if( ab1 == 0 ){
                $("#msg4").show();
                return false;
            } else {
                sw10 = true;
            }
        }
        
        c1 = formatinteger( $("#C5").val() );        
        if( c1 > 0 ){
            a1 = formatinteger( $("#A5").val() );
            b1 = formatinteger( $("#B5").val() );
            ab1 = a1 + b1;            
            if( ab1 == 0 ){
                $("#msg4").show();
                return false;
            } else {
                sw11 = true;
            }
        }
                
        var totparcial = tot1 + tot2;
        if( totparcial == 0 ) {
            $("#msg4").show();
            return false;
        }
                
        tot1 = formatinteger( $("#A6").val() );
        tot2 = formatinteger( $("#B6").val() );
        var totgen = tot1 + tot2;
        if( totgen == 0 ) {
            $("#msg5").show();
            return false;
        }
        
        
    });
    
               
} );

function saveUPD(inp){
    
    var datos = "", sw=0;    
    switch( inp ) {
        case 1: 
        case 2: 
        case 3: 
        case 4: 
        case 5: sw = 1; break;
    }
    
    if( sw == 1 ) {
        $.ajax({
            type:"POST",
            url: "acap2Upd.php",
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