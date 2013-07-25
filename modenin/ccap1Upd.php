<?php session_start(); header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");
include_once('../verifyLogin.php'); 

$dato = array(); // 0,1
$desc = array(); // string
$cant1 = array(); // number
$cant2 = array(); // number

$in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("nrolineas")),'Text');
$cant1[248] = preg_replace('/,/', '', $in1);

$in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("nrocelular")),'Text');
$cant1[249] = preg_replace('/,/', '', $in1);

$dato[250] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("rbtn_radioafi")),'Number');

$in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("nro_pcs")),'Text');
$cant1[251] = preg_replace('/,/', '', $in1);

$dato[252] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("rbtn_usointer")),'Number');

$dato[253] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("rbtn_usointra")),'Number');

// 7. cual es el tipo de conexion a internet utilizado
$ci1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("coninter_1")),'Text');
$ci2 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("coninter_2")),'Text');
$ci3 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("coninter_3")),'Text');
$ci4 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("coninter_4")),'Text');
$ci5 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("coninter_5")),'Text');
$coninter_otro = OPERATOR::toSql(safeHTML(OPERATOR::getParam("coninter_otro")),'Text');

if( $ci1 == 'on' ) { $ci1 = 1; } else { $ci1 = 0; }
if( $ci2 == 'on' ) { $ci2 = 1; } else { $ci2 = 0; }
if( $ci3 == 'on' ) { $ci3 = 1; } else { $ci3 = 0; }
if( $ci4 == 'on' ) { $ci4 = 1; } else { $ci4 = 0; }
if( $ci5 == 'on' ) { $ci5 = 1; } else { $ci5 = 0; $coninter_otro = ""; }

$dato[255] = $ci1;
$dato[256] = $ci2;
$dato[257] = $ci3;
$dato[258] = $ci4;
$dato[259] = $ci5;
$desc[259] = $coninter_otro;

// 8. cual es el ancho de banda con el que cuenta la empresa
$an1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("ancho_1")),'Text');
$an2 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("ancho_2")),'Text');
$an3 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("ancho_3")),'Text');
$an4 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("ancho_4")),'Text');
$an5 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("ancho_5")),'Text');
$an6 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("ancho_6")),'Text');
$ancho_otro = OPERATOR::toSql(safeHTML(OPERATOR::getParam("ancho_otro")),'Text');

if( $an1 == 'on' ) { $an1 = 1; } else { $an1 = 0; }
if( $an2 == 'on' ) { $an2 = 1; } else { $an2 = 0; }
if( $an3 == 'on' ) { $an3 = 1; } else { $an3 = 0; }
if( $an4 == 'on' ) { $an4 = 1; } else { $an4 = 0; }
if( $an5 == 'on' ) { $an5 = 1; } else { $an5 = 0; }
if( $an6 == 'on' ) { $an6 = 1; } else { $an6 = 0; $ancho_otro = ""; }

$dato[261] = $an1;
$dato[262] = $an2;
$dato[263] = $an3;
$dato[264] = $an4;
$dato[265] = $an5;
$dato[266] = $an6;
$desc[266] = $ancho_otro;

if( $dato[252] == 0 ) {
    $dato[255] = 0;
    $dato[256] = 0;
    $dato[257] = 0;
    $dato[258] = 0;
    $dato[259] = 0;
    $desc[259] = "";

    $dato[261] = 0;
    $dato[262] = 0;
    $dato[263] = 0;
    $dato[264] = 0;
    $dato[265] = 0;
    $dato[266] = 0;
    $desc[266] = "";
}

// personal administrativo y produccion
$admA_1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("admA_1")),'Text');
$cant1[267] = preg_replace('/,/', '', $admA_1);
$admB_1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("admB_1")),'Text');
$cant2[267] = preg_replace('/,/', '', $admB_1);

$admA_2 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("admA_2")),'Text');
$cant1[268] = preg_replace('/,/', '', $admA_2);
$admB_2 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("admB_2")),'Text');
$cant2[268] = preg_replace('/,/', '', $admB_2);

$admA_3 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("admA_3")),'Text');
$cant1[269] = preg_replace('/,/', '', $admA_3);
$admB_3 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("admB_3")),'Text');
$cant2[269] = preg_replace('/,/', '', $admB_3);

$dato[270] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("rbtn_usointeradm")),'Number');


$ac1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("activity_1")),'Text');
$ac2 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("activity_2")),'Text');
$ac3 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("activity_3")),'Text');
$ac4 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("activity_4")),'Text');
$ac5 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("activity_5")),'Text');
$ac6 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("activity_6")),'Text');
$ac7 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("activity_7")),'Text');

if( $ac1 == 'on' ) { $ac1 = 1; } else { $ac1 = 0; }
if( $ac2 == 'on' ) { $ac2 = 1; } else { $ac2 = 0; }
if( $ac3 == 'on' ) { $ac3 = 1; } else { $ac3 = 0; }
if( $ac4 == 'on' ) { $ac4 = 1; } else { $ac4 = 0; }
if( $ac5 == 'on' ) { $ac5 = 1; } else { $ac5 = 0; }
if( $ac6 == 'on' ) { $ac6 = 1; } else { $ac6 = 0; }
if( $ac7 == 'on' ) { $ac7 = 1; } else { $ac7 = 0; }

$dato[272] = $ac1;
$dato[273] = $ac2;
$dato[274] = $ac3;
$dato[275] = $ac4;
$dato[276] = $ac5;
$dato[277] = $ac6;
$dato[278] = $ac7;

$dato[270] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("rbtn_usointeradm")),'Number');

$dato[279] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("rbtn_web")),'Text');

$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];

$btnsubmit = OPERATOR::toSql(safeHTML(OPERATOR::getParam("continuarregistro")),'Text');

// obtener el uid del token
$uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );
    
if( !empty($regisroUID)  ) {

    $sql = "SELECT * FROM frm2_ccap1_usoaccesotic WHERE usac_regi_uid = '".$regisroUID."' ";
    $db->query($sql);

    while ( $aTic = $db->next_record() ) {
        $sql  = "UPDATE frm2_ccap1_usoaccesotic SET ";        
        $sql .= "usac_valor = '".$dato[$aTic["usac_defi_uid"]]."', ";        
        $sql .= "usac_description = UPPER('".utf8_decode($desc[$aTic["usac_defi_uid"]])."'), ";        
        $sql .= "usac_cantidad1 = '".$cant1[$aTic["usac_defi_uid"]]."', ";
        $sql .= "usac_cantidad2 = '".$cant2[$aTic["usac_defi_uid"]]."', ";
        $sql .= "usac_suv_uid = '".$uid_token."', ";
        $sql .= "usac_updatedate = NOW() ";
        $sql .= "WHERE usac_regi_uid = '".$regisroUID."' AND usac_defi_uid = '".$aTic["usac_defi_uid"]."' ";         
        $db2->query($sql);
    }
    
    // editar
    $sql = "SELECT * FROM  frm2_ccap1_2aplicaciones WHERE apli_regi_uid = '".$regisroUID."' ";
    $db->query($sql);
    if( $db->numrows() > 0 ) {
        for( $i = 1; $i<=6; $i++ ) {
            $prog = OPERATOR::toSql(safeHTML(OPERATOR::getParam("prog_".$i)),'Text');
            if( $prog == 'on' ){ $prog = 1; } else { $prog = 0; }
            
            $nomprog = OPERATOR::toSql(safeHTML(OPERATOR::getParam("B_".$i)),'Text');
            $cantNal = OPERATOR::toSql(safeHTML(OPERATOR::getParam("C_".$i)),'Text');
            $cantNal = preg_replace('/,/', '', $cantNal);
            $cantImportado = OPERATOR::toSql(safeHTML(OPERATOR::getParam("D_".$i)),'Text');
            $cantImportado = preg_replace('/,/', '', $cantImportado);
            
            $tot = $cantNal + $cantImportado;
            
            if( $prog == 0 && false ) {
                $nomprog = "";
                $cantNal = 0;
                $cantImportado = 0;
                $tot = 0;
            }                        
            
            if( !empty( $nomprog ) && $tot > 0 ) {
                $sql2 = " UPDATE frm2_ccap1_2aplicaciones SET apli_valor = '".$prog."', apli_nombre = UPPER('".utf8_decode($nomprog)."'), apli_cantidadnacional = '".$cantNal."', "
                       ." apli_cantidadimportado = '".$cantImportado."', apli_total = '".$tot."', apli_suv_uid = '".$uid_token."', apli_updatedate = NOW() "
                       ." WHERE apli_regi_uid = '".$regisroUID."' AND apli_position = '".$i."'  ";
                $db->query( $sql2 );
            } else {
                $sql2 = " UPDATE frm2_ccap1_2aplicaciones SET apli_valor = '".$prog."', apli_nombre = '', apli_cantidadnacional = '0', "
                       ." apli_cantidadimportado = '0', apli_total = '0', apli_suv_uid = '".$uid_token."', apli_updatedate = NOW() "
                       ." WHERE apli_regi_uid = '".$regisroUID."' AND apli_position = '".$i."'  ";
                $db->query( $sql2 );
            }
        }
    } else {
    // crear
        $nroregistros = 6;
        for( $i = 1; $i<=$nroregistros; $i++ ) {
            $prog = OPERATOR::toSql(safeHTML(OPERATOR::getParam("prog_".$i)),'Text');
            if( $prog == 'on' ){ $prog = 1; } else { $prog = 0; }
            
            $nomprog = OPERATOR::toSql(safeHTML(OPERATOR::getParam("B_".$i)),'Text');
            $cantNal = OPERATOR::toSql(safeHTML(OPERATOR::getParam("C_".$i)),'Text');
            $cantNal = preg_replace('/,/', '', $cantNal);
            $cantImportado = OPERATOR::toSql(safeHTML(OPERATOR::getParam("D_".$i)),'Text');
            $cantImportado = preg_replace('/,/', '', $cantImportado);
            
            $tot = $cantNal + $cantImportado;
            
            $sql2 = " INSERT INTO  frm2_ccap1_2aplicaciones ( apli_regi_uid, apli_valor, apli_nombre, apli_cantidadnacional, "
                   ." apli_cantidadimportado, apli_total, apli_position, apli_suv_uid, apli_createdate, apli_updatedate ) "
                   ." VALUES( '".$regisroUID."', '".$prog."', UPPER('".utf8_decode($nomprog)."'), '".$cantNal."', '".$cantImportado."', '".$tot."', $i , '".$uid_token."', NOW(), NOW() )";
            $db->query( $sql2 );                        
        }
    }
    
}
?>