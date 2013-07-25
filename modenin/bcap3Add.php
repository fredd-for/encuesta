<?php session_start(); header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");
include_once('../verifyLogin.php');
$dat = array();
$desc = array();



$chk_1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("chk_1")),'Text'); 
$chk_2 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("chk_2")),'Text'); 
$chk_3 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("chk_3")),'Text'); 

if( $chk_1 == 'on' ) { $chk_1 = 1; } else { $chk_1 = 0; }
if( $chk_2 == 'on' ) { $chk_2 = 0; } else { $chk_2 = 0; }
if( $chk_3 == 'on' ) { $chk_3 = 2; } else { $chk_3 = 0; }

$seleccionado = 0;
if( $chk_1 == 1 ) { $seleccionado = 1; }
if( $chk_3 == 2 ) { $seleccionado = 2; }

$dat[245] = $seleccionado;

$dat[246] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("rbtn_gastos")),'Number');
$in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("numpersonas")),'Text');  // 1
$desc[246] = preg_replace('/,/', '', $in1);

$in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("txtasignacion")),'Text');  // 1
$desc[247] = preg_replace('/,/', '', $in1);

if( $dat[246] == 0 ) {
    $desc[246] = "";
}

/* usuario */
$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];


$btnsubmit = OPERATOR::toSql(safeHTML(OPERATOR::getParam("continuarregistro")),'Text');

// obtener el uid del token
$uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );
    
if( !empty($regisroUID)  ) { 

    $sql = "SELECT * FROM  frm2_bcap3_responsocial WHERE reso_regi_uid = '".$regisroUID."' ";
    $db->query($sql);

    //echo $sql;
    while ( $aGesAmb = $db->next_record() ) {         
        $sql  = "UPDATE  frm2_bcap3_responsocial SET ";
        $sql .= "reso_valor = '".$dat[$aGesAmb["reso_defi_uid"]]."', ";
        $sql .= "reso_description = UPPER('".$desc[$aGesAmb["reso_defi_uid"]]."'), ";
        $sql .= "reso_suv_uid	 = '".$uid_token."', ";
        $sql .= "reso_updatedate = NOW() ";
        $sql .= "WHERE reso_regi_uid = '".$regisroUID."' AND reso_defi_uid = '".$aGesAmb["reso_defi_uid"]."' ";  
        $db2->query($sql);        
    }
    
}
  
if( !empty( $btnsubmit ) ) {
    header("Location: ccap1.php");
}
?>