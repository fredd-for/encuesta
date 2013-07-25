function saveUPD(inp){
    var sw=0;    
    switch( inp ) {
        case 1: sw = 1; break;
    }
    
    if( sw == 1 ) {
        $.ajax({
            type:"POST",
            url: "dcap1eUpd.php",
            cache: false,
            data: $(".formA").serialize()+'&tabla='+inp,
            success: function (data) {
                $("#statusACAP1").html('<div class="bxS"><img alt="Guardado" src="../lib/ico_chk.gif">guardado</div>');   
            }
        });
                
        $("#statusACAP1").hide(1600);
    }
}