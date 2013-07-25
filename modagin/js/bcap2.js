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
    $("#rbtn_inv1").click( function (){
        $("#noopcioninv").hide();
        $("#siopcioninv").show();
        
        $("#msg1, #msg2, #msg3, #msg4 ").hide();
        
    } );
    
    $("#rbtn_inv2").click( function (){
        $("#noopcioninv").show();
        $("#siopcioninv").hide();  
        
        $("#msg1, #msg2, #msg3, #msg4 ").hide();
    } );
    
    $("#chk_3").click( function(){
        var chkIsChecked = document.getElementById("chk_3").checked;
        if( chkIsChecked ) {
            $("#inversionotros").show();
        } else {
            $("#inversionotros").hide();
        }        
        
        $("#msg1, #msg2, #msg3, #msg4 ").hide();
    } );
    
    $("#activity_8").click( function(){        
        var chkIsChecked = document.getElementById("activity_8").checked;
        if( chkIsChecked ) {
            $("#otrosgestion").show();
        } else {
            $("#otrosgestion").hide(); 
        }
        
        $("#msg1, #msg2, #msg3, #msg4 ").hide();
    } );
    
    // gastos
    $("#rbtn_inversion1").click( function (){        
        $("#noopciongastos").hide();
        $("#siopciongastos").show();
        
        $("#msg1, #msg2, #msg3, #msg4 ").hide();
    } );
    
    $("#rbtn_inversion2").click( function (){
        $("#siopciongastos").hide();
        $("#noopciongastos").show();    
        
        $("#msg1, #msg2, #msg3, #msg4 ").hide();
    } );
    
    $("#chk_g3").click( function(){
        
        var chkIsChecked = document.getElementById("chk_g3").checked;
        if( chkIsChecked ) {
            $("#txt_gastos").show();
        } else {
            $("#txt_gastos").hide(); 
        }      
        
        $("#msg1, #msg2, #msg3, #msg4 ").hide();
    } );
    
    $("#gastos_16").click(function(){
        var chkIsChecked = document.getElementById("gastos_16").checked;
        if( chkIsChecked ) {
            $("#txt_otrosgastos").show();
        } else {
            $("#txt_otrosgastos").hide(); 
        }
        
        $("#msg1, #msg2, #msg3, #msg4 ").hide();
    });
    
    $("#inversionotros, #txt_otrosgastos, #otrosgestion, #txt_gastos").click(function(){
        $("#msg1, #msg2, #msg3, #msg4 ").hide();
    });
    
    $("#chk_1, #chk_2, #chk_3").click(function(){
        $("#msg1, #msg2, #msg3, #msg4 ").hide();
    });
    
    $("#addcertificacion").click( function( event ){
        
        event.preventDefault();        
        var nextrow = formatinteger( $("#maxrow").val() );        
        $("#maxrow").val( nextrow );            
        var myrow;
        myrow = '<tr id="row_'+nextrow+'" >'
        myrow = myrow + '<td ><input type="text" name="B1_'+nextrow+'" id="B1_'+nextrow+'" size="70" class="inpC" /></td>';       
        myrow = myrow + '<td ><a href="#" class="lnkCls" id="delplan_'+nextrow+'" onclick="delRow('+nextrow+',0); return false;" >eliminar</a></td>';
        myrow = myrow + '</tr>';                        
                
        $("#tablecertificacion > tbody").append(myrow);
        
        nextrow = nextrow + 1;
        $("#maxrow").val( nextrow );                
    } );
    
    
    $("#sendData").click( function (){
        var chkIsChecked = document.getElementById("rbtn_inv2").checked;                
                
        if( chkIsChecked ) {            
            chkIsChecked = document.getElementById("chk_3").checked;
            var txt = $("#inversionotros").val();
            if( chkIsChecked && txt == '' ) {
                $("#msg1").show();
                $('body').scrollTo("#chk_2", 500);
                return false;
            }            
        }                                  
    });
    
});


function delRow( numero, sw ) {
    var cd, ce, cf, cg, ch, ci, cj,ck;
    var co = confirm( "¿Esta seguro de eliminar este registro?" );
    if( co ) {               
            
    if( sw == 1 ) {
        $.ajax( {
            url: "bcap2Del.php",
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
            url: "bcap2Upd.php",
            cache: false,
            data: $(".formA").serialize(), 
            success: function (data) {
                $("#statusACAP1").html('<div class="bxS"><img alt="Guardado" src="../lib/ico_chk.gif">guardado</div>');   
            }
                        
        });
                
        $("#statusACAP1").hide(1600);
    }
}