$(document).ready( function() {                
    $("#addcertificacion").click( function( event ){
                       
        event.preventDefault();        
        var nextrow = formatinteger( $("#maxrow").val() );        
        $("#maxrow").val( nextrow );            
        var myrow;
        myrow = '<tr id="row_'+nextrow+'" >';
        myrow = myrow + '<td width="13%"><input type="text" name="A_'+nextrow+'" id="A_'+nextrow+'" size="30" class="inpC2" /></td>';
        myrow = myrow + '<td width="6%" ><input type="text" name="B_'+nextrow+'" id="B_'+nextrow+'" size="8" class="inpC2" /></td>';        
        myrow = myrow + '<td width="8%" ><input type="text" name="C_'+nextrow+'" id="C_'+nextrow+'" size="8" class="inpB2 numeric" onblur="sumcol(\'C\','+nextrow+'); " /></td>';
        myrow = myrow + '<td width="8%" ><input type="text" name="D_'+nextrow+'" id="D_'+nextrow+'" size="8" class="inpB2 numeric" onblur="sumcol(\'D\','+nextrow+'); " /></td>';
        myrow = myrow + '<td width="8%" ><input type="text" name="E_'+nextrow+'" id="E_'+nextrow+'" size="8" class="inpB2 numeric" onblur="sumcol(\'E\','+nextrow+'); " /></td>';
        myrow = myrow + '<td width="8%" ><input type="text" name="F_'+nextrow+'" id="F_'+nextrow+'" size="8" class="inpB2 numeric" onblur="sumcol(\'F\','+nextrow+'); " /></td>';
        myrow = myrow + '<td width="8%" ><input type="text" name="G_'+nextrow+'" id="G_'+nextrow+'" size="8" class="inpB2 numeric" onblur="sumcol(\'G\','+nextrow+'); " /></td>';
        myrow = myrow + '<td width="8%" ><input type="text" name="H_'+nextrow+'" id="H_'+nextrow+'" size="8" class="inpB2 numeric" onblur="sumcol(\'H\','+nextrow+'); saveUPD(1); return false;"></td>';
        myrow = myrow + '<td width="8%" ><label class="labB" id="totI_'+nextrow+'" >0</label></td>';
        myrow = myrow + '<td width="8%" ><label class="labB" id="totJ_'+nextrow+'" >0</label></td>';        
        myrow = myrow + '<td width="5%" ><a href="#" class="lnkCls" id="delplan_'+nextrow+'" onclick="delRow('+nextrow+',0); return false;" >eliminar</a></td>';
        myrow = myrow + '</tr>';         
        $("#tablecertificacion > tbody").append(myrow);
        
        nextrow = nextrow + 1;
        $("#maxrow").val( nextrow );
        
        $('.numeric').priceFormat({
            prefix: '',
            thousandsSeparator: ',',
            limit: 12,
            centsSeparator: '',
            centsLimit: 0
        });
    } );
    
    $("#sendData").click( function(){       
        var tot = formatinteger( $("#totTJ").text() );
        var Tt = formatinteger( $("#Tt").text() );
        if( tot != Tt ) {
            $("#msg3").show();
            return false;
        }        
    });
            
});

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
    
function sumcol( columna, fila ){
    
    var totinicial = 0;
    totinicial = formatinteger( $("#tot"+columna).text() );
    
    // columna
    var sum = 0, sumI = 0, sumJ = 0;
    $("input[id^='"+columna+"_']").each(function(){        
        sum = sum + formatinteger(this.value);
    });    
    $("#tot"+columna).text( number_format(sum,0,'',',') );    
    
    // fila
    var finCant=0, finVal=0;
    var c1 = formatinteger( $("#C_"+fila).val() );
    var d1 = formatinteger( $("#D_"+fila).val() );
    var e1 = formatinteger( $("#E_"+fila).val() );
    var f1 = formatinteger( $("#F_"+fila).val() );
    var g1 = formatinteger( $("#G_"+fila).val() );
    var h1 = formatinteger( $("#H_"+fila).val() );
        
    finCant = c1 + e1 - g1; //cantidad
    finVal = d1 + f1 - h1;
            
    $("#totI_"+fila).text( number_format(finCant,0,'',',') );
    $("#totJ_"+fila).text( number_format(finVal ,0,'',',') );
    
    $("label[id^='totI_']").each(function(){        
        sumI = sumI + formatinteger( $(this).text() );
    });
    $("#totI").text( number_format(sumI,0,'',',') );
    
    $("label[id^='totJ_']").each(function(){        
        sumJ = sumJ + formatinteger( $(this).text() );
    });
    $("#totJ").text( number_format(sumJ,0,'',',') );
    
    /*-----------------*/
    var td = 0;
    td = formatinteger( $("#totT"+columna).text());
    td = td - totinicial +  sum;
    $("#totT"+columna).text( number_format(td,0,'',',') );
    
    var totc, totd, totf, toth, tote, totg, cantidadIF, valorIF;
    totc = formatinteger( $("#totTC").text() );
    tote = formatinteger( $("#totTE").text() );
    totg = formatinteger( $("#totTG").text() );
    cantidadIF = totc + tote - totg;
        
    totd = formatinteger( $("#totTD").text() );
    totf = formatinteger( $("#totTF").text() );
    toth = formatinteger( $("#totTH").text() );
    valorIF = totd + totf - toth;   
    
    $("#totTI").text( number_format(cantidadIF,0,'',',') );
    $("#totTJ").text( number_format(valorIF,0,'',',') );
    
    $("#msg3").hide();
    
}
function delRow( numero, sw ) {
    
    var co = confirm( "¿Esta seguro de eliminar este registro?" );
    if( co ) {          
    
    var x = formatinteger( $("#C_"+numero).val());
    var s = formatinteger( $("#totC").text() ); 
    s = s - x; cd = s;
    $("#totC").text( number_format(s,0,'',',') );
    
    var td = formatinteger( $("#totTC").text());
    td = td - x; $("#totTC").text( number_format(td,0,'',',') ); 
    
    x = formatinteger( $("#D_"+numero).val());
    s = formatinteger( $("#totD").text() ); 
    s = s - x; cd = s;
    $("#totD").text( number_format(s,0,'',',') );
    
    td = formatinteger( $("#totTD").text());
    td = td - x; $("#totTD").text( number_format(td,0,'',',') ); 
    
    x = formatinteger( $("#E_"+numero).val());
    s = formatinteger( $("#totE").text() ); 
    s = s - x; ce = s;
    $("#totE").text( number_format(s,0,'',',') );
    
    td = formatinteger( $("#totTE").text());
    td = td - x; $("#totTE").text( number_format(td,0,'',',') );
    
    x = formatinteger( $("#F_"+numero).val());
    s = formatinteger( $("#totF").text() ); 
    s = s - x; cf = s;
    $("#totF").text( number_format(s,0,'',',') );
    
    td = formatinteger( $("#totTF").text());
    td = td - x; $("#totTF").text( number_format(td,0,'',',') );
    
    x = formatinteger( $("#G_"+numero).val());
    s = formatinteger( $("#totG").text() ); 
    s = s - x; cg = s;
    $("#totG").text( number_format(s,0,'',',') );
    
    td = formatinteger( $("#totTG").text());
    td = td - x; $("#totTG").text( number_format(td,0,'',',') );
    
    x = formatinteger( $("#H_"+numero).val());
    s = formatinteger( $("#totH").text() ); 
    s = s - x; ch = s;
    $("#totH").text( number_format(s,0,'',',') );
    
    td = formatinteger( $("#totTH").text());
    td = td - x; $("#totTH").text( number_format(td,0,'',',') );
    
    var ti = 0, tj = 0;
    ti = formatinteger( $("#totI_"+numero).text());
    tj = formatinteger( $("#totJ_"+numero).text());

    td = formatinteger( $("#totTI").text());
    td = td - ti;
    $("#totTI").text( number_format(td,0,'',',') );

    td = formatinteger( $("#totTJ").text());
    td = td - tj;
    $("#totTJ").text( number_format(td,0,'',',') );
            
    if( 1 ) {
        $.ajax( {
            url: "acap14b3Del.php",
            data: "uid="+numero,
            type: "POST",
            success: function( ) {            
                $("#row_"+numero).hide();
                $("#row_"+numero).remove();                                
            }
        });
    } else {
        $("#row_"+numero).hide();
        $("#row_"+numero).remove();
        var nextrow = formatinteger( $("#maxrow").val() ) - 1;        
        $("#maxrow").val( nextrow ); 
    }
    
    }    

    var sumI=0, sumJ=0;
    $("label[id^='totI_']").each(function(){        
        sumI = sumI + formatinteger( $(this).text() );        
    });
    sumI = sumI - formatinteger( $("#totI_"+numero).text() );
    $("#totI").text( number_format(sumI,0,'',',') );
    
    $("label[id^='totJ_']").each(function(){        
        sumJ = sumJ + formatinteger( $(this).text() );        
    });    
    sumJ = sumJ - formatinteger( $("#totJ_"+numero).text() );
    $("#totJ").text( number_format(sumJ,0,'',',') );
    
    return false;       
}

function saveUPD(inp){
    
    var sw=0;    
    switch( inp ) {
        case 1: sw = 1; break;
    }
    
    if( sw == 1 ) {
        $.ajax({
            type:"POST",
            url: "acap14b3Upd.php",
            cache: false,
            data: $(".formA").serialize(), 
            success: function (data) {
                $("#statusACAP1").html('<div class="bxS"><img alt="Guardado" src="../lib/ico_chk.gif">guardado</div>');   
            }
                        
        });
        
        $("#statusACAP1").hide(800);
    }       
}