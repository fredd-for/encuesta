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
    
    // inversiones                     
    $("#rbtn_usointer1").click( function (){
        console.log("hola");
        var chkIsChecked = document.getElementById("rbtn_usointer1").checked;
        if( chkIsChecked ) {
            $(".areainter").show();
        }       
        //$("#msg1, #msg2").hide();
    } );    
    
    $("#rbtn_usointer2").click( function (){        
        var chkIsChecked = document.getElementById("rbtn_usointer2").checked;
        if( chkIsChecked ) {
            $(".areainter").hide();
        }       
        //$("#msg1, #msg2").hide();
    } );
    
    $("#coninter_5").click( function(){
        var chkIsChecked = document.getElementById("coninter_5").checked;
        if( chkIsChecked ) {
            $("#coninter_otro").show();
        } else {
            $("#coninter_otro").hide();
        }        
    });
    
    $("#ancho_6").click( function(){
        var chkIsChecked = document.getElementById("ancho_6").checked;
        if( chkIsChecked ) {
            $("#ancho_otro").show();
        } else {
            $("#ancho_otro").hide();
        }        
    });
    
    $("#coninter_otro").click( function(){
        $("#msg_coninterotro").hide();
    } );
    
    $("#ancho_otro").click( function(){
        $("#msg_anchootro").hide();
    } );
    
    
    $("#C_1, #D_1").blur(function(){
        var b1 = $("#B_1").val();
        if( b1 != '' ){            
            var c1 = formatinteger( $("#C_1").val() );
            var d1 = formatinteger( $("#D_1").val() );
            var tot = c1 + d1;
            $("#tot_1").text(number_format(tot,0,'',','));            
        } else {
            $("#C_1").val(0);
            $("#D_1").val(0);
        }        
    });
    
    $("#B_1").blur(function(){
        if( this.value == '' ) {
            $("#C_1").val(0);
            $("#D_1").val(0);
            $("#tot_1").text(0);
        }
    });
    
    
    $("#C_2, #D_2").blur(function(){
        var b1 = $("#B_2").val();
        if( b1 != '' ){            
            var c1 = formatinteger( $("#C_2").val() );
            var d1 = formatinteger( $("#D_2").val() );
            var tot = c1 + d1;
            $("#tot_2").text(number_format(tot,0,'',','));            
        } else {
            $("#C_2").val(0);
            $("#D_2").val(0);
        }        
    });
    
    $("#B_2").blur(function(){
        if( this.value == '' ) {
            $("#C_2").val(0);
            $("#D_2").val(0);
            $("#tot_2").text(0);
        }
    });
    
    $("#C_3, #D_3").blur(function(){
        var b1 = $("#B_3").val();
        if( b1 != '' ){            
            var c1 = formatinteger( $("#C_3").val() );
            var d1 = formatinteger( $("#D_3").val() );
            var tot = c1 + d1;
            $("#tot_3").text(number_format(tot,0,'',','));            
        } else {
            $("#C_3").val(0);
            $("#D_3").val(0);
        }        
    });
    
    $("#B_3").blur(function(){
        if( this.value == '' ) {
            $("#C_3").val(0);
            $("#D_3").val(0);
            $("#tot_3").text(0);
        }
    });
    
    $("#C_4, #D_4").blur(function(){
        var b1 = $("#B_4").val();
        if( b1 != '' ){            
            var c1 = formatinteger( $("#C_4").val() );
            var d1 = formatinteger( $("#D_4").val() );
            var tot = c1 + d1;
            $("#tot_4").text(number_format(tot,0,'',','));            
        } else {
            $("#C_4").val(0);
            $("#D_4").val(0);
        }        
    });
    
    $("#B_4").blur(function(){
        if( this.value == '' ) {
            $("#C_4").val(0);
            $("#D_4").val(0);
            $("#tot_4").text(0);
        }
    });
    
    $("#C_5, #D_5").blur(function(){
        var b1 = $("#B_5").val();
        if( b1 != '' ){            
            var c1 = formatinteger( $("#C_5").val() );
            var d1 = formatinteger( $("#D_5").val() );
            var tot = c1 + d1;
            $("#tot_5").text(number_format(tot,0,'',','));            
        } else {
            $("#C_5").val(0);
            $("#D_5").val(0);
        }        
    });
    
    $("#B_5").blur(function(){
        if( this.value == '' ) {
            $("#C_5").val(0);
            $("#D_5").val(0);
            $("#tot_5").text(0);
        }
    });
    
    $("#C_6, #D_6").blur(function(){
        var b1 = $("#B_6").val();
        if( b1 != '' ){            
            var c1 = formatinteger( $("#C_6").val() );
            var d1 = formatinteger( $("#D_6").val() );
            var tot = c1 + d1;
            $("#tot_6").text(number_format(tot,0,'',','));            
        } else {
            $("#C_6").val(0);
            $("#D_6").val(0);
        }        
    });
    
    $("#B_6").blur(function(){
        if( this.value == '' ) {
            $("#C_6").val(0);
            $("#D_6").val(0);
            $("#tot_6").text(0);
        }
    });
                          
    $("#sendData").click( function (){
        var chkIsChecked = document.getElementById("rbtn_usointer1").checked;
        if( chkIsChecked ) {
            var chkIsChecked2 = document.getElementById("coninter_5").checked;
            var coninter_otro = $("#coninter_otro").val();            
            if( chkIsChecked2 && coninter_otro == '' ) {
                $("#msg_coninterotro").show();
                $('body').scrollTo('#coninter_4', 500);
                return false;
            }
            
            coninter_otro = $("#ancho_otro").val();            
            if( chkIsChecked2 && coninter_otro == '' ) {
                $("#msg_anchootro").show();
                $('body').scrollTo('#ancho_5', 500);
                return false;
            }                        
        }
        
        var c1, d1, txtB1;
        txtB1 = $("#B_1").val();
        if( txtB1 != '' ) {
            c1 = formatinteger( $("#C_1").val() );
            d1 = formatinteger( $("#D_1").val() );            
            if( c1 == 0 && d1 == 0  ) {
                $("#msg3").show();
                return false;
            }
        }
        
        txtB1 = $("#B_2").val();
        if( txtB1 != '' ) {
            c1 = formatinteger( $("#C_2").val() );
            d1 = formatinteger( $("#D_2").val() );            
            if( c1 == 0 && d1 == 0  ) {
                $("#msg3").show();
                return false;
            }
        }
        
        txtB1 = $("#B_3").val();
        if( txtB1 != '' ) {
            c1 = formatinteger( $("#C_3").val() );
            d1 = formatinteger( $("#D_3").val() );            
            if( c1 == 0 && d1 == 0  ) {
                $("#msg3").show();
                return false;
            }
        }
        
        txtB1 = $("#B_4").val();
        if( txtB1 != '' ) {
            c1 = formatinteger( $("#C_4").val() );
            d1 = formatinteger( $("#D_4").val() );            
            if( c1 == 0 && d1 == 0  ) {
                $("#msg3").show();
                return false;
            }
        }
        
        txtB1 = $("#B_5").val();
        if( txtB1 != '' ) {
            c1 = formatinteger( $("#C_5").val() );
            d1 = formatinteger( $("#D_5").val() );            
            if( c1 == 0 && d1 == 0  ) {
                $("#msg3").show();
                return false;
            }
        }
        
        txtB1 = $("#B_6").val();
        if( txtB1 != '' ) {
            c1 = formatinteger( $("#C_6").val() );
            d1 = formatinteger( $("#D_6").val() );            
            if( c1 == 0 && d1 == 0  ) {
                $("#msg3").show();
                return false;
            }
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
            url: "ccap1Upd.php",
            cache: false,
            data: $(".formA").serialize(), 
            success: function (data) {
                $("#statusACAP1").html('<div class="bxS"><img alt="Guardado" src="../lib/ico_chk.gif">guardado</div>');   
            }
                        
        });
                
        $("#statusACAP1").hide(1600);
    }
}