function showInputOtro( tipo ) {
    var cate;
    switch ( tipo ) {
        case "electricidad":  
        var inp1 = formatinteger($("#input-1").val()); 
        if( inp1 > 0 ) {
            cate = $("#input-11").val(); 
            if( cate == 'OTRAS' ) {
                $("#otroelectricidad").show();
            } else {
                $("#otroelectricidad").val("");
                $("#otroelectricidad").hide();
            }
            
        } else {            
            $("#input-11 option[value='']").attr("selected","selected");
        }
        $("#msg").hide();
        $("#msg3").hide();
        $("#otroelectricidad").removeClass("req");
        break;
        case "agua":  
        var inp2 = formatinteger($("#input-2").val()); 
        if( inp2 > 0 ) {
            cate = $("#input-12").val(); 
            if( cate == 'OTRAS' ) {
                $("#otroagua").show();
            } else {
                $("#otroagua").val("");
                $("#otroagua").hide();
            }
        } else {            
            $("#input-12 option[value='']").attr("selected","selected");
        }
        $("#msg").hide();
        $("#msg3").hide();
        $("#otroagua").removeClass("req");
        break;
        case "gas":  
        var inp3 = formatinteger($("#input-3").val()); 
        if( inp3 > 0 ) {    
            cate = $("#input-13").val(); 
            if( cate == 'OTRAS' ) {
                $("#otrogas").show();
            } else {
                $("#otrogas").val("");
                $("#otrogas").hide();
            }            
        } else {
            $("#input-13 option[value='']").attr("selected","selected");
        }
        $("#msg").hide();
        $("#msg3").hide();
        $("#otrogas").removeClass("req");
        break;
    }        
    //console.log( cate );

}

$(document).ready( function(){
    
    $("#sendData").click( function(){
        var ct1 = $("#input-11").val(), ct2 = $("#input-12").val(), ct3 = $("#input-13").val();
        var sw1=1,sw2=1,sw3=1; 
        
        if( ct1 == 'OTRAS' ) {
            if( $("#otroelectricidad").val() == '' ) {
                sw1=0;
                $("#otroelectricidad").addClass("req");
            }
        }
        
        if( ct2 == 'OTRAS' ) {
            if( $("#otroagua").val() == '' ) {
                $("#otroagua").addClass("req");
                sw2=0;
            }
        }
        
        if( ct3 == 'OTRAS' ) {
            if( $("#otrogas").val() == '' ) {
                $("#otrogas").addClass("req");
                sw3=0;
            }
        }
        
        if( !sw1 || !sw2 || !sw3  ) {
            $("#msg").show();
            return false;
        }
        
        var inp1 = formatinteger($("#input-1").val());
        var inp2 = formatinteger($("#input-2").val());
        var inp3 = formatinteger($("#input-3").val());
        //--------------/
        
        if( ct1 == '' && inp1 > 0 ){
            $("#msg3").show();
            return false;
        }
        
        if( ct2 == '' && inp2 > 0 ){
            $("#msg3").show();
            return false;
        }
        
        if( ct3 == '' && inp3 > 0 ){
            $("#msg3").show();
            return false;
        }
        //--------------/
        
        var inp8 = formatinteger( $("#input-8").val() );
        
        if( inp8 > 0 ){
            var otroscomb = $("#input-9").val();
            if( otroscomb == '' ){
                $("#input-9").addClass("req");
                $("#msg4").show();
                return false;
            }
        }
        //--------------/
        
        var tot = formatinteger( $("#ai_totsuministros").text());
        if( tot > 0 ) {
            return true;
        } else {
            $("#msg2").show();
            return false;
        }
                
    });
    
    $("#input-1, #input-2, #input-3, #input-4, #input-5, #input-6, #input-10").blur( function() {
        totalvalortarifa();
        var val1;
        
        var myId = (this).id;
        if( myId == "input-1" ){
            val1 = formatinteger($(this).val());

            if( val1 == 0 || val1 == '' ) {
                $("#input-11 option[value='']").attr("selected","selected");
                $("#otroelectricidad").val("");
                $("#otroelectricidad").hide();
            }
        }
        
        if( myId == "input-2" ){
            val1 = formatinteger($(this).val());
          
            if( val1 == 0 || val1 == '' ) {
                $("#input-12 option[value='']").attr("selected","selected");
                $("#otroagua").val("");
                $("#otroagua").hide();
            }
        }
        
        if( myId == "input-3" ){
            val1 = formatinteger($(this).val());
          
            if( val1 == 0 || val1 == '' ) {
                $("#input-13 option[value='']").attr("selected","selected");
                $("#otrogas").val("");
                $("#otrogas").hide();
            }
        }
        
    } );
        
    $("#input-8").blur( function() {
        var v = $(this).val();
        v = parseInt( v );
  
        if( v > 0 ) {            
            $("#input-9").show();                      
            $("#input-9").addClass("required");
        } else {
            $("#input-9").hide();
            $("#input-9").val("");
            $("#input-9").removeClass("required");
        }
        $("#msg4").hide();
        totalvalortarifa();        
    } );
    
    $("#input-9").blur( function() {               
        totalvalortarifa();        
        $("#msg4").hide();
    } );   
    
    $("#otroelectricidad").click(function(){
        $("#otroelectricidad").removeClass("req");
        $("#msg").hide();
    });
    
    $("#otroagua").click(function(){
        $("#otroagua").removeClass("req");
        $("#msg").hide();
    });
    
    $("#otrogas").click(function(){
        $("#otrogas").removeClass("req");
        $("#msg").hide();
    });
    
    function totalvalortarifa() {
        var v1,v2,v3,v4,v5,v6,v7,v8;
        v1 = formatinteger( $("#input-1").val() );
        v2 = formatinteger( $("#input-2").val() );
        v3 = formatinteger( $("#input-3").val() );
        v4 = formatinteger( $("#input-4").val() );
        v5 = formatinteger( $("#input-5").val() );
        v6 = formatinteger( $("#input-6").val() );
        v7 = formatinteger( $("#input-8").val() );
        v8 = formatinteger( $("#input-10").val() );
        
        tot = v1 + v2 + v3 + v4 + v5 + v6 + v7 + v8;                
        
        $("#ai_totsuministros").text(number_format(tot,0,'',','));
        
        if( tot > 0 ) {
            $("#msg2").hide();
        }
        //$("#totperH").val(subtotal);
    }                    
    
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
            url: "acap3Upd.php",
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