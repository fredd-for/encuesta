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
    
    $("#rbtn_usointer2").click( function(){             
        $("#opcionesinter").hide();
    } );
    
    $("#rbtn_usointer1").click( function(){             
        $("#opcionesinter").show();
    } );
    
    $("#coninter_5").click( function(){        
        var chk1 = document.getElementById("coninter_5").checked;
        //console.log( chk1 );
        if( chk1 ) {
            $("#coninter_otro").show();
        } else {
            $("#coninter_otro").hide();
        }
        
        $("#msgcon").hide();
        $("#msg3").hide();
        
        
    } );
    
    
    $("#coninter_otro").click( function() {
        $("#msgotro").hide();
    } );
    
    $("#nocuenta").click( function() {
        //var chk1 = document.getElementById("nocuenta").checked;
        if( $(this).is(':checked') ) {
            $("#internet").attr('checked', false);
            $("#intranet").attr('checked', false);
        }
    } );
    
    $("#internet").click( function() {        
        if( $(this).is(':checked') ) {
            $("#nocuenta").attr('checked', false);            
        }
    } );
    
    $("#intranet").click( function() {        
        if( $(this).is(':checked') ) {
            $("#nocuenta").attr('checked', false);            
        }
    } );
    
    $("#inputA-1, #inputB-1").blur( function(){
        var c1, c2, tot;
        c1 = formatinteger( $("#inputA-1").val() );
        c2 = formatinteger( $("#inputB-1").val() );
        tot = c1 + c2;
        $("#tot_1").text( number_format(tot,0,'',',') );
        $("#msg3").hide();
    } );
    
    $("#inputA-2, #inputB-2").blur( function(){
        var c1, c2, tot;
        c1 = formatinteger( $("#inputA-2").val() );
        c2 = formatinteger( $("#inputB-2").val() );
        tot = c1 + c2;
        $("#tot_2").text( number_format(tot,0,'',',') );
        $("#msg3").hide();
    } );
    
    $("#inputA-3, #inputB-3").blur( function(){
        var c1, c2, tot;
        c1 = formatinteger( $("#inputA-3").val() );
        c2 = formatinteger( $("#inputB-3").val() );
        tot = c1 + c2;
        $("#tot_3").text( number_format(tot,0,'',',') );
        $("#msg3").hide();
    } );
    
    $("#inputA-4, #inputB-4").blur( function(){
        var c1, c2, tot;
        c1 = formatinteger( $("#inputA-4").val() );
        c2 = formatinteger( $("#inputB-4").val() );
        tot = c1 + c2;
        $("#tot_4").text( number_format(tot,0,'',',') );
        $("#msg3").hide();
    } );
    
    $("#inputA-5, #inputB-5").blur( function(){
        var c1, c2, tot;
        c1 = formatinteger( $("#inputA-5").val() );
        c2 = formatinteger( $("#inputB-5").val() );
        tot = c1 + c2;
        $("#tot_5").text( number_format(tot,0,'',',') );
        $("#msg3").hide();
    } );
    
    $("#nomprog_1, #nomprog_2, #nomprog_3, #nomprog_4, #nomprog_5 ").blur( function(){
        $("#msg3").hide();
    } );
    
    
    $("#activity_1, #activity_2, #activity_3, #activity_4, #activity_5, #activity_6, #activity_7").click( function(){
       $("#msgacti").hide();
    } );
    
    
    $("#coninter_1, #coninter_2, #coninter_3, #coninter_4").click( function(){
       $("#msgcon").hide();
       $("#msgotro").hide();
    } );
    
            
    $("#sendData").click( function() {                                     
        
        var txt_otro, tot_1, nom_1;
        var chkIsChecked = document.getElementById("rbtn_usointer1").checked;
        if( chkIsChecked ) { 
            
            /*
            var act1 = document.getElementById("activity_1").checked;
            var act2 = document.getElementById("activity_2").checked;
            var act3 = document.getElementById("activity_3").checked;
            var act4 = document.getElementById("activity_4").checked;
            var act5 = document.getElementById("activity_5").checked;
            var act6 = document.getElementById("activity_6").checked;
            var act7 = document.getElementById("activity_7").checked;

            var ci1 = document.getElementById("coninter_1").checked;
            var ci2 = document.getElementById("coninter_2").checked;
            var ci3 = document.getElementById("coninter_3").checked;
            var ci4 = document.getElementById("coninter_4").checked;
            var ci5 = document.getElementById("coninter_5").checked;

            var sw = false;
            var sw2 = false; 
            if( !act1 && !act2 && !act3 && !act4 && !act5 && !act6 && !act7 ) {
                sw = true;
            }

            if( !ci1 && !ci2 && !ci3 && !ci4 && !ci5 ) {
                sw2 = true;
            }


            if( sw || sw2 ) {
                if( sw ) {
                    $("#msgacti").show();
                    $("#msgcon").hide();
                    $('body').scrollTo('#activity_1', 500);
                } else {
                    $("#msgcon").show();
                    $("#msgacti").hide();
                    $('body').scrollTo('#coninter_1', 500);
                }
                return false;
            }
            */
            
            if( $("#coninter_5").is(':checked') ) {                                                                                
                txt_otro = $("#coninter_otro").val();                
                if( txt_otro == '' ) {
                    $("body").scrollTo("#coninter_5");
                    $("#msgotro").show();
                    return false;
                }
            }
        }
        
                                
        tot_1 = formatinteger( $("#tot_1").text() );
        nom_1 = $("#nomprog_1").val();
        if( tot_1 == 0 && nom_1 != ''  ){
            $("#msg3").show();
            return false;
        }
        
        if( tot_1 > 0 &&  nom_1 == '' ) {
            $("#msg6").show();
            return false;
        }
        
                               
        tot_1 = formatinteger( $("#tot_2").text() );
        nom_1 = $("#nomprog_2").val();
        if( tot_1 == 0 && nom_1 != '' ){
            $("#msg3").show();
            return false;
        }
        
        if( tot_1 > 0 &&  nom_1 == '' ) {
            $("#msg6").show();
            return false;
        }

        tot_1 = formatinteger( $("#tot_3").text() );
        nom_1 = $("#nomprog_3").val();
        if( tot_1 == 0 && nom_1 != '' ){
            $("#msg3").show();
            return false;
        }            
        
        if( tot_1 > 0 &&  nom_1 == '' ) {
            $("#msg6").show();
            return false;
        }
        
        
                
        tot_1 = formatinteger( $("#tot_4").text() );
        nom_1 = $("#nomprog_4").val();
        if( tot_1 == 0 && nom_1 != '' ){
            $("#msg3").show();
            return false;
        }     
        
        if( tot_1 > 0 &&  nom_1 == '' ) {
            $("#msg6").show();
            return false;
        }

        tot_1 = formatinteger( $("#tot_5").text() );
        nom_1 = $("#nomprog_5").val();
        if( tot_1 == 0 && nom_1 != '' ){
            $("#msg3").show();
            return false;
        }
        
        if( tot_1 > 0 &&  nom_1 == '' ) {
            $("#msg6").show();
            return false;
        }
                
    } );
     
});