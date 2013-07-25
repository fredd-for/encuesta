$(document).ready( function() {                
    $("#addcertificacion").click( function( event ){
                                
        event.preventDefault();        
        var nextrow = formatinteger( $("#maxrow").val() );        
        $("#maxrow").val( nextrow );            
        var myrow;
        myrow = '<tr id="row_'+nextrow+'" >';
        myrow = myrow + '<td width="11%"><input type="text" name="A_'+nextrow+'" id="A_'+nextrow+'" size="30" class="inpC2" ></td>';
        myrow = myrow + '<td width="6%" ><input type="text" name="B_'+nextrow+'" id="B_'+nextrow+'" size="8" class="inpC2" ></td>';
        myrow = myrow + '<td width="6%" ><input type="text" name="C_'+nextrow+'" id="C_'+nextrow+'" size="8" class="inpB2 numeric" onblur="sumcol(\'C\','+nextrow+'); "  ></td>';
        myrow = myrow + '<td width="8%" ><input type="text" name="D_'+nextrow+'" id="D_'+nextrow+'" size="8" class="inpB2 numeric" onblur="sumcol(\'D\','+nextrow+'); " ></td>';
        myrow = myrow + '<td width="8%" ><input type="text" name="E_'+nextrow+'" id="E_'+nextrow+'" size="8" class="inpB2 numeric" onblur="sumcol(\'E\','+nextrow+'); " ></td>';
        myrow = myrow + '<td width="8%" ><input type="text" name="F_'+nextrow+'" id="F_'+nextrow+'" size="8" class="inpB2 numeric" onblur="sumcol(\'F\','+nextrow+'); " ></td>';
        myrow = myrow + '<td width="8%" ><label class="labB" id="G_'+nextrow+'" >0</label></td>';
        myrow = myrow + '<td width="8%" ><input type="text" name="H_'+nextrow+'" id="H_'+nextrow+'" size="8" class="inpB2 numeric" onblur="sumcol(\'H\','+nextrow+'); " ></td>';
        myrow = myrow + '<td width="8%" ><input type="text" name="I_'+nextrow+'" id="I_'+nextrow+'" size="8" class="inpB2 numeric" onblur="sumcol(\'I\','+nextrow+'); " ></td>';
        myrow = myrow + '<td width="8%" ><input type="text" name="J_'+nextrow+'" id="J_'+nextrow+'" size="8" class="inpB2 numeric" onblur="sumcol(\'J\','+nextrow+');  saveUPD(1); return false;" ></td>';
        myrow = myrow + '<td width="8%" ><label class="labB" id="totK_'+nextrow+'">0</label></td>';
        myrow = myrow + '<td width="8%" ><label class="labB" id="totL_'+nextrow+'">0</label></td>';
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
    var sum = 0;        
    var patronE = /E_\d{1,3}/gi;
    var patronF = /F_\d{1,3}/gi;
    var ismatchE = "", ismatchF = "";        
    var colfil = columna+"_"+fila;
    
    ismatchE = patronE.test(colfil);
    ismatchF = patronF.test(colfil);
    
    var iE1, iF1, tot, sum2 = 0;
    if( ismatchE ) {
        iE1 = formatinteger( $("#"+columna+"_"+fila).val() );
        iF1 = formatinteger( $("#F_"+fila).val() );
        tot = iE1 + iF1;                
        $("#G_"+fila).text(number_format(tot,0,'',','));
        $("label[id^='G_']").each(function(){
            sum2 = sum2 + formatinteger($(this).text());                       
        });        
        $("#totG").text(number_format(sum2,0,'',','));
    }
    
    if( ismatchF ) {
        iF1 = formatinteger( $("#"+columna+"_"+fila).val() );
        iE1 = formatinteger( $("#E_"+fila).val() );
        tot = iE1 + iF1;                
        $("#G_"+fila).text(number_format(tot,0,'',','));
        $("label[id^='G_']").each(function(){
            sum2 = sum2 + formatinteger($(this).text());                       
        });        
        $("#totG").text(number_format(sum2,0,'',','));
    }
    
    $("input[id^='"+columna+"_']").each(function(){
        sum = sum + formatinteger(this.value);                       
    });
    $("#tot"+columna).text( number_format(sum,0,'',',') );
    
    // fila
    var finCant=0, finVal=0;
    var c1 = formatinteger( $("#C_"+fila).val() );
    var g1 = formatinteger( $("#G_"+fila).text() );
    var i1 = formatinteger( $("#I_"+fila).val() );
    finCant = c1 + g1 - i1; //cantidad
    
    var d1 = formatinteger( $("#D_"+fila).val() );
    var h1 = formatinteger( $("#H_"+fila).val() );
    var j1 = formatinteger( $("#J_"+fila).val() );                
    finVal = d1 + h1 - j1;
            
    $("#totK_"+fila).text( number_format(finCant,0,'',',') );
    $("#totL_"+fila).text( number_format(finVal ,0,'',',') );
    
    /* ----------------------------- */
    var sumJ=0, sumL=0;
    $("label[id^='totK_']").each(function(){        
        sumJ = sumJ + formatinteger( $(this).text() );
    });
    $("#totK").text( number_format(sumJ,0,'',',') );
    
    $("label[id^='totL_']").each(function(){        
        sumL = sumL + formatinteger( $(this).text() );
    });
    $("#totL").text( number_format(sumL,0,'',',') );
}
function delRow( numero, sw ) {
    var cd, ce, cf, cg, ch, ci, cj,ck;
    var co = confirm( "¿Esta seguro de eliminar este registro?" );
    if( co ) {
        
    var x = formatinteger( $("#C_"+numero).val());
    var s = formatinteger( $("#totC").text() ); 
    s = s - x; cd = s;
    $("#totC").text( number_format(s,0,'',',') );    
    
    x = formatinteger( $("#D_"+numero).val());
    s = formatinteger( $("#totD").text() ); 
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
    
    x = formatinteger( $("#J_"+numero).val());
    s = formatinteger( $("#totJ").text() ); 
    s = s - x; cj = s;
    $("#totJ").text( number_format(s,0,'',',') );
                
    x = formatinteger( $("#G_"+numero).text());
    s = formatinteger( $("#totG").text() ); 
    s = s - x; ck = s;
    $("#totG").text( number_format(s,0,'',',') );
                    
    //if( sw == 1 ) {
    if( 1 ) {    
        $.ajax( {
            url: "acap14a2Del.php",
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
    
    var sumK=0, sumL=0;
    $("label[id^='totK_']").each(function(){        
        sumK = sumK + formatinteger( $(this).text() );        
    });
    sumK = sumK - formatinteger( $("#totK_"+numero).text() );
    $("#totK").text( number_format(sumK,0,'',',') );

    $("label[id^='totL_']").each(function(){        
        sumL = sumL + formatinteger( $(this).text() );        
    });    
    sumL = sumL - formatinteger( $("#totL_"+numero).text() );
    $("#totL").text( number_format(sumL,0,'',',') );
    
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
            url: "acap14a2Upd.php",
            cache: false,
            data: $(".formA").serialize(), 
            success: function (data) {
                $("#statusACAP1").html('<div class="bxS"><img alt="Guardado" src="../lib/ico_chk.gif">guardado</div>');   
            }
                        
        });
        
        $("#statusACAP1").hide(800);
    }       
}