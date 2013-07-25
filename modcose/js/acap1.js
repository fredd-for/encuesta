
$(document).ready( function() {    

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
});




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

function showAfilNinguno() {        
    
    var chkIsChecked = document.getElementById("afil_5").checked;
    if( chkIsChecked ) {
        document.getElementById("afil_1").checked = false;
        document.getElementById("afil_2").checked = false;
        document.getElementById("afil_3").checked = false;
        document.getElementById("afil_4").checked = false;
        $("#afil_camara").val("")
        $("#afil_camara").hide();
        $("#afil_federacion").val("");
        $("#afil_federacion").hide();
        $("#afil_asociacion").val("");
        $("#afil_asociacion").hide();
        $("#afil_otros").val("");
        $("#afil_otros").hide();        
    }
    $("#div_ai_afil1").hide();
};

function saveUPD(inp){
if (inp==1) {
    
    $("#statusACAP1").html('<div class="bxSL"><img alt="Guardando" src="lib/load.gif">guardando</div>');
    var datos="pack=1&ai_rs="+$("#ai_rs").val()+"&ai_societario="+$("#ai_societario").val()+"&ai_tradename="+$("#ai_tradename").val();
$.ajax({
            type:"POST",
            url: "acap1Upd.php",
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
            url: "acap1Upd.php",
            cache: false,
            data: "pack=2&ai_nit="+$("#ai_nit").val()+"&ai_traderegis="+$("#ai_traderegis").val()+"&ai_depto="+$("#ai_depto").val()+"&ai_municipio="+$("#ai_municipio").val()+"&ai_city="+$("#ai_city").val()+"&ai_zona="+$("#ai_zona").val()+"&ai_address="+$("#ai_address").val()+"&ai_reference="+$("#ai_reference").val(),
            success: function (data) {
                $("#statusACAP1").html('<div class="bxS"><img alt="Guardado" src="../lib/ico_chk.gif">guardado</div>');   
            },
            complete: function (data) {
                  $("#statusACAP1").fadeOut(1600, "linear");
            }
});  
};
if (inp==3) {
      $("#statusACAP1").html('<div class="bxSL"><img alt="Guardando" src="lib/load.gif">guardando</div>');
  $.ajax({
            type:"POST",
            url: "acap1Upd.php",
            cache: false,
            data: "pack=3&ai_phone1="+$("#ai_phone1").val()+"&ai_phone2="+$("#ai_phone2").val()+"&ai_fax="+$("#ai_fax").val()+"&ai_pagweb="+$("#ai_pagweb").val(),
            success: function (data) {
                $("#statusACAP1").html('<div class="bxS"><img alt="Guardado" src="../lib/ico_chk.gif">guardado</div>');   
            },
            complete: function (data) {
                  $("#statusACAP1").fadeOut(1600, "linear");
            }
}); 
};
if (inp==4) {
      $("#statusACAP1").html('<div class="bxSL"><img alt="Guardando" src="lib/load.gif">guardando</div>');
     $.ajax({
            type:"POST",
            url: "acap1Upd.php",
            cache: false,
            data: "pack=4&ai_email="+$("#ai_email").val(),
                        success: function (data) {
                $("#statusACAP1").html('<div class="bxS"><img alt="Guardado" src="../lib/ico_chk.gif">guardado</div>');   
            },
            complete: function (data) {
                  $("#statusACAP1").fadeOut(1600, "linear");
            }
}); 
};

if (inp==5) {
      $("#statusACAP1").html('<div class="bxSL"><img alt="Guardando" src="lib/load.gif">guardando</div>');
     $.ajax({
            type:"POST",
            url: "acap1Upd.php",
            cache: false,
            data: "pack=5&ai_actprin="+$("#ai_actprin").val()+"&ai_actsec1="+$("#ai_actsec1").val()+"&ai_actsec2="+$("#ai_actsec2").val(),
                        success: function (data) {
                $("#statusACAP1").html('<div class="bxS"><img alt="Guardado" src="../lib/ico_chk.gif">guardado</div>');   
            },
            complete: function (data) {
                  $("#statusACAP1").fadeOut(1600, "linear");
            }
}); 
};

if (inp==6) {
    $("#statusACAP1").html('<div class="bxSL"><img alt="Guardando" src="lib/load.gif">guardando</div>');
    $.ajax({
        type:"POST",
        url: "acap1Upd2.php",
        cache: false,
        data: $(".formA").serialize(),
        success: function (data) {
            $("#statusACAP1").html('<div class="bxS"><img alt="Guardado" src="../lib/ico_chk.gif">guardado</div>');   
        },
        complete: function (data) {
              $("#statusACAP1").fadeOut(1600, "linear");
        }
    });
};

}
