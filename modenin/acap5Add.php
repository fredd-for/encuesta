<?php session_start(); header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");

include_once('../verifyLogin.php');

$dato = array();
$desc = array();
$a1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A1")),'Text');
$dato[154] = preg_replace('/,/', '', $a1);

$a2 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A2")),'Text');
$dato[156] = preg_replace('/,/', '', $a2);

$dato[157] = $dato[154] + $dato[156];


/* usuario */
$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];

$btnsubmit = OPERATOR::toSql(safeHTML(OPERATOR::getParam("continuarregistro")),'Text');

// obtener el uid del token
$uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );
    
if( !empty($regisroUID)  ) {

    $sql = "SELECT * FROM  frm2_cap5_materiaprima WHERE mapi_regi_uid = '".$regisroUID."' ";
    $db->query($sql);

    while ( $aSueldo = $db->next_record() ) {
        $sql  = "UPDATE  frm2_cap5_materiaprima SET ";        
        $sql .= "mapi_valor = '".$dato[$aSueldo["mapi_defi_uid"]]."', ";              
        $sql .= "mapi_suv_uid = '".$uid_token."', ";
        $sql .= "mapi_updatedate = NOW() ";
        $sql .= "WHERE mapi_regi_uid = '".$regisroUID."'  AND mapi_defi_uid = '".$aSueldo["mapi_defi_uid"]."' ";         
        $db2->query($sql);
    }        
}
  
if( !empty( $btnsubmit ) ) {
    header("Location: acap6.php");
}
?>