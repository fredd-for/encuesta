$(document).ready( function() {                
    $("#addcertificacion").click( function( event ){
        
        event.preventDefault();        
        var nextrow = formatinteger( $("#maxrow").val() );        
        $("#maxrow").val( nextrow );            
        var myrow;
        myrow = '<tr id="row_'+nextrow+'" >'
        myrow = myrow + '<td width="13%"><input type="text" name="A_'+nextrow+'" id="A_'+nextrow+'" size="30" class="inpC2" /></td>';
        myrow = myrow + '<td width="12%"><input type="text" name="B_'+nextrow+'" id="B_'+nextrow+'" size="20" class="inpC2" /></td>';
        myrow = myrow + '<td width="6%" ><input type="text" name="C_'+nextrow+'" id="C_'+nextrow+'" size="8" class="inpC2" /></td>';
        myrow = myrow + '<td width="8%" ><input type="text" name="D_'+nextrow+'" id="D_'+nextrow+'" size="8" class="inpB2 numeric" onblur="sumcol(\'D\');" /></td>';
        myrow = myrow + '<td width="8%" ><input type="text" name="E_'+nextrow+'" id="E_'+nextrow+'" size="8" class="inpB2 numeric" onblur="sumcol(\'E\');" /></td>';
        myrow = myrow + '<td width="8%" ><input type="text" name="F_'+nextrow+'" id="F_'+nextrow+'" size="8" class="inpB2 numeric" onblur="sumcol(\'F\');" /></td>';
        myrow = myrow + '<td width="8%" ><input type="text" name="G_'+nextrow+'" id="G_'+nextrow+'" size="8" class="inpB2 numeric" onblur="sumcol(\'G\');" /></td>';
        myrow = myrow + '<td width="8%" ><input type="text" name="H_'+nextrow+'" id="H_'+nextrow+'" size="8" class="inpB2 numeric" onblur="sumcol(\'H\');" /></td>';
        myrow = myrow + '<td width="8%" ><input type="text" name="I_'+nextrow+'" id="I_'+nextrow+'" size="8" class="inpB2 numeric" onblur="sumcol(\'I\');" /></td>';
        myrow = myrow + '<td width="8%" ><input type="text" name="J_'+nextrow+'" id="J_'+nextrow+'" size="8" class="inpB2 numeric" onblur="sumcol(\'J\');" /></td>';
        myrow = myrow + '<td width="8%" ><input type="text" name="K_'+nextrow+'" id="K_'+nextrow+'" size="8" class="inpB2 numeric" onblur="sumcol(\'K\');" /></td>';
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
    
function sumcol( columna ){    
    var sum = 0;
    $("input[id^='"+columna+"_']").each(function(){        
        sum = sum + formatinteger(this.value);
    });    
    $("#tot"+columna).text( number_format(sum,0,'',',') );
}
function delRow( numero, sw ) {
    
    var co = confirm( "¿Esta seguro de eliminar este registro?" );
    if( co ) {                  
            
    if( sw == 1 ) {
        $.ajax( {
            url: "acap14a3Del.php",
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

    return false;        
}