<?php session_start(); header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");
include_once('../verifyLogin.php');
$dat = array();
$desc = array();

$rbtn_rs = OPERATOR::toSql(safeHTML(OPERATOR::getParam("rbtn_rs")),'Text'); //gastos o inversión

$monto = OPERATOR::toSql(safeHTML(OPERATOR::getParam("monto")),'Text');
$monto = preg_replace('/,/', '', $monto);

/* usuario */
$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];


$btnsubmit = OPERATOR::toSql(safeHTML(OPERATOR::getParam("continuarregistro")),'Text');

// obtener el uid del token
$uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );
    
if( !empty($regisroUID)  ) {   

    $sql = "SELECT * FROM frm1_bcap3_responsabilidadsocial WHERE gece_regi_uid = '".$regisroUID."' ";
    $db->query($sql);

    if( $db->numrows() > 0 ) {
        $sql  = "UPDATE frm1_bcap3_responsabilidadsocial SET ";
        $sql .= "gece_valor = '".$rbtn_rs."', ";
        $sql .= "gece_monto = '".$monto."', ";
        $sql .= "gece_suv_uid	 = '".$uid_token."', ";
        $sql .= "gece_updatedate = NOW() ";
        $sql .= "WHERE gece_regi_uid = '".$regisroUID."' ";  
        $db2->query($sql);
    } else {
        $sql  = "INSERT frm1_bcap3_responsabilidadsocial SET ";
        $sql .= "gece_regi_uid = '".$regisroUID."', ";
        $sql .= "gece_valor = '".$rbtn_rs."', ";
        $sql .= "gece_monto = '".$monto."', ";
        $sql .= "gece_suv_uid	 = '".$uid_token."', ";        
        $sql .= "gece_createdate = NOW(), ";
        $sql .= "gece_updatedate = NOW() ";
        $db2->query($sql);
    }                     
}
  
if( !empty( $btnsubmit ) ) {
   header("Location: ccap1.php");
}
?>