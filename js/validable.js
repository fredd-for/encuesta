// JavaScript Document
// JavaScript Document 
// Validate with jquery version 1.3
// more validations added and uses name instead if div

	var filters = {
			required: function(el) {return ($(el).val() != '' && $(el).val() != -1);},
			email: function(el) {return /^[A-Za-z][A-Za-z0-9_\.\-]*@[A-Za-z0-9_\-]+\.[A-Za-z0-9_.\-]+[A-za-z]$/.test($(el).val());},
			numeric: function(el){return /^[0-9,]*$/.test($(el).val());},
			integer: function(el){return /^[0-9]*?[0-9]*$/.test($(el).val());},
			currency: function(el){return /^[0-9]*\.?[0-9]{0,2}$/.test($(el).val());},
			alpha: function(el){return /^[a-zA-Z áéíóúAÉÍÓÚÑñ\.,;:\|)"(º_@><#&'\?¿¡!/\\%\$=]*$/.test($(el).val());},
			alphanum: function(el){return /^[a-zA-Z0-9 áéíóúAÉÍÓÚÑñëïüÿâêîôûæç\.,;:\|)"(º_@><#&'\?¿¡!/\\%\$=]*$/.test($(el).val());},
			password: function(el){return /^[a-zA-Z0-9+áéíóúAÉÍÓÚÑñëïüÿâêîôûæç\.,;:\|)"(º_@><#&'\?¿¡!/\\%\$=]*$/.test($(el).val());}
		};	


$.extend({
		/* PARAMOS LA EJECUCIÓN*/
		stop: function(e){
        if (e.preventDefault) e.preventDefault();
        if (e.stopPropagation) e.stopPropagation();
    }, 
    /* PERSONALIZAMOS LA SALIDA POR PANTALLA */
    alert: function(str) {
    	alert(str);	
    }
});

function loadValidable(){
    //on submit
  
    $("form.validable").bind("submit", function(e){
        
        var sw = 1;
        if (typeof filters == 'undefined') return;
        $(this).find("input").each(function(x,el){ 

            if ($(el).attr("className") != 'undefined') {
                $(el).removeClass("req");
                $.each(new String($(el).attr("className")).split(" "), function(x, klass){
                    if ($.isFunction(filters[klass]))
                        if (!filters[klass](el)){
                            $(el).addClass("req");
                            
                            
                            if(sw == 1 ) {
                                var iditem = $(el).attr("id");
                                $('body').scrollTo('#'+iditem, 500);
                                sw = 0;
                            }
                            
                            var idName = $(el).attr("name");
                            if($(el).val()==''){
                                $("#div_"+idName).show();
                            } else {
                                $("#div_"+idName+"_2").show();
                            }
                        }
                });
            }
        });

        $(this).find("textarea, select").each(function(x, el){
		
            if ($(el).attr("className") != 'undefined') {
                
                $.each(new String($(el).attr("className")).split(" "), function(x, klass){
                    if ($.isFunction(filters[klass]))
                        if (!filters[klass](el)){
                            //$(el).addClass("reqA");
                            $(el).addClass("req");
                            
                            if(sw == 1 ) {
                                var iditem = $(el).attr("id");
                                $('body').scrollTo('#'+iditem, 500);
                                sw = 0;
                            }                        
                            var idName = $(el).attr("name");
                            if($(el).val()==''){
                                $("#div_"+idName).show();
                            }
                            else{
                                $("#div_"+idName+"_2").show();
                            }
                        }
                });
            }
         
         
        });
        if ( $(this).find(".req").size() > 0  || $(this).attr('action')=='' ) {
            $.stop(e || window.event); 
            return false;
        } else {
            $('#loading').show();
            return true;
        }
	});

// on focus	remueve los tag de error
	$("form.validable").find("input, textarea, select").each(function(x,el){ 
		$(el).bind("focus",function(e){
				if ($(el).attr("className") != 'undefined') { 
								$(el).removeClass("req");
        $(el).removeClass("reqA");
						var idName = $(el).attr("name");
						$("#div_"+idName).hide();
						$("#div_"+idName+"_2").hide();
				}
		});
	});
// end 

  
}

$(document).ready(function(){
    loadValidable();            
       
});