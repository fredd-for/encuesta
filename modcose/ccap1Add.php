<?php session_start(); header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");
include_once('../verifyLogin.php');
$desc = array();
$dat = array();


$dat[73] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("internet")),'Text'); // 1
if( $dat[73] == 'on' ){ $dat[73] = 1; } else { $dat[73] = 0; }
$dat[74] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("intranet")),'Text'); // 2
if( $dat[74] == 'on' ){ $dat[74] = 1; } else { $dat[74] = 0; }
$dat[89] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("nocuenta")),'Text'); // 3
if( $dat[89] == 'on' ){ $dat[89] = 1; } else { $dat[89] = 0; }

$uso_pc = OPERATOR::toSql(safeHTML(OPERATOR::getParam("uso_pc")),'Text'); // 
$desc[75] = preg_replace('/,/', '', $uso_pc);


$dat[76]  = OPERATOR::toSql(safeHTML(OPERATOR::getParam("rbtn_usointer")),'Number'); //

// actividades
$dat[77]  = OPERATOR::toSql(safeHTML(OPERATOR::getParam("activity_1")),'Text'); //

if( $dat[77] == 'on' ){ $dat[77] = 1; } else { $dat[77] = 0; }
$dat[78]  = OPERATOR::toSql(safeHTML(OPERATOR::getParam("activity_2")),'Text'); //
if( $dat[78] == 'on' ){ $dat[78] = 1; } else { $dat[78] = 0; }
$dat[79]  = OPERATOR::toSql(safeHTML(OPERATOR::getParam("activity_3")),'Text'); //
if( $dat[79] == 'on' ){ $dat[79] = 1; } else { $dat[79] = 0; }
$dat[80]  = OPERATOR::toSql(safeHTML(OPERATOR::getParam("activity_4")),'Text'); //
if( $dat[80] == 'on' ){ $dat[80] = 1; } else { $dat[80] = 0; }
$dat[81]  = OPERATOR::toSql(safeHTML(OPERATOR::getParam("activity_5")),'Text'); //
if( $dat[81] == 'on' ){ $dat[81] = 1; } else { $dat[81] = 0; }
$dat[82]  = OPERATOR::toSql(safeHTML(OPERATOR::getParam("activity_6")),'Text'); //
if( $dat[82] == 'on' ){ $dat[82] = 1; } else { $dat[82] = 0; }
$dat[83]  = OPERATOR::toSql(safeHTML(OPERATOR::getParam("activity_7")),'Text'); //
if( $dat[83] == 'on' ){ $dat[83] = 1; } else { $dat[83] = 0; }

// conexión a Internet utilizad

$dat[84]  = OPERATOR::toSql(safeHTML(OPERATOR::getParam("coninter_1")),'Text'); //
if( $dat[84] == 'on' ){ $dat[84] = 1; } else { $dat[84] = 0; }
$dat[85]  = OPERATOR::toSql(safeHTML(OPERATOR::getParam("coninter_2")),'Text'); //
if( $dat[85] == 'on' ){ $dat[85] = 1; } else { $dat[85] = 0; }
$dat[86]  = OPERATOR::toSql(safeHTML(OPERATOR::getParam("coninter_3")),'Text'); //
if( $dat[86] == 'on' ){ $dat[86] = 1; } else { $dat[86] = 0; }
$dat[87]  = OPERATOR::toSql(safeHTML(OPERATOR::getParam("coninter_4")),'Text'); //
if( $dat[87] == 'on' ){ $dat[87] = 1; } else { $dat[87] = 0; }
$dat[88]  = OPERATOR::toSql(safeHTML(OPERATOR::getParam("coninter_5")),'Text'); //
if( $dat[88] == 'on' ){ $dat[88] = 1; } else { $dat[88] = 0; }
$desc[88] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("coninter_otro")),'Text');

// si la empresa no utiliza internet hacer ceros los campos de la preg 4 y 5
if( $dat[76] == 0 ) {
    $dat[77] = 0;
    $dat[78] = 0;
    $dat[79] = 0;
    $dat[80] = 0;
    $dat[81] = 0;
    $dat[82] = 0;
    $dat[83] = 0;
    $dat[84] = 0;
    $dat[85] = 0;
    $dat[86] = 0;
    $dat[87] = 0;
    $dat[88] = 0;
    $desc[88] = "";    
}

/* usuario */
$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];


$btnsubmit = OPERATOR::toSql(safeHTML(OPERATOR::getParam("continuarregistro")),'Text');

// obtener el uid del token
$uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );
    
if( !empty($regisroUID)  ) {      

    $sql = "SELECT * FROM  frm1_ccap1_usoaccesotic WHERE usac_regi_uid = '".$regisroUID."' ";
    $db->query($sql);

    //echo $sql;
    while ( $aTIC = $db->next_record() ) {            
        $sql  = "UPDATE frm1_ccap1_usoaccesotic SET ";        
        $sql .= "usac_valor = '".$dat[$aTIC["usac_defi_uid"]]."', ";
        $sql .= "usac_description = UPPER('".$desc[$aTIC["usac_defi_uid"]]."') , ";
        $sql .= "usac_suv_uid = '".$uid_token."', ";
        $sql .= "usac_updatedate = NOW() ";
        $sql .= "WHERE usac_regi_uid = '".$regisroUID."' AND usac_defi_uid = '".$aTIC["usac_defi_uid"]."' ";  
        $db2->query($sql);
        
    }           
    
    // editar
    $sql = "SELECT * FROM frm1_ccap1_2aplicaciones WHERE apli_regi_uid = '".$regisroUID."' ";
    $db->query($sql);
    if( $db->numrows() > 0 ) {
        for( $i = 1; $i<=5; $i++ ) {
            $prog = OPERATOR::toSql(safeHTML(OPERATOR::getParam("prog_".$i)),'Text');
            if( $prog == 'on' ){ $prog = 1; } else { $prog = 0; }
            
            $nomprog = OPERATOR::toSql(safeHTML(OPERATOR::getParam("nomprog_".$i)),'Text');
            $cantNal = OPERATOR::toSql(safeHTML(OPERATOR::getParam("inputA-".$i)),'Text');
            $cantNal = preg_replace('/,/', '', $cantNal);
            $cantImportado = OPERATOR::toSql(safeHTML(OPERATOR::getParam("inputB-".$i)),'Text');
            $cantImportado = preg_replace('/,/', '', $cantImportado);
            
            $tot = $cantNal + $cantImportado;
            
            if( $prog == 0 && false ) {
                $nomprog = "";
                $cantNal = 0;
                $cantImportado = 0;
                $tot = 0;
            }                        
            
            if( !empty( $nomprog ) && $tot > 0 ) {
                $sql2 = " UPDATE frm1_ccap1_2aplicaciones SET apli_valor = '".$prog."', apli_nombre = UPPER('".$nomprog."'), apli_cantidadnacional = '".$cantNal."', "
                       ." apli_cantidadimportado = '".$cantImportado."', apli_total = '".$tot."', apli_suv_uid = '".$uid_token."', apli_updatedate = NOW() "
                       ." WHERE apli_regi_uid = '".$regisroUID."' AND apli_position = '".$i."'  ";
                $db->query( $sql2 );
            }
        }
    } else {
    // crear
        $nroregistros = 5;
        for( $i = 1; $i<=$nroregistros; $i++ ) {
            $prog = OPERATOR::toSql(safeHTML(OPERATOR::getParam("prog_".$i)),'Text');
            if( $prog == 'on' ){ $prog = 1; } else { $prog = 0; }
            
            $nomprog = OPERATOR::toSql(safeHTML(OPERATOR::getParam("nomprog_".$i)),'Text');
            $cantNal = OPERATOR::toSql(safeHTML(OPERATOR::getParam("inputA-".$i)),'Text');
            $cantNal = preg_replace('/,/', '', $cantNal);
            $cantImportado = OPERATOR::toSql(safeHTML(OPERATOR::getParam("inputB-".$i)),'Text');
            $cantImportado = preg_replace('/,/', '', $cantImportado);
            
            $tot = $cantNal + $cantImportado;
            
            $sql2 = " INSERT INTO frm1_ccap1_2aplicaciones ( apli_regi_uid, apli_valor, apli_nombre, apli_cantidadnacional, "
                   ." apli_cantidadimportado, apli_total, apli_position, apli_suv_uid, apli_createdate, apli_updatedate ) "
                   ." VALUES( '".$regisroUID."', '".$prog."', UPPER('".$nomprog."'), '".$cantNal."', '".$cantImportado."', '".$tot."', $i , '".$uid_token."', NOW(), NOW() )";
            $db->query( $sql2 );                        
        }
    }
}

if( !empty( $btnsubmit ) ) {
    header("Location: bol1.php");
}
?>