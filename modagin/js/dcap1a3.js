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
    
    $("#total").text( number_format(sum,0,'',',') );
}


function delRow( numero, sw, reg ) {
    
    var item = 0;
    
    switch( reg ) {
        case 'a': item =  formatinteger( $("#B_"+numero).val() ); break;
        default: item = 0; break;
    }
    
    var co = confirm( "¿Esta seguro de eliminar este registro?" );
    if( co ) {
                                                
    if( sw == 1 ) {
        $.ajax( {
            url: "dcap1a3Del.php",
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
    }
    
    if( sw == 1 ) {
        $.ajax({
            type:"POST",
            url: "dcap1a3Upd.php",
            cache: false,
            data: $(".formA").serialize()+'&tabla='+inp,
            success: function (data) {
                $("#statusACAP1").html('<div class="bxS"><img alt="Guardado" src="../lib/ico_chk.gif">guardado</div>');   
            }
        });
                
        $("#statusACAP1").hide(1600);
    }
}