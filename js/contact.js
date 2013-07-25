$(document).ready(function(){
	 
    $("#formContact input").keypress(function(){
        domain = $('#domain').val();
        $("#formContact").attr('action',domain+'/skin/contactSend'+'.'+'php');
    });
    
    $('#formContact input').bind('paste', null, function() {
        domain = $('#domain').val();
        $("#formContact").attr('action',domain+'/skin/contactSend'+'.'+'php');
    });
    
    // hide message 
    if( $('#messageBox').html()!='' ) {
        $('#messageBox').fadeIn(800, function() {
            setTimeout(function(){
                $('#messageBox').fadeOut(800)
            },4000);
        });
    }
});
