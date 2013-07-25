$(document).ready( function() {  
    
    
    $("#sendData").click( function(){
        
        var subtotH = formatinteger( $("#perH").text() );
        var subtotM = formatinteger( $("#perM").text() );
        
        var nopagH = formatinteger( $("#nopagH").val() );
        var nopagM = formatinteger( $("#nopagM").val() );
        
        var sal = '';
                
        
        var pH = formatinteger( $("#pepermanenteH").val() ), pM = formatinteger( $("#pepermanenteM").val() );
        var subtotHM = pH + pM;
        if( subtotHM > 0 ){
             sal = formatinteger( $("#pepermanente").val() );
            if( sal == 0 ) {
                $("#msg3").show();
                return false;
            }
        } else {
             sal = formatinteger( $("#pepermanente").val() );
            if( sal > 0 ) {
                $("#msg4").show();
                return false;
            }
        }     
        
        var peH = formatinteger( $("#peventualH").val() ), peM = formatinteger( $("#peventualM").val() );
         subtotHM = peH + peM;
        if( subtotHM > 0 ){
             sal = formatinteger( $("#peventual").val() );
            if( sal == 0 ) {
                $("#msg3").show();
                return false;
            }
        } else {
             sal = formatinteger( $("#peventual").val() );
            if( sal > 0 ) {
                $("#msg4").show();
                return false;
            }
        }
                
        var totHM = ( subtotH + nopagH ) + ( subtotM + nopagM );                
        if( totHM > 0 ) {
            return true;
        } else {
            $("#msg").show(); 
            return false;            
        }            
        
        
    });
    
    var subtotal;
    $("#pepermanenteH, #peventualH").blur( function () {                      
        var h1 = $("#pepermanenteH").val(),  h2 = $("#peventualH").val(), iH1, iH2, tot, totGen;
        iH1 = h1.replace(/,/g, "");
        iH2 = h2.replace(/,/g, ""); 
        tot = parseInt( iH1 ) + parseInt( iH2 );      
                
        var m1 = $("#pepermanenteM").val(),  m2 = $("#peventualM").val(), iM1, iM2;
        iM1 = m1.replace(/,/g, "");
        iM2 = m2.replace(/,/g, ""); 
        var totM = parseInt( iM1 ) + parseInt( iM2 );               
       
        totGen = tot + totM;
        if( totGen > 5000 ) {            
            h1 = $(this).val();
            iH1 = h1.replace(/,/g, "");
            iH1 = parseInt( iH1 );
            subtotal = tot - iH1;
            $(this).val(0);
            $("#msg2").show();
        } else {
            subtotal = tot;
            $("#msg2").hide();
        }
        
        $("#msg4").hide();
        //console.log(subtotal);        
        $("#perH").text(number_format(subtotal,0,'',','));
        $("#totperH").val(subtotal);
                                        
    } );
    
    $("#pepermanenteM, #peventualM").blur( function () {        
        var h1 = $("#pepermanenteH").val(),  h2 = $("#peventualH").val(), iH1, iH2, tot, totGen;
        iH1 = h1.replace(/,/g, "");
        iH2 = h2.replace(/,/g, ""); 
        tot = parseInt( iH1 ) + parseInt( iH2 );      
                
        var m1 = $("#pepermanenteM").val(),  m2 = $("#peventualM").val(), iM1, iM2;
        iM1 = m1.replace(/,/g, "");
        iM2 = m2.replace(/,/g, ""); 
        var totM = parseInt( iM1 ) + parseInt( iM2 );               
       
        totGen = tot + totM;
        if( totGen > 5000 ) {           
            h1 = $(this).val();
            iH1 = h1.replace(/,/g, "");
            iH1 = parseInt( iH1 );
            subtotal = totM - iH1;            
            $(this).val(0);
            $("#msg2").show();
        } else {
            subtotal = totM;
            $("#msg2").hide();
        }
        
        $("#msg4").hide();
        //console.log(subtotal);        
        $("#perM").text(number_format(subtotal,0,'',','));
        $("#totperM").val(subtotal);        
    } );
    
    $("#pepermanente").blur( function () {    
        var pph, ppm, totPP, pp;
        subtotal = subTotal( "sueldo" );  
        $("#msg3").hide();
        
        if( subtotal > 0 ) {            
            pph = formatinteger( $("#pepermanenteH").val() );                        
            ppm = formatinteger( $("#pepermanenteM").val() );            
            totPP = pph + ppm ;
            
            if( totPP == 0 ) {
                pp = formatinteger( $("#pepermanente").val() );   
                subtotal = subtotal - pp;
                $("#pepermanente").val(0);
            }
        }
        
        $("#perHM").text(number_format(subtotal,0,'',','));
        $("#totperHM").val(subtotal);                   
    } );
    
    $("#peventual").blur( function () {        
        var pph, ppm, totPP, pp;
        subtotal = subTotal( "sueldo" );    
        $("#msg3").hide();
        
        if( subtotal > 0 ) {            
            pph = formatinteger( $("#peventualH").val() );                        
            ppm = formatinteger( $("#peventualM").val() );            
            totPP = pph + ppm;
            
            if( totPP == 0 ) {
                pp = formatinteger( $("#peventual").val() );   
                subtotal = subtotal - pp;
                $("#peventual").val(0);
            }
        }
        
        $("#perHM").text(number_format(subtotal,0,'',','));
        $("#totperHM").val(subtotal);               
  
    } );
    
    function subTotal( tipo ) {
        var tot;
        switch( tipo ){            
            case "sueldo": 
                var s1 = $("#pepermanente").val(), s2=$("#peventual").val(), iS1=0, iS2=0;
                iS1 = s1.replace(/,/g, "");
                iS2 = s2.replace(/,/g, "");                
                tot = parseInt( iS1 ) + parseInt( iS2 );
            break;
            default: tot = 0; break;
        }       
        tot = verifyNaN(tot)
        return tot;
    }
    
    function formatinteger( numero ) {
        numero = numero.replace(/,/g, ""); 
        numero = verifyNaN(numero);
        return numero;
    }
    
    function verifyNaN(numero)
    {
       if (isNaN(numero)) 
         return 0;
       else
         return numero;
    }
    
    
    
} );



function saveUPD(inp){
if (inp==1) {
    
    $("#statusACAP1").html('<div class="bxSL"><img alt="Guardando" src="lib/load.gif">guardando</div>');
    var datos="pack=1&pepermanenteH="+$("#pepermanenteH").val()+"&pepermanenteM="+$("#pepermanenteM").val()+"&pepermanente="+$("#pepermanente").val();
$.ajax({
            type:"POST",
            url: "acap2Upd.php",
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
            url: "acap2Upd.php",
            cache: false,
            data: "pack=2&peventualH="+$("#peventualH").val()+"&peventualM="+$("#peventualM").val()+"&peventual="+$("#peventual").val(),
            success: function (data) {
                $("#statusACAP1").html('<div class="bxS"><img alt="Guardado" src="../lib/ico_chk.gif">guardado</div>');   
            },
            complete: function (data) {
                  $("#statusACAP1").fadeOut(1600, "linear");
            }
});  
};
}
