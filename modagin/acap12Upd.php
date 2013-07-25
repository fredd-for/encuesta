<?php session_start(); header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");

include_once('../verifyLogin.php');

$dato = array();
$desc = array();

$in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A1")),'Text');
$dato[413] = preg_replace('/,/', '', $in1);

$in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A2")),'Text');
$dato[414] = preg_replace('/,/', '', $in1);

$in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A3")),'Text');
$dato[415] = preg_replace('/,/', '', $in1);

$in1 = OPERATOR::toSql(safeHTML(OPERATOR::getParam("A4")),'Text');
$dato[417] = preg_replace('/,/', '', $in1);


$dato[416] = $dato[413] + $dato[414] + $dato[415];

/* usuario */
$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];

$btnsubmit = OPERATOR::toSql(safeHTML(OPERATOR::getParam("continuarregistro")),'Text');

// obtener el uid del token
$uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );
    
if( !empty($regisroUID)  ) {

    $sql = "SELECT * FROM frm3_cap12_capitalsocial WHERE caso_regi_uid = '".$regisroUID."' ";
    $db->query($sql);

    while ( $aIngreso = $db->next_record() ) {
        $sql  = "UPDATE frm3_cap12_capitalsocial SET ";        
        $sql .= "caso_valor = '".$dato[$aIngreso["caso_defi_uid"]]."', ";        
        $sql .= "caso_suv_uid = '".$uid_token."', ";
        $sql .= "caso_updatedate = NOW() ";
        $sql .= "WHERE caso_regi_uid = '".$regisroUID."'  AND caso_defi_uid = '".$aIngreso["caso_defi_uid"]."' ";         
        $db2->query($sql);
    }        
}
?>