<?php session_start(); header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");

include_once('../verifyLogin.php');

$dato = array();

$in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A1")),'Text');
$dato[177] = preg_replace('/,/', '', $in1);

$in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A2")),'Text');
$dato[178] = preg_replace('/,/', '', $in1);


/* usuario */
$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];

$btnsubmit = OPERATOR::toSql(safeHTML(OPERATOR::getParam("continuarregistro")),'Text');

// obtener el uid del token
$uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );
    
if( !empty($regisroUID)  ) {

    $sql = "SELECT * FROM frm2_cap10_resultadogestion WHERE rege_regi_uid = '".$regisroUID."' ";
    $db->query($sql);

    while ( $aIngreso = $db->next_record() ) {
        $sql  = "UPDATE frm2_cap10_resultadogestion SET ";        
        $sql .= "rege_valor = '".$dato[$aIngreso["rege_defi_uid"]]."', ";        
        $sql .= "rege_suv_uid = '".$uid_token."', ";
        $sql .= "rege_updatedate = NOW() ";
        $sql .= "WHERE rege_regi_uid = '".$regisroUID."'  AND rege_defi_uid = '".$aIngreso["rege_defi_uid"]."' ";         
        $db2->query($sql);
    }        
}
if( !empty( $btnsubmit ) ) {
    header("Location: acap11.php");
}
?>