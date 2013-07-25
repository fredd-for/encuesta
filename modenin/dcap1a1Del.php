<?php session_start(); header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
include_once("../connection/database/connection.php");
include_once("../connection/core/operator.php");
include_once('../verifyLogin.php');

$usuario_uid = $_SESSION[SITE]["usr_uid"];
$regisroUID = $_SESSION[SITE]["registro_uid"];
$uidFormulario = $_SESSION[SITE]["uidtipoformulario"];

$uid = OPERATOR::toSql(safeHTML(OPERATOR::getParam("uid")),'Number');
$reg = OPERATOR::toSql(safeHTML(OPERATOR::getParam("reg")),'Text');

switch ( $reg  ){
    case 'a': $capa_defi_uid = 288; break;
    case 'b': $capa_defi_uid = 289; break;
    case 'c': $capa_defi_uid = 290; break;    
}

$uid_token = OPERATOR::getDbValue( "SELECT suv_uid FROM sys_users_verify WHERE suv_cli_uid = '".$usuario_uid."' ORDER BY suv_date DESC LIMIT 0,1 " );
$sql = " UPDATE frm2_dcap1a_capacitacion SET capa_delete = 1, capa_suv_uid = '".$uid_token."', capa_updatedate = NOW()   "
      ." WHERE capa_position = '".$uid."' AND capa_regi_uid = '".$regisroUID."' AND capa_defi_uid = '".$capa_defi_uid."' ";
$db->query( $sql );


$sql = "SELECT SUM(capa_valor) as tot FROM frm2_dcap1a_capacitacion WHERE capa_regi_uid = '".$regisroUID."' AND capa_defi_uid IN(288, 289, 290) AND capa_delete = 0 ";
$totalExistente = OPERATOR::getDbValue( $sql );


$sql = " UPDATE frm2_dcap1a_capacitacion SET capa_valor = '".$totalExistente."', capa_suv_uid = '".$uid_token."', capa_updatedate = NOW() "
      ." WHERE capa_regi_uid = '".$regisroUID."' AND capa_defi_uid = '307'  ";
$db->query( $sql );

?>