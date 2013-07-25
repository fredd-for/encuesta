<?php session_start(); header("Expires: Mon, 26 Jul 4247 05:00:00 GMT");
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");
include_once('../verifyLogin.php');
$dat = array();
$desc = array();

// inversiones
$dat[422] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("rbtn_inv")),'Text'); //gastos o inversión
// opcion no
$dat[423] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("chk_1")),'Text');
$dat[424] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("chk_2")),'Text');
$dat[425] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("chk_3")),'Text'); //otros

$desc[425] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("inversionotros")),'Text'); // descripcion

if( $dat[422] == 1 ) {
    $dat[423] = 0;
    $dat[424] = 0;
    $dat[425] = 0;
    $desc[425] = "";
}

if( !empty( $dat[423] ) ) { $dat[423] = 1; }
if( !empty( $dat[424] ) ) { $dat[424] = 1; }
if( !empty( $dat[425] ) ) { $dat[425] = 1; } else { $desc[425] = "";  }

// opcion si

$a1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("activity_1")),'Text');  // 1
$a2 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("activity_2")),'Text');  // 2
$a3 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("activity_3")),'Text');  // 3
$a4 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("activity_4")),'Text');  // 4
$a5 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("activity_5")),'Text');  // 5
$a6 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("activity_6")),'Text');  // 6
$a7 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("activity_7")),'Text');  // 7
$a8 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("activity_8")),'Text');  // 8
$desc[433] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("otrosgestion")),'Text');  // 8 desc

if( !empty( $a1 ) ) { $a1 = 1; } else { $a1 = 0; }
if( !empty( $a2 ) ) { $a2 = 1; } else { $a2 = 0; }
if( !empty( $a3 ) ) { $a3 = 1; } else { $a3 = 0; }
if( !empty( $a4 ) ) { $a4 = 1; } else { $a4 = 0; }
if( !empty( $a5 ) ) { $a5 = 1; } else { $a5 = 0; }
if( !empty( $a6 ) ) { $a6 = 1; } else { $a6 = 0; }
if( !empty( $a7 ) ) { $a7 = 1; } else { $a7 = 0; }
if( !empty( $a8 ) ) { $a8 = 1; } else { $a8 = 0; }

$dat[426] = $a1; 
$dat[427] = $a2;
$dat[428] = $a3;
$dat[429] = $a4;
$dat[430] = $a5;
$dat[431] = $a6;
$dat[432] = $a7;
$dat[433] = $a8;

if( $dat[422] == 0 ) {
    $dat[426] = 0; 
    $dat[427] = 0;
    $dat[428] = 0;
    $dat[429] = 0;
    $dat[430] = 0;
    $dat[431] = 0;
    $dat[432] = 0;
    $dat[433] = 0;
    $desc[433]  = "";
}

// gastos corrientes
// opcion no
$dat[434] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("rbtn_gastos")),'Text');
$dat[435] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("chk_g1")),'Text');
$dat[436] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("chk_g2")),'Text');
$dat[437] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("chk_g3")),'Text'); //otros

$desc[437] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("txt_gastos")),'Text'); // descripcion

if( $dat[434] == 1 ) {
    $dat[435] = 0;
    $dat[436] = 0;
    $dat[437] = 0;
    $desc[437] = "";
}

if( !empty( $dat[435] ) ) { $dat[435] = 1; }
if( !empty( $dat[436] ) ) { $dat[436] = 1; }
if( !empty( $dat[437] ) ) { $dat[437] = 1; } else { $desc[437] = "";  }


//opcion si
$aGasto = array();
for( $i = 1; $i<=16; $i++ ) {
    $a1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("gastos_".$i)),'Text');    
    if( $dat[434] == 0 ) {
        $aGasto[$i] = 0;
    } else {        
        if( !empty( $a1 ) ) { $aGasto[$i] = 1; } else { $aGasto[$i] = 0; }
    }
}
$dat[438] = $aGasto[1]; 
$dat[439] = $aGasto[2]; 
$dat[440] = $aGasto[3];
$dat[441] = $aGasto[4];
$dat[442] = $aGasto[5];
$dat[443] = $aGasto[6]; 
$dat[444] = $aGasto[7];
$dat[445] = $aGasto[8];
$dat[446] = $aGasto[9];
$dat[447] = $aGasto[10];
$dat[448] = $aGasto[11];
$dat[449] = $aGasto[12];
$dat[450] = $aGasto[13];
$dat[451] = $aGasto[14];
$dat[452] = $aGasto[15];
$dat[453] = $aGasto[16];

$desc[453] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("txt_otrosgastos")),'Text');


// descripcion
$dat[454] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("rbtn_rs")),'Text');
$dat[455] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("rbtn_vr")),'Text');
$dat[456] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("rbtn_ta")),'Text');
$dat[457] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("rbtn_eas")),'Text');


/* usuario */
$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];


$btnsubmit = OPERATOR::toSql(safeHTML(OPERATOR::getParam("continuarregistro")),'Text');

// obtener el uid del token
$uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );
    
if( !empty($regisroUID)  ) {   

    $sql = "SELECT * FROM frm3_bcap1_gestionambiental WHERE geam_regi_uid = '".$regisroUID."' ";
    $db->query($sql);

    //echo $sql;
    while ( $aGesAmb = $db->next_record() ) {         
        $sql  = "UPDATE frm3_bcap1_gestionambiental SET ";
        $sql .= "geam_valor = '".$dat[$aGesAmb["geam_defi_uid"]]."', ";
        $sql .= "geam_description = UPPER('".utf8_decode($desc[$aGesAmb["geam_defi_uid"]])."'), ";
        $sql .= "geam_suv_uid	 = '".$uid_token."', ";
        $sql .= "geam_updatedate = NOW() ";
        $sql .= "WHERE geam_regi_uid = '".$regisroUID."' AND geam_defi_uid	 = '".$aGesAmb["geam_defi_uid"]."' ";  
        $db2->query($sql);
    }      

}
?>