$(document).ready( function() {                
    $("#addcertificacion").click( function( event ){
        
        event.preventDefault();        
        var nextrow = formatinteger( $("#maxrow").val() );        
        $("#maxrow").val( nextrow );            
        var myrow;
        myrow = '<tr id="row_'+nextrow+'" >';
        myrow = myrow + '<td width="13%"><input type="text" name="A_'+nextrow+'" id="A_'+nextrow+'" size="30" class="inpC2" /></td>';
        myrow = myrow + '<td width="12%"><input type="text" name="B_'+nextrow+'" id="B_'+nextrow+'" size="20" class="inpC2" /></td>';
        myrow = myrow + '<td width="6%" ><input type="text" name="C_'+nextrow+'" id="C_'+nextrow+'" size="8" class="inpC2" /></td>';
        myrow = myrow + '<td width="8%" ><input type="text" name="D_'+nextrow+'" id="D_'+nextrow+'" size="8" class="inpB2 numeric" onblur="sumcol(\'D\','+nextrow+');" /></td>';
        myrow = myrow + '<td width="8%" ><input type="text" name="E_'+nextrow+'" id="E_'+nextrow+'" size="8" class="inpB2 numeric" onblur="sumcol(\'E\','+nextrow+');" /></td>';
        myrow = myrow + '<td width="8%" ><input type="text" name="F_'+nextrow+'" id="F_'+nextrow+'" size="8" class="inpB2 numeric" onblur="sumcol(\'F\','+nextrow+');" /></td>';
        myrow = myrow + '<td width="8%" ><input type="text" name="G_'+nextrow+'" id="G_'+nextrow+'" size="8" class="inpB2 numeric" onblur="sumcol(\'G\','+nextrow+');" /></td>';
        myrow = myrow + '<td width="8%" ><input type="text" name="H_'+nextrow+'" id="H_'+nextrow+'" size="8" class="inpB2 numeric" onblur="sumcol(\'H\','+nextrow+');" /></td>';
        myrow = myrow + '<td width="8%" ><input type="text" name="I_'+nextrow+'" id="I_'+nextrow+'" size="8" class="inpB2 numeric" onblur="sumcol(\'I\','+nextrow+'); saveUPD(1); return false;" /></td>';
        myrow = myrow + '<td width="8%" ><label class="labB" id="totJ_'+nextrow+'">0</label></td>';
        myrow = myrow + '<td width="8%" ><label class="labB" id="totK_'+nextrow+'">0</label></td>';
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
    var sum = 0, sumJ = 0, sumK = 0;
    $("input[id^='"+columna+"_']").each(function(){        
        sum = sum + formatinteger(this.value);
    });    
    $("#tot"+columna).text( number_format(sum,0,'',',') );
    
    // fila
    var finCant=0, finVal=0;
    var d1 = formatinteger( $("#D_"+fila).val() );
    var e1 = formatinteger( $("#E_"+fila).val() );
    var f1 = formatinteger( $("#F_"+fila).val() );
    var g1 = formatinteger( $("#G_"+fila).val() );
    var h1 = formatinteger( $("#H_"+fila).val() );
    var i1 = formatinteger( $("#I_"+fila).val() );
    
    finCant = d1 + f1 - h1; //cantidad
    finVal = e1 + g1 - i1;
            
    $("#totJ_"+fila).text( number_format(finCant,0,'',',') );
    $("#totK_"+fila).text( number_format(finVal ,0,'',',') );
    
    $("label[id^='totJ_']").each(function(){        
        sumJ = sumJ + formatinteger( $(this).text() );
    });
    $("#totJ").text( number_format(sumJ,0,'',',') );
    
    $("label[id^='totK_']").each(function(){        
        sumK = sumK + formatinteger( $(this).text() );
    });
    $("#totK").text( number_format(sumK,0,'',',') );
}
function delRow( numero, sw ) {
    var cd, ce, cf, cg, ch, ci, cj,ck;
    var co = confirm( "�Esta seguro de eliminar este registro?" );
    if( co ) {          
    var x = formatinteger( $("#D_"+numero).val());
    var s = formatinteger( $("#totD").text() ); 
    s = s - x; cd = s;
    $("#totD").text( number_format(s,0,'',',') ); 
    
    x = formatinteger( $("#E_"+numero).val());
    s = formatinteger( $("#totE").text() ); 
    s = s - x; ce = s;
    $("#totE").text( number_format(s,0,'',',') );
    
    x = formatinteger( $("#F_"+numero).val());
    s = formatinteger( $("#totF").text() ); 
    s = s - x; cf = s;
    $("#totF").text( number_format(s,0,'',',') );
    
    x = formatinteger( $("#G_"+numero).val());
    s = formatinteger( $("#totG").text() ); 
    s = s - x; cg = s;
    $("#totG").text( number_format(s,0,'',',') );
    
    x = formatinteger( $("#H_"+numero).val());
    s = formatinteger( $("#totH").text() ); 
    s = s - x; ch = s;
    $("#totH").text( number_format(s,0,'',',') );
    
    x = formatinteger( $("#I_"+numero).val());
    s = formatinteger( $("#totI").text() ); 
    s = s - x; ci = s;
    $("#totI").text( number_format(s,0,'',',') );          
            
    if( 1 ) {
        $.ajax( {
            url: "acap14b2Del.php",
            data: "uid="+numero+"&cd="+cd+"&ce="+ce+"&cf="+cf+"&cg="+cg+"&ch="+ch+"&ci="+ci+"&cj="+cj+"&ck="+ck,
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
    
    var sumJ=0, sumK=0;
    $("label[id^='totJ_']").each(function(){        
        sumJ = sumJ + formatinteger( $(this).text() );        
    });
    sumJ = sumJ - formatinteger( $("#totJ_"+numero).text() );
    $("#totJ").text( number_format(sumJ,0,'',',') );
    
    $("label[id^='totK_']").each(function(){        
        sumK = sumK + formatinteger( $(this).text() );        
    });    
    sumK = sumK - formatinteger( $("#totK_"+numero).text() );
    $("#totK").text( number_format(sumK,0,'',',') );

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
            url: "acap14b2Upd.php",
            cache: false,
            data: $(".formA").serialize(), 
            success: function (data) {
                $("#statusACAP1").html('<div class="bxS"><img alt="Guardado" src="../lib/ico_chk.gif">guardado</div>');   
            }
                        
        });
        
        $("#statusACAP1").hide(800);
    }       
}