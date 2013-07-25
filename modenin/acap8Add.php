<?php session_start(); header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");

include_once('../verifyLogin.php');

$dato = array();
$desc = array();

$in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A1")),'Text');
$dato[166] = preg_replace('/,/', '', $in1);

$in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A2")),'Text');
$dato[167] = preg_replace('/,/', '', $in1);

$in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A3")),'Text');
$dato[168] = preg_replace('/,/', '', $in1);

$in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A4")),'Text');
$dato[169] = preg_replace('/,/', '', $in1);

$desc[169] = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A5")),'Text');
$dato[170] = $dato[166] + $dato[167] + $dato[168] + $dato[169];

/* usuario */
$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];

$btnsubmit = OPERATOR::toSql(safeHTML(OPERATOR::getParam("continuarregistro")),'Text');

// obtener el uid del token
$uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );
    
if( !empty($regisroUID)  ) {

    $sql = "SELECT * FROM frm2_cap8_ingresosopera WHERE inop_regi_uid = '".$regisroUID."' ";
    $db->query($sql);

    while ( $aIngreso = $db->next_record() ) {
        $sql  = "UPDATE frm2_cap8_ingresosopera SET ";        
        $sql .= "inop_valor = '".$dato[$aIngreso["inop_defi_uid"]]."', ";               
        $sql .= "inop_description	 = UPPER('".$desc[$aIngreso["inop_defi_uid"]]."'), ";
        $sql .= "inop_suv_uid = '".$uid_token."', ";
        $sql .= "inop_updatedate = NOW() ";
        $sql .= "WHERE inop_regi_uid = '".$regisroUID."'  AND inop_defi_uid = '".$aIngreso["inop_defi_uid"]."' ";         
        $db2->query($sql);
    }        
}
if( !empty( $btnsubmit ) ) {
    header("Location: acap9.php");
}
?>