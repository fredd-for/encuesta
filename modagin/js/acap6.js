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
    
    $("#input-21, #input-22, #input-23, #input-24").blur( function(){
        var a1, a2, a3, a4, tot, valA;        
        
        valA = formatinteger( $("#input-1").val() );        
        if( valA != '' && valA > 0  ) {
            a1 = formatinteger( $("#input-21").val() );
            a2 = formatinteger( $("#input-22").val() );
            a3 = formatinteger( $("#input-23").val() );
            a4 = formatinteger( $("#input-24").val() );

            tot = a1 + a2 + a3 + a4;        
            $("#percent1").text( number_format(tot,0,'',',') );                       
            
            if( tot == 100 ) {
                $("#percent1").removeClass("labB2");
            }
        } else {
            this.value = 0;
        }        
        
        $("#msg").hide();
        $("#msg2").hide();
    });
        
    
    $("#input-25, #input-26, #input-27, #input-28, #input-29, #input-30, #input-31").blur( function(){
        var a1, a2, a3, a4, a5, a6, a7, tot, valA;        
        
        valA = formatinteger( $("#input-2").val() );        
        if( valA != '' && valA > 0  ) {
            a1 = formatinteger( $("#input-25").val() );
            a2 = formatinteger( $("#input-26").val() );
            a3 = formatinteger( $("#input-27").val() );
            a4 = formatinteger( $("#input-28").val() );
            a5 = formatinteger( $("#input-29").val() );
            a6 = formatinteger( $("#input-30").val() );
            a7 = formatinteger( $("#input-31").val() );

            tot = a1 + a2 + a3 + a4 + a5 + a6 + a7;        
            $("#percent2").text( number_format(tot,0,'',',') );                       
            
            if( tot == 100 ) {
                $("#percent2").removeClass("labB2");
            }
        } else {
            this.value = 0;
        }        
        
        $("#msg").hide();
        $("#msg2").hide();
    });
    
    $("#input-32, #input-33").blur( function(){
        var a1, a2, tot, valA;        
        
        valA = formatinteger( $("#input-3").val() );        
        if( valA != '' && valA > 0  ) {
            a1 = formatinteger( $("#input-32").val() );
            a2 = formatinteger( $("#input-33").val() );            

            tot = a1 + a2;        
            $("#percent3").text( number_format(tot,0,'',',') );                       
            
            if( tot == 100 ) {
                $("#percent3").removeClass("labB2");
            }
        } else {
            this.value = 0;
        }        
        
        $("#msg").hide();
        $("#msg2").hide();
    });
    
    
    $("#input-1, #input-2, #input-3").blur( function(){
        var a1, a2, a3, tot, totext, totventa;
        
        a1 = formatinteger( $("#input-1").val() );
        a2 = formatinteger( $("#input-2").val() );
        a3 = formatinteger( $("#input-3").val() );
        
        tot = a1 + a2 + a3;  
        $("#totventanal").text( number_format(tot,0,'',',') );
        
        totext = formatinteger( $("#totexterno").val() );
        
        totventa = totext + tot;
        
        $("#totventa").text( number_format(totventa,0,'',',') );
        
        if( this.id == 'input-1' && ( this.value == 0 || this.value == '' ) ) {
            $("#input-21").val(0);
            $("#input-22").val(0);
            $("#input-23").val(0);
            $("#input-24").val(0);
            $("#percent1").text(0);
        }
        
        if( this.id == 'input-2' && ( this.value == 0 || this.value == '' ) ) {
            $("#input-25").val(0);
            $("#input-26").val(0);
            $("#input-27").val(0);
            $("#input-28").val(0);
            $("#input-29").val(0);
            $("#input-30").val(0);
            $("#input-31").val(0);
            $("#percent2").text(0);
        }
        
        if( this.id == 'input-3' && ( this.value == 0 || this.value == '' ) ) {
            $("#input-32").val(0);
            $("#input-33").val(0);            
            $("#percent3").text(0);
        }
        
        $("#msg").hide();
        $("#msg2").hide();
        
    });
    
    $("#totexterno").blur( function(){
        var a1, a2,tot;
        a1 = formatinteger( $("#totventanal").text() );
        a2 = formatinteger( this.value );
        tot = a1 + a2;
        $("#totventa").text( number_format(tot,0,'',',') );
        
        $("#msg").hide();
        $("#msg2").hide();
    } );
    
    
    
    $("#sendData").click( function() {
        
        var p1, p2, p3, valA, valB, valC;
        
        valA = formatinteger( $("#input-1").val() );        
        if( valA != '' && valA > 0  ) {
            p1 = formatinteger( $("#percent1").text() );
        
            if( p1 > 100 || p1 < 100 ) {
                $("#percent1").addClass("labB2");
                $("#msg").show();
                return false;
            }
        }
        
        valB = formatinteger( $("#input-2").val() );        
        if( valB != '' && valB > 0  ) {
            p2 = formatinteger( $("#percent2").text() );
        
            if( p2 > 100 || p2 < 100 ) {
                $("#percent2").addClass("labB2");
                $("#msg").show();
                return false;
            }
        }
        
        valC = formatinteger( $("#input-3").val() );        
        if( valC != '' && valC > 0  ) {
            p3 = formatinteger( $("#percent3").text() );
        
            if( p3 > 100 || p3 < 100 ) {
                $("#percent3").addClass("labB2");
                $("#msg").show();
                return false;
            }
        }
        
        var totventa;
        totventa = formatinteger( $("#totventa").text() );
        if( totventa == 0 || totventa == '') {
            $("#msg2").show();
            return false;
        }
        
        
    } );
    
});

function saveUPD(inp){
    
    var sw=0;    
    switch( inp ) {
        case 1:
        case 2:        
        case 3: sw = 1; break;
    }
    
    if( sw == 1 ) {
        $.ajax({
            type:"POST",
            url: "acap6Upd.php",
            cache: false,
            data: $(".formA").serialize(), 
            success: function (data) {
                $("#statusACAP1").html('<div class="bxS"><img alt="Guardado" src="../lib/ico_chk.gif">guardado</div>');   
            },
            complete: function (data) {
                  $("#statusACAP1").fadeOut(1600);
            }
        });
    }       
}