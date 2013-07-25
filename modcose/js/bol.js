$(function() {                     
    $('#sendData').click(function( e ) {        
        $("#formA").hide();
        $('#areaprint').printArea();
        return false;              
        e.preventDefault();
    })                      
} );