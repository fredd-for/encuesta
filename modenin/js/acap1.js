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
    
    $("#ai_phone1, #ai_phone2").click(function(){
        $("#ai_phone1").removeClass("req");
        $("#div_ai_phone1").hide();
        $("#ai_phone2").removeClass("req");
        $("#div_ai_phone2").hide();
    });
        
    
    
    $("#sendData").click( function() {

           if ( $("#ai_phone2").val()=="" && $("#ai_phone1").val()=="")
           {
               sw = false; 
               $("#div_ai_phone1").show(); 
               $("#ai_phone1").addClass("req");   
               $('body').scrollTo('#ai_phone1', 500);

               return false;
           } else { 
               sw = true; 
           }

           if (document.getElementById("afil_1").checked == true || document.getElementById("afil_2").checked == true || document.getElementById("afil_3").checked == true || document.getElementById("afil_4").checked == true || document.getElementById("afil_5").checked == true ) 
           {
               sw1= true;
           } else {
               sw1= false; 
               $("#div_ai_afil1").show(); 
               $('body').scrollTo('#afil_1', 500);
               return false;
           }


           if (sw && sw1)       
           { return true; } else { return false; }


    });

    $("#addcertificacion").click( function( event ){
        
        event.preventDefault();        
        var nextrow = formatinteger( $("#maxrow").val() );        
                
        $("#tablecertificacion > tbody").append("<tr id=\"row_"+nextrow+"\"><td align=\"center\"><input name=\"inputA_"+nextrow+"\" type=\"text\" id=\"inputA_"+nextrow+"\" size=\"50\" class=\"inpC2\" ></td><td align=\"center\"><input onblur=\"saveUPD(6);\" name=\"inputB_"+nextrow+"\" type=\"text\" id=\"inputB_"+nextrow+"\" size=\"40\" class=\"inpC2\" ></td><td width=\"10%\" align=\"center\"><a href=\"#\" class=\"lnkCls\" id=\"delcerti_"+nextrow+"\" onclick=\"delRow("+nextrow+");return false;\" >eliminar</a></td></tr>");        
        nextrow = nextrow + 1;
        $("#maxrow").val( nextrow );
    } );    
    
});

function delRow( numero ) {       
    var co = confirm( "¿Esta seguro de eliminar este registro?" );
    if( co ) {                
        $.ajax( {
            url: "acap1planDel.php",
            data: "uid="+numero,
            type: "POST",
            success: function( ) {            
                $("#row_"+numero).hide();
                $("#row_"+numero).remove();                                
            }
        });
    }    

    return false;        
}


function showMunicipios(){   
  var uid;
  uid = document.getElementById("ai_depto").value;    	
  $.ajax({
	  type: "POST",
	  url: "municipiosList.php",
	  data: "uid="+uid,
	  success: function( resp ){		  
		  $("#areamunicipio").html(resp);		  
	  }
  });   
  
  
};

function showAfilCamara() {        
    var chkIsChecked = document.getElementById("afil_1").checked;
    if( chkIsChecked ) {
        $("#afil_camara").show();
        document.getElementById("afil_5").checked = false;
    } else {
        $("#afil_camara").val("");
        $("#afil_camara").hide();
    }
    
    $("#div_ai_afil1").hide();
};

function showAfilFederacion() {        
    var chkIsChecked = document.getElementById("afil_2").checked;
    if( chkIsChecked ) {
        $("#afil_federacion").show();
        document.getElementById("afil_5").checked = false;
    } else {
        $("#afil_federacion").val("");
        $("#afil_federacion").hide();
    }
    $("#div_ai_afil1").hide();
};

function showAfilAsociacion() {        
    var chkIsChecked = document.getElementById("afil_3").checked;
    if( chkIsChecked ) {
        $("#afil_asociacion").show();
        document.getElementById("afil_5").checked = false;
    } else {
        $("#afil_asociacion").val("");
        $("#afil_asociacion").hide();
    }
    $("#div_ai_afil1").hide();
};

function showAfilOtros() {        
    var chkIsChecked = document.getElementById("afil_4").checked;
    if( chkIsChecked ) {
        $("#afil_otros").show();
        document.getElementById("afil_5").checked = false;
    } else {
        $("#afil_otros").val("");
        $("#afil_otros").hide();
    }
    $("#div_ai_afil1").hide();
};

function showSindicato() {        
    var chkIsChecked = document.getElementById("afil_6").checked;
    if( chkIsChecked ) {
        $("#afil_sindicato").show();
        document.getElementById("afil_5").checked = false;
    } else {
        $("#afil_sindicato").val("");
        $("#afil_sindicato").hide();
    }
    $("#div_ai_afil1").hide();
};

function showAfilNinguno() {        
    
    var chkIsChecked = document.getElementById("afil_5").checked;
    if( chkIsChecked ) {
        document.getElementById("afil_1").checked = false;
        document.getElementById("afil_2").checked = false;
        document.getElementById("afil_3").checked = false;
        document.getElementById("afil_4").checked = false;
        document.getElementById("afil_6").checked = false;
        $("#afil_camara").val("")
        $("#afil_camara").hide();
        $("#afil_federacion").val("");
        $("#afil_federacion").hide();
        $("#afil_asociacion").val("");
        $("#afil_asociacion").hide();
        $("#afil_otros").val("");
        $("#afil_otros").hide();
        $("#afil_sindicato").val("");
        $("#afil_sindicato").hide();        
    }
    $("#div_ai_afil1").hide();
};

function saveUPD(inp){
    var sw=0, sUrl;    
    switch( inp ) {
        case 1: sw = 1; sUrl = "acap1Upd.php"; break;
        case 6: sw = 1; sUrl = "acap1UpdDir.php"; break;
    }

    if( sw == 1 ) {
        $.ajax({
            type:"POST",
            url: sUrl,
            cache: false,
            data: $(".formA").serialize()+'&tabla='+inp,
            success: function (data) {
                $("#statusACAP1").html('<div class="bxS"><img alt="Guardado" src="../lib/ico_chk.gif">guardado</div>');   
            }
        });

        $("#statusACAP1").hide(1600);
    }

}