<?php session_start(); header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");
include_once('../verifyLogin.php');
$dat = array();
$desc = array();

// inversiones
$dat[197] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("rbtn_inv")),'Text'); //gastos o inversión
// opcion no
$dat[198] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("chk_1")),'Text');
$dat[199] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("chk_2")),'Text');
$dat[200] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("chk_3")),'Text'); //otros

$desc[200] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("inversionotros")),'Text'); // descripcion

if( $dat[197] == 1 ) {
    $dat[198] = 0;
    $dat[199] = 0;
    $dat[200] = 0;
    $desc[200] = "";
}

if( !empty( $dat[198] ) ) { $dat[198] = 1; }
if( !empty( $dat[199] ) ) { $dat[199] = 1; }
if( !empty( $dat[200] ) ) { $dat[200] = 1; } else { $desc[200] = "";  }

// opcion si

$a1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("activity_1")),'Text');  // 1
$a2 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("activity_2")),'Text');  // 2
$a3 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("activity_3")),'Text');  // 3
$a4 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("activity_4")),'Text');  // 4
$a5 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("activity_5")),'Text');  // 5
$a6 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("activity_6")),'Text');  // 6
$a7 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("activity_7")),'Text');  // 7
$a8 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("activity_8")),'Text');  // 8
$desc[208] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("otrosgestion")),'Text');  // 8 desc

if( !empty( $a1 ) ) { $a1 = 1; } else { $a1 = 0; }
if( !empty( $a2 ) ) { $a2 = 1; } else { $a2 = 0; }
if( !empty( $a3 ) ) { $a3 = 1; } else { $a3 = 0; }
if( !empty( $a4 ) ) { $a4 = 1; } else { $a4 = 0; }
if( !empty( $a5 ) ) { $a5 = 1; } else { $a5 = 0; }
if( !empty( $a6 ) ) { $a6 = 1; } else { $a6 = 0; }
if( !empty( $a7 ) ) { $a7 = 1; } else { $a7 = 0; }
if( !empty( $a8 ) ) { $a8 = 1; } else { $a8 = 0; }

$dat[201] = $a1; 
$dat[202] = $a2;
$dat[203] = $a3;
$dat[204] = $a4;
$dat[205] = $a5;
$dat[206] = $a6;
$dat[207] = $a7;
$dat[208] = $a8;

if( $dat[197] == 0 ) {
    $dat[201] = 0; 
    $dat[202] = 0;
    $dat[203] = 0;
    $dat[204] = 0;
    $dat[205] = 0;
    $dat[206] = 0;
    $dat[207] = 0;
    $dat[208] = 0;
    $desc[208]  = "";
}

// gastos corrientes
// opcion no
$dat[209] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("rbtn_gastos")),'Text');
$dat[210] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("chk_g1")),'Text');
$dat[211] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("chk_g2")),'Text');
$dat[212] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("chk_g3")),'Text'); //otros

$desc[212] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("txt_gastos")),'Text'); // descripcion

if( $dat[209] == 1 ) {
    $dat[210] = 0;
    $dat[211] = 0;
    $dat[212] = 0;
    $desc[212] = "";
}

if( !empty( $dat[210] ) ) { $dat[210] = 1; }
if( !empty( $dat[211] ) ) { $dat[211] = 1; }
if( !empty( $dat[212] ) ) { $dat[212] = 1; } else { $desc[212] = "";  }


//opcion si
$aGasto = array();
for( $i = 1; $i<=16; $i++ ) {
    $a1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("gastos_".$i)),'Text');    
    if( $dat[209] == 0 ) {
        $aGasto[$i] = 0;
    } else {        
        if( !empty( $a1 ) ) { $aGasto[$i] = 1; } else { $aGasto[$i] = 0; }
    }
}
$dat[213] = $aGasto[1]; 
$dat[214] = $aGasto[2]; 
$dat[215] = $aGasto[3];
$dat[216] = $aGasto[4];
$dat[217] = $aGasto[5];
$dat[218] = $aGasto[6]; 
$dat[219] = $aGasto[7];
$dat[220] = $aGasto[8];
$dat[221] = $aGasto[9];
$dat[222] = $aGasto[10];
$dat[223] = $aGasto[11];
$dat[224] = $aGasto[12];
$dat[225] = $aGasto[13];
$dat[226] = $aGasto[14];
$dat[227] = $aGasto[15];
$dat[228] = $aGasto[16];

$desc[228] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("txt_otrosgastos")),'Text');


// descripcion
$dat[229] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("rbtn_rs")),'Text');
$dat[230] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("rbtn_vr")),'Text');
$dat[231] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("rbtn_ta")),'Text');
$dat[232] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("rbtn_eas")),'Text');


/* usuario */
$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];


$btnsubmit = OPERATOR::toSql(safeHTML(OPERATOR::getParam("continuarregistro")),'Text');

// obtener el uid del token
$uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );
    
if( !empty($regisroUID)  ) {   

    $sql = "SELECT * FROM frm2_bcap1_gestionambiental WHERE geam_regi_uid = '".$regisroUID."' ";
    $db->query($sql);

    //echo $sql;
    while ( $aGesAmb = $db->next_record() ) {         
        $sql  = "UPDATE frm2_bcap1_gestionambiental SET ";
        $sql .= "geam_valor = '".$dat[$aGesAmb["geam_defi_uid"]]."', ";
        $sql .= "geam_description = UPPER('".utf8_decode($desc[$aGesAmb["geam_defi_uid"]])."'), ";
        $sql .= "geam_suv_uid	 = '".$uid_token."', ";
        $sql .= "geam_updatedate = NOW() ";
        $sql .= "WHERE geam_regi_uid = '".$regisroUID."' AND geam_defi_uid	 = '".$aGesAmb["geam_defi_uid"]."' ";  
        $db2->query($sql);       
    }        
}
?>