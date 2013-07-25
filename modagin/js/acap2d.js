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
    
    $("#A1, #A2, #A3").blur( function(){
        var a1, a2, a3, tot;
        a1 = formatinteger( $("#A1").val() );
        a2 = formatinteger( $("#A2").val() );
        a3 = formatinteger( $("#A3").val() );        
        tot = a1 + a2 + a3;        
        $("#tot1").text( number_format(tot,0,'',',') );                
    });
    
    
    $("#B1, #B2, #B3").blur( function(){
        var a1, a2, a3, tot;
        a1 = formatinteger( $("#B1").val() );
        a2 = formatinteger( $("#B2").val() );
        a3 = formatinteger( $("#B3").val() );        
        tot = a1 + a2 + a3;        
        $("#tot2").text( number_format(tot,0,'',',') );                
    });
    
    $("#C1, #C2, #C3").blur( function(){
        var a1, a2, a3, tot;
        a1 = formatinteger( $("#C1").val() );
        a2 = formatinteger( $("#C2").val() );
        a3 = formatinteger( $("#C3").val() );        
        tot = a1 + a2 + a3;        
        $("#tot3").text( number_format(tot,0,'',',') );                
    });
        
    $("#D1, #D2, #D3").blur( function(){
        var a1, a2, a3, tot;
        a1 = formatinteger( $("#D1").val() );
        a2 = formatinteger( $("#D2").val() );
        a3 = formatinteger( $("#D3").val() );        
        tot = a1 + a2 + a3;        
        $("#tot4").text( number_format(tot,0,'',',') );                
    });
    
    $("#E1, #E2, #E3").blur( function(){
        var a1, a2, a3, tot;
        a1 = formatinteger( $("#E1").val() );
        a2 = formatinteger( $("#E2").val() );
        a3 = formatinteger( $("#E3").val() );        
        tot = a1 + a2 + a3;        
        $("#tot5").text( number_format(tot,0,'',',') );                
    });
    
    $("#F1, #F2, #F3").blur( function(){
        var a1, a2, a3, tot;
        a1 = formatinteger( $("#F1").val() );
        a2 = formatinteger( $("#F2").val() );
        a3 = formatinteger( $("#F3").val() );        
        tot = a1 + a2 + a3;        
        $("#tot6").text( number_format(tot,0,'',',') );                
    });
    
    $("#mes_menor").click(function(){
        $("#msg").hide();
    });
    
    $("#mes_mayor").click(function(){
        $("#msg").hide();
    });
                
    $("#sendData").click( function() {    
        var a1, a2, a3, a4, a5, a6, tot;
        a1 = formatinteger( $("#tot1").text() );
        a2 = formatinteger( $("#tot2").text() );
        a3 = formatinteger( $("#tot3").text() ); 
        a4 = formatinteger( $("#tot4").text() ); 
        a5 = formatinteger( $("#tot5").text() ); 
        a6 = formatinteger( $("#tot6").text() );
        
        if( a1 != 0 || a2 != 0 || a3 != 0 || a4 != 0 || a5 != 0 || a6 != 0 ){
            var m1 = $("#mes_menor").val();
            var m2 = $("#mes_mayor").val();
            
            if( m1 != '' && m2 != '' ) {
                return true;
            } else {
                $("#msg").show();
                return false;
            }
            
        } else {
            return true;
        }
        
    } );
    
});


function saveUPD(inp){

var sw=0;    
switch( inp ) {
    case 1: sw = 1; break;
}

if( sw == 1 ) {
    $.ajax({
        type:"POST",
        url: "acap2dUpd.php",
        cache: false,
        data: $(".formA").serialize()+'&tabla='+inp,
        success: function (data) {
            $("#statusACAP1").html('<div class="bxS"><img alt="Guardado" src="../lib/ico_chk.gif">guardado</div>');   
        }
    });

    $("#statusACAP1").hide(1600);
}

}