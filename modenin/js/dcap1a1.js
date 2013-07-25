$(document).ready( function() {                
    $("#addrow_a").click( function( event ){                                        
        event.preventDefault();        
        var nextrow = formatinteger( $("#maxrow_a").val() );        
        $("#maxrow_a").val( nextrow );            
        var myrow;
        myrow = '<tr id="rowa_'+nextrow+'" >'
        myrow = myrow + '<td width="13%"><input type="text" name="A_'+nextrow+'" id="A_'+nextrow+'" size="40" class="inpC2" /></td>';
        myrow = myrow + '<td width="12%"><input type="text" name="B_'+nextrow+'" id="B_'+nextrow+'" size="10" class="inpB2 numeric" onblur=\"sumcol(\'B\');\" /></td>';
        myrow = myrow + '<td width="6%" ><input type="text" name="C_'+nextrow+'" id="C_'+nextrow+'" size="40" class="inpC2" onblur="saveUPD(1);" /></td>';        
        myrow = myrow + '<td width="5%" ><a href="#" class="lnkCls" id="delplan_'+nextrow+'" onclick="delRow('+nextrow+',0,\'a\'); return false;" >eliminar</a></td>';
        myrow = myrow + '</tr>';        
        $("#table_a > tbody").append(myrow);
        
        nextrow = nextrow + 1;
        $("#maxrow_a").val( nextrow );
        
        $('.numeric').priceFormat({
            prefix: '',
            thousandsSeparator: ',',
            limit: 12,
            centsSeparator: '',
            centsLimit: 0
        });
    } );
    
    
    $("#addrow_b").click( function( event ){                                        
        event.preventDefault();        
        var nextrow = formatinteger( $("#maxrow_b").val() );        
        $("#maxrow_b").val( nextrow );            
        var myrow;
        myrow = '<tr id="rowb_'+nextrow+'" >'
        myrow = myrow + '<td width="13%"><input type="text" name="A2_'+nextrow+'" id="A2_'+nextrow+'" size="40" class="inpC2"  /></td>';
        myrow = myrow + '<td width="12%"><input type="text" name="B2_'+nextrow+'" id="B2_'+nextrow+'" size="10" class="inpB2 numeric" onblur=\"sumcol(\'B2\');\" /></td>';
        myrow = myrow + '<td width="6%" ><input type="text" name="C2_'+nextrow+'" id="C2_'+nextrow+'" size="40" class="inpC2" onblur="saveUPD(2);" /></td>';        
        myrow = myrow + '<td width="5%" ><a href="#" class="lnkCls" id="delplan_'+nextrow+'" onclick="delRow('+nextrow+',0,\'b\'); return false;" >eliminar</a></td>';
        myrow = myrow + '</tr>';        
        $("#table_b > tbody").append(myrow);
        
        nextrow = nextrow + 1;
        $("#maxrow_b").val( nextrow );
        
        $('.numeric').priceFormat({
            prefix: '',
            thousandsSeparator: ',',
            limit: 12,
            centsSeparator: '',
            centsLimit: 0
        });
    } );
    
    $("#addrow_c").click( function( event ){                                       
        event.preventDefault();        
        var nextrow = formatinteger( $("#maxrow_c").val() );        
        $("#maxrow_c").val( nextrow );            
        var myrow;
        myrow = '<tr id="rowc_'+nextrow+'" >'
        myrow = myrow + '<td width="13%"><input type="text" name="A3_'+nextrow+'" id="A3_'+nextrow+'" size="40" class="inpC2" /></td>';
        myrow = myrow + '<td width="12%"><input type="text" name="B3_'+nextrow+'" id="B3_'+nextrow+'" size="10" class="inpB2 numeric" onblur=\"sumcol(\'B3\');\" /></td>';
        myrow = myrow + '<td width="6%" ><input type="text" name="C3_'+nextrow+'" id="C3_'+nextrow+'" size="40" class="inpC2" onblur="saveUPD(3);" /></td>';        
        myrow = myrow + '<td width="5%" ><a href="#" class="lnkCls" id="delplan_'+nextrow+'" onclick="delRow('+nextrow+',0,\'c\'); return false;" >eliminar</a></td>';
        myrow = myrow + '</tr>';        
        $("#table_c > tbody").append(myrow);
        
        nextrow = nextrow + 1;
        $("#maxrow_c").val( nextrow );
        
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
    $("input[id^='B_']").each(function(){        
        sum = sum + formatinteger(this.value);
    });

    $("input[id^='B2_']").each(function(){        
        sum = sum + formatinteger(this.value);
    });
    
    $("input[id^='B3_']").each(function(){        
        sum = sum + formatinteger(this.value);
    });
    
    $("#total").text( number_format(sum,0,'',',') );
}


function delRow( numero, sw, reg ) {
    
    var item = 0;
    
    switch( reg ) {
        case 'a': item =  formatinteger( $("#B_"+numero).val() ); break;
        case 'b': item =  formatinteger( $("#B2_"+numero).val() ); break;
        case 'c': item =  formatinteger( $("#B3_"+numero).val() ); break;
        default: item = 0; break;
    }
    
    var co = confirm( "¿Esta seguro de eliminar este registro?" );
    if( co ) {
                                                
    if( sw == 1 ) {
        $.ajax( {
            url: "dcap1a1Del.php",
            data: "uid="+numero+"&reg="+reg,
            type: "POST",
            success: function( ) {            
                $("#row"+reg+"_"+numero).hide();
                $("#row"+reg+"_"+numero).remove();                                
            }
        });
    } else {
        $("#row"+reg+"_"+numero).hide();
        $("#row"+reg+"_"+numero).remove();
        var nextrow = formatinteger( $("#maxrow_"+reg).val() ) - 1;        
        $("#maxrow_"+reg).val( nextrow ); 
    }
       
    var tot = formatinteger( $("#total").text() );    
    tot = tot - item;        
    $("#total").text( number_format(tot,0,'',',') );    
    
    }    

    return false;        
}

function saveUPD(inp){   
    var sw=0;    
    switch( inp ) {
        case 1: sw = 1; break;
        case 2: sw = 1; break;
        case 3: sw = 1; break;
    }
    
    if( sw == 1 ) {
        $.ajax({
            type:"POST",
            url: "dcap1a1Upd.php",
            cache: false,
            data: $(".formA").serialize()+'&tabla='+inp,
            success: function (data) {
                $("#statusACAP1").html('<div class="bxS"><img alt="Guardado" src="../lib/ico_chk.gif">guardado</div>');   
            }
        });
                
        $("#statusACAP1").hide(1600);
    }
}